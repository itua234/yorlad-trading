<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Validator, Response, Hash};
use App\Models\{User, Otp, Product, Category, ReferralUser};
use App\Rules\{
    ContainsNumber,
    HasSpecialCharacter,
    PhoneVerified
};
use Carbon\Carbon;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        $referral = $request["referral"] ?? "";

        return view('auth.register', [
            "referral" => $referral
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'firstname' => ["required", "string"],
            'lastname' => ["required", "string"],
            'password' => [
                'required', 
                'string', 
                'min:6'
            ],
            'referral' => ["required", "exists:users,referral"],
            'password_confirmation' => 'required|same:password',
            'phone' => ['required', 'size:10', new PhoneVerified]
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "Registration failed",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = new User();
        $user->phone = $request["phone"];
        $user->firstname = $request["firstname"];
        $user->lastname = $request["lastname"];
        $user->password = Hash::make($request["password"]);
        $user->referral = Str::random(7);
        $user->phone_verified_at = date('Y-m-d h:i:s', time());
        $user->save();

        $oldUser = User::where([
            "referral" => $request["referral"]
        ])->first();
        if($oldUser):
            ReferralUser::create([
                "user_id" => $oldUser->id,
                "referee_id" => $user->id
            ]);
        endif;


        return Response::json([
            'status'    => 'success',
            'message'   => 'Registration successful',
            'results'     => $user,
            "redirect" => url("/")
        ], 201);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "password" => "required",
            "phone" => "required"
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "Login failed",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $user = User::where(['phone' => $request["phone"]])->first();
        if(!$user || !Hash::check($request["password"], $user->password)):
            return Response::json([
                'status' => 'fail',
                'message' => 'Invalid credentials',
                'error' => true
            ], 400);
        endif;

        //Authentication successful
        Auth::login($user, true);
        $user = Auth::user();
        $token = $user->createToken("web-session")->plainTextToken;
        $user->token = $token;
        
        return Response::json([
            'status' => 'success',
            "message" => "Login successful",
            'results' => $user,
            "redirect" => url("/")
        ], 200);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login");
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'password' => [
                'required', 
                'string', 
                'min:6'
            ],
            'confirm_password' => 'required|same:password',
            'phone' => ['required', 'size:10', 'exists:users,phone'],
            "code" => "required"
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "Registration failed",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $phone = $request["phone"];
        $otp = $request["code"];
        $otp = Otp::where([
            "otp" => $otp, 
            "phone" => $phone, 
            "valid" => true, 
            "purpose" => "password_reset"
        ])->where('created_at', '>=', Carbon::now()->subHours(24)->toDateTimeString())->first();
        if(!$otp){
            return Response::json([
                'status'    => 'failed',
                'message'   => 'Password reset failed',
                'error' => [
                    "code" => [
                        "invalid code."
                    ]
                ]
            ], 422);
        }

        $user = User::where(["phone" => $phone])->first();
        $user->password = Hash::make($request["password"]);
        $user->save();

        $otp->delete();

        return Response::json([
            'status' => 'success',
            "message" => "success",
            "redirect" => url("/login")
        ], 200);
    }

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone' => ['required', 'size:10', new PhoneVerified],
            'purpose' => "required"
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $otp = new Otp();
        $otp->otp = mt_rand(1000, 9999);
        $otp->phone = $request["phone"];
        $otp->purpose = $request["purpose"];
        $otp->save();

        return Response::json([
            'status'    => 'success',
            'message'   => 'Success'
        ], 201);
    }

    public function sendResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'phone' => ['required', 'size:10', 'exists:users,phone'],
            'purpose' => "required"
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }

        $phone = $request["phone"];
        $code = mt_rand(1000, 9999);

        $otp = new Otp();
        $otp->otp = $code;
        $otp->phone = $phone;
        $otp->purpose = $request["purpose"];
        $otp->save();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://login.betasms.com.ng/api/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'username' => "demo@opas.pro",
                'password' => "12345",
                'sender' => "Yorlad",
                'mobiles' => $phone,
                'message' => "Your verification number is: ".$code
            ),
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        return Response::json([
            'status'    => 'success',
            'message'   => 'Success'
        ], 201);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'current_password' =>   'required',
            'new_password' => ['required', 'string', 'min:6'],
            'confirm_password' => 'required|same:new_password'
        ]);

        if($validator->fails())
        {
            return response([
                'message' => "failed to send otp",
                'error' => $validator->getMessageBag()->toArray()
            ], 422);
        }
        $current_password = $request["current_password"];
        $new_password = $request["new_password"];

        $user = User::find(Auth::user()->id);
        
        if((Hash::check($current_password, $user->password)) == false):
            $message = "Check your current password.";
            $error = [
                "current_password" => "Check your current password."
            ];
        elseif((Hash::check($new_password, $user->password)) == true):
            $message = "Please enter a password which is not similar to your current password.";
            $error = [
                "new_password" => "Please enter a password which is not similar to your current password."
            ];
        else:
            $user->password = Hash::make($new_password);
            $user->save();
            $message = "Your password has been changed successfully";
            return Response::json([
                'status'    =>'success',
                'message'   =>$message,
                'results'     => $user
            ], 200);
        endif;

        return Response::json([
            'status'    => 'failed',
            'message'   => $message,
            'error'     =>  $error
        ], 422); 
    }

}
