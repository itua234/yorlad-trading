<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'currency_id',
        'name',
        'price',
        'old_price',
        'photo',
        'description',
        'returns',
        'daily_income',
        'validity',
        'expired_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'category_id'
    ];

    protected $with = ["currency"];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

}
