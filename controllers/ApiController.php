<?php

namespace app\controllers;

use app\components\Currency;
use app\components\FlavonApi;
use app\components\Lang;
use app\components\Push;
use app\components\Stripe;
use App\Helpers\FlavonApiHelper;
use app\models\Beallitasok;
use App\Models\Category;
use app\models\Cim;
use App\Models\Country;
use app\models\Dashboard;
use app\models\EmailSablon;
use app\models\Felhasznalo;
use app\models\Felsegjel;
use app\models\FlavonFelhasznalo;
use app\models\FlavonFizetesiMod;
use app\models\FlavonKategoria;
use app\models\FlavonOrszag;
use app\models\FlavonSzallitasiMod;
use app\models\FlavonTermek;
use app\models\FlavonTermekAr;
use app\models\Job;
use app\models\JobKiserlet;
use app\models\Kapcsolat;
use app\models\Kerdoiv;
use app\models\Kosar;
use app\models\KosarKedveles;
use app\models\KosarTetel;
use app\models\KosarTetelMegye;
use app\models\Matrica;
use app\models\Megye;
use App\Models\Message;
use App\Models\Order;
use App\Models\Product;
use app\models\Rendeles;
use app\models\StatikusSzoveg;
use app\models\StripeKulcs;
use app\models\Szallitas;
use app\models\Termek;
use app\models\Tudastar;
use app\models\UzenetCimzett;
use app\models\Vasarlo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Yii;

use app\components\Helpers;
use app\components\ReCaptchaValidator;
use yii\base\BaseObject;
use yii\helpers\Url;

use app\models\User;
use app\models\Session;
use app\models\Texts;


class űApiController extends \yii\web\Controller
{
    const JOB_KEY = '6FSA67C3ICpUJBVm1NVb';

    public $enableCsrfValidation = false;
    
    public function beforeAction($action) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        ignore_user_abort(true);
        set_time_limit(120);

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Methods: GET,PUT,POST,DELETE');
        
        if (!parent::beforeAction($action)) {
            return false;
        }
        
        return true;
    }

    public function actionVersion() {
        return [
            'version' => 1,
        ];
    }

    public function actionAcceptCookies() {
        $cookies = Yii::$app->response->cookies;

        $cookies->add(new \yii\web\Cookie([
            'name' => 'cookie_consent',
            'value' => '1',
        ]));

        return [];
    }

    public function actionSearch() {
        $q = trim(Yii::$app->request->post('q', ''));

        $results = [];

        foreach (Termek::find()->where(['and', ['or', ['like', 'nev', $q], ['like', 'cikkszam', $q]], ['=', 'statusz', 1]])->limit(8)->all() as $prod) {
            $results[] = [
                'price' => $prod->renderPrice(),
                'name' => $prod->nev,
                'photo' => $prod->getThumbnail(),
                'url' => '/' . $prod->page->url,
            ];
        }

        return $results;
    }

    public function actionContact() {
        $name = trim(Yii::$app->request->post('name', ''));
        $email = trim(Yii::$app->request->post('email', ''));
        $phone = trim(Yii::$app->request->post('phone', ''));
        $message = trim(Yii::$app->request->post('message', ''));
        $product_id = trim(Yii::$app->request->post('product_id', ''));

        $product = Termek::findOne($product_id);

        $message = str_replace("\n", '<br>', $message);

        // Save to db
        $model = new Kapcsolat;
        $model->idopont = date('Y-m-d H:i:s');
        $model->nev = $name;
        $model->email = $email;
        $model->telefonszam = $phone;
        $model->uzenet = $message;
        if ($product) {
            $model->termek_id = $product->getPrimaryKey();
        }
        $model->save(false);

        $data = [
            'nev' => $name,
            'email' => $email,
            'telefon' => $phone,
            'uzenet' => $message,
            'termek' => $product ? [ $product->nev ] : [],
            'foto_url' => $product ? $product->getThumbnail() : '',
            'termeknev' => $product ? $product->nev : '',
            'opciok' => $product ? 'Cikkszám: ' . $product->cikkszam : '',
        ];

        // Send email

        $notify_users = Felhasznalo::find()->where(['ertesites' => 1])->all();

        Helpers::setSmpt();
        $template = EmailSablon::findOne(3);
        $fromName = Beallitasok::get('smtp_sender_name');
        $fromAddress = Beallitasok::get('smtp_sender_email');

        foreach ($notify_users as $adminUser) {

            Yii::$app->mailer->compose()
                ->setTo($adminUser->email)
                ->setReplyTo($email)
                ->setFrom([
                    $fromAddress => $fromName,
                ])
                ->setSubject($template->renderSubject($data))
                ->setHtmlBody($template->renderBody($data))
                ->send();
        }

        return [];
    }

    public function actionSetPushToken() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));
        $pushToken = trim(Yii::$app->request->post('pushToken', ''));

        $session = Kosar::find()->where(['token' => $sessionId])->one();

        if ($session && $pushToken) {
            $session->push_token = $pushToken;
            $session->save(false);
        }

        return [];
    }

    public function actionInit() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));
        //$pushToken = trim(Yii::$app->request->post('pushToken', ''));

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            // Create new session
            $session = new Kosar;
            $session->token = Helpers::random_bytes();
            $session->nyelv = 'hu';
            $session->penznem = 'HUF';
            $session->orszag_id = 1; // Magyarország
            /*
            if ($pushToken) {
                $session->push_token = $pushToken;
            }
            */
            $session->save(false);
        } else {
            /*
            if ($pushToken) {
                $session->push_token = $pushToken;
                $session->save(false);
            }
            */
        }

        $session->refresh();

        return [
            'session' => $session->toApi(),
            'countries' => FlavonOrszag::allForApi(),
            'categories' => FlavonKategoria::allForApi(),
            'products' => FlavonTermek::allForApi(),
            'dashboards' => Dashboard::allForApi(),
            'texts' => StatikusSzoveg::allForApi(),
            'articles' => Tudastar::allForApi(),
            'paymentMethods' => FlavonFizetesiMod::allForApi(),
            'shippingMethods' => FlavonSzallitasiMod::allForApi(),
            'mainForm' => Kerdoiv::findOne(2)->toApi(),
        ];
    }

    public function actionPushTest() {
        Push::sendToUser('M-439141', 'Ez egy teszt', 'Hello world');
    }

    public function actionSignup() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));

        $name = trim(Yii::$app->request->post('name', ''));
        $email = trim(Yii::$app->request->post('email', ''));
        $phone = trim(Yii::$app->request->post('phone', ''));
        $sponsorMid = strtoupper(trim(Yii::$app->request->post('sponsorMid', '')));
        // $password = Yii::$app->request->post('password', '');
        // $passwordRepeat = Yii::$app->request->post('passwordRepeat', '');

        $mailingAddress = json_decode( $_POST['mailingAddress'] ?? '{}', true);
        $shippingAddress = json_decode( $_POST['shippingAddress'] ?? '{}', true);
        $billingAddress = json_decode($_POST['billingAddress'] ?? '{}', true);

        $differentBillingAddress = strval(Yii::$app->request->post('differentBillingAddress', '')) === '1';

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        if (!$name) {
            return [
                'error' => 'Adja meg a nevét!',
            ];
        }
        if (!$email) {
            return [
                'error' => 'Adja meg az e-mail címét!',
            ];
        } else if (!Helpers::isEmailValid($email)) {
            return [
                'error' => 'Helytelen az e-mail cím formátuma!',
            ];
        }
        if (!$phone) {
            return [
                'error' => 'Adja meg a telefonszámát!',
            ];
        }
        if (!$sponsorMid) {
            return [
                'error' => 'Adja meg szponzorának M-azonosítóját!',
            ];
        }
        /*
        if (!$password) {
            return [
                'error' => 'Adjon meg egy jelszót!',
            ];
        } else if (!$passwordRepeat) {
            return [
                'error' => 'Ismételje meg a jelszót!',
            ];
        } else if ($password !== $passwordRepeat) {
            return [
                'error' => 'A két jelszó nem egyezik!',
            ];
        }
        */

        if (!$mailingAddress['zip'] || !$mailingAddress['city'] || !$mailingAddress['street'] || !$mailingAddress['country_id']) {
            return [
                'error' => 'Töltse ki a levelezési címet!',
            ];
        }

        if ($differentBillingAddress && (!$billingAddress['zip'] || !$billingAddress['city'] || !$billingAddress['street'] || !$billingAddress['country_id'])) {
            return [
                'error' => 'Töltse ki a számlázási címet!',
            ];
        }

        /*
        if (!$mailingAddress['zip'] || !$mailingAddress['city'] || !$mailingAddress['street'] || !$mailingAddress['country_id']) {
            return [
                'error' => 'Adjon meg egy levelezési címet!',
            ];
        }

        if (!$billingAddress['zip'] || !$billingAddress['city'] || !$billingAddress['street'] || !$billingAddress['country_id']) {
            return [
                'error' => 'Adjon meg egy számlázási címet!',
            ];
        }

        if (!$shippingAddress['zip'] || !$shippingAddress['city'] || !$shippingAddress['street'] || !$shippingAddress['country_id']) {
            return [
                'error' => 'Adjon meg egy szállítási címet!',
            ];
        }
        */

        // Flavon API call
        try {
            $response = FlavonApi::call('POST', 'user', [
                'sponsorMid' => $sponsorMid,
                'fullName' => $name,
                'email' => [$email],
                'phone' => [$phone],
                // 'password' => $password,
                'mailingAddress' => $mailingAddress,
                'billingAddress' => $differentBillingAddress ? $billingAddress : $mailingAddress,
                'shippingAddress' => $mailingAddress,
                'newsletter' => 0,
            ]);

            if ($response && is_array($response) && ($response['mid'] ?? null) && ($response['token'] ?? null)) {
                // Ez egy sikeres regisztrációnak néz ki formailag az API válasz alapján

                // Bejelentkeztetés a session-be

                $user = new FlavonFelhasznalo;
                $user->id = intval($response['id']);
                $user->mid = $response['mid'];
                $user->frissitve = date('Y-m-d H:i:s');
                $user->save(false);

                $session->felhasznalo_id = $user->getPrimaryKey();
                $session->bearer_token = $response['token'];
                $session->save(false);

            } else if ($response && is_array($response) && ($response['message'] ?? null)) {
                return [
                    'error' => $response['message']
                ];
            } else {
                return [
                    'error' => 'Technikai okok miatt nem sikerült a regisztráció. Vegye fel a kapcsolatot az ügyfélszolgálattal!',
                ];
            }
        } catch (\Throwable $e) {

        }

        return [
            'session' => $session->toApi(),
        ];
    }

    public function actionDeleteLike() {
        $id = trim(Yii::$app->request->post('id', ''));
        $cart = Kosar::current(true);

        $found = false;

        foreach ($cart->likes as $like) {
            if ($like->product->id == $id) {
                $like->delete();
            }
        }
        return [
            'html' => Yii::$app->controller->renderPartial('@app/themes/main/site/_likes'),
            'nr_of_items' => count($cart->likes),
        ];
    }

    public function actionRemoveFromCart() {
        $id = trim(Yii::$app->request->post('id', ''));
        $cartItem = KosarTetel::findOne($id);
        if ($cartItem) {
            $cartItem->delete();
        }

        return [
            'html' => Yii::$app->controller->renderPartial('@app/themes/main/site/_cart'),
            'nr_of_items' => Kosar::nr(),
            'total' => \app\components\Helpers::formatMoney(Kosar::current()->getItemsTotal()),
        ];
    }

    public function actionLike() {
        $id = trim(Yii::$app->request->post('id', ''));
        $variation_id = trim(Yii::$app->request->post('variation_id', ''));
        $cart = Kosar::current(true);

        $found = false;

        foreach ($cart->likes as $like) {
            if ($variation_id) {
                if ($like->product->id == $id && $like->variation->id == $variation_id) {
                    $found = true;
                    $like->save(false);
                    break;
                }
            } else {
                if ($like->product->id == $id) {
                    $found = true;
                    $like->save(false);
                    break;
                }
            }
        }

        if (!$found) {
            $like = new KosarKedveles;
            $like->termek_id = $id;
            $like->variacio_id = $variation_id ? $variation_id : null;
            $like->kosar_id = $cart->getPrimaryKey();
            $like->idopont = date('Y-m-d H:i:s');
            $like->save(false);
        }

        return [
            'html' => Yii::$app->controller->renderPartial('@app/themes/main/site/_likes'),
            'nr_of_items' => count($cart->likes),
        ];
    }

    public function actionAddToCart() {
        $id = trim(Yii::$app->request->post('id', ''));
        $variation_id = trim(Yii::$app->request->post('variation_id', ''));
        $amount = intval(Yii::$app->request->post('amount', '1'));

        $cart = Kosar::current(true);

        $found = false;

        foreach ($cart->items as $like) {
            if ($variation_id) {
                if ($like->product->id == $id && $like->variation->id == $variation_id) {
                    $found = true;
                    $like->mennyiseg += $amount;
                    $like->save(false);
                    break;
                }
            } else {
                if ($like->product->id == $id) {
                    $found = true;
                    $like->mennyiseg += $amount;
                    $like->save(false);
                    break;
                }
            }
        }

        if (!$found) {
            $like = new KosarTetel;
            $like->termek_id = $id;
            $like->variacio_id = $variation_id ? $variation_id : null;
            $like->kosar_id = $cart->getPrimaryKey();
            $like->mennyiseg = $amount;
            $like->idopont = date('Y-m-d H:i:s');
            $like->save(false);
        }

        return [
            'html' => Yii::$app->controller->renderPartial('@app/themes/main/site/_cart'),
            'nr_of_items' => Kosar::nr(),
            'total' => \app\components\Helpers::formatMoney(Kosar::current()->getItemsTotal()),
        ];
    }

    public function actionChangeShippingMethod() {
        $id = trim(Yii::$app->request->post('id', ''));

        $cart = Kosar::current();

        if (!$cart) {
            return [];
        }

        $cart->szallitas_id = $id;
        $cart->save(false);

        $cart->refresh();

        return [
            'html' => Yii::$app->controller->renderPartial('@app/themes/main/site/_payment_methods'),
            'total' => Helpers::formatMoney( Kosar::total() ),
            'shipping_price' => Helpers::formatMoney( $cart->getShippingPrice() ),
        ];
    }


    public function actionChangePaymentMethod() {
        $id = trim(Yii::$app->request->post('id', ''));

        $cart = Kosar::current();

        if (!$cart) {
            return [];
        }

        $cart->fizetes_id = $id;
        $cart->save(false);

        $cart->refresh();

        return [
            'total' => Helpers::formatMoney( Kosar::total() ),
            'shipping_price' => Helpers::formatMoney( $cart->getShippingPrice() ),
        ];
    }

    public function actionOrder() {
        $cart = Kosar::current();

        if (!$cart) {
            return [];
        }

        $name = trim(Yii::$app->request->post('name', ''));
        $email = trim(Yii::$app->request->post('email', ''));
        $phone = trim(Yii::$app->request->post('phone', ''));

        $shipping = intval(trim(Yii::$app->request->post('shipping', '')));
        $payment = intval(trim(Yii::$app->request->post('payment', '')));

        $shipping_name = trim(Yii::$app->request->post('shipping_name', ''));
        $shipping_zip = trim(Yii::$app->request->post('shipping_zip', ''));
        $shipping_city = trim(Yii::$app->request->post('shipping_city', ''));
        $shipping_street = trim(Yii::$app->request->post('shipping_street', ''));

        $billing_name = trim(Yii::$app->request->post('billing_name', ''));
        $billing_zip = trim(Yii::$app->request->post('billing_zip', ''));
        $billing_city = trim(Yii::$app->request->post('billing_city', ''));
        $billing_street = trim(Yii::$app->request->post('billing_street', ''));
        $billing_tax_number = trim(Yii::$app->request->post('billing_tax_number', ''));

        $comment = trim(Yii::$app->request->post('comment', ''));

        $customer = Vasarlo::findOne(['email' => $email]);
        if (!$customer) {
            $customer = new Vasarlo;
            $customer->nev = $name;
            $customer->email = $email;
            $customer->telefonszam = $phone;
            $customer->save(false);
        }

        $shippingAddress = new Cim;
        $shippingAddress->nev = $shipping_name;
        $shippingAddress->iranyitoszam = $shipping_zip;
        $shippingAddress->orszag_id = 1; // Hungary
        $shippingAddress->telepules = $shipping_city;
        $shippingAddress->utca = $shipping_street;
        $shippingAddress->save(false);

        $billingAdddress = new Cim;
        $billingAdddress->nev = $billing_name;
        $billingAdddress->iranyitoszam = $billing_zip;
        $billingAdddress->orszag_id = 1; // Hungary
        $billingAdddress->telepules = $billing_city;
        $billingAdddress->utca = $billing_street;
        $billingAdddress->adoszam = $billing_tax_number;
        $billingAdddress->save(false);

        $customer->szallitasi_cim_id  = $shippingAddress->getPrimaryKey();
        $customer->szamlazasi_cim_id  = $billingAdddress->getPrimaryKey();
        $customer->save(false);

        // Freeze items data
        foreach ($cart->items as $item) {
            $item->egysegar = $item->getUnitPrice();
            $item->afa = 27;
            $item->save(false);
        }

        $cart->rendelesszam = 'ORD' . Helpers::nextOrderNumber();
        $cart->nev = $name;
        $cart->email = $email;
        $cart->telefonszam = $phone;
        $cart->megrendelve = 1;
        $cart->fizetes_id = $payment;
        $cart->szallitas_id = $shipping;
        $cart->megjegyzes = $comment;
        $cart->afa = 27;
        $cart->vasarlo_id = $customer->getPrimaryKey();
        $cart->szallitasi_cim_id = $shippingAddress->getPrimaryKey();
        $cart->szamlazasi_cim_id = $billingAdddress->getPrimaryKey();
        $cart->szallitasi_dij = Szallitas::findOne($shipping)->ar ?: 0;
        $cart->fizetesi_dij = 0;
        $cart->kedvezmeny = 0;
        $cart->szallitasi_dij_afa = 0;
        $cart->fizetesi_dij_afa = 0;
        $cart->kedvezmeny_afa = 0;
        $cart->megrendeles_idopontja = date('Y-m-d H:i:s');
        $cart->save(false);

        // Készlet levonása
        $cart->decrementStock();

        // Új kosár létrehozása
        Kosar::createNewCart();

        // E-mail küldés (vásárló)
        EmailSablon::findOne(1)->send($cart->getPrimaryKey(), $email);

        // E-mail küldés (admin)
        EmailSablon::findOne(2)->send($cart->getPrimaryKey(), 'borago.74@gmail.com');
        //EmailSablon::findOne(2)->send($cart->getPrimaryKey(), 'gmenyhert92@gmail.com');

        return [
            'redirect_url' => '/site/ordered?number=' . $cart->rendelesszam,
        ];
    }

    public function actionSubmitOrder() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));
        $paymentMethod = Yii::$app->request->post('payment_method', '');
        $shippingMethod = Yii::$app->request->post('shipping_method', '');
        $billingAddress = json_decode(Yii::$app->request->post('billing_address', '{}'), true);
        $shippingAddress = json_decode(Yii::$app->request->post('shipping_address', '{}'), true);

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        // TODO: remove coupons from cart

        // Flavon API call
        $orderResponse = null;
        try {
            $total = 0;

            $items = [];
            foreach ($session->items as $item) {
                $items[] = [
                    'id' => $item->termek_id,
                    'amount' => $item->mennyiseg,
                    'subitems' => [],
                ];
                $prodRecord = FlavonTermek::findOne($item->termek_id);
                $total += $prodRecord->getPriceByCurrency($session->penznem) * $item->mennyiseg;
            }

            $orderResponse = FlavonApi::call("POST", 'orders', [
                'userId'=> $session->user?$session->user->id:null,
                'country'=> $session->country ? $session->country->kod : null,
                'lang' =>$session->nyelv,
                'currency'=>$session->penznem,
                'country_id'=> $session->country ? $session->country->id : null,
                'items'=> $items,
                'shippingMethodId'=>$shippingMethod,
                'paymentMethodId'=>$paymentMethod,
                'cardProvider'=>'stripe',
                'szamlaTipus'=>2, // ????????????????
                'shippingAddress'=>[
                    'name'=>$shippingAddress['name'],
                    'country_id'=>$shippingAddress['country_id'],
                    'zip'=>$shippingAddress['zip'],
                    'city'=>$shippingAddress['city'],
                    'street'=>$shippingAddress['street'],
                ],
                'billingAddress'=>[
                    'name'=>$billingAddress['name'],
                    'country_id'=>$billingAddress['country_id'],
                    'zip'=>$billingAddress['zip'],
                    'city'=>$billingAddress['city'],
                    'street'=>$billingAddress['street'],
                ],
                'usedCoupons'=>[],
                'orderNotes'=>'',
            ], $session->bearer_token);

            if (!is_array($orderResponse) || !($orderResponse['orderNumber'] ?? null)) {
                return [
                    'error' => 'A rendelést nem sikerült leadni. Vegye fel a kapcsolatot az ügyfélszolgálattal!',
                ];
            }

            $orderRecord = new Rendeles;
            $orderRecord->idopont = date('Y-m-d H:i:s');
            $orderRecord->fizetesi_mod = intval($paymentMethod) === 1 ? 'stripe' : 'egyeb';
            $orderRecord->bizonylatszam = $orderResponse['orderNumber'];
            $orderRecord->stripe_id = null;
            $orderRecord->fizetve = 0;
            $orderRecord->penznem = $session->penznem;
            $orderRecord->osszeg = $total;
            $orderRecord->orszag = $session->country->kod;
            $orderRecord->felhasznalo_id = $session->user ? $session->user->id : null;
            $orderRecord->save(false);

            // Remove cart items
            foreach ($session->items as $item) {
                $item->delete();
            }

        } catch (\Throwable $e) {
            // var_dump($e);
        }

        return [
            'session' => $session->toApi(),
            'orderNumber' => is_array($orderResponse) && ($orderResponse['orderNumber'] ?? null) ? $orderResponse['orderNumber'] : '#',
            'orderId' => is_array($orderResponse) && ($orderResponse['id'] ?? null) ? $orderResponse['id'] : '',
        ];
    }

    public function actionLogin() {
        $mid = strtoupper(trim(Yii::$app->request->post('mid', '')));
        $password = trim(Yii::$app->request->post('password', ''));
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $errors = [];
        if (!$mid) {
            $errors['mid'] = 'Kötelező mező.';
        }
        if (!$password) {
            $errors['password'] = 'Kötelező mező.';
        }

        if (count($errors) > 0) {
            return [
                'errors' => $errors,
            ];
        }

        // API CALL
        $response = FlavonApi::post('user/auth', [
            'mid' => $mid,
            'password' => $password,
        ]);

        if (!$response || !($response['ID_UGYFEL'] ?? null)) {
            return [
                'errors' => 'Hibás felhasználónév vagy jelszó!',
            ];
        }

        $user = FlavonFelhasznalo::findOne(intval($response['ID_UGYFEL']));
        if (!$user) {
            $user = new FlavonFelhasznalo;
            $user->id = intval($response['ID_UGYFEL']);
            $user->mid = $mid;
            $user->frissitve = date('Y-m-d H:i:s');
            $user->save(false);
        }

        // Login (into the session)
        $session->felhasznalo_id = $user->id;
        $session->bearer_token = $response['token'];
        $session->save(false);

        return [
            'session' => $session->toApi(),
        ];
    }

    public function actionLogout() {
        $sessionId = trim(Yii::$app->request->post('sessionId'));

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        // Logout (from the session)
        $session->felhasznalo_id = NULL;
        $session->save(false);

        return [
            'session' => $session->toApi(),
        ];
    }

    public function actionIsPaid($orderNumber) {
        $orderRecord = Rendeles::findOne([
            'bizonylatszam' => $orderNumber,
        ]);
        if (!$orderRecord) {
            return [
                'paid' => true,
            ];
        }
        if ($orderRecord->fizetesi_mod === 'stripe' && !$orderRecord->fizetve) {
            return [
                'paid' => false,
            ];
        }
        return [
            'paid' => true,
        ];
    }

    public function actionPay() {
        $sessionId = trim(Yii::$app->request->post('sessionId'));
        $orderNumber = trim(Yii::$app->request->post('orderNumber'));
        $redirect = trim(Yii::$app->request->post('redirect'));

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $orderRecord = Rendeles::findOne([
            'bizonylatszam' => $orderNumber,
        ]);

        if (!$orderRecord) {
            return [
                'errors' => 'A rendelés nem létezik.',
            ];
        }

        if ($orderRecord->fizetesi_mod !== 'stripe') {
            return [
                'errors' => 'A rendelés fizetési módja NEM Stripe.',
            ];
        }

        if ($orderRecord->fizetve) {
            return [
                'errors' => 'A rendelés már ki lett fizetve.',
            ];
        }

        if (!$session->user || $session->user->id != $orderRecord->felhasznalo_id) {
            return [
                'errors' => 'A rendelés nem a felhasználóhoz tartozik.',
            ];
        }

        $user = FlavonApi::get('user/' . $session->user->id, null, $session->bearer_token);

        $stripeResponse = Stripe::createPayment(
            StripeKulcs::demoSecretKey(StripeKulcs::getIdFromCountryAndCurrency( $orderRecord->orszag, $orderRecord->penznem )),
            $orderRecord->penznem,
            $orderRecord->osszeg,
            $orderRecord->bizonylatszam,
            $user['email'][0],
            'https://flavon-admin.makeweb.hu/site/stripe-success?id=' . $orderRecord->id . '&redirect=' . urlencode($redirect),
            'https://flavon-admin.makeweb.hu/site/stripe-failure?id=' . $orderRecord->id . '&redirect=' . urlencode($redirect)
        );

        $orderRecord->stripe_id = $stripeResponse['id'];
        $orderRecord->save(false);

        return [
            'url' => $stripeResponse['url'],
        ];
    }

    public function actionForm($id) {
        $model = Kerdoiv::findOne($id);
        return $model->toApi();
    }

    public function actionForgotPassword() {
        $sessionId = trim(Yii::$app->request->post('sessionId'));
        $mid = strtoupper(trim(Yii::$app->request->post('mid', '')));

        $session = Kosar::find()->where(['token' => $sessionId])->one();
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        if (!preg_match("@^M\-[0-9]{1,15}$@", $mid)) {
            return [
                'error' => 'Hibás M-azonosítót adott meg!',
            ];
        }

        // TODO: Flavon API call
        try {
            FlavonApi::call('POST', 'user/' . $mid . '/forgot-password');
        } catch (\Throwable $e) {
        
        }

        return [
            // 'session' => $session->toApi(),
        ];
    }


    public function actionSetAmount() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));
        $item_id = trim(Yii::$app->request->post('item_id', ''));
        $amount = min(99, max(1, intval(Yii::$app->request->post('amount', '1'))));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $cartItems = $session->items;
        foreach ($cartItems as $cartItem) {
            if ($cartItem->id == $item_id) {
                $cartItem->mennyiseg = $amount;
                $cartItem->save(false);
                break;
            }
        }

        $session->refresh();

        return [
            'session' => $session->toApi(),
        ];
    }

    public function actionDashboards() {
        $all = [];
        foreach (Dashboard::find()->all() as $model) {
            $cards = [];
            $isPrevHalf = false;
            foreach ($model->cards as $card) {
                $cardArray = $card->toApi();
                if ($card->tipus === 'half' || $card->tipus === "half_random" || $card->tipus === "welcome") {
                    if ($isPrevHalf) {
                        $cardArray['right'] = true;
                    }
                    $isPrevHalf = true;
                } else {
                    $isPrevHalf = false;
                }
                $cardArray['dashboardTitle'] = [
                    'hu' => $model->nev_hu,
                    'en' => $model->nev_en,
                    'de' => $model->nev_de,
                    'fr' => $model->nev_fr,
                    'bg' => $model->nev_bg,
                    'pl' => $model->nev_pl,
                ];
                $cards[] = $cardArray;
            }
            $all[$model->id] = $cards;
        }
        return $all;
    }

    public function actionDashboardPage($id) {
        $model = Dashboard::findOne($id);
        $cards = [];
        $isPrevHalf = false;
        foreach ($model->cards as $card) {
            $cardArray = $card->toApi();
            if ($card->tipus === 'half' || $card->tipus === "half_random" || $card->tipus === "welcome") {
                if ($isPrevHalf) {
                    $cardArray['right'] = true;
                }
                $isPrevHalf = true;
            } else {
                $isPrevHalf = false;
            }
            $cards[] = $cardArray;
        }
        return $cards;
    }

    public function actionArticles() {
        $all = [];
        foreach (Tudastar::find()->where(['publikalva' => 1])->orderBy('id DESC')->all() as $article) {
            $all[] = [
                'id' => $article->id,
                'category' => $article->kategoria,
                'title' => [
                    'hu' => $article->nev_hu,
                    'en' => $article->nev_en,
                    'de' => $article->nev_de,
                    'fr' => $article->nev_fr,
                    'bg' => $article->nev_bg,
                    'pl' => $article->nev_pl,
                ],
                'image' => $article->fajl ? 'https://flavon-admin.makeweb.hu' . $article->fajl->getUrl() : null,
            ];
        }
        return $all;
    }

    public function actionTexts() {
        $all = [];
        foreach (StatikusSzoveg::find()->all() as $item) {
            $all[$item->nev] = [
                'hu' => $item->tartalom_hu,
                'en' => $item->tartalom_en,
                'de' => $item->tartalom_de,
                'fr' => $item->tartalom_fr,
                'bg' => $item->tartalom_bg,
                'pl' => $item->tartalom_pl,
            ];
        }
        return $all;
    }

    public function actionKpi() {
        $sessionId = trim(Yii::$app->request->get('sessionId', ''));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [

            ];
        }

        $user = $session->user;
        if (!$user) {
            return [

            ];
        }

        return FlavonApi::call('GET', 'dashboard/' . $user->id, [], $session->bearer_token);
    }

    public function actionAddress() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $user = $session->user;
        if (!$user) {
            return [
                'errors' => 'Nincs bejelentkezve.',
            ];
        }

        $data = json_decode(trim(Yii::$app->request->post('data', '{}')), true);

        FlavonApi::put('user/' . $user->id, $data, $session->bearer_token);

        return [
            'session' => $session->toApi()
        ];
    }

    public function actionArticle($id) {
        $article = Tudastar::findOne($id);

        $chapters = [];
        foreach ($article->chapters as $chapter) {
            $content = [];
            foreach ($chapter->sections as $section) {
                $content[] = [
                    'type' => $section->tipus,
                    'text' => [
                        'hu' => $section->tartalom_hu,
                        'en' => $section->tartalom_en,
                        'de' => $section->tartalom_de,
                        'fr' => $section->tartalom_fr,
                        'bg' => $section->tartalom_bg,
                        'pl' => $section->tartalom_pl,
                    ],
                    'file' => $section->file ? 'https://flavon-admin.makeweb.hu' . $section->file->getUrl() : null,
                    'video_url' => $section->video_url,
                ];
            }
            $chapters[] = [
                'id' => $chapter->id,
                'title' => [
                    'hu' => $chapter->nev_hu,
                    'en' => $chapter->nev_en,
                    'de' => $chapter->nev_de,
                    'fr' => $chapter->nev_fr,
                    'bg' => $chapter->nev_bg,
                    'pl' => $chapter->nev_pl,
                ],
                'content' => $content,
            ];
        }

        return [
            'id' => $article->id,
            'category' => $article->kategoria,
            'title' => [
                'hu' => $article->nev_hu,
                'en' => $article->nev_en,
                'de' => $article->nev_de,
                'fr' => $article->nev_fr,
                'bg' => $article->nev_bg,
                'pl' => $article->nev_pl,
            ],
            'chapters' => $chapters,
            'image' => $article->fajl ? 'https://flavon-admin.makeweb.hu' . $article->fajl->getUrl() : null,
        ];
    }

    public function actionMessages() {
        $sessionId = trim(Yii::$app->request->get('sessionId', ''));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $user = $session->user;
        if (!$user) {
            return [
                'errors' => 'Nincs bejelentkezve.',
            ];
        }

        $messages = [];
        foreach (UzenetCimzett::find()->where(['mid' => $user->mid])->all() as $message) {
            $messages[] = $message->toApi();
        }

        $messages = array_reverse($messages);

        return $messages;
    }

    public function actionPushOpened() {
        $pushToken = trim(Yii::$app->request->post('push_token', ''));
        $sessionId = trim(Yii::$app->request->post('message_id', ''));
        $uniqueMessageId = trim(Yii::$app->request->post('unique_message_id', ''));

        $msg = UzenetCimzett::findOne($uniqueMessageId);
        if ($msg) {
            $msg->megtekintve = 1;
            $msg->save(false);
        }

        return [];
    }

    public function actionMessage($id) {
        $sessionId = trim(Yii::$app->request->get('sessionId', ''));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $user = $session->user;
        if (!$user) {
            return [
                'errors' => 'Nincs bejelentkezve.',
            ];
        }

        $message = UzenetCimzett::findOne(['mid' => $user->mid, 'id' => $id]);

        if (!$message) {
            return null;
        }

        return $message->toApi();
    }

    public function actionSettings() {
        $request = Yii::$app->request;

        $sessionId = trim($request->post('sessionId', ''));
        $splash = $request->post('splash');
        $lang = trim($request->post('lang', ''));
        $currency = trim($request->post('currency', ''));
        $country = trim($request->post('country', ''));
        $notify_system = $request->post('notify_system');
        $notify_newsletter = $request->post('notify_newsletter');
        $newsletter = $request->post('newsletter');
        $agree_email = $request->post('agree_email');
        $agree_phone = $request->post('agree_phone');
        $old_password = $request->post('old_password');
        $new_password = $request->post('new_password');
        $new_password_repeat = $request->post('new_password_repeat');
        $name = $request->post('name');
        $email1 = $request->post('email1');
        $email2 = $request->post('email2');
        $email3 = $request->post('email3');
        $phone1 = $request->post('phone1');
        $phone2 = $request->post('phone2');
        $phone3 = $request->post('phone3');

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }
        $user = $session->user;

        $errors = [];

        if ($user) {
            $apiPut = [];

            // Set system notification
            if ($notify_system) {
                $user->rendszeruzenet_ertesito = ($notify_system === 'true');
            }
            // Set newsletter notification
            if ($notify_newsletter) {
                $user->hirlevel_ertesito = ($notify_newsletter === 'true');
            }
            // Set newsletter
            if ($newsletter) {
                $user->hirlevel = ($newsletter === 'true');
            }
            // Agree email
            if ($agree_email) {
                $user->email_elfogadva = ($agree_email === 'true');
            }
            // Agree phone
            if ($agree_phone) {
                $user->telefon_elfogadva = ($agree_phone === 'true');
            }
            // Name
            if ($name !== NULL) {
                if (!trim($name)) {
                    return ['errors' => [
                        'name' => 'Kötelelező mező!',
                    ]];
                } else {
                    $apiPut['fullName'] = trim(strval($name));
                }
            }
            // Set password
            if ($old_password !== NULL) {
                if (!$old_password) {
                    $errors['old_password'] = 'Kötelező mező.';
                }
                if (!$new_password) {
                    $errors['new_password'] = 'Kötelező mező.';
                }
                if (!$new_password_repeat) {
                    $errors['new_password_repeat'] = 'Kötelező mező.';
                }
                if (($new_password && $new_password_repeat) && ($new_password !== $new_password_repeat)) {
                    $errors['new_password_repeat'] = 'Nem egyeznek a jelszavak.';
                }
                if (count($errors) > 0) {
                    return ['errors' => $errors];
                }
                $apiPut['old_password'] = $old_password;
                $apiPut['password'] = $new_password;
            }
            // Set email
            $emails = [];
            if ($email1) {
                if (!Helpers::isEmailValid($email1)) {
                    $errors['email1'] = 'Helytelen e-mail cím';
                } else {
                    $emails[] = $email1;
                }
            }
            if ($email2) {
                if (!Helpers::isEmailValid($email2)) {
                    $errors['email2'] = 'Helytelen e-mail cím';
                } else {
                    $emails[] = $email2;
                }
            }
            if ($email3) {
                if (!Helpers::isEmailValid($email3)) {
                    $errors['email3'] = 'Helytelen e-mail cím';
                } else {
                    $emails[] = $email3;
                }
            }

            if ($email1 || $email2 || $email3) {
                if (count($errors) > 0) {
                    return ['errors' => $errors];
                }
                if (count($emails) > 0) {
                    $apiPut['email'] = $emails;
                }
            }
            // Set phone
            $phones = [];
            if ($phone1) {
                if (!Helpers::isPhoneValid($phone1)) {
                    $errors['phone1'] = 'Helytelen telefonszám.';
                } else {
                    $phones[] = $phone1;
                }
            }
            if ($phone2) {
                if (!Helpers::isPhoneValid($phone2)) {
                    $errors['phone2'] = 'Helytelen telefonszám.';
                } else {
                    $phones[] = $phone2;
                }
            }
            if ($phone3) {
                if (!Helpers::isPhoneValid($phone3)) {
                    $errors['phone3'] = 'Helytelen telefonszám.';
                } else {
                    $phones[] = $phone3;
                }
            }
            if ($phone1 || $phone2 || $phone3) {
                if (count($errors) > 0) {
                    return ['errors' => $errors];
                }
                if (count($phones) > 0) {
                    $apiPut['phone'] = $phones;
                }
            }

            // API PUT
            if (count($apiPut) > 0) {
                FlavonApi::put('user/' . $user->id, $apiPut, $session->bearer_token);
            }
        }

        // Set lang
        if ($lang) {
            $session->nyelv = $lang;
        }

        // Set currency
        if ($currency) {
            if ($session->country->isCurrencySupported($currency)) {
                $session->penznem = $currency;
            }
        }

        // Set splash
        if ($splash !== NULL) {
            $session->splash = ($splash === "true");
        }

        // Set country
        if ($country) {
            $countryRecord = FlavonOrszag::findOne(str_replace('id', '', $country));
            if ($countryRecord) {
                $session->orszag_id = $countryRecord->id;
                if (!$countryRecord->isCurrencySupported($session->penznem)) {
                    $session->penznem = $countryRecord->getCurrenciesForApi()[0]; // Reset currency
                }
            }
        }

        // Save all
        $session->save(false);
        if ($user) {
            $user->save(false);
        }

        return [
            'session' => $session->toApi()
        ];
    }

    public function actionOrders() {
        $sessionId = trim(Yii::$app->request->get('sessionId', ''));

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $user = $session->user;
        if (!$user) {
            return [
                'errors' => 'Nincs bejelentkezve.',
            ];
        }

        // TODO: Flavon API CALL

        $response = FlavonApi::call('GET', 'orders/' . $user->id, [], $session->bearer_token);

        if (!is_array($response) || ($response['code'] ?? null)) {
            return [];
        }

        $all = [];
        foreach ($response as $orderItem) {
            $orderRecord = Rendeles::findOne([
                'bizonylatszam' => $orderItem['orderNumber'],
            ]);
            if ($orderRecord) {
                $orderItem['is_stripe'] = $orderRecord->fizetesi_mod === 'stripe';
                $orderItem['stripe_paid'] = $orderRecord->fizetve ? true : false;
            }
            $all[] = $orderItem;
        }

        return $all;
    }

    public function actionSetMessage() {
        $sessionId = trim(Yii::$app->request->post('sessionId', ''));

        $ids = Yii::$app->request->post('ids');
        $archived = Yii::$app->request->post('archived');
        $seen = Yii::$app->request->post('seen');

        $session = Kosar::findOne(['token' => $sessionId]);
        if (!$session) {
            return [
                'errors' => 'A session nem létezik vagy nincs megadva.',
            ];
        }

        $user = $session->user;
        if (!$user) {
            return [
                'errors' => 'Nincs bejelentkezve.',
            ];
        }

        $ids = explode(',', $ids);

        foreach ($ids as $id) {
            $message = UzenetCimzett::findOne($id);
            if (!$message) {
                return [
                    'errors' => 'Az üzenet nem található.',
                ];
            }

            if ($seen !== NULL) {
                $message->megtekintve = (strval($seen) === 'true');
            }

            if ($archived !== NULL) {
                $message->archivalva = (strval($archived) === 'true');
                $message->megtekintve = true;
            }

            $message->save(false);
        }

        return [
            // 'message' => $message->toApi(),
            'session' => $session->toApi(),
        ];
    }
}

