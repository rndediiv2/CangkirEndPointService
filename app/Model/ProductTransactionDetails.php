<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductTransactionDetails extends Model
{
    protected $table = 'TrProductTransactionDetails';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'details_id', 'details_serial', 'details_product_id', 'details_product_title', 'details_product_type', 
        'details_product_qty', 'details_product_price', 'details_product_disc', 'details_product_subtotals', 'details_product_remarks'
    ];
}
