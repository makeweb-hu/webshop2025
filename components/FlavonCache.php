<?php
namespace app\components;

use app\models\FlavonAllam;
use app\models\FlavonFizetesiMod;
use app\models\FlavonKategoria;
use app\models\FlavonNyelv;
use app\models\FlavonOrszag;
use app\models\FlavonOrszagPenznem;
use app\models\FlavonPenznem;
use app\models\FlavonSzallitasiMod;
use app\models\FlavonTermek;
use app\models\FlavonTermekAr;
use app\models\FlavonTermekOrszag;
use yii\base\BaseObject;

// TODO: frissítés időpontjának elmentése

class FlavonCache {

    public static function cacheAll() {
        self::cacheCurrencies();
        self::cacheDelivery();
        self::cachePayment();
        self::cacheLangs();
        self::cacheCountries();
        self::cacheStates();
        self::cacheCategories();
        self::cacheProducts();
    }

    public static function cacheCurrencies() {
        $currencies = FlavonApi::get('currency');
        foreach ($currencies as $currency) {
            $model = FlavonPenznem::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonPenznem;
                $model->id = $currency['id'];
            }
            $model->kod = $currency['code'];
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->jel = $currency['sign'];
            $model->save(false);
        }
    }

    public static function cacheDelivery() {
        $currencies = FlavonApi::get('delivery');
        foreach ($currencies as $currency) {
            $model = FlavonSzallitasiMod::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonSzallitasiMod;
                $model->id = $currency['id'];
            }
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->save(false);
        }
    }

    public static function cachePayment() {
        $currencies = FlavonApi::get('payment');
        foreach ($currencies as $currency) {
            $model = FlavonFizetesiMod::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonFizetesiMod;
                $model->id = $currency['id'];
            }
            $model->kod = $currency['code'];
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->save(false);
        }
    }

    public static function cacheLangs() {
        $currencies = FlavonApi::get('language');
        foreach ($currencies as $currency) {
            $model = FlavonNyelv::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonNyelv;
                $model->id = $currency['id'];
            }
            $model->kod = $currency['code'];
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->save(false);
        }
    }

    public static function cacheCountries() {
        $currencies = FlavonApi::get('state');
        foreach ($currencies as $currency) {
            $model = FlavonAllam::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonAllam;
                $model->id = $currency['id'];
            }
            $model->orszag_id = $currency['country_id'];
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->save(false);
        }
    }

    public static function cacheStates() {
        $currencies = FlavonApi::get('country');
        foreach ($currencies as $currency) {
            $model = FlavonOrszag::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonOrszag;
                $model->id = $currency['id'];
            }
            $model->kod = $currency['code'];
            $model->alapertelmezett_nyelv = $currency['defaultLanguage'];
            $model->cegnev = $currency['companyName'];
            $model->telefon = $currency['companyPhone'];
            $model->email = $currency['companyEmail'];
            $model->adoszam = $currency['companyTax'];
            $model->afa = $currency['companyVat'] ? floatval($currency['companyVat']) : null;
            $model->bankszamlaszam = $currency['companyBankAccountNumber'];
            $model->aszf_url = $currency['termsAndConditions'][0]['content'] ?: $currency['termsAndConditions'][0]['pdf_url'];
            $model->adatkezelesi_url = $currency['privacyPolicy'][0]['content'] ?: $currency['privacyPolicy'][0]['pdf_url'];
            $model->szervezeti_es_mukodesi_url = $currency['organizationalAndOperationalRules'][0]['content'] ?: $currency['organizationalAndOperationalRules'][0]['pdf_url'];
            $model->autoshipment_url = $currency['autoshipmentConditions'][0]['content'] ?: $currency['autoshipmentConditions'][0]['pdf_url'];

            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->save(false);

            // TODO: linked currencies
            foreach (FlavonOrszagPenznem::find()->where(['orszag_id' => $model->getPrimaryKey()])->all() as $cRecord) {
                $cRecord->delete();
            }
            foreach ($currency['currencies'] as $c) {
                $cRecord = new FlavonOrszagPenznem;
                $cRecord->orszag_id = $model->getPrimaryKey();
                $cRecord->penznem = strtoupper($c);
                $cRecord->frissitve = date('Y-m-d H:i:s');
                $cRecord->save(false);
            }
        }
    }

    public static function cacheCategories() {
        $currencies = FlavonApi::get('product/categories');
        foreach ($currencies as $currency) {
            $model = FlavonKategoria::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonKategoria;
                $model->id = $currency['id'];
            }
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            $model->tipus = $currency['type']==='product'?'termek':'egyeb';
            $model->frissitve = date('Y-m-d H:i:s');
            $model->save(false);
        }
    }

    public static function cacheProducts() {
        $currencies = FlavonApi::get('product');
        foreach ($currencies as $currency) {
            $model = FlavonTermek::findOne($currency['id']);
            if (!$model) {
                $model = new FlavonTermek;
                $model->id = $currency['id'];
            }
            if ($currency['category'] ?? null) {
                $model->kategoria_id = $currency['category']['id'];
            } else {
                $model->kategoria_id = null;
            }
            $model->statusz = $currency['status'] ? 1 : 0;
            foreach ($currency['name'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->nev_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->nev_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->nev_de = $item['content'];
                }
            }
            foreach ($currency['shortDescription'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->rovid_leiras_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->rovid_leiras_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->rovid_leiras_de = $item['content'];
                }
            }
            foreach ($currency['longDescription'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->leiras_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->leiras_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->leiras_de = $item['content'];
                }
            }
            foreach ($currency['unit'] as $item) {
                if ($item['language'] == 'hu') {
                    $model->mertekegyseg_hu = $item['content'];
                } else if ($item['language'] == 'en') {
                    $model->mertekegyseg_en = $item['content'];
                } else if ($item['language'] == 'de') {
                    $model->mertekegyseg_de = $item['content'];
                }
            }
            $model->frissitve = date('Y-m-d H:i:s');
            $model->save(false);

            // Countries
            foreach (FlavonTermekOrszag::find()->where(['termek_id' => $model->getPrimaryKey()])->all() as $productCountryRecord) {
                $productCountryRecord->delete();
            }
            foreach ($currency['countries'] as $countryCode) {
                $countryRecord = FlavonOrszag::findOne(['kod' => strtolower($countryCode)]);
                if ($countryRecord) {
                    $productCountryRecord = new FlavonTermekOrszag;
                    $productCountryRecord->orszag_id = $countryRecord->getPrimaryKey();
                    $productCountryRecord->termek_id = $model->getPrimaryKey();
                    $productCountryRecord->orszagkod = $countryRecord->kod;
                    $productCountryRecord->save(false);
                }
            }
            // Prices
            foreach (FlavonTermekAr::find()->where(['termek_id' => $model->getPrimaryKey()])->all() as $productPriceRecord) {
                $productPriceRecord->delete();
            }
            foreach ($currency['prices'] as $price) {
                $productPriceRecord = new FlavonTermekAr;
                $productPriceRecord->termek_id = $model->getPrimaryKey();
                $productPriceRecord->penznem = strtoupper($price['currency']);
                $productPriceRecord->ar = floatval($price['grossUnitPrice']);
                $productPriceRecord->save(false);
            }
        }
    }
}