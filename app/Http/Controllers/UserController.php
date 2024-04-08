<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function LoginPage(){
        return view('pages.auth.login-page');
    }

    function RegistrationPage(){
        return view('pages.auth.registration-page');
    }
    function SendOtpPage(){
        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage(){
        return view('pages.auth.verify-otp-page');
    }

    function ResetPasswordPage(){
        return view('pages.auth.reset-pass-page');
    }

    function ProfilePage(Request $request){
        return view('pages.dashboard.profile-page');
    }

 

















    public function UserRegistration(Request $request){
        try{
            User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'password' => $request->input('password')
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration Failed'
            ]);
        }
       
    }

    public function UserLogin(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $count = User::where('email', '=', $email)
                ->where('password', '=', $password)
                ->select('id')->first();
           
            if($count != null){
        
               $token = JWTToken::CreateToken($email, $count->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Login Successfull',
                ],200)->cookie('token', $token, time()+60+24*30);
            }else{
                return response()->json([
                    'status' => 'failed',
                    'message' => 'unauthorized from controller'
                ]);
            }
    }

    public function SendOTPCode(Request $request){
        $email = $request->input('email');
        $otp = rand(1000, 9999);
        $count = User::where('email', '=', $email)->count();
        if($count == 1){
            User::where('email', '=', $email)->update([
                'otp' => $otp
            ]);
            Mail::to($email)->send(new OTPMail($otp));
            return response()->json([
                'status' => 'success',
                'message' => '4 Digit OTP has Sent to Email'
            ]);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function VerifyOTP(Request $request){
        $email = $request->input('email');
        $otp = $request->input('otp');
        $count = User::where('email', '=', $email)
            ->where('otp', '=', $otp)
            ->count();

        if($count == 1){
            User::where('email', '=', $email)
                ->update([
                    'otp' => '0'
                ]);
            $token = JWTToken::CreateTokenForSetPassword($request->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'OTP Verification Successfull'
            ])->cookie('token', $token, 60 * 24 * 30 * 60 * 60);
        }else{
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorized'
            ]);
        }
    }

    public function ResetPassword(Request $request){
        try{
            $email = $request->header('email');
            $password = $request->input('password');
            User::where('email', '=', $email)
                ->update([
                    'password' => $password
                ]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Request Successfull'
                ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Something Went Wrong'
            ]);
        }
    }

    public function UserLogout(){
        return redirect('/userLogin')->cookie('token', '', -1);
    }

    public function UserProfile(Request $request){

        $email = $request->header('email');
        $user = User::where('email', '=', $email)
            ->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ]);

    }

    public function UpdateProfile(Request $request){

        try{
            $email = $request->header('email');
            $firstName = $request->input('firstName');
            $lastName = $request->input('lastName');
            $mobile = $request->input('mobile');
            $password = $request->input('password');
            User::where('email', '=', $email)->update([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'mobile' => $mobile,
                'password' => $password
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful'
            ]);
        }catch(Exception $e){
            return response()->json([
                'status' => 'failed',
                'message' => 'Something Went Wrong'
            ]);
        }


    }




















    // testing perpose
    // public function testCreateToken(Request $request){
    //     $userEmail = $request->input('userEmail');
    //     $userID = $request->input('userID');
    //    return JWTToken::CreateToken($userEmail, $userID);
     
    // }

    // public function testVerifyToken(Request $request){
    //     $token = $request->input('token');

    //     return JWTToken::VerifyToken($token);


        
    // }

}