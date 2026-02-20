<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\KycApplicationRequest;
use App\Mail\NewNotification;
use App\Models\Kyc;
use App\Models\Settings;
use App\Models\User;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class VerifyController extends Controller
{
    /**
     * Handle KYC verification submission.
     */
    public function verifyaccount(KycApplicationRequest $request)
    {
        $user = Auth::user();
        $whitelist = ['jpeg', 'jpg', 'png'];
        $cardname = null;

        try {
            // Validate required files
            $frontimg = $request->file('frontimg');
            $backimg = $request->file('backimg');
            $photo = $request->file('photo');

            if (!$frontimg || !$backimg) {
                return redirect()->back()->with('error', 'Both front and back document images are required.');
            }

            $frontExt = $frontimg->extension();
            $backExt = $backimg->extension();

            if (!in_array($frontExt, $whitelist) || !in_array($backExt, $whitelist)) {
                return redirect()->back()->with('error', 'Invalid image format. Please upload a valid JPEG or PNG file.');
            }

            // Upload images
            try {
                $frontimgPath = $frontimg->store('uploads', 'public');
                $backimgPath = $backimg->store('uploads', 'public');
            } catch (\Exception $e) {
                Log::error('File upload failed: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to upload documents. Please try again.');
            }

            // Save to database with transaction
            DB::beginTransaction();

            $kyc = Kyc::create(array_merge([
                'user_id'       => $user->id,
                'title'         => $request->title,
                'gender'        => $request->gender,
                'zipcode'       => $request->zipcode,
                'dob'           => $request->dob,
                'statenumber'   => $request->statenumber,
                'accounttype'   => $request->accounttype,
                'income'        => $request->income,
                'kinname'       => $request->kinname,
                'kinaddress'    => $request->kinaddress,
                'relationship'  => $request->relationship,
                'employer'      => $request->employer,
                'address'       => $request->address,
                'city'          => $request->city,
                'state'         => $request->state,
                'country'       => $request->country,
                'document_type' => $request->document_type,
                'frontimg'      => $frontimgPath,
                'backimg'       => $backimgPath,
            ], Kyc::getDefaultValues()));

            // Handle optional photo upload
            if ($photo) {
                $filename = $photo->getClientOriginalName();
                $parts = explode('.', $filename);
                $ext = strtolower(array_pop($parts));

                if (in_array($ext, $whitelist)) {
                    $randomStr = $this->RandomStringGenerator(6);
                    $cardname = $randomStr . '_' . time() . '.' . $ext;
                    $photo->storeAs('photos', $cardname, 'public');

                    $user->update([
                        'profile_photo_path' => 'photos/' . $cardname,
                    ]);
                }
            }

            // Update user info with KYC status
            $user->update([
                'kyc_id'         => $kyc->id,
                'account_verify' => 'Under review',
                'dob'            => $request->dob,
                'address'        => $request->address,
            ]);

            DB::commit();

            // Send user notification
            try {
                NotificationHelper::createSafe(
                    $user,
                    'Your KYC verification documents have been submitted successfully and are under review. You will be notified once the verification process is complete.',
                    'KYC Verification Submitted',
                    'info',
                    'shield',
                    route('account.verify')
                );
            } catch (\Exception $e) {
                Log::warning('Failed to create KYC notification: ' . $e->getMessage());
            }

            // Notify admin
            try {
                $settings = Settings::find(1);

                if ($settings && $settings->contact_email) {
                    $subject = "Identity Verification Request from {$user->name}";
                    $message = "This is to inform you that {$user->name} just submitted a KYC (identity verification) request. Please log in to your admin panel to review.";
                    $url = config('app.url') . '/admin/dashboard/kyc';

                    Mail::to($settings->contact_email)->send(
                        new NewNotification($message, $subject, 'Admin', $url)
                    );
                }
            } catch (\Exception $e) {
                Log::error('Failed to send admin KYC notification: ' . $e->getMessage());
            }

            return redirect()->route('account.verify')->with('success', 'KYC submitted successfully! Please wait while we verify your application.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('KYC verification failed: ' . $e->getMessage(), [
                'user_id' => $user->id ?? null,
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'An error occurred while processing your KYC application. Please try again.');
        }
    }

    /**
     * Generate random string.
     */
    private function RandomStringGenerator($length = 6)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $generated = '';

        for ($i = 0; $i < $length; $i++) {
            $generated .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $generated;
    }
}
