<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;
    const EXPIRE = 60; //Minutes
    const UPDATED_AT = null;
    protected $fillable = [
        'email',
        'token'
    ];

    protected static function GenerateOtp(){
        $otp = rand(100000,999999);
        $token = self::where('token',$otp)->first();
        if($token != null){
            self::GenerateOtp();
        }
        return $otp;
    }
    protected static function checkOtp($data){
        $expireTime = Carbon::now()->subMinute(self::EXPIRE)->toDateTimeString();
        $otp = self::where('email',$data['email'])
        ->where('token',$data['otp'])
        ->where('created_at','>', $expireTime)
        ->first();
        return $otp == null ? false :true;
    }
}
