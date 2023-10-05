<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    //use SoftDeletes;

    protected $fillable = [
        'name',
        'uuid',
    ];

    /*protected $hidden = [
        'created_at',
        'updated_at'
    ];*/

    protected $dates = ["deleted_at"];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
    
}
