<?php
namespace app\components;

class ClientInfo {

    public static function getAll() {
        try {
            $Browser = new BrowserDetection();
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            return $Browser->getAll($useragent);
        } catch (\Throwable $e) {
            return [];
        }
    }

    public static function osName() {
        return self::getAll()['os_name'] ?? 'unknown';
    }

    public static function osVersion() {
        return self::getAll()['os_version'] ?? 'unknown';
    }

    public static function deviceType() {
        return self::getAll()['device_type'] ?? 'unknown';
    }

    public static function browserName() {
        return self::getAll()['browser_name'] ?? 'unknown';
    }

    public static function browserVersion() {
        return self::getAll()['browser_version'] ?? 'unknown';
    }
}