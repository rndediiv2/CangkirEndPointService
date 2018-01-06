<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use App\Model\CoffeeShop;
use Keygen;
use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;
use Nexmo\Laravel\Facade\Nexmo;

class RegisterController extends Controller
{
    public function setRegisterUserSignUp(Request $request)
    {

        // $response = Curl::to('http://api.elpiamessenger.com/api/v3/sendsms/plain')
        //             ->withData(array(
        //                                 'user' => 'insw_api',
        //                                 'password' => 'insw2017',
        //                                 'SMSText' => 'Helo World!',
        //                                 'GSM' => '6281932824567'
        //                             )
        //                       )
        //             ->get();
        // print_r($response);
        // die();
        // $response = Nexmo::message()->send([
        //     'to'   => '6281287388292',
        //     'from' => '16105552344',
        //     'text' => 'Using the facade to send a message.'
        // ]);
        // print_r($response);
        // die();
        
        $arrUserData = (array)$request->all();
        $validatorUser = Validator::make($arrUserData, [
            'name' => 'required|max:75',
            'email' => 'required|email',
            'phone' => 'required|max:14',
            'password' => 'required|max:32'
        ],[
            'name.required' => 'Full name must be fill',
            'email.required' => 'Email must be fill',
            'phone.required' => 'Phone number must be fill',
            'password.required' => 'Password must be fill'
        ]);

        if($validatorUser->fails())
        {
            return response()->json(['status' => 400,
                'error' => $validatorUser->errors()
            ]);
        }
        else
        {
            try {
                $smsToken = Keygen::numeric(6)->generate();
                $userStoreObject = User::create([
                    'name' => $arrUserData['name'],
                    'email' => $arrUserData['email'],
                    'password' => bcrypt($arrUserData['password']),
                    'phone' => $arrUserData['phone'],
                    'last_lat' => $arrUserData['latitude'],
                    'last_lang' => $arrUserData['longitude'],
                    'sms_token' => $smsToken,
                    'sms_expired' => Carbon::now()->addMinutes(5)
                ]);
                $tokenString = $userStoreObject->createToken('CangkirApps')->accessToken;
                return response()->json([
                    'message' => 'Register Successfully',
                    'redirect' => [
                        'statement' => true,
                        'url' => 'VerifikasiPage'
                    ],
                    'status' => 200,
                    'collection' => array(
                        'verification' => array(
                            'token' => $userStoreObject->sms_token,
                            'phone' => $userStoreObject->phone,
                            'expired' => $userStoreObject->sms_expired
                        )
                    )
                ]);
            }
            catch (Exception $e) 
            {
                return response()->json(['error' => 'Unfortunately something went wrong', 'status' => 400]);
            }
        }        
    }

    public function setRegisterCoffeShop(Request $request)
    {  
        $arrCoffeData = (array)$request->all();
        $validatorCoffeeShop = Validator::make($arrCoffeData, [
            'coffee_name' => 'required|max:100',
            'coffee_address' => 'required|max:175',
            'email' => 'required|email',
            'phone' => 'required|max:14',
            'password' => 'required|max:32'
        ],[
            
            'coffee_name.required' => 'Full name / coffee name must be fill',
            'coffee_address.required' => 'Address must be fill',
            'email.required' => 'Email must be fill',
            'phone.required' => 'Phone number must be fill',
            'password.required' => 'Password must be fill'
        ]);
        if($validatorCoffeeShop->fails())
        {
            return response()->json(['status' => 400,
                'error' => $validatorCoffeeShop->errors()
            ]);
        }
        else
        {
            try {
                $smsToken = Keygen::numeric(6)->generate();
                $coffeeShopObject = CoffeeShop::create([
                    'coffee_name' => $arrCoffeData['coffee_name'],
                    'coffee_address' => $arrCoffeData['coffee_address'],
                    'coffee_phone' => $arrCoffeData['phone'],
                    'coffee_lat' => $arrCoffeData['latitude'],
                    'coffee_lang' => $arrCoffeData['longitude']
                ]);
                if($coffeeShopObject)
                {
                    $coffeeShopObject = User::create([
                        'name' => $arrCoffeData['coffee_name'],
                        'email' => $arrCoffeData['email'],
                        'password' => bcrypt($arrCoffeData['password']),
                        'phone' => $arrCoffeData['phone'],
                        'has_coffee' => true,
                        'coffee_id' => $coffeeShopObject->coffee_id,
                        'last_lat' => $arrCoffeData['latitude'],
                        'last_lang' => $arrCoffeData['longitude'],
                        'sms_token' => $smsToken,
                        'sms_expired' => Carbon::now()->addMinutes(5)
                    ]);
                    $tokenString = $coffeeShopObject->createToken('CangkirApps')->accessToken;
                    return response()->json([
                        'message' => 'Register Successfully',
                        'redirect' => [
                            'statement' => true,
                            'url' => 'onTapPassword'
                        ],
                        'status' => 200,
                        'collection' => array(
                            'verification' => array(
                                'token' => $coffeeShopObject->sms_token,
                                'phone' => $coffeeShopObject->phone,
                                'expired' => $coffeeShopObject->sms_expired
                            )
                        )
                    ]); 
                }
            }
            catch (Exception $e) 
            {
                return response()->json(['error' => $e, 'status' => 400]);
            }
        }
    }

    public function setPhoneVerification(Request $request)
    {
        $arrData = (array)$request->all();
        try {
            $userExist = User::where([
                ['phone', '=', $arrData['phone']],
                ['sms_token', '=', $arrData['token']]
            ])->firstOrFail();

            $validThrough = Carbon::parse($userExist->sms_expired);
            $now = Carbon::parse(date("Y-m-d H:i:s"));
            $diff = strtotime($validThrough) - strtotime($now);
            if($diff > 0)
            {
                $arrDataUser['activated'] = 1;
                User::where('phone', $arrData['phone'])->update($arrDataUser);
                return response()->json([
                    'email' => $arrData['email'],
                    'password' => $arrData['password'],
                    'status' => 200,
                    'differentTime' => $diff,
                    'countDownTime' => $validThrough->diffInSeconds($now)
                ]);
            }
            else
            {
                return response()->json([
                    'error' => 'Time expired. Try to resend code',
                    'status' => 400
                ]);
            }
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'error' => 'Phone or token not valid', 
                'status' => 400
            ]);
        }
    }

    public function setResendCode(Request $request)
    {
        $arrData = (array)$request->all();
        try {
            $userExist = User::where([
                ['phone', '=', $arrData['phone']]
            ])->firstOrFail();
            $smsToken = Keygen::numeric(6)->generate();
            $arrDataUser['sms_token'] = $smsToken;
            $arrDataUser['sms_expired'] = Carbon::now()->addMinutes(5);
            User::where('phone', $arrData['phone'])->update($arrDataUser);
            $userStoreObject = User::where('phone', $arrData['phone'])->get()->toArray();
            return response()->json([
                'message' => 'Resend Code Successfully. Please check your sms inbox',
                'status' => 200,
                'redirect' => null,
                'collection' => array(
                    'verification' => array(
                        'token' => $userStoreObject[0]['sms_token'],
                        'phone' => $userStoreObject[0]['phone'],
                        'expired' => $userStoreObject[0]['sms_expired']
                    )
                )
            ]);
        } catch (ModelNotFoundException $ex) {
            return response()->json([
                'error' => 'Phone number not valid or not found', 
                'status' => 400
            ]);
        }
    }

    protected function generateCode()
    {
        return Keygen::bytes()->generate(
            function($key) {
                $random = Keygen::numeric()->generate();
                return substr(md5($key . $random . strrev($key)), mt_rand(0,8), 16);
            },
            function($key) {
                return join('-', str_split($key, 4));
            },
            'strtoupper'
        );
    }

}
