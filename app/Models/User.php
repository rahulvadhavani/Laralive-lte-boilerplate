<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $appends = array('full_name');
    const ROLEADMIN = 1;
    const ROLEUSER= 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'role',
        'image',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getImageAttribute(){
        if (!$this->attributes['image'] || !File::exists(public_path('uploads/'.$this->attributes['image']))) {
            return url('dist/img/avatar.png');
        }
        return  url('uploads/'.$this->attributes['image']);
    }

    public function getFullNameAttribute(){
        return  $this->attributes['first_name'] .' '.$this->attributes['last_name'];
    }

    public function ScopeUserRole($query){
        return $query->where('role',self::ROLEUSER);
    }
    
}
