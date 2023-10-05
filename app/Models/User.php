<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'phone',
        'email',
        'password',
        'firstname',
        'lastname',
        'balance',
        'pin',
        'referral',
        'total_withdrawal',
        'total_income',
        "referral_income",
        "usertype"
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'phone_verified_at' => 'datetime',
        //'password' => 'hashed',
    ];

    protected function firstname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function lastname(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => ucwords(strtolower($value)),
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value,
            set: fn ($value) => strtolower($value),
        );
    }

    public function bank()
    {
        return $this->hasOne(BankDetail::class, 'user_id');
    }

    public function referees()
    {
        return $this->hasMany(ReferralUser::class, 'user_id');
    }

    public function referer()
    {
        return $this->hasOne(ReferralUser::class, 'referee_id');
    }

}
