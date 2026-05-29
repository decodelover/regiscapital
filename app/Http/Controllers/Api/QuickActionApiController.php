<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\QuickActionController;
use App\Models\Tp_Transaction;
use App\Models\User;
use App\Models\UserBeneficiary;
use App\Models\UtilityPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class QuickActionApiController extends Controller
{
    public function services()
    {
        return response()->json([
            'success' => true,
            'data' => QuickActionController::SERVICES,
        ]);
    }

    public function pay(Request $request, string $service)
    {
        if (!isset(QuickActionController::SERVICES[$service])) {
            return response()->json(['success' => false, 'message' => 'Unknown service.'], 404);
        }

        $data = $request->validate([
            'provider' => ['required', 'string', 'max:100'],
            'customer_reference' => ['required', 'string', 'max:120'],
            'package' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1', 'max:999999999'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        try {
            $payment = DB::transaction(function () use ($data, $service, $request) {
                $user = User::where('id', $request->user()->id)->lockForUpdate()->firstOrFail();
                $amount = round((float) $data['amount'], 2);

                if ((float) $user->account_bal < $amount) {
                    abort(422, 'Insufficient balance for this payment.');
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
                        'service_title' => QuickActionController::SERVICES[$service]['title'],
                    ],
                ]);

                Tp_Transaction::create([
                    'user' => $user->id,
                    'plan' => QuickActionController::SERVICES[$service]['title'] . ' - ' . $payment->provider,
                    'amount' => $amount,
                    'type' => 'Utility Payment',
                ]);

                return $payment;
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $exception->getStatusCode());
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment completed successfully.',
            'data' => $payment,
        ]);
    }

    public function beneficiaries(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => UserBeneficiary::where('user_id', $request->user()->id)->orderByDesc('id')->get(),
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

        $data['user_id'] = $request->user()->id;

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary added successfully.',
            'data' => UserBeneficiary::create($data),
        ], 201);
    }

    public function destroyBeneficiary(Request $request, UserBeneficiary $beneficiary)
    {
        if ($beneficiary->user_id !== $request->user()->id) {
            return response()->json(['success' => false, 'message' => 'Forbidden.'], 403);
        }

        $beneficiary->delete();

        return response()->json([
            'success' => true,
            'message' => 'Beneficiary removed successfully.',
        ]);
    }
}
