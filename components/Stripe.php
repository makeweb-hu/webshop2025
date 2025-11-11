<?php
namespace app\components;

use app\components\Stripe\Customer;
use app\models\Beallitasok;

class Stripe {
    //const STRIPE_SECRET_KEY = 'sk_test_51M86GwKP9fkYIF7gfan3rH1QvL2ikUYh2v0KmMxVT8bZpX2SN2eBaWUR4YQNgiEdogS7spFsjmTXA6s8YUJXyJNg00yrkvp48T';
    const CURRENCY = 'HUF';

    public static function createPayment($apiKey, $currency, $total, $name, $email, $successUrl, $failUrl) {
        try {
            // TODO: db-ből lekérni
            \app\components\Stripe\Stripe::setApiKey($apiKey);

            $theProduct = \app\components\Stripe\Product::create([
                "name" => $name,
            ]);

            $thePrice = \app\components\Stripe\Price::create([
                'product'       => $theProduct->id,
                'unit_amount'   => round($total * 100),
                'currency'      => $currency,
            ]);

            $checkout_session = \app\components\Stripe\Checkout\Session::create([
                'success_url'                =>  $successUrl,
                'cancel_url'                 =>  $failUrl,
                'locale'                     =>  'hu',
                'mode'                       =>  'payment',
                'billing_address_collection' =>  'auto',
                'payment_method_types'       =>  ['card'],
                 // 'customer'                   =>  $customer->stripe_id,
                 'customer_email'         =>  $email,

                'line_items' => [
                    [
                        'price' => $thePrice->id,
                        'quantity' => 1,
                    ],
                ],

            ]);

            return [
                'url' =>  $checkout_session->url,
                'id'  =>  $checkout_session->id,
            ];
        } catch (\Exception $e) {
            var_dump($e);
            return null;
        }
    }

    public static function isPaid($txId) {

    }
}