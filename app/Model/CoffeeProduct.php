<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Carbon\Carbon;

class CoffeeProduct extends Model
{
    protected $primaryKey = 'coffee_product_id';
    public $incrementing = false;
    protected $table = 'trcoffeeproduct';

    protected $fillable = [
        'coffee_product_id', 'coffee_shop_owner', 'coffee_category_id', 'coffee_product_title', 
        'coffee_product_body', 'coffee_product_thumbs', 'coffee_product_disc', 'coffee_product_active'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];


    public function category()
    {
        return $this->belongsTo('App\Model\CoffeeProductCategory', 'coffee_category_id', 'category_id')->select(['category_id', 'category_title', 'category_desc']);
    }

    public function pricing()
    {
        return $this->hasMany('App\Model\CoffeeProductPrice', 'coffee_product_id', 'coffee_product_id')->select(['id', 'coffee_product_id', 'coffee_price_name', 'coffee_price_value', 'coffee_price_offer', 'coffee_price_status']);
    }


    protected static function boot()
	{
		parent::boot();
		
		static::creating(function ($model) {
			try {
				$model->coffee_product_id = Uuid::uuid4()->toString();
			} catch (UnsatisfiedDependencyException $e) {
				abort(500, $e->getMessage());
			}
		});
    }
}
