<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function(){

    /**
     * Dashboard Group 
     */

    Route::group(['prefix' => 'dashboard'], function(){
        Route::post('listMerchant', 'Dashboard\DashboardController@getListMerchant');
        Route::post('merchantDetail', 'Dashboard\DashboardController@getMerchantDetail');  
    }); 

    /**
     * Transaction group
     */
    Route::group(['prefix' => 'transaction'], function(){
        Route::post('newBookingTransaction', 'Transaction\TransactionController@setNewBookingTransaction');
    });

    /**
     * Receipt
     */
    Route::group(['prefix' => 'receipt'], function(){
        Route::post('confirmation', 'Transaction\TransactionController@getReceiptTransaction');
    });

    
    # ------------------------------------------------------------------------------------
    /**
     * Coffee Shop Group
     */
    Route::group(['prefix' => 'coffeeshop'], function(){
        Route::post('profile', 'CoffeeShop\CoffeeShopController@getCoffeeShopProfile');
        Route::post('updateProfile', 'CoffeeShop\CoffeeShopController@setCoffeeShopProfile');
    });

    /**
     * Product Group
     */
    Route::group(['prefix' => 'product'], function(){
        Route::post('getCategoryProductFromMerchant', 'Product\ProductController@getCategoryProductFromMerchant');
        Route::post('getDetailProductFromCategory', 'Product\ProductController@getDetailProductFromCategory');
        Route::post('newReleaseProduct', 'Product\ProductController@setNewReleaseProduct');
        Route::post('detailProduct', 'Product\ProductController@getDetailProduct');
    });

});

Route::group(['prefix' => 'v3'], function(){
    Route::post('userSignUp', 'Register\RegisterController@setRegisterUserSignUp');
    Route::post('coffeShopRegister', 'Register\RegisterController@setRegisterCoffeShop');
    Route::post('phoneVerification', 'Register\RegisterController@setPhoneVerification');
    Route::post('resendCodeVerification', 'Register\RegisterController@setResendCode');
});
