<?php
namespace app\components;

use app\models\Beallitasok;

class Twilio {
    // const SEND_URL = 'https://api.twilio.com/2010-04-01/Accounts/ACdb1aed6de949f0c24063ad40ed50a8a0/Messages.json';
    //const SID = 'xx';
    //const TOKEN = 'xx';
    //const MESSAGE_SERVICE_ID = 'xx';

    public static function sendSms($phoneNumber, $text) {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, Beallitasok::get('twilio_send_url'));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_USERPWD, Beallitasok::get('twilio_sid') . ':' . Beallitasok::get('twilio_token'));
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                 'To=' . urlencode($phoneNumber)
                . '&MessagingServiceSid=' . urlencode(Beallitasok::get('twilio_message_service_id'))
                . '&Body=' . urlencode($text)
            );

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                return null;
            }

            curl_close($ch);

            return json_decode($result, true);
        } catch (\Throwable $e) {
            return null;
        }
    }
}