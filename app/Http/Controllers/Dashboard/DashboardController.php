<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Model\CoffeeShop;

class DashboardController extends Controller
{
    public function getListMerchant(Request $request)
    {   
        $subQuery = \DB::table('tmcoffeeshop')->selectRaw('coffee_id, coffee_name, coffee_address,
                                                           coffee_phone, coffee_mail, coffee_start_at, coffee_stop_at,
                                                           coffee_facilites, coffee_avatar, coffee_banner, coffee_lat, coffee_lang, coffee_status,
                                                           ( 6371 * ACOS( COS(RADIANS('. $request->currLat .'))
                                                                    * COS(RADIANS(coffee_lat))
                                                                    * COS(RADIANS(coffee_lang) - RADIANS('. $request->currLang .'))
                                                                    + SIN(RADIANS('. $request->currLat .'))
                                                                    * SIN(RADIANS(coffee_lat)) 
                                                                ) 
                                                            ) as distance')
                                              ->where('coffee_status', 1);
        $objCoffeeShop = \DB::table(\DB::raw('('.$subQuery->toSql().') as t'))
                                    ->selectRaw('coffee_id, coffee_name, coffee_address, coffee_phone, coffee_mail, coffee_start_at, coffee_stop_at, coffee_facilites, coffee_avatar, coffee_banner, coffee_lat, coffee_lang, coffee_status, distance')
                                    ->having('distance', '<', 10)
                                    ->orderBy('distance', 'asc')
                                    ->mergeBindings($subQuery)
                                    ->get();
        return response()->json([
            'message' => 'OK',
            'status' => 200,
            'collection' => $objCoffeeShop
        ]);
    }

    public function getMerchantDetail(Request $request)
    {
        $objRequest = $request->all(); 
        try {
            $coffeeShopExist = CoffeeShop::where([
                ['coffee_id', '=', $objRequest['coffee_id']]
            ])->firstOrFail();
            return response()->json([
                'message' => 'OK',
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
}
