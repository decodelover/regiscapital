<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Plans;
use App\Models\Tp_Transaction;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\NewNotification;
use App\Mail\LoanStatus;
use App\Models\User_plans;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LoanController extends Controller
{
    
    public function loan(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'income' => 'nullable|string|max:255',
            'purpose' => 'required|string|max:1000',
            'duration' => 'required|integer|min:1',
            'facility' => 'required|string|max:255',
        ]);

        //get user
        $user=User::where('id',Auth::user()->id)->first();
        $settings=Settings::where('id', '=', '1')->first();
        //get plan

        if(strtolower(trim((string) $user->account_status)) !== 'active'){
            return redirect()->back()
                ->with("message", "Sorry, your account is dormant. Contact support on $settings->contact_email for more details.");
        }

        $durationWeeks = (int) $request['duration'];
        $end_at = Carbon::now()->addWeeks($durationWeeks);
    
        //save user laon
        $userplanid = DB::table('user_plans')->insertGetId([
            
            'user' => Auth::user()->id,
            'amount' => $request['amount'],
            'income'=> $request['income'],
            'purpose'=> $request['purpose'],
            'duration'=>$request['duration'],
            'facility' => $request['facility'],
            'active' => 'Pending',
            'inv_duration'=>$request['duration'],
            'expire_date' => $end_at,
            'activated_at' => \Carbon\Carbon::now(),
            'last_growth' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);

        User::where('id',Auth::user()->id)
        ->update([
          
          'user_plan' => $userplanid,
          'entered_at'=>\Carbon\Carbon::now(),
        ]);

        // Create notification
        NotificationHelper::create(
            $user,
            'Your loan application for ' . $request['amount'] . ' has been submitted successfully and is pending approval. You will be notified once it is processed.',
            'Loan Application Submitted',
            'info',
            'file-text',
            route('veiwloan')
        );

        $loanPlan = User_plans::find($userplanid);

        // send user loan email
        if ($loanPlan) {
            try {
                Mail::to($user->email)->send(
                    new LoanStatus($user, $loanPlan, 'Pending', 'Loan Application Received')
                );
            } catch (\Exception $e) {
                Log::warning('Loan application email failed to send', [
                    'user_id' => $user->id,
                    'loan_id' => $loanPlan->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // send admin notification
        $message = "This is to inform you that $user->name just applied for a loan plan for $request->purpose";
        $subject ="Loan Application by $user->name ";
        try {
            Mail::to($settings->contact_email)->send(new NewNotification($message, $subject, 'Admin'));
        } catch (\Exception $e) {
            Log::warning('Admin loan application email failed to send', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->back()
          ->with('success', "You have successfully applied for a loan your loan is currently pending, you will be contacted soon.");
    }


    public function veiwloans(){

        $loans = User_plans::where('user', Auth::user()->id)->orderByDesc('id')->get();

      
        return view('user.loans',['loans'=>$loans]);
    }
    
}
