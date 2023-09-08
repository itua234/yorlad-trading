<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'status'
    ];

    protected $hidden = [
        'updated_at',
        'user_id'
    ];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->toFormattedDateString(),
            set: fn ($value) => $value
        );
    }

    /*protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value, 2),
            set: fn ($value) => $value
        );
    }*/

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
