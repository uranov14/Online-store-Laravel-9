<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Country;
use App\Models\Cart;
use Auth;
use Validator;
use Session;
use Hash;

class UserController extends Controller
{
    public function loginRegister() {
        return view('front.users.login_register');
    }

    public function userRegister(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:10',
                'email' => 'required|email|max:150|unique:users',
                'password' => 'required|min:6',
                'accept' => 'required',
            ], [
                'accept.required' => "Please accept our Terms & Conditions"
            ]);

            if ($validator->passes()) {
                //Register new User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                //Set Default Timezone to Ukraine
                date_default_timezone_set("Europe/Kyiv");
                $user->created_at = date("Y-m-d H:i:s");
                $user->updated_at = date("Y-m-d H:i:s");

                //Activate the user only when user confirming his email account
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])
                ];
                Mail::send('emails.confirm', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Confirm your E-commerce Account!');
                });

                //Redirect back user with success message
                $redirectTo = url('user/login-register');
                return response()->json(['type'=>'success','url'=>$redirectTo, 'email'=>$email, 'message'=>"Please confirm your email to activate your account."]);

                //Activate the user straight way without sending any confirmation email


                //Send Register Email
                /* $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'mobile' => $data['mobile']
                ];

                Mail::send('emails.register', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Welcome to Stack Developers E-commerce!');
                }); */

                //Send Register Sms
                /* $message = "Dear Customer, you have been successfully registered with our E-commerce Shop. Login to your Account to access orders,addresses and available offers!";
                $mobile = $data['mobile'];

                Sms::sendSms($message, $mobile); */

                /* if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                    //Update User Cart with user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                } */
            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }
    }

    public function userLogin(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users',
                'password' => 'required|min:6'
            ]);

            if ($validator->passes()) {
                if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {

                    if (Auth::user()->status == 0) {
                        Auth::logout();
                        return response()->json(['type'=>'inactive', 'message'=>"Your Account is not inactivated. Please confirm your email to activate your account!"]);
                    }

                    //Update User Cart with user id
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    $redirectTo = url('cart');
                    return response()->json(['type'=>'success','url'=>$redirectTo]);
                } else {
                    return response()->json(['type'=>'incorrect', 'message'=>"Incorrect Your Email or Password!"]);
                }
            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        }
    }

    public function userAccount(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'address' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'mobile' => 'required|numeric|digits:10',
                'pincode' => 'required|numeric|digits:5'
            ]);

            if ($validator->passes()) {
                //Update User Details
                User::where('id', Auth::user()->id)->update([
                    'name'=>$data['name'],
                    'mobile'=>$data['mobile'],
                    'city'=>$data['city'],
                    'state'=>$data['state'],
                    'address'=>$data['address'],
                    'country'=>$data['country'],
                    'pincode'=>$data['pincode'],
                ]);

                //Redirect back user with success message
                return response()->json(['type'=>'success', 'message'=>"Your contact/billing details successfully updated!"]);
            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        } else {
            $countries = Country::where('status', 1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
        
    }

    public function userUpdatePassword(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|min:6|same:new_password'
            ]);

            if ($validator->passes()) {
                $current_password = $data['current_password'];
                $userDetails = User::where('id', Auth::user()->id)->first();
                if (Hash::check($current_password, $userDetails->password)) {
                    //Update User Password
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['new_password']);
                    $user->save();

                    //Redirect back user with success message
                    return response()->json(['type'=>'success', 'message'=>"Your password successfully updated!"]);
                } else {
                    //Redirect back user with error message
                    return response()->json(['type'=>'incorrect', 'message'=>"Your current password is incorrect!"]);
                }

                //Redirect back user with success message
                return response()->json(['type'=>'success', 'message'=>"Your contact/billing details successfully updated!"]);
            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
        } else {
            $countries = Country::where('status', 1)->get()->toArray();
            return view('front.users.user_account')->with(compact('countries'));
        }
        
    }

    public function forgotPassword(Request $request) {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150|exists:users'
            ], [
                'email.exists' => "Your Email does not exists."
            ]);

            if ($validator->passes()) {
                $email = $data['email'];

                //Generate New Password
                $new_password = Str::random(16);

                //Update Password
                User::where('email', $email)->update(['password'=>bcrypt($new_password)]);

                //Get User Details
                $userDetails = User::where('email', $email)->first()->toArray();

                //Send Email to User
                $messageData = [
                    'email' => $email,
                    'name' => $userDetails['name'],
                    'password' => $new_password
                ];

                Mail::send('emails.user_forgot_password', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('New Password E-commerce Account');
                });

                //Show Success Message
                return response()->json(['type'=>'success', 'message'=>"New Password sent to your registered email!"]);

            } else {
                return response()->json(['type'=>'error', 'errors'=>$validator->messages()]);
            }
            
        } else {
            return view('front.users.forgot_password');
        }
    }

    public function confirmAccount($code) {
        $email = base64_decode($code);
        $userCount = User::where('email', $email)->count();
        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            //echo $userDetails->status; die;
            if ($userDetails->status == 1) {
                //Redirect the user to Login/Register Page with error message
                return redirect('user/login-register')->with('error_message', "Your account is already activated. You can login and buy now.");
            } else {
                User::where('email', $email)->update(['status'=>1]);

                //Send Welcome Email
                $messageData = [
                    'email' => $email,
                    'name' => $userDetails->name,
                    'mobile' => $userDetails->mobile
                ];

                Mail::send('emails.register', $messageData, function ($message)use($email) {
                    $message->to($email)->subject('Welcome to Stack Developers E-commerce!');
                });

                //Redirect the user to Login/Register Page with success message
                return redirect('user/login-register')->with('success_message', "Your account is activated. You can login and buy now.");
            }
        } else {
            abort(404);
        }
    }

    public function userLogout() {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}
