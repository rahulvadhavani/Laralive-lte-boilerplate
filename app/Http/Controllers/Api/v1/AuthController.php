<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\{UserRegisterRequest, UserLoginRequest, ForgotPasswordRequest, VerifyOtpRequest, ResetPasswordRequest, UserSocialLoginRequest};
use App\Mail\{SignupMail, ForgotPasswordMail};
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\{Crypt, URL, Mail, Auth};

class AuthController extends Controller
{
    public function Register(UserRegisterRequest $request)
    {
        try {
            $validData = $request->validated();
            $validData['role'] = User::ROLEUSER;
            if (isset($validData['image']) && $validData['image'] != '') {
                $validData['image'] = $request->image->store('users', ['disk' => 'userPublic']);
            }
            $user = User::create($validData);
            $link = URL::to("verify-email/" . Crypt::encrypt($user->id));
            $email_data = ['name' =>  $user->name, 'link' =>  $link,];
            Mail::to($request->email)->send(new SignupMail($email_data));
            return success('Signup successfully, Please verify your email address.');
        } catch (Exception $e) {
            return error('Something went wrong', $e->getMessage());
        }
    }

    public function EmailVerification($id)
    {
        $user = User::where('id', Crypt::decrypt($id))->where('email_verified_at', null)->first();
        if ($user == null) {
            abort(404);
        }
        $user->update(['email_verified_at' => date('Y-m-d H:i:s')]);
        return view('account-verified-success');
    }

    public function ForgotPasword(ForgotPasswordRequest $request)
    {
        try {
            $post = $request->validated();
            $user = User::userRole(true)->where('email', $post['email'])->first();
            if ($user == null) {
                return error('No user found with this email!');
            }
            $otp = PasswordReset::GenerateOtp();
            $expireTime = Carbon::now()->subMinute(PasswordReset::EXPIRE)->toDateTimeString();
            PasswordReset::where('email', $request->email) //delete expired token
                ->where('created_at', '<', $expireTime)
                ->delete();
            PasswordReset::create(['email' => $request->email, 'token' => $otp]);
            $mailData = [
                'name'      =>  $user->name,
                'otp'       => $otp,
                'expire'    => PasswordReset::EXPIRE,
            ];
            Mail::to($request->email)->send(new ForgotPasswordMail($mailData));
            return success('Forgot password OTP sent on your email.');
        } catch (Exception $e) {
            return error('Something went wrong', $e->getMessage());
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        try {
            $validData = $request->validated();
            $otp = PasswordReset::checkOtp($validData);
            $res = $otp ? success("OTP verified successfully.") : error('Invalid OTP');
            return $res;
        } catch (Exception $e) {
            return error('Something went wrong', $e->getMessage());
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $validData = $request->validated();
            $user = User::userRole(true)->where('email', $validData['email'])->first();
            $otpVerified = PasswordReset::checkOtp($validData);
            if ($user == null || !$otpVerified) {
                return error('Invalide request');
            }
            $udateData['password'] = $validData['password'];
            $user->update($udateData);
            PasswordReset::where('email', $validData['email'])->delete();
            return success('Passowrd reset successfully.');
        } catch (Exception $e) {
            return error('Something went wrong', $e->getMessage());
        }
    }

    public function signIn(UserLoginRequest $request)
    {
        try {
            $validData = $request->all();
            if (Auth::attempt(['email' => $validData['email'], 'password' => $validData['password']])) {
                $user = User::userRole()->where('id', Auth::user()->id)->first();
                if($user->status == User::STATUSINACTIVE){
                    return error('You account is not active, Please contact to admin for active you account request.');
                }
                elseif ($user->email_verified_at != null) {
                    $tokenBody = User::getTokenAndRefreshToken($validData['email'], $validData['password']);
                    return loginAndSignupSuccess('Login successful', $tokenBody, $user->loginResponse());
                } else {
                    return error('Please verify your email address!');
                }
            } else {
                return error('Login credentials are invalid!');
            }
        } catch (Exception $err) {
            return error('Something went wrong', $err->getMessage());
        }
    }
}
