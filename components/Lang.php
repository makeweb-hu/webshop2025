<?php

namespace app\components;

use app\models\Texts;
use Yii;

class Lang {

    public static $supported = [
        'hu',
        'en',
        'pl',
        'bg',
        'fr'
    ];

    public static $names = [
        'en' => 'EN',
        'hu' => 'HU',
        'de' => 'DE',
        'pl' => 'PL',
        'bg' => 'BG',
        'fr' => 'FR',
    ];

    public static $default = 'hu';
    public static $current = 'hu';
    
    public static function currentName() {
        return self::$names[self::$current];
    }
    
    public static function defaultCurrency() {
        return [
            'hu' => 'HUF',
            'en' => 'HUF',
            'de' => 'EUR',
            'fr' => 'EUR',
            'pl' => 'EUR',
            'bg' => 'EUR'
        ][self::$current];
    }

    public static function isValidLang($lang) {
        return boolval(self::$names[$lang] ?? null);
    }

    public static function getLangName($lang) {
        return self::$names[$lang];
    }

    public static function hasLang($lang) {
        return array_search($lang, self::$supported) !== false;
    }

    /*
    public static function currentUrlInLang($lang) {
        $path = Yii::$app->request->getPathInfo();
        $url = Yii::$app->request->url;

        if (array_search(substr($path, 0, 2), self::$supported) !== false) {
            return '/' . $lang . substr($url, 3);
        }

        return $url;
    }
    */
}