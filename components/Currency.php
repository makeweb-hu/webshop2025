<?php
namespace app\components;

use app\models\Beallitasok;
use Yii;

class Currency {
    
    public static $rate = null;

    public static function getRate() {
        if (self::$rate) {
            return self::$rate;
        }
        $rate = floatval(Beallitasok::get('eur_huf'));
        self::$rate = $rate;
        return $rate;
    }
    
    public static function current() {
        $lang = \app\components\Lang::$current;
        $currency = Yii::$app->request->cookies->getValue('currency', '');
        if ($currency === 'HUF') {
            return 'HUF';
        } else if ($currency === 'EUR') {
            return 'EUR';
        } else {
            return \app\components\Lang::defaultCurrency();
        }
    }
    
    public static function changeCurrency($currency) {
        if ($currency === 'HUF') {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'currency',
                'value' => 'HUF',
                'expire' => time() + 86400 * 365,
            ]));
        } else if ($currency === 'EUR') {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'currency',
                'value' => 'EUR',
                'expire' => time() + 86400 * 365,
            ]));
        } else {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'currency',
                'value' => \app\components\Lang::defaultCurrency(),
                'expire' => time() + 86400 * 365,
            ]));
        }
    }
}