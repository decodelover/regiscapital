 <!-- Top Up Modal -->
 <div id="credit" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                @if(!empty($user->profile_photo_path))
    <img
        alt="{{ $user->name }}"
        src="{{ asset('storage/app/public/photos/'.$user->profile_photo_path) }}"
        width="40" height="40"
        style="border-radius: 50%;">
@else
    @php
        $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
    @endphp
    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold border border-secondary"
         style="width: 48px; height: 48px; background-color: #0d6efd; color: white;">
        {{ $initials }}
    </div>
@endif

                 <h4 class="modal-title pl-1">Credit Account.</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form method="post" action="{{ route('topup') }}">
                     @csrf
                     <div class="form-group">
                        <h4 class="">Amount</h4>
                         <input class="form-control" placeholder="Enter amount" type="number" name="amount"
                             required>
                     </div>

                     <input type='hidden' name="type" value="balance" required>

                     <input type='hidden' name="t_type" value="Credit" required >
                     {{-- <div class="form-group">
                         <h5 class="">Select Fund to add, debit to subtract.</h5>
                         <select class="form-control  " name="t_type" required>
                             <option value="">Select type</option>
                             <option value="Credit">Credit </option>

                         </select>

                     </div> --}}
                     <div class="form-group">
                        <h5 class="">Transfer Scope.</h5>
                        <select class="form-control  " name="scope" required>
                            <option value="">Select type</option>
                            <option value="International transfer">International transfer</option>
                            <option value="Local transfer">Local transfer</option>
                            <option value="Crypto Deposit">Crypto Deposit</option>
                            <option value="Check Deposit">Check Deposit</option>
                        </select>
                        {{-- <small> <b>NOTE:</b> You cannot debit deposit</small> --}}
                    </div>

                    <div class="form-group">
                        <h5 class="">Sender </h5>
                        <input class="form-control" name="name" placeholder="Sender Name" type='text' >


                    </div>

                     <div class="form-group">
                        <h5 class="">Description </h5>
                        <input class="form-control" name="Description" type='text' >


                    </div>


                    <div class="form-group">
                        <h5 class="">Bank Address</h5>
                        <input class="form-control" name="bankaddress" value = "{{$settings->address}}" placeholder="Sender Name" type='text' >


                    </div>
                     <div class="form-group">
                        <h5 class="">Date (You can back date transction here)</h5>
                        <input class="form-control" name="date" type='datetime-local' >


                    </div>

                    <div class="form-group">
                        <h5 class="">Send Email and SMS to User</h5>
                        <select class="form-control" name="notifymailuser" type='text' >
                        <option value='0'>No</option>
                        <option value='1'>Yes</option>
                        </select>



                    </div>
                     <div class="form-group">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <input type="submit" class="btn btn-primary" value="Fund Account">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /deposit for a plan Modal -->

 {{-- Debit strats  --}}

<!-- Top Up Modal -->
<div id="debit" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                @if(!empty($user->profile_photo_path))
                <img
                    alt="{{ $user->name }}"
                    src="{{ asset('storage/app/public/photos/'.$user->profile_photo_path) }}"
                    width="40" height="40"
                    style="border-radius: 50%;">
            @else
                @php
                    $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
                @endphp
                <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold border border-secondary"
                     style="width: 48px; height: 48px; background-color: #0d6efd; color: white;">
                    {{ $initials }}
                </div>
            @endif

               <h4 class="modal-title pl-1">Debit {{$user->username}} Account.</strong></h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{ route('topup') }}">
                    @csrf
                    <div class="form-group">
                       <h4 class="">Amount</h4>
                        <input class="form-control" placeholder="Enter amount" type="number" name="amount"
                            required>
                    </div>
                    <input type='hidden' name="type" value="balance" required>

                     <input type='hidden' name="t_type" value="Debit" required >

                    {{-- <div class="form-group">
                        <h5 class="">Select Fund to add, debit to subtract.</h5>
                        <select class="form-control  " name="t_type" required>
                            <option value="">Select type</option>

                            <option value="Debit">Debit</option>
                        </select>

                    </div> --}}
                    <div class="form-group">
                       <h5 class="">Transfer Scope.</h5>
                       <select class="form-control  " name="scope" required>
                           <option value="">Select type</option>
                           <option value="International transfer">International transfer</option>
                           <option value="Local transfer">Local transfer</option>
                           <option value="Crypto Deposit">Crypto Deposit</option>
                           <option value="Check Deposit">Check Deposit</option>
                       </select>
                       {{-- <small> <b>NOTE:</b> You cannot debit deposit</small> --}}
                   </div>

                   <div class="form-group">
                       <h5 class="">Reciver's Bank </h5>
                       <input class="form-control" name="bank" placeholder="Enter receivers's bank" type='text' >


                   </div>
                   <div class="form-group">
                       <h5 class="">Reciver's Name </h5>
                       <input class="form-control" name="name" placeholder="Enter receiver's name" type='text' >


                   </div>

                   <div class="form-group">
                       <h5 class="">Reciver's Account number </h5>
                       <input class="form-control" placeholder="Enter receiver's account number" name="account_number" type='text' >


                   </div>

                   <div class="form-group">
                       <h5 class="">Bank Address </h5>
                       <input class="form-control" name="bankaddress" placeholder="Enter receiver's bank address" type='text' >


                   </div>

                    <div class="form-group">
                       <h5 class="">Description </h5>
                       <input class="form-control" name="Description" type='text' >


                   </div>
                    <div class="form-group">
                       <h5 class="">Date (You can back date transction here)</h5>
                       <input class="form-control" name="date" type='datetime-local' >


                   </div>

                   <div class="form-group">
                       <h5 class="">Send Email and SMS to User</h5>
                       <select class="form-control" name="notifymailuser" type='text' >
                       <option value='0'>No</option>
                       <option value='1'>Yes</option>
                       </select>



                   </div>
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-primary" value="Fund Account">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- /deposit for a


 {{-- Debits end --}}
<!--user action mode-->
<div id="userAction" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-{{$bg}}">
                    <h4 class="modal-title text-{{$text}}">Action amount  for{{$user->name}} account.</strong></h4>
                    <button type="button" class="close text-{{$text}}" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-{{$bg}}">
                    <form method="post" action="{{route('action')}}">
                        @csrf
                        <div class="form-group">
                            <h5 class="text-{{$text}}">On or Off Action</h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="type" required>
                                <option value="" selected disabled>Select Column</option>
                                <option value="Yes">On upgrade action</option>
                                <option value="No">Off upgrade action</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control bg-{{$bg}} text-{{$text}}" placeholder="Enter actoin amount" type="text" name="amount">
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="submit" class="btn btn-{{$text}}" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--user action modal end-->

    {{-- usage limits starts --}}


    <div id="useages" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-{{$bg}}">
                    <h4 class="modal-title text-{{$text}}">{{$user->name}} Useage Limits.</strong></h4>
                    <button type="button" class="close text-{{$text}}" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-{{$bg}}">
                    <form method="post" action="{{route('useage')}}">
                        @csrf
                        <div class="form-group">
                            <h5 class="text-{{$text}}">Daily Limits</h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="dailyTotal" required>
                            <option value="{{$user->dailyTotal}}"> Daily Limits on</option>
                            <option value="1" {{ $user->dailyTotal == 1 ? 'selected' : '' }}>ON</option>
                            <option value="0" {{ $user->dailyTotal != 1 ? 'selected' : '' }}>OFF</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <h5 class="text-{{$text}}">Weekly Limits</h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="weeklyTotal" required>

                            <option value="1" {{ $user->weeklyTotal == 1 ? 'selected' : '' }}>ON</option>
                            <option value="0" {{ $user->weeklyTotal != 1 ? 'selected' : '' }}>OFF</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <h5 class="text-{{$text}}">Monthly Limits</h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="monthlyTotal" required>
                                <option value="1" {{ $user->monthlyTotal == 1 ? 'selected' : '' }}>ON</option>
                                <option value="0" {{ $user->monthlyTotal != 1 ? 'selected' : '' }}>OFF</option>

                            </select>
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="submit" class="btn btn-{{$text}}" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- Useagse Limits ends --}}
    
    
    
    {{-- lupdate balance --}}


    <div id="balance" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-{{$bg}}">
                    <h4 class="modal-title text-{{$text}}">{{$user->name}} Balance.</strong></h4>
                    <button type="button" class="close text-{{$text}}" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-{{$bg}}">
                    <form method="post" action="{{route('balanceupdate')}}">
                        @csrf
                        <div class="form-group">
                            <h5 class="text-{{$text}}">Update Balance</h5>
                            <input type="number" step="any" class="form-control bg-{{$bg}} text-{{$text}}" name="balance" value="{{$user->account_bal}}">

                        </div>
                        


                        

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="submit" class="btn btn-{{$text}}" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- update balance --}}


    {{-- User code starts --}}
    <div id="bankingcodes" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-{{$bg}}">
                    <h4 class="modal-title text-{{$text}}">{{$user->username}} banking authorization Codes   </strong></h4>
                    <button type="button" class="close text-{{$text}}" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-{{$bg}}">
                    <form method="post" action="{{route('authorizationcodes')}}">
                        @csrf
                        <div class="form-group">
                            <h5 class="text-{{$text}}">{{$settings->code1}} authorization code </h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="code1status" required>
                            <option value="1" {{ $user->code1status == 1 ? 'selected' : '' }}>ON</option>
                            <option value="0" {{ $user->code1status != 1 ? 'selected' : '' }}>OFF</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <h5 class=" ">{{$settings->code1}} Code</h5>
                        <input class="form-control  " value="{{ $user->code1 }}" type="text" name="code1"
                            required>
                    </div>
                        <div class="form-group">
                            <h5 class="text-{{$text}}">{{$settings->code2}} authorization code </h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="code2status" required>
                            <option value="1" {{ $user->code2status == 1 ? 'selected' : '' }}>ON</option>
                            <option value="0" {{ $user->code2status != 1 ? 'selected' : '' }}>OFF</option>
                            </select>
                        </div>

                        <div class="form-group">
                        <h5 class=" ">{{$settings->code2}} Code</h5>
                        <input class="form-control  " value="{{ $user->code2 }}" type="text" name="code2"
                            required>
                    </div>
                        <div class="form-group">
                            <h5 class="text-{{$text}}">{{$settings->code3}} authorization code </h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="code3status" required>

                            <option value="1" {{ $user->code3status == 1 ? 'selected' : '' }}>ON</option>
                            <option value="0" {{ $user->code3status != 1 ? 'selected' : '' }}>OFF</option>
                            </select>
                        </div>
                        <div class="form-group">
                        <h5 class=" ">{{$settings->code3}} Code</h5>
                        <input class="form-control  " value="{{ $user->code3 }}" type="text" name="code3"
                            required>
                    </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="submit" class="btn btn-{{$text}}" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    {{-- User codes ends --}}
<!--signal action model-->


<div id="userActionsignal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header bg-{{$bg}}">
                    <h4 class="modal-title text-{{$text}}">Signal action for {{$user->name}} account.</strong></h4>
                    <button type="button" class="close text-{{$text}}" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body bg-{{$bg}}">
                    <form method="post" action="{{route('signalaction')}}">
                        @csrf
                        <div class="form-group">
                            <h5 class="text-{{$text}}">On or Off signal action</h5>
                            <select class="form-control bg-{{$bg}} text-{{$text}}" name="signalstatus" required>
                                <option value="" selected disabled>Select Column</option>
                                <option value="Yes">On signal</option>
                                <option value="No">Off signal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input class="form-control bg-{{$bg}} text-{{$text}}" placeholder="Enter actoin amount" type="text" name="signalamount" >
                        </div>
                         <div class="form-group">
                            <input class="form-control bg-{{$bg}} text-{{$text}}" placeholder="Enter signal name" type="text" name="signalname" >
                        </div>

                        <div class="form-group">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
                            <input type="submit" class="btn btn-{{$text}}" value="Submit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--user action modal end-->

 <!-- send a single user email Modal-->
 <div id="sendmailtooneuserModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">Send Email</h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <p class="">This message will be sent to {{ $user->name }}</p>
                 <form style="padding:3px;" role="form" method="post" action="{{ route('sendmailtooneuser') }}">
                     @csrf
                     <div class=" form-group">
                         <input type="text" name="subject" class="form-control  " placeholder="Subject" required>
                     </div>
                     <div class=" form-group">
                         <textarea placeholder="Type your message here" class="form-control  " name="message" row="8"
                             placeholder="Type your message here" required></textarea>
                     </div>
                     <div class=" form-group">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <input type="submit" class="btn " value="Send">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /Trading History Modal -->

 <div id="TradingModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">
                    @if(!empty($user->profile_photo_path))
                    <img
                        alt="{{ $user->name }}"
                        src="{{ asset('storage/app/public/photos/'.$user->profile_photo_path) }}"
                        width="40" height="40"
                        style="border-radius: 50%;">
                @else
                    @php
                        $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
                    @endphp
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold border border-secondary"
                         style="width: 48px; height: 48px; background-color: #0d6efd; color: white;">
                        {{ $initials }}
                    </div>
                @endif



                    <h1 class="d-inline text-primary"> {{ $user->name }} {{ $user->l_name }} </h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('profileimage') }}" enctype="multipart/form-data">
                     @csrf
                     <div class="form-group">
                         <h5 class=" ">Change {{ $user->name }} profile image</h5>

                     </div>
                     <div class="form-group">
                         <h5 class=" ">Profile image</h5>
                         <input type="file" name="photo" class="form-control  ">
                     </div>

                     <div class="form-group">
                         <input type="submit" class="btn btn-primary" value="Change Profile Image">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- /send a single user email Modal -->

 <!-- Edit user Modal -->
 <div id="edituser" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                @if(!empty($user->profile_photo_path))
    <img
        alt="{{ $user->name }}"
        src="{{ asset('storage/app/public/photos/'.$user->profile_photo_path) }}"
        width="45" height="45"
        style="border-radius: 50%;">
@else
    @php
        $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
    @endphp
    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold border border-secondary"
         style="width: 48px; height: 48px; background-color: #0d6efd; color: white;">
        {{ $initials }}
    </div>
@endif

                <h4 class="modal-title pl-1">Edit {{ $user->name }} details.</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <form role="form" method="post" action="{{ route('edituser') }}">
                     <div class="form-group">
                         <h5 class=" ">Username</h5>
                         <input class="form-control  " id="input1" value="{{ $user->username }}" type="text"
                             name="username" required>
                         {{-- <small>Note: same username should be use in the referral link.</small> --}}
                     </div>
                     <div class="form-group">
                         <h5 class=" ">First Name</h5>
                         <input class="form-control  " value="{{ $user->name }}" type="text" name="name"
                             required>
                     </div>
                     <div class="form-group">
                        <h5 class=" ">Middle Name</h5>
                        <input class="form-control  " value="{{ $user->middlename }}" type="text" name="middlename"
                            required>
                    </div>

                    <div class="form-group">
                        <h5 class=" ">Last Name</h5>
                        <input class="form-control  " value="{{ $user->lastname }}" type="text" name="lastname"
                            required>
                    </div>
                     <div class="form-group">
                         <h5 class=" ">Email</h5>
                         <input class="form-control  " value="{{ $user->email }}" type="text" name="email"
                             required>
                     </div>
                     <div class="form-group">
                         <h5 class=" ">Phone Number</h5>
                         <input class="form-control  " value="{{ $user->phone }}" type="text" name="phone"
                             required>
                     </div>

                     <div class="form-group">
                        <h5 class=" ">Date Of birth</h5>
                        <input class="form-control  " value="{{ $user->dob }}" type="date" name="dob"
                            required>
                    </div>

             <div class="form-group">
                         <h5 class=" "> Address </h5>
                         <input class="form-control  " value="{{ $user->address }}" type="text" name="address"
                             required>
                     </div>
                    <div class="form-group col-md-12">
                        <h6 class="text-{{$text}}">Nationality</h6>
                        <select type="text" class="form-control bg-{{$bg}} text-{{$text}}" name="country"  value='{{ $user->country }}' required>
                            <option value='{{ $user->country }}'>{{ $user->country }}</option>
                            @include('auth.countries')

                        </select>
                    </div>
                     <div class="form-group">
                        <h5 class=" ">Account  Number</h5>
                        <input class="form-control  " value="{{ $user->usernumber }}" type="text" name="usernumber"
                            required>
                    </div>
                     <div class="form-group">
                        <h5 class=" ">IRS Filing No.</h5>
                        <input class="form-control  " value="{{ $user->irs_filing_id }}" type="text" name="irs_filing_id"
                            required>
                    </div>
                    <div class="form-group">
                        <h5 class=" ">{{ $settings->code1 }}</h5>
                        <input class="form-control  " value="{{ $user->code1 }}" type="text" name="code1"
                            required>
                    </div>

                    <div class="form-group">
                        <h5 class=" ">{{ $settings->code2 }}</h5>
                        <input class="form-control  " value="{{ $user->code2 }}" type="text" name="code2"
                            required>
                    </div>
                    <div class="form-group">
                        <h5 class=" ">{{ $settings->code3 }}</h5>
                        <input class="form-control" value="{{ $user->code3 }}" type="text" name="code3"
                            required>
                    </div>
                    <div class="form-group col-md-12">
                        <h6 class="text-{{ $text }}">Account Type</h6>
                        <select type="text" class="form-control  text-{{ $text }}"
                            name="accounttype" value='{{ $user->accounttype }}' required>
                            <option value="{{ $user->accounttype }}">{{ $user->accounttype }}</option>
                            <option value="Checking Account">Checking Account</option>
                            <option value="Savings Account">Saving Account</option>
                            <option value="Fixed Deposit Account">Fixed Deposit Account</option>
                            <option value="Current Account">Current Account</option>
                            <option value="Crypto Currency Account">Crypto Currency Account</option>
                            <option value="Business Account">Business Account</option>
                            <option value="Non Resident Account">Non Resident Account</option>
                            <option value="Cooperate Business Account">Cooperate Business Account</option>
                            <option value="Investment Account">Investment Account</option>
                    </select>
                    </div>

                     <div class="form-group">
                        <h6 class="text-{{ $text }}">Account Limit ({{$settings->currency}}) </h6>
                        <input type="number" class="form-control  text-{{ $text }}"
                            name="limit" value='{{ $user->limit }}' required>
                    </div>
                    <div class="form-group">
                        <h6 class="text-{{ $text }}">4 Digit Transaction pin</h6>
                        <input type="text" class="form-control  text-{{ $text }}"
                            name="pin" value='{{ $user->pin }}' required>
                    </div>

                     {{-- <div class="form-group">
                         <h5 class=" ">Country</h5>
                         <input class="form-control" value="{{ $user->country }}" type="text" name="country">
                     </div> --}}
                     {{-- <div class="form-group">
                         <h5 class=" ">Referral link</h5>
                         <input class="form-control  " value="{{ $user->ref_link }}" type="text" name="ref_link"
                             required>
                     </div> --}}
                     <div class="form-group">
                     <h5 class=" ">Account Age/Date created (You  can back dateAccount age here)</h5>
                         <input class="form-control  " value="{{ $user->created_at }}" type="datetime" name="created_at"
                             required>
                     </div>
                     <div class="form-group">
                         <input type="hidden" name="_token" value="{{ csrf_token() }}">
                         <input type="hidden" name="user_id" value="{{ $user->id }}">
                         <input type="submit" class="btn  btn-primary" value="Update">
                     </div>
                 </form>
             </div>
             <script>
                 $('#input1').on('keypress', function(e) {
                     return e.which !== 32;
                 });
             </script>
         </div>
     </div>
 </div>
 <!-- /Edit user Modal -->

 <!-- Reset user password Modal -->
 <div id="resetpswdModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">Reset Password</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <p class="">Are you sure you want to reset password for {{ $user->name }} to <span
                         class="text-primary font-weight-bolder">user01236</span></p>
                 <a class="btn " href="{{ url('admin/dashboard/resetpswd') }}/{{ $user->id }}">Reset Now</a>
             </div>
         </div>
     </div>
 </div>
 <!-- /Reset user password Modal -->


<!-- Generate Transactions Starts -->
<div id="generate" class="modal fade" role="dialog">
    <div class="modal-dialog ">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header ">
                @if(!empty($user->profile_photo_path))
                <img
                    alt="{{ $user->name }}"
                    src="{{ asset('storage/app/public/photos/'.$user->profile_photo_path) }}"
                    width="45" height="45"
                    style="border-radius: 50%;">
            @else
                @php
                    $initials = strtoupper(substr($user->name, 0, 1) . substr($user->lastname, 0, 1));
                @endphp
                <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold border border-secondary"
                     style="width: 48px; height: 48px; background-color: #0d6efd; color: white;">
                    {{ $initials }}
                </div>
            @endif

               <h4 class="modal-title pl-1">Generate Transaction for {{$user->username}} Account.</strong></h4>
                <button type="button" class="close " data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body ">
                <form method="post" action="{{ route('generateTransactions') }}">
                    @csrf
                    <div class="form-group">
                       <h4 class="">Min Amount</h4>
                        <input class="form-control" placeholder="Enter Min amount" type="number" name="min_amount"
                            required>
                    </div>

                    <div class="form-group">
                       <h4 class="">Max Amount</h4>
                        <input class="form-control" placeholder="Enter Max amount" type="number" name="max_amount"
                            required>
                    </div>

<div class="form-group">
    <h4 class="">Transaction Type</h4>
    <select name="type" class="form-control" required>
        <option value="" disabled selected>Select Type</option>
        <option value="credit">Credit</option>
        <option value="debit">Debit</option>
    </select>
</div>

                    <div class="form-group">
                       <h5 class="">From Date</h5>
                       <input class="form-control" name="from_date" type='datetime-local' >


                   </div>

                   <div class="form-group">
                       <h5 class="">To Date</h5>
                       <input class="form-control" name="to_date" type='datetime-local' >


                   </div>

                   <div class="form-group">
                       <h4 class="">Number Of Transactions to Generate</h4>
                        <input class="form-control" placeholder="Enter number transactions" type="number" name="number_of_transactions"
                            required>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="submit" class="btn btn-primary" value="Generate Transactions">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Generate Transactions Ends -->

 <!-- Switch useraccount Modal -->
 <div id="switchuserModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">You are about to login as {{ $user->name }}.</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <a class="btn btn-success"
                     href="{{ url('admin/dashboard/switchuser') }}/{{ $user->id }}">Proceed</a>
             </div>
         </div>
     </div>
 </div>
 <!-- /Switch user account Modal -->

 <!-- Clear account Modal -->
 <div id="clearacctModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">
                 <h4 class="modal-title ">Clear Account</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body ">
                 <p class="">You are clearing account for {{ $user->name }} to {{ $settings->currency }}0.00
                 </p>
                 <a class="btn " href="{{ url('admin/dashboard/clearacct') }}/{{ $user->id }}">Proceed</a>
             </div>
         </div>
     </div>
 </div>
 <!-- /Clear account Modal -->

 <!-- Delete user Modal -->
 <div id="deleteModal" class="modal fade" role="dialog">
     <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header ">

                 <h4 class="modal-title ">Delete User</strong></h4>
                 <button type="button" class="close " data-dismiss="modal">&times;</button>
             </div>
             <div class="modal-body  p-3">
                 <p class="">Are you sure you want to delete {{ $user->name }} Account? Everything associated
                     with this account will be loss.</p>
                 <a class="btn btn-danger" href="{{ url('admin/dashboard/delsystemuser') }}/{{ $user->id }}">Yes
                     i'm sure</a>
             </div>
         </div>
     </div>
 </div>
 <!-- /Delete user Modal -->
