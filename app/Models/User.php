<?php

namespace App\Models;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable,SoftDeletes;

    public $transformer=UserTransformer::class;
    protected $table='users';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function setPasswordAttribute($value)
    {
        $this->attributes['password']=Hash::make($value);
//        $this->attributes['password']=crypt($value);
    }

    public static function generateVerificationCode()
    {
        return Str::random(32);
    }
}
