<?php
namespace app\components;

use app\models\ApiNaplo;
use yii\base\BaseObject;

class FlavonApi {
    const FLAVON_API_ENDPOINT = 'http://79.139.63.89/flavon-api/';

    public static function get($path, $payload = null, $bearerToken = null) {
        return self::call('GET', $path, $payload, $bearerToken);
    }

    public static function post($path, $payload = null, $bearerToken = null) {
        return self::call('POST', $path, $payload, $bearerToken);
    }

    public static function put($path, $payload = null, $bearerToken = null) {
        return self::call('PUT', $path, $payload, $bearerToken);
    }

    public static function delete($path, $payload = null, $bearerToken = null) {
        return self::call('DELETE', $path, $payload, $bearerToken);
    }

    public static function call($method, $path, $payload = null, $bearerToken = null) {
        $method = trim(strtoupper($method));

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_URL,self::FLAVON_API_ENDPOINT . $path);

        $headers = [];

        if ($method !== 'GET') {
            $headers[] = 'Content-Type:application/json';
            $json = json_encode($payload, JSON_PRETTY_PRINT);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        }

        if ($bearerToken) {
            $headers[] = 'Authorization: Bearer ' . $bearerToken;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT,30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response_body = curl_exec($ch);
        $response_status = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));

        curl_close($ch);

        // Log
        $record = new ApiNaplo;
        $record->response_status = $response_status;
        $record->payload = json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $record->response_body = json_encode(json_decode($response_body, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $record->idopont = date('Y-m-d H:i:s');
        $record->url = self::FLAVON_API_ENDPOINT . $path;
        $record->method = $method;
        $record->save(false);

        if ($response_status === '200') {
            return json_decode($response_body, true);
        } else {
            return null;
        }
    }
}