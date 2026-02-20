<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Settings;
use App\Models\Deposit;
use App\Models\Tp_Transaction;
use App\Mail\DepositStatus;
use App\Traits\PingServer;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ManageDepositController extends Controller
{
    use PingServer;

    //Delete deposit
    public function deldeposit($id)
    {
        $deposit = Deposit::where('id', $id)->first();

        if (empty($deposit)) {
            return redirect()->back()->with('message', 'Deposit not found.');
        }

        if (!empty($deposit->proof) && Storage::disk('public')->exists($deposit->proof)) {
            Storage::disk('public')->delete($deposit->proof);
        }

        Deposit::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Deposit history has been deleted!');
    }

    //process deposits
    public function pdeposit($id)
    {
        //confirm the users plan
        $deposit = Deposit::where('id', $id)->first();
        if (empty($deposit)) {
            return redirect()->back()->with('message', 'Deposit record not found.');
        }

        if ($deposit->status !== 'Pending') {
            return redirect()->back()->with('message', "This deposit is already {$deposit->status}.");
        }

        $user = User::where('id', $deposit->user)->first();
        if (empty($user)) {
            return redirect()->back()->with('message', 'User for this deposit was not found.');
        }

        //get settings 
        $settings = Settings::where('id', '=', '1')->first();

        $response = $this->callServer('earnings', '/process-deposit', [
            'referral_commission' => $settings->referral_commission,
            'amount' => $deposit->amount,
            'account_bal' => $user->account_bal,
            'depositBonus' => $settings->deposit_bonus,
        ]);

    if($deposit->user==$user->id){
            //add funds to user's account
            User::where('id',$user->id)
            ->update([
                'account_bal' => $user->account_bal + $deposit->amount,
                'cstatus' => 'Customer',
            ]);
            
            // Create notification for deposit approval
            NotificationHelper::create(
                $user,
                'Your deposit of ' . $settings->currency . $deposit->amount . ' has been approved and credited to your account.',
                'Deposit Approved',
                'success',
                'check-circle',
                route('deposits')
            );
            
            //get settings 
            $settings=Settings::where('id', '=', '1')->first();
            $earnings=$settings->referral_commission*$deposit->amount/100;

            if(!empty($user->ref_by)){
                
                //get agent
                $agent=User::where('id',$user->ref_by)->first();
                User::where('id',$user->ref_by)
                ->update([
                    'account_bal' => $agent->account_bal + $earnings,
                    'ref_bonus' => $agent->ref_bonus + $earnings,
                ]);
        
                //create history
                Tp_Transaction::create([
                    'user' => $user->ref_by,
                    'plan' => "Credit",
                    'amount'=>$earnings,
                    'type'=>"Ref_bonus",
                ]);
        
                //credit commission to ancestors
                $deposit_amount = $deposit->amount;
                $array=User::all();
                $parent=$user->id;
                $this->getAncestors($array, $deposit_amount, $parent);
            }

            //Send confirmation email to user regarding his deposit and it's successful.
            Mail::to($user->email)->send(new DepositStatus($deposit, $user,'Your Deposit have been Confirmed', false));
    
        }

        //update deposits
        Deposit::where('id',$id)
            ->update([
            'status' => 'Processed',
        ]);
        return redirect()->back()->with('success', 'Deposit processed successfully.');
    }

    // reject deposit
    public function rdeposit($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        if (empty($deposit)) {
            return redirect()->back()->with('message', 'Deposit record not found.');
        }

        if ($deposit->status === 'Processed') {
            return redirect()->back()->with('message', 'Processed deposits cannot be rejected.');
        }

        if ($deposit->status === 'Rejected') {
            return redirect()->back()->with('message', 'This deposit is already rejected.');
        }

        $user = User::where('id', $deposit->user)->first();
        $settings = Settings::where('id', '=', '1')->first();

        $deposit->status = 'Rejected';
        $deposit->save();

        if (!empty($user)) {
            NotificationHelper::create(
                $user,
                'Your deposit of ' . $settings->currency . $deposit->amount . ' via ' . $deposit->payment_mode . ' has been rejected. Please contact support for clarification.',
                'Deposit Rejected',
                'danger',
                'x-circle',
                route('deposits')
            );

            try {
                Mail::to($user->email)->send(new DepositStatus($deposit, $user, 'Deposit Rejected', false));
            } catch (\Exception $e) {
                // Ignore mail failures; status has already been updated.
            }
        }

        return redirect()->back()->with('success', 'Deposit rejected successfully.');
    }


    public function viewdepositimage($id)
    {
        $deposit = Deposit::where('id', $id)->first();
        if (empty($deposit)) {
            return redirect()->route('mdeposits')->with('message', 'Deposit record not found.');
        }

        return view('admin.Deposits.depositimg', [
            'deposit' => $deposit,
            'title' => 'View Deposit Screenshot',
            'settings' => Settings::where('id', '=', '1')->first(),
        ]);
    }


    //Get uplines
    function getAncestors($array, $deposit_amount, $parent = 0, $level = 0)
    {
        $referedMembers = '';
        $parent = User::where('id', $parent)->first();

        foreach ($array as $entry) {
            if ($entry->id == $parent->ref_by) {
                //get settings 
                $settings = Settings::where('id', '=', '1')->first();

                if ($level == 1) {
                    $earnings = $settings->referral_commission1 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 2) {
                    $earnings = $settings->referral_commission2 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 3) {
                    $earnings = $settings->referral_commission3 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 4) {
                    $earnings = $settings->referral_commission4 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                } elseif ($level == 5) {
                    $earnings = $settings->referral_commission5 * $deposit_amount / 100;
                    //add earnings to ancestor balance
                    User::where('id', $entry->id)
                        ->update([
                            'account_bal' => $entry->account_bal + $earnings,
                            'ref_bonus' => $entry->ref_bonus + $earnings,
                        ]);

                    //create history
                    Tp_Transaction::create([
                        'user' => $entry->id,
                        'plan' => "Credit",
                        'amount' => $earnings,
                        'type' => "Ref_bonus",
                    ]);
                }

                if ($level == 6) {
                    break;
                }

                //$referedMembers .= '- ' . $entry->name . '- Level: '. $level. '- Commission: '.$earnings.'<br/>';
                $referedMembers .= $this->getAncestors($array, $deposit_amount, $entry->id, $level + 1);
            }
        }
        return $referedMembers;
    }

    // for front end content management
    function RandomStringGenerator($n)
    {
        $generated_string = "";
        $domain = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string = $generated_string . $domain[$index];
        }
        // Return the random generated string 
        return $generated_string;
    }
}
