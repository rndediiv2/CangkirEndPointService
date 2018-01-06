<?php

namespace App\Http\Controllers\CoffeeShop;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Model\CoffeeShop;

class CoffeeShopController extends Controller
{
    public function getCoffeeShopProfile(Request $request)
    {
        $arrData = $request->all();
        try {
            $coffeeShopExist = CoffeeShop::where([
                ['coffee_id', '=', $arrData['coffee_id']]
            ])->firstOrFail();
            return response()->json([
                'message' => '',
                'redirect' => '',
                'status' => 200,
                'collection' => $coffeeShopExist
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'error' => 'Not Valid Merchant', 
                'status' => 400
            ]);
        }
    }

    public function setCoffeeShopProfile(Request $request)
    {
        $arrRequest = $request->all();
        try {
            $coffeeShopExist = CoffeeShop::where([
                ['coffee_id', '=', $arrRequest['coffee_id']]
            ])->firstOrFail();
            
            $arrCoffeeShop['coffee_mail'] = $arrRequest['mail'];
            $arrCoffeeShop['coffee_start_at'] = $arrRequest['start_at'];
            $arrCoffeeShop['coffee_stop_at'] = $arrRequest['end_at'];
            $arrCoffeeShop['coffee_facilites'] = $arrRequest['facilities'];
            $arrCoffeeShop['coffee_tagsline'] = $arrRequest['tagsline'];
            $affectedCoffeeShop = CoffeeShop::where('coffee_id', $arrRequest['coffee_id'])->update($arrCoffeeShop);
            if($affectedCoffeeShop)
            {
                return response()->json([
                    'message' => 'Update profile success',
                    'status' => 200,
                    'redirect' => array(
                        'statement' => true,
                        'url' => 'MerchantProfile'
                    ),
                    'collection' => CoffeeShop::where('coffee_id', $arrRequest['coffee_id'])->firstOrFail()
                ]);
            }
            else
            {
                return response()->json([
                    'error' => 'Ups. Something wrong, please try again', 
                    'status' => 400
                ]);    
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'error' => 'Not Valid Merchant', 
                'status' => 400
            ]);
        }
    }
}
