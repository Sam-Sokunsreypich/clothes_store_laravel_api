<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    protected $table = 'products';
    protected $fillable =[
        'title',
        'description',
        'price',
        'discount',
        'stock',
        'store_category',
        'user_category',
        'after_dis_price',
        'image',
    ];
}
