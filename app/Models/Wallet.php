<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'earnings',
        'balance'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'doctor_id',
        'id'
    ];

    protected function balance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2),
            set: fn ($value) => $value,
        );
    }

    protected function earnings(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2),
            set: fn ($value) => $value,
        );
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'wallet_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, "doctor_id");
    }

}
