<?php

namespace app\controllers;

use app\components\FlavonApi;
use app\components\FlavonCache;
use app\components\Gravatar;
use app\components\Helpers;
use app\components\Imagelib;
use app\components\kulcssoft\KulcsExport;
use app\components\NMFR;
use app\components\Pdf;
use app\components\QR;
use app\components\Szamlazz;
use app\components\Twilio;
use app\components\TwoFactorAuth;
use app\models\Beallitasok;
use app\models\Fajl;
use app\models\Felhasznalo;
use app\models\Hir;
use app\models\Kategoria;
use app\models\Kosar;
use app\models\StatikusOldal;
use app\models\Termek;
use app\models\TermekTulajdonsag;
use app\models\TermekTulajdonsagErtek;
use app\models\Tulajdonsag;
use app\models\TulajdonsagOpcio;
use app\models\Variacio;
use Yii;

use yii\web\HttpException;
use ZendSearch\Lucene\Index\Term;

class SiteController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function actionRedirect($to, $isPermanent = false) {
        return $this->redirect($to, $isPermanent ? 301 : 302);
    }

    public function beforeAction($action) {

        $user = Felhasznalo::current();
        $isMaintenance = Beallitasok::get('karbantartas_alatt');

        if ($isMaintenance && !$user) {
            $this->layout = 'maintenance';
            return true;
        }

        return true;
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionBlog()
    {
        return $this->render('blog');
    }

    public function actionBlogPost($id)
    {
        return $this->render('blog-post', [
            'model' => Hir::findOne($id),
        ]);
    }


    public function actionCheckout()
    {
        $this->layout = 'checkout';
        $cart = Kosar::current();
        if (!$cart) {
            return $this->redirect('/');
        }
        if (count($cart->items) === 0) {
            return $this->redirect('/');
        }
        return $this->render('checkout');
    }

    public function actionSearch()
    {
        return $this->render('search');
    }

    public function actionOrdered($number)
    {
        $this->layout = 'checkout';
        return $this->render('ordered');
    }

    public function actionStaticPage($id) {
        $model = StatikusOldal::findOne($id);
        if (!$model->statusz && !Felhasznalo::current()) {
            throw new HttpException(404);
        }

        return $this->render('static_page', [
            'model' => $model,
        ]);
    }

    public function actionProducts() {
        return $this->render('category', [
            'model' => null,
        ]);
    }

    public function actionContact() {
        return $this->render('contact', [

        ]);
    }

    public function actionFaq() {
        return $this->render('faq', [

        ]);
    }

    public function actionDecrementStock($number) {
        $model = Kosar::findOne(['rendelesszam' => $number]);
        if ($model) {
            // $model->decrementStock();
            var_dump('done');
        }
    }

    public function actionImportCategories() {
        $categories = json_decode(file_get_contents('import/categories.json'), true);

        foreach ($categories as $category) {
            $model = Kategoria::findOne($category['id']);
            if (!$model) {
                try {
                    $model = new Kategoria;
                    $model->id = $category['id'];
                    $model->nev = $category['name'];
                    $model->szulo_id = $category['parent_id'] ? $category['parent_id'] : null;
                    $model->save(false);
                } catch (\Throwable $e) {

                }
            } else {
                $model->postProcess();

                if ($category['photo'] ?? null) {
                    $file = Fajl::uploadByUrl($category['photo']);

                    $model->foto_id = $file->getPrimaryKey();
                    $model->save(false);
                }
            }
        }
    }

    public function actionImportProducts() {
        $products = json_decode(file_get_contents('import/products.json'), true);

        foreach ($products as $product) {
            $model = Termek::findOne($product['id']);
            if (!$model) {
                $model = new Termek;
                $model->nev = $product['name'];
                $model->kategoria_id = is_array($product['category'] ?? null) ? $product['category']['id'] : null;
                $model->statusz = $product['status'] ? 1 : 0;
                $model->leiras = $product['description'];
                if (count($product['photos'] ?? []) > 0) {
                    $model->foto_id = Fajl::uploadByUrl($product['photos'][0])->getPrimaryKey();
                } else {
                    $model->foto_id = NULL;
                }
                $model->cikkszam = $product['sku'];
                $model->ar = $product['price'];
                $model->afa = $product['vat'] ?: 27;
                $model->keszlet = $product['stock'];
                $model->keszlet_info = $product['stock_text'];
                $model->ujdonsag = $product['is_new'] ? 1 : 0;
                if ($product['is_sale']) {
                    $model->akcio_tipusa = 'fix_ar';
                    $model->akcios_ar = $product['sale_price'];
                    $model->akcios = 1;
                }
                $model->save(false);

                $model->postProcess();

            } else {
                $model->createOrUpdateVariationsFromAttributes();
            }
        }
    }

    public function actionImportVariations() {
        $products = json_decode(file_get_contents('import/products.json'), true);

        $variations = [];

        foreach ($products as $product) {
            $model = Termek::findOne($product['id']);

            if (count($product['variations'] ?? []) > 0) {
                foreach ($product['variations'] as $variation) {
                    $attr = $variation['attribute'];
                    $attr = str_replace(' ', '', $attr);
                    $attr = str_replace(',', '/', $attr);
                    $attr = str_replace('//', '/', $attr);
                    $attr = trim($attr);
                    $attr = mb_strtolower($attr);
                    $attr = str_replace('fajt/', 'fajta/', $attr);
                    $attr = str_replace('méret/fajta', 'fajta/méret', $attr);
                    $attr = str_replace('fajták', 'fajta', $attr);
                    $attr = str_replace('méret/kiszerelés', 'kiszerelés/méret', $attr);
                    $attr = str_replace('fajta/kiszerelés', 'kiszerelés/fajta', $attr);
                    $attr = str_replace('szín/kiszerelés', 'kiszerelés/szín', $attr);
                    $variations[$attr] = true;

                    $attrModel = Tulajdonsag::findOne(['variaciokepzo' => 1, 'nev' => $attr]);
                    if (!$attrModel) {
                        $attrModel = new Tulajdonsag;
                        $attrModel->nev = $attr;
                        $attrModel->variaciokepzo = 1;
                        $attrModel->ertek_tipus = 'select';
                        $attrModel->save(false);
                    }

                    $option = TulajdonsagOpcio::findOne([
                        'tulajdonsag_id' => $attrModel->getPrimaryKey(),
                        'ertek' => $variation['name'],
                    ]);
                    if (!$option) {
                        $option = new TulajdonsagOpcio;
                        $option->tulajdonsag_id = $attrModel->getPrimaryKey();
                        $option->ertek = $variation['name'];
                        $option->save(false);
                    }

                    $attrLinkModel = TermekTulajdonsag::findOne([
                        'termek_id' => $product['id'],
                        'tulajdonsag_id' => $attrModel->getPrimaryKey(),
                    ]);
                    if (!$attrLinkModel) {
                        $attrLinkModel = new TermekTulajdonsag;
                        $attrLinkModel->termek_id = $product['id'];
                        $attrLinkModel->tulajdonsag_id = $attrModel->getPrimaryKey();
                        $attrLinkModel->save(false);
                    }

                    $attrLinKValueModel = TermekTulajdonsagErtek::findOne([
                        'termek_tulajdonsag_id' => $attrLinkModel->getPrimaryKey(),
                        'tulajdonsag_opcio_id' => $option->getPrimaryKey(),
                    ]);
                    if (!$attrLinKValueModel) {
                        $attrLinKValueModel = new TermekTulajdonsagErtek;
                        $attrLinKValueModel->termek_tulajdonsag_id = $attrLinkModel->getPrimaryKey();
                        $attrLinKValueModel->tulajdonsag_opcio_id = $option->getPrimaryKey();
                        $attrLinKValueModel->save(false);
                    }

/*
                    $variationModel = Variacio::findOne([
                        'termek_id' => $product['id'],
                        'opcio_1' => ,
                    ]);
*/
                }
            }
        }

        var_dump($variations);
    }

    public function actionImportSubproducts() {
        //$ids = array_values(array_unique([112, 141, 195, 203, 528, 237, 240, 383, 384, 443, 446, 449, 450, 624, 516, 517, 528, 541, 544, 546, 362, 374, 574, 579, 581, 582, 587, 446, 623, 622, 654]));
$ids = [580, 501, 437, 426, 373, 365, 354, 358, 359, 355, 335, 318, 305, 300, 474];
        $products = json_decode(file_get_contents('import/products.json'), true);

        foreach ($products as $product) {
            $model = Termek::findOne($product['id']);

            if (!in_array($product['id'], $ids)) {
                continue;
            }

            /*  "attribute": "Méret",
                "name": "Taxus baccata Fastigiata Robusta - oszlopos tiszafa 125+ - Személyes átvétellel",
                "price": 19900,
                "photo": "https://borago.hu/images/products/products/variations/16811178644472.jpg" */

            if ($model) {
                $model->delete();
            }

            foreach ($product['variations'] as $v) {
                $variation = Termek::findOne([
                    'nev' => $v['name'],
                    'ar' => $v['price'],
                ]);
                if (!$variation) {
                    $variation = new Termek;
                    $variation->nev = $v['name'];
                    $variation->kategoria_id = is_array($product['category'] ?? null) ? ($product['category']['id']==15?14:$product['category']['id']) : null;
                    $variation->statusz = 1;
                    $variation->leiras = $product['description'];
                    if ($v['photo']) {
                        $variation->foto_id = Fajl::uploadByUrl($v['photo'])->getPrimaryKey();
                    } else {
                        $variation->foto_id = null;
                    }
                    $variation->keszlet = 1;
                    $variation->ar = $v['price'];
                    $variation->afa = 27;
                    $variation->keszlet_info = '';
                    $variation->ujdonsag = $product['is_new'] ? 1 : 0;
                    $variation->save(false);

                    $variation->postProcess();
                }
            }

            /*
            if (!$model) {
                $model = new Termek;
                $model->nev = $product['name'];
                $model->kategoria_id = is_array($product['category'] ?? null) ? $product['category']['id'] : null;
                $model->statusz = $product['status'] ? 1 : 0;
                $model->leiras = $product['description'];
                if (count($product['photos'] ?? []) > 0) {
                    $model->foto_id = Fajl::uploadByUrl($product['photos'][0])->getPrimaryKey();
                } else {
                    $model->foto_id = NULL;
                }
                $model->cikkszam = $product['sku'];
                $model->ar = $product['price'];
                $model->afa = $product['vat'] ?: 27;
                $model->keszlet = $product['stock'];
                $model->keszlet_info = $product['stock_text'];
                $model->ujdonsag = $product['is_new'] ? 1 : 0;
                if ($product['is_sale']) {
                    $model->akcio_tipusa = 'fix_ar';
                    $model->akcios_ar = $product['sale_price'];
                    $model->akcios = 1;
                }
                $model->save(false);

                $model->postProcess();

            } else {
                $model->createOrUpdateVariationsFromAttributes();
            }
            */
        }
    }

    public function actionProduct($id, $variation = '') {
        $model = Termek::findOne($id);
        if (!$model || !$model->statusz) {
            throw new HttpException(404);
        }
        return $this->render('product', [
            'model' => $model,
            'variationId' => $variation,
        ]);
    }

    public function actionCategory($id) {
        $model = Kategoria::findOne($id);
        if (!$model) {
            throw new HttpException(404);
        }
        return $this->render('category', [
            'model' => $model,
        ]);
    }

    public function actionRedirectTo($where, $statusCode = 301)
    {
        return $this->redirect($where, $statusCode);
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public function actionGoogleFeed($description='') {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');
        $xml = '<?xml version="1.0"?>';
        $xml .= "\n";
        $xml .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">';
        $xml .= "\n";
        $xml .= '<channel>';
        $xml .= '<title>Borágó Webáruház</title>';
        $xml .= '<link>https://borago.hu</link>';
        $xml .= '<description/>';
        foreach (Termek::find()->where(['statusz' => 1])->all() as $item) {
            if (!$item->ar) {
                continue;
            }
            if (!$item->foto_id) {
                continue;
            }
            $xml .= '<item>';
            $xml .= '<g:id>' . $item->getPrimaryKey() . '</g:id>';
            $xml .= '<g:title><![CDATA[ ' . trim(htmlspecialchars($item->nev)) . ' ]]></g:title>';
            $xml .= '<g:google_product_category>985</g:google_product_category>'; // 985 - Home & Garden > Plants
            if ($description) {
                $xml .= '<g:description><![CDATA[' . htmlspecialchars(strip_tags(trim($item->leiras))) . ']]></g:description>'; //
            } else {
                $xml .= '<g:description><![CDATA[' . '' . ']]></g:description>'; // strip_tags(trim($item->leiras))
            }
            $xml .= '<g:link>https://borago.hu' . htmlspecialchars($item->url) . '</g:link>';
            $xml .= '<g:image_link>https://borago.hu' . $item->photo->url . '</g:image_link>';
            $xml .= '<g:brand>Borágó</g:brand>';
            $xml .= '<g:shipping>';
            $xml .= '<g:country>HU</g:country>';
            $xml .= '<g:price>3000 HUF</g:price>';
            $xml .= '</g:shipping>';
            $xml .= '<g:condition>new</g:condition>';
            if ($item->keszlet > 0) {
                $xml .= '<g:availability>in_stock</g:availability>';
            } else {
                $xml .= '<g:availability>out_of_stock</g:availability>';
            }
            $xml .= '<g:price>' . $item->ar . ' HUF</g:price>';
            $xml .= '<g:sale_price/>';
            $xml .= '</item>';
            $xml .= "\n";
        }
        $xml .= '</channel>';
        $xml .= '</rss>';
        return $xml;
    }

    public function actionFlavonCache() {
        // FlavonCache::cacheAll();
    }

    public function actionFlavonTest() {
        var_dump(
            FlavonApi::call('GET', 'state')
        );
    }

    public function actionStripeSuccess($id, $redirect = '') {
        $this->layout = false;

        $order = Rendeles::findOne($id);
        if ($order) {
            $order->fizetve = 1;
            $order->save(false);
        }

        return $this->render('stripe', [
            'redirect' => $redirect,
        ]);
    }

    public function actionStripeFailure($id, $redirect = '') {
        $this->layout = false;
        return $this->render('stripe', [
            'redirect' => $redirect,
        ]);
    }

    public function actionGravatar() {
        echo '<img src="'.Gravatar::generate('fdddsfd@fgddfdffddds.hu').'">';
    }
}
