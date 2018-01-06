<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class ProductTransaction extends Model
{
    protected $table = 'TrProductTransaction';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'transaction_id', 'transaction_user_id', 'transaction_name', 'transaction_phone', 'transaction_mail', 'transaction_coffee_id', 'transaction_coffee_name', 'transaction_arrived', 'transaction_method', 'transaction_references', 'transaction_tips', 'transaction_bills', 'transaction_notes', 'transaction_rate', 'transaction_remarks', 'transaction_progress', 'transaction_expired', 'transaction_time'
    ];

    public function details()
    {
        return $this->hasMany('App\Model\ProductTransactionDetails', 'details_id', 'transaction_id')->select(['details_id', 'details_serial', 'details_product_id', 'details_product_title', 'details_product_type', 'details_product_qty', 'details_product_price', 'details_product_disc', 'details_product_subtotals']);
    }

    protected static function boot()
	{
		parent::boot();
		
		static::creating(function ($model) {
			try {
				$model->transaction_id = 'TRXID' . Keygen::numeric(15)->generate();
			} catch (UnsatisfiedDependencyException $e) {
				abort(500, $e->getMessage());
			}
		});
    }

}
