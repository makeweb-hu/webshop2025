<?php
namespace app\components;

use app\models\FlavonFelhasznalo;
use app\models\Kosar;

class Push {
    const URL = 'https://exp.host/--/api/v2/push/send';

    public static function sendToUser($mid, $title, $body = '', $data = []) {
        $user = FlavonFelhasznalo::findOne([
            'mid' => strtoupper(trim($mid)),
        ]);
        $sentTo = [];
        if ($user) {
            // Find push tokens
            $carts = Kosar::find()->where([
                'felhasznalo_id' => $user->id,
            ])->all();
            foreach ($carts as $cart) {
                if ($cart->push_token) {
                    if (!($sentTo[$cart->push_token] ?? null)) {
                        $data['push_token'] = $cart->push_token;
                        self::sendToToken($cart->push_token, $title, $body, $data);
                    }
                    $sentTo[$cart->push_token] = true;
                }
            }
        }
    }

    public static function sendToToken($pushToken, $title, $body = '', $data = []) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'channelId' => 'default',
            'sound' => 'default',
            'to' => $pushToken,
            'title' => $title,
            'body' => $body,
            'data' => $data,
        ],JSON_PRETTY_PRINT));

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    }
}