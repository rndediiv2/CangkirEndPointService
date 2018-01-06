<?php

namespace App\Http\Controllers\Transaction;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Model\ProductTransaction;
use App\Model\ProductTransactionDetails;
use Carbon\Carbon;
use DB;
class TransactionController extends Controller
{
    
    public function setNewBookingTransaction(Request $request)
    {
        try
        {
            $arrTransaction['transaction_user_id'] = $request->user()->id;
            $arrTransaction['transaction_name'] = $request->user()->name;
            $arrTransaction['transaction_phone'] = $request->user()->phone;
            $arrTransaction['transaction_mail'] = $request->user()->email;
            $arrTransaction['transaction_coffee_id'] = $request->coffee_id;
            $arrTransaction['transaction_coffee_name'] = $request->coffee_name;
            $arrTransaction['transaction_arrived'] = $request->arrived;
            $arrTransaction['transaction_tips'] = $request->tips;
            $arrTransaction['transaction_bills'] = $request->bills;
            $arrTransaction['transaction_notes'] = $request->notes;
            $arrTransaction['transaction_expired'] = Carbon::now()->addMinutes(60);
            $arrTransaction['transaction_time'] = date("Y-m-d H:i:s");
            $productTransaction = ProductTransaction::create($arrTransaction);
            if($productTransaction)
            {
                $arrRequestProductTransactionDetails = $request->product;
                $arrKeyProductTransactionDetails = array_keys($arrRequestProductTransactionDetails);
                for($a = 0; $a < count($_POST['product']['details_product_id']); $a++){
                    $detailSerial = DB::table('trproducttransactiondetails')->select('details_serial')->where('details_id', $productTransaction->transaction_id)->max('details_serial') + 1;
                    $arrProductTransactionDetails = array('details_id' => $productTransaction->transaction_id,
                                                          'details_serial' => $detailSerial);
                    for($b=0;$b<count($arrKeyProductTransactionDetails);$b++)
                    {
                        $arrProductTransactionDetails[$arrKeyProductTransactionDetails[$b]] = $arrRequestProductTransactionDetails[$arrKeyProductTransactionDetails[$b]][$a];
                    }
                    
                    $itemPrice = $arrProductTransactionDetails['details_product_price'];
                    $discPrice = $arrProductTransactionDetails['details_product_disc'];
                    $itemQty = $arrProductTransactionDetails['details_product_qty'];
                    if($discPrice > 0)
                    {
                        $iTempPrice = ($discPrice / 100) * $itemPrice;
                        $iSubtotal = ($itemPrice - $iTempPrice) * $itemQty;
                    }
                    else
                    {
                        $iSubtotal = $itemPrice * $itemQty;
                    }

                    $arrProductTransactionDetails['details_product_subtotals'] = $iSubtotal;
                    ProductTransactionDetails::create($arrProductTransactionDetails);
                }
            }
            return response()->json([
                'message' => 'Transaction has been successfully',
                'redirect' => [
                    'statement' => true,
                    'url' => 'bookingReceipt'
                ],
                'status' => 200,
                'collection' => [
                    'reff' => $productTransaction->transaction_id 
                ]
            ]);  
        }
        catch (Exception $e) 
        {
            return response()->json(['error' => $e, 'status' => 400]);
        }
    }

    public function getReceiptTransaction(Request $request)
    {
        try {
            $objTransaction = ProductTransaction::with(['details'])->where('transaction_id', '=', $request->transaction)->firstOrFail();
            return response()->json([
                'message' => 'OK',
                'status' => 200,
                'collection' => $objTransaction
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => $ex, 'status' => 400]);
        }
    }
}
