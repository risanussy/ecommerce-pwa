<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;

class MidtransController extends Controller
{
    public function index(Request $request) {
        /*Install Midtrans PHP Library (https://github.com/Midtrans/midtrans-php)
        composer require midtrans/midtrans-php
                                    
        Alternatively, if you are not using **Composer**, you can download midtrans-php library 
        (https://github.com/Midtrans/midtrans-php/archive/master.zip), and then require 
        the file manually.   

        require_once dirname(__FILE__) . '/pathofproject/Midtrans.php'; */

        //SAMPLE REQUEST START HERE
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'total' => 'required|integer',
            'email' => 'required|string',
            'wa' => 'required|string',
        ]);

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-cBOiovNEv5SQnEBLJ3-9tfVU';
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-pk8PrsJLAaVJvaH55op6I_qx';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = false;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = false;

        $params = array(
            'transaction_details' => array(
                'order_id' => now(),
                'gross_amount' => $request['total'],
            ),
            'customer_details' => array(
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'phone' => $request['wa'],
            ),
            'enabled_payments' => [
                'gopay',
                'shopeepay',
                'permata_va',
                'bca_va',
                'bni_va',
                'bri_va',
                'other_va',
                'Indomaret',
                'alfamart',
            ]
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json(["token" => $snapToken], 201);
    }
}
        