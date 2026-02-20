<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\Card;
use App\Models\CardSettings;
use App\Models\CardTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CardController extends Controller
{
    /**
     * Display the virtual cards dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $cards = $user->cards()->latest()->get();

        $activeCards = $cards->where('status', 'active')->count();
        $pendingCards = $cards->where('status', 'pending')->count();
        $totalBalance = $cards->where('status', 'active')->sum('balance');

        return view('user.cards.index', [
            'title' => 'Virtual Cards',
            'cards' => $cards,
            'activeCards' => $activeCards,
            'pendingCards' => $pendingCards,
            'totalBalance' => $totalBalance,
        ]);
    }

    /**
     * Show the application form for a new card.
     *
     * @return \Illuminate\Http\Response
     */
    public function showApplicationForm()
    {
        $cardSettings = $this->cardSettings();

        // If virtual cards are disabled, redirect back with message
        if (!$cardSettings->is_enabled) {
            return redirect()->route('cards')->with('message', 'Virtual cards are currently unavailable. Please try again later.')
                ->with('type', 'danger');
        }

        $issuanceFees = [
            'standard' => $cardSettings->standard_fee,
            'gold' => $cardSettings->gold_fee,
            'platinum' => $cardSettings->platinum_fee,
            'black' => $cardSettings->black_fee,
        ];

        return view('user.cards.apply', [
            'title' => 'Apply for Virtual Card',
            'issuanceFees' => $issuanceFees,
            'minLimit' => $cardSettings->min_daily_limit,
            'maxLimit' => $cardSettings->max_daily_limit,
        ]);
    }

    /**
     * Process a new card application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function applyCard(Request $request)
    {
        $cardSettings = $this->cardSettings();

        // If virtual cards are disabled, redirect back with message
        if (!$cardSettings->is_enabled) {
            return redirect()->route('cards')->with('message', 'Virtual cards are currently unavailable. Please try again later.')
                ->with('type', 'danger');
        }

        $request->validate([
            'card_type' => 'required|string|in:visa,mastercard,american_express,discover',
            'card_level' => 'required|string|in:standard,gold,platinum,black',
            'card_holder_name' => 'nullable|string|max:100',
            'daily_limit' => 'nullable|numeric|min:' . $cardSettings->min_daily_limit . '|max:' . $cardSettings->max_daily_limit,
            'currency' => 'required|string|max:10',
            'billing_address' => 'required|string|max:255',
            'terms_accepted' => 'required|accepted',
        ]);

        $user = Auth::user();

        $userStatus = strtolower(trim((string) $user->status));
        $accountStatus = strtolower(trim((string) $user->account_status));
        $isRestricted = in_array($userStatus, ['blocked', 'suspended', 'disabled'], true)
            || ($accountStatus !== '' && $accountStatus !== 'active');

        if ($isRestricted) {
            return redirect()->back()
                ->with('message', 'Sorry, your account is restricted. Please contact support for assistance.')
                ->with('type', 'danger');
        }

        // Get appropriate issuance fee based on card level
        $feeKey = $request->card_level . '_fee';
        $issuanceFee = (float) $cardSettings->$feeKey;

        // Check if user has sufficient balance
        if ($user->account_bal < $issuanceFee) {
            return back()->with('message', 'Insufficient account balance to cover card issuance fee of $' . number_format($issuanceFee, 2) . '.')
                ->with('type', 'danger');
        }

        try {
            $card = DB::transaction(function () use ($request, $user, $issuanceFee, $cardSettings) {
                $freshUser = \App\Models\User::lockForUpdate()->find($user->id);

                if ((float) $freshUser->account_bal < $issuanceFee) {
                    throw new \RuntimeException('Your account balance changed. Please try again.');
                }

                $dailyLimit = (float) ($request->daily_limit ?: $cardSettings->min_daily_limit);
                $monthlyLimit = $dailyLimit * 30;

                $card = new Card();
                $card->user_id = $freshUser->id;
                $card->card_holder_name = trim((string) $request->input('card_holder_name', $freshUser->name . ' ' . ($freshUser->lastname ?? '')));
                $card->card_type = $request->card_type;
                $card->daily_limit = $dailyLimit;
                $card->monthly_limit = $monthlyLimit;
                $card->card_level = $request->card_level;
                $card->currency = strtoupper($request->currency);
                $card->status = 'pending';
                $card->billing_address = $request->billing_address;
                $card->application_date = now();
                $card->reference_id = 'CARD' . strtoupper(Str::random(10));
                $card->is_virtual = true;
                $card->save();

                // Charge issuance fee at application time (auto-refunded on rejection).
                $freshUser->account_bal = (float) $freshUser->account_bal - $issuanceFee;
                $freshUser->save();

                CardTransaction::create([
                    'card_id' => $card->id,
                    'user_id' => $freshUser->id,
                    'amount' => $issuanceFee,
                    'currency' => strtoupper($request->currency),
                    'transaction_type' => 'fee',
                    'transaction_reference' => 'FEE' . strtoupper(Str::random(8)),
                    'merchant_name' => config('app.name'),
                    'status' => 'completed',
                    'description' => 'Card issuance fee for ' . ucfirst($request->card_level) . ' card application',
                    'transaction_date' => now(),
                ]);

                return $card;
            });
        } catch (\Throwable $e) {
            return back()->with('message', $e->getMessage())->with('type', 'danger');
        }

        // Create notification
        NotificationHelper::create(
            $user,
            'Your card request has been submitted and is under admin review. You will be notified once approved or declined.',
            'Card Application Submitted',
            'info',
            'credit-card',
            route('cards.view', $card->id)
        );

        return redirect()->route('cards')->with('message', 'Your virtual card application has been submitted successfully. It is now pending approval.')
            ->with('type', 'success');
    }

    /**
     * Display a specific card's details.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function viewCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            return redirect()->route('cards.apply')->with('message', 'You need to apply for a card.');
        }

        // Get recent transactions for this card
        $transactions = $card->transactions()
            ->latest('transaction_date')
            ->take(10)
            ->get();

        return view('user.cards.view', [
            'title' => 'Card Details',
            'card' => $card,
            'transactions' => $transactions,
        ]);
    }

    /**
     * Activate a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function activateCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            return redirect()->route('cards.apply')->with('message', 'You need to apply for a card.');
        }

        if ($card->status !== 'inactive') {
            return back()->with('message', 'This card cannot be activated.')
                ->with('type', 'danger');
        }

        $card->status = 'active';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been activated successfully.',
            'Card Activated',
            'success',
            'check-circle',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been activated successfully.')
            ->with('type', 'success');
    }

    /**
     * Deactivate a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function deactivateCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            return redirect()->route('cards.apply')->with('message', 'You need to apply for a card.');
        }
        if ($card->status !== 'active') {
            return back()->with('message', 'This card cannot be deactivated.')
                ->with('type', 'danger');
        }

        $card->status = 'inactive';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been deactivated.',
            'Card Deactivated',
            'warning',
            'pause',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been deactivated successfully.')
            ->with('type', 'success');
    }

    /**
     * Block a card.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function blockCard(Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            return redirect()->route('cards.apply')->with('message', 'You need to apply for a card.');
        }

        if (!in_array($card->status, ['active', 'inactive'])) {
            return back()->with('message', 'This card cannot be blocked.')
                ->with('type', 'danger');
        }

        $card->status = 'blocked';
        $card->save();

        // Create notification
        NotificationHelper::create(
            Auth::user(),
            'Your ' . ucfirst($card->card_level) . ' ' . ucfirst(str_replace('_', ' ', $card->card_type)) . ' card ending in ' . $card->last_four . ' has been blocked for security reasons. Please contact support if you didn\'t request this action.',
            'Card Blocked',
            'danger',
            'lock',
            route('cards.view', $card->id)
        );

        return back()->with('message', 'Card has been blocked. Please contact support for assistance.')
            ->with('type', 'success');
    }

    /**
     * Display card transactions.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function cardTransactions(Request $request, Card $card)
    {
        if (Auth::id() !== $card->user_id) {
            return redirect()->route('cards.apply')->with('message', 'You need to apply for a card.');
        }

        $query = $card->transactions()->latest('transaction_date');

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_start')) {
            $query->whereDate('transaction_date', '>=', $request->date_start);
        }

        if ($request->filled('date_end')) {
            $query->whereDate('transaction_date', '<=', $request->date_end);
        }

        $transactions = $query->paginate(15);
        $lastActivity = $card->transactions()->latest('transaction_date')->first();
        $totalSpending = (float) $card->transactions()
            ->whereIn('transaction_type', ['purchase', 'fee', 'deduction'])
            ->sum(DB::raw('ABS(amount)'));

        return view('user.cards.transactions', [
            'title' => 'Card Transactions',
            'card' => $card,
            'transactions' => $transactions,
            'totalSpending' => $totalSpending,
            'lastActivity' => $lastActivity,
        ]);
    }

    /**
     * Resolve or initialize card settings.
     */
    private function cardSettings(): CardSettings
    {
        return CardSettings::firstOrCreate(
            ['id' => 1],
            [
                'standard_fee' => 5,
                'gold_fee' => 15,
                'platinum_fee' => 25,
                'black_fee' => 50,
                'monthly_fee' => 2,
                'topup_fee_percentage' => 1,
                'is_enabled' => true,
                'max_daily_limit' => 10000,
                'min_daily_limit' => 1000,
                'description' => 'Default card settings',
            ]
        );
    }
}
