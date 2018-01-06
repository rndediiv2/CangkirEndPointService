<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Carbon\Carbon;

class CoffeeShop extends Model
{
    protected $primaryKey = 'coffee_id';
    public $incrementing = false;
    protected $table = 'tmcoffeeshop';

    protected $fillable = [
        'coffee_id', 'coffee_name', 'coffee_address', 'coffee_phone', 'coffee_mail', 'coffee_start_at', 'coffee_stop_at', 
        'coffee_facilites', 'coffee_tagsline', 'coffee_avatar', 'coffee_banner', 'coffee_lat', 'coffee_lang', 'coffee_status'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function userOwner()
    {
        return $this->belongsTo('App\User', 'coffee_id', 'coffee_id')->select(['name', 'email', 'password', 'phone', 'avatar', 'has_coffee', 'coffee_id', 'last_lat', 'last_lang']);
    }

    protected static function boot()
	{
		parent::boot();
		
		static::creating(function ($model) {
			try {
				$model->coffee_id = Uuid::uuid4()->toString();
			} catch (UnsatisfiedDependencyException $e) {
				abort(500, $e->getMessage());
			}
		});
    }
}
