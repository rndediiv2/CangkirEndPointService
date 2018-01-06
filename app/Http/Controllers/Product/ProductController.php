<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Validator;
use App\Model\CoffeeProduct;
use App\Model\CoffeeProductPrice;

class ProductController extends Controller
{
    public function setNewReleaseProduct(Request $request)
    {
        $arrRequest = (array)$request->all();
        $arrProduct = [
            'coffee_shop_owner'     => $arrRequest['coffee_id'],
            'coffee_category_id'    => $arrRequest['category'],
            'coffee_product_title'  => $arrRequest['title'],
            'coffee_product_body'   => $arrRequest['description'],
            'coffee_product_thumbs' => $arrRequest['thumbs'],
            'coffee_product_disc'   => 0,
            'coffee_product_active' => 1
        ];
        $validatorProductEntry = Validator::make($arrProduct, [
            'coffee_shop_owner' => 'required|max:36',
            'coffee_product_title' => 'required|max:150',
            'coffee_product_body' => 'required|max:500'
        ],[
            'coffee_shop_owner.required' => 'Owner must bee selected or fill with 36 max of character',
            'coffee_product_title.required' => 'Title of product must be fill with 150 max of character',
            'coffee_product_body.required' => 'Description of product must be fill with 500 max of character'
        ]);

        if($validatorProductEntry->fails())
        {
            return response()->json([
                'error' => $validatorProductEntry->errors(), 
                'status' => 400
            ]);
            die();
        }
        try {
            $Product = CoffeeProduct::create($arrProduct);
            if($Product)
            {
                $arrRequestProductPrice = $request->plan;
                $arrKeyProductPrice = array_keys($arrRequestProductPrice);
                for($a = 0; $a < count($_POST['plan']['coffee_price_name']); $a++){
                    $arrProductPrice = array('coffee_product_id' => $Product->coffee_product_id);
                    for($b=0;$b<count($arrKeyProductPrice);$b++)
                    {
                        $arrProductPrice[$arrKeyProductPrice[$b]] = $arrRequestProductPrice[$arrKeyProductPrice[$b]][$a];
                    }
                    CoffeeProductPrice::create($arrProductPrice);
                }
                $objProduct = CoffeeProduct::with(['category', 'pricing'])->find($Product->coffee_product_id);
                return response()->json([
                    'message' => 'New product has been successfully added',
                    'redirect' => [
                        'statement' => true,
                        'url' => 'productDetail'
                    ],
                    'status' => 200,
                    'collection' => $objProduct
                ]); 
            }
            else
            {
                return response()->json([
                    'error' => 'Ups ... something went wrong. Please try again', 
                    'status' => 400
                ]);    
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => $e, 
                'status' => 400
            ]);
        }
    }

    public function getDetailProduct(Request $request)
    {
        try {
            $objProduct = CoffeeProduct::with(['category', 'pricing'])->where('coffee_product_id', '=', $request->product_id)->firstOrFail();
            return response()->json([
                'message' => 'OK',
                'status' => 200,
                'collection' => $objProduct
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => $ex, 'status' => 400]);
        }
    }

    public function getCategoryProductFromMerchant(Request $request)
    {
        try {
            $objProduct = CoffeeProduct::with(['category', 'pricing'])->where([
                ['coffee_shop_owner', '=', $request->coffee_id],
                ['coffee_category_id', '=', $request->category]
            ])->get();
            return response()->json([
                'message' => 'OK',
                'status' => 200,
                'collection' => $objProduct
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => $ex, 'status' => 400]);
        }
    }

    public function getDetailProductFromCategory(Request $request)
    {
        try {
            $objProduct = CoffeeProduct::with(['category', 'pricing'])->where([
                ['coffee_product_id', '=', $request->product_id],
                ['coffee_category_id', '=', $request->category]
            ])->get();
            return response()->json([
                'message' => 'OK',
                'status' => 200,
                'collection' => $objProduct
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json(['error' => $ex, 'status' => 400]);
        }
    }

}
