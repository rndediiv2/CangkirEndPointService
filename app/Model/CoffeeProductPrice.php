<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CoffeeProductPrice extends Model
{
    protected $table = 'trcoffeeproductprice';
    public $timestamps = false;

    protected $fillable = [
        'id', 'coffee_product_id', 'coffee_price_name', 'coffee_price_value', 'coffee_price_offer', 'coffee_price_status'
    ];

}
