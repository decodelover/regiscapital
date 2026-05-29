<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Models\UserBeneficiary;
use App\Models\UtilityPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class QuickActionController extends Controller
{
    public const SERVICES = [
        'airtime-data' => [
            'title' => 'Mobile Top-Up',
            'icon' => 'phone-call',
            'reference_label' => 'Phone number',
            'providers' => ['Verizon', 'AT&T', 'T-Mobile', 'US Mobile', 'Mint Mobile', 'Other Carrier'],
            'packages' => ['Talk & Text', 'Data Add-on', 'Monthly Plan', 'Prepaid Top-up'],
        ],
        'bill-payments' => [
            'title' => 'Bill Payments',
            'icon' => 'receipt',
            'reference_label' => 'Customer ID / bill reference',
            'providers' => ['Water Utility', 'Internet Service', 'Insurance', 'Rent Payment', 'Other Bill'],
            'packages' => ['Standard Payment', 'Partial Payment', 'Full Payment'],
        ],
        'betting' => [
            'title' => 'Sportsbook',
            'icon' => 'ticket',
            'reference_label' => 'Sportsbook wallet ID',
            'providers' => ['DraftKings', 'FanDuel', 'BetMGM', 'Caesars Sportsbook', 'Other Sportsbook'],
            'packages' => ['Wallet Top-up'],
        ],
        'ach-payment' => [
            'title' => 'ACH Payment',
            'icon' => 'building-2',
            'reference_label' => 'Routing / payment reference',
            'providers' => ['ACH Credit', 'ACH Debit', 'Payroll Payment', 'Vendor Payment', 'Other ACH'],
            'packages' => ['Same-Day ACH', 'Standard ACH'],
        ],
        'electricity' => [
            'title' => 'Electricity',
            'icon' => 'zap',
            'reference_label' => 'Utility account number',
            'providers' => ['Con Edison', 'Pacific Gas & Electric', 'Duke Energy', 'Florida Power & Light', 'Other Utility'],
            'packages' => ['Electric Bill', 'Gas Bill', 'Combined Utility'],
        ],
        'cable-streaming' => [
            'title' => 'Cable & Streaming',
            'icon' => 'tv',
            'reference_label' => 'Cable / streaming account ID',
            'providers' => ['Xfinity', 'Spectrum', 'DIRECTV', 'Hulu', 'Netflix', 'Other Provider'],
            'packages' => ['Basic', 'Standard', 'Premium', 'Sports Add-on'],
        ],
    ];

    public function service(string $service)
    {
        abort_unless(isset(self::SERVICES[$service]), 404);

        return view('user.quick-actions.payment', [
            'title' => self::SERVICES[$service]['title'],
            'serviceKey' => $service,
            'service' => self::SERVICES[$service],
            'settings' => Settings::find(1),
            'payments' => UtilityPayment::where('user_id', Auth::id())
                ->where('service', $service)
                ->orderByDesc('id')
                ->take(10)
                ->get(),
        ]);
    }

    public function pay(Request $request, string $service)
    {
        abort_unless(isset(self::SERVICES[$service]), 404);

        $data = $request->validate([
            'provider' => ['required', 'string', 'max:100'],
            'customer_reference' => ['required', 'string', 'max:120'],
            'package' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $payment = DB::transaction(function () use ($data, $service) {
            $user = User::where('id', Auth::id())->lockForUpdate()->firstOrFail();
            $amount = round((float) $data['amount'], 2);

            if ((float) $user->account_bal < $amount) {
                throw ValidationException::withMessages([
                    'amount' => 'Insufficient balance for this payment.',
                ]);
            }

            $before = (float) $user->account_bal;
            $after = $before - $amount;
            $user->account_bal = $after;
            $user->save();

            $payment = UtilityPayment::create([
                'user_id' => $user->id,
                'service' => $service,
                'provider' => $data['provider'],
                'customer_reference' => $data['customer_reference'],
                'package' => $data['package'] ?? null,
                'amount' => $amount,
                'balance_before' => $before,
                'balance_after' => $after,
                'reference' => 'UP-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(6)),
                'status' => 'Processed',
                'description' => $data['description'] ?? null,
                'meta' => [
                    'service_title' => self::SERVICES[$service]['title'],
                ],
            ]);

            Tp_Transaction::create([
                'user' => $user->id,
                'plan' => self::SERVICES[$service]['title'] . ' - ' . $payment->provider,
                'amount' => $amount,
                'type' => 'Utility Payment',
            ]);

            return $payment;
        });

        return redirect()
            ->route('quick-actions.service', $service)
            ->with('success', 'Payment completed successfully. Reference: ' . $payment->reference);
    }

    public function beneficiaries()
    {
        return view('user.quick-actions.beneficiaries', [
            'title' => 'Manage Beneficiaries',
            'beneficiaries' => UserBeneficiary::where('user_id', Auth::id())->orderByDesc('id')->get(),
        ]);
    }

    public function storeBeneficiary(Request $request)
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['bank', 'mobile', 'bill', 'electricity', 'cable-streaming', 'ach', 'other'])],
            'name' => ['required', 'string', 'max:120'],
            'nickname' => ['nullable', 'string', 'max:120'],
            'provider' => ['nullable', 'string', 'max:120'],
            'account_number' => ['nullable', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
        ]);

        $data['user_id'] = Auth::id();
        UserBeneficiary::create($data);

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary added successfully.');
    }

    public function destroyBeneficiary(UserBeneficiary $beneficiary)
    {
        abort_unless($beneficiary->user_id === Auth::id(), 403);
        $beneficiary->delete();

        return redirect()->route('beneficiaries.index')->with('success', 'Beneficiary removed successfully.');
    }
}
