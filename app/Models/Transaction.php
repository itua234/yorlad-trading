<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'product_id',
        'account_id',
        'amount',
        "amount_paid",
        'status',
        'reference',
        'verified',
        'date',
        'last_clicked'
    ];

    protected $hidden = [
        //'created_at',
        'updated_at'
    ];

    protected $with = ["account"];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format("Y-m-d H:i:s"),
            set: fn ($value) => $value
        );
    }

}
