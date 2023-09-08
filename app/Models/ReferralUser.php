<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referee_id',
    ];

    public $timestamps = FALSE;
}
