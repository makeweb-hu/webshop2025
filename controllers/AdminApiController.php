<?php
namespace app\controllers;

use app\components\ClientInfo;
use app\components\Excel;
use app\components\GLS;
use app\components\Helpers;
use app\components\QR;
use app\components\Szamlazz;
use app\components\TwoFactorAuth;
use app\models\Beallitasok;
use app\models\Bejelentkezes2fa;
use app\models\EmailSablon;
use app\models\Fajl;
use app\models\Felhasznalo;
use app\models\Kosar;
use app\models\Munkamenet;
use app\models\StatikusSzoveg;
use app\models\Szamla;
use app\models\Termek;
use app\models\TermekTulajdonsag;
use app\models\TermekTulajdonsagErtek;
use Yii;
use yii\base\BaseObject;
use yii\web\Cookie;
use yii\web\Response;

class AdminApiController extends \yii\web\Controller {
    public $enableCsrfValidation = false;

    public function beforeAction($action) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        ignore_user_abort(true);

        $user = Felhasznalo::current();

        // Csak az itt felsorolt action-ök a publikusak
        if (!$user && $action->id !== "login"  && $action->id !== "verify-2fa") {
            return [
                'error' => 'Nincs jogosultsága a művelet végrehajtásához vagy lejárt a munkamenete!',
            ];
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;
    }

    public function actionSendTemplateTestEmail() {
        $id= Yii::$app->request->post('id');
        $email = trim(Yii::$app->request->post('email'));

        if (!$email) {
            return [
                'error' => ['email' => 'Kötelező mező!'],
            ];
        }

        $template = EmailSablon::findOne($id);
        $testData = $template->testData();

        try {
            Helpers::setSmpt();

            $fromName = Beallitasok::get('smtp_sender_name');
            $fromAddress = Beallitasok::get('smtp_sender_email');

            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([
                    $fromAddress => $fromName,
                ])
                ->setSubject($template->renderSubject($testData))
                ->setHtmlBody($template->renderBody($testData))
                ->send();

            return [
                'success_message' => 'Üzenet sikeresen elküldve',
            ];
        } catch (\Throwable $e) {
            return [
                'error' => 'Nem sikerült elküldeni az üzenetet ',
            ];
        }
    }

    public function actionCreateLabel() {
        $id = Yii::$app->request->post('id');
        $codamount = intval(Yii::$app->request->post('codamount', '0'));

        $model = Kosar::findOne($id);

        if ($model->csomagszam) {
            return [
                'error' => 'Már ki lett állítva címke! Frissítse be az oldalt!',
            ];
        }

        /*
                "City" => $data[""],
                "ContactEmail" => $data[""],
                "ContactName" => $data[""],
                "ContactPhone" => $data[""],
                "CountryIsoCode" => "HU",
                "HouseNumber" => "",
                "Name" => $data[""],
                "Street" => $data[""],
                "ZipCode" => $data[""]
         */

        $glsResult = GLS::printlabel([
            'codamount' => $codamount,
            'consig_name' => $model->shippingAddress->nev,
            'consig_zipcode' => $model->shippingAddress->iranyitoszam,
            'consig_city' => $model->shippingAddress->telepules,
            'consig_email' => $model->email,
            'consig_phone' => $model->telefonszam,
            'consig_address' => $model->shippingAddress->utca,
        ]);

        if ($glsResult["pcls"] ?? null) {
            // Success
            file_put_contents('storage/gls/' . $glsResult['pcls'] . '.pdf', $glsResult['pdf']);
            $model->csomagszam = $glsResult['pcls'];
            $model->save(false);
            return [
                'success_message' => 'GLS címke sikeresen ki lett állítva a következő sorszámmal: ' . $glsResult['pcls'],
                'redirect_url' => '(current)',
            ];
        } else {
            // Error
            return [
                'error' => $glsResult,
            ];
        }
    }

    public function actionCreateInvoice() {
        $id = Yii::$app->request->post('id');
        $date = Yii::$app->request->post('date');

        $order = Kosar::findOne($id);
        if (!$order) {
            return [];
        }

        if (!$date) {
            $date = strtotime('Y-m-d', strtotime($order->idopont));
        }

        $invoices = $order->invoices;
        if (count($invoices) && !$invoices[count($invoices) - 1]->sztorno) {
            return [
                'error' => 'Már van kiállítva számla a rendelésről. Új számla kiállításához előbb azt sztornózni kell!',
            ];
        }

        $buyer = [
            'name' => $order->billingAddress->nev,
            'country' => $order->billingAddress->country->nev,
            'zip' => $order->billingAddress->iranyitoszam,
            'city' => $order->billingAddress->telepules,
            'street' => $order->billingAddress->utca,
            'tax_number' => $order->billingAddress->adoszam,
        ];

        $items = $order->getItemsForInvoice();
// var_dump($items);die();
        $szamlazzResponse = Szamlazz::generateInvoice($buyer, $items, trim($order->payment->megnevezes_szamlan ?: '') ?: $order->payment->nev, $date);

        if (!is_string($szamlazzResponse)) {
            return [
                'error' => 'Nem sikerült a számla kiállítása.<br><br><i> ' . $szamlazzResponse['error'] . '</i>',
            ];
        }
        $invoice = new Szamla;
        $invoice->kosar_id = $order->getPrimaryKey();
        $invoice->bizonylatszam = $szamlazzResponse;
        $invoice->szamlazo = 'szamlazzhu';
        $invoice->idopont = date('Y-m-d H:i:s');
        $invoice->save(false);

        return [
            'redirect_url' => '/admin/order?id=' . $id . '&tab=invoices',
        ];
    }

    public function actionCancelInvoice() {
        $id = Yii::$app->request->post('id');
        $invoice = Szamla::findOne($id);
        if ($invoice->sztorno) {
            return [
                'error' => 'Sztornó számla nem sztornózható!',
            ];
        }

        $szamlazzResponse = Szamlazz::generateCancelInvoice($invoice->bizonylatszam);

        if (!is_string($szamlazzResponse)) {
            return [
                'error' => 'Nem sikerült a sztornó számla kiállítása.<br><br><i> ' . $szamlazzResponse['error'] . '</i>',
            ];
        }
        $i = new Szamla;
        $i->kosar_id = $invoice->kosar_id;
        $i->bizonylatszam = $szamlazzResponse;
        $i->szamlazo = 'szamlazzhu';
        $i->idopont = date('Y-m-d H:i:s');
        $i->sztorno = 1;
        $i->sztornozott_bizonylat = $invoice->bizonylatszam;
        $i->save(false);

        return [
            'redirect_url' => '/admin/order?id=' . $invoice->kosar_id . '&tab=invoices',
        ];
    }

    public function actionSendTestEmail() {
        $lang = Yii::$app->request->post('lang');
        $email = trim(Yii::$app->request->post('email'));
        $content = Yii::$app->request->post('content');

        if (!$email) {
            return [
                'error' => ['email' => 'Kötelező mező!'],
            ];
        }

        try {
            Helpers::setSmpt();

            $fromName = Beallitasok::get('smtp_sender_name');
            $fromAddress = Beallitasok::get('smtp_sender_email');

            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([
                    $fromAddress => $fromName,
                ])
                ->setSubject('Teszt üzenet')
                ->setHtmlBody($content)
                ->send();

            return [
                'success_message' => 'Üzenet sikeresen elküldve',
            ];
        } catch (\Throwable $e) {
            return [
                'error' => 'Nem sikerült elküldeni az üzenetet ',
            ];
        }
    }

    // AUTH (LOGIN & LOGOUT)

    public function actionExcelExport($type = '') {
        $data = [];

        if ($type === 'texts') {
            foreach (StatikusSzoveg::find()->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Megnevezés' => $item->nev,
                    'Tartalom (HU)' => $item->tartalom_hu,
                    'Tartalom (EN)' => $item->tartalom_en,
                    'Tartalom (PL)' => $item->tartalom_pl,
                    'Tartalom (BG)' => $item->tartalom_bg,
                    'Tartalom (FR)' => $item->tartalom_fr,
                ];
            }
            $path = Excel::generate($data);
        }

        if ($type === 'schedule') {
            foreach (UtemezettUzenet::find()->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Cím (HU)' => $item->cim_hu,
                    'Cím (EN)' => $item->cim_en,
                    'Cím (PL)' => $item->cim_pl,
                    'Cím (BG)' => $item->cim_bg,
                    'Cím (FR)' => $item->cim_fr,
                    'Leírás (HU)' => $item->leiras_hu,
                    'Leírás (EN)' => $item->leiras_en,
                    'Leírás (PL)' => $item->leiras_pl,
                    'Leírás (BG)' => $item->leiras_bg,
                    'Leírás (FR)' => $item->leiras_fr,
                ];
            }
            $path = Excel::generate($data);
        }

        if ($type === 'articles') {
            $sheets = [];
            foreach (Tudastar::find()->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Cím (HU)' => $item->nev_hu,
                    'Cím (EN)' => $item->nev_en,
                    'Cím (PL)' => $item->nev_pl,
                    'Cím (BG)' => $item->nev_bg,
                    'Cím (FR)' => $item->nev_fr,
                ];
            }
            $sheets['Tananyag'] = $data;

            $data = [];
            foreach (Tudastar::find()->all() as $i) {
                foreach (TudastarFejezet::find()->where(['tudastar_id' => $i->getPrimaryKey()])->all() as $item) {
                    $data[] = [
                        'ID' => $item->getPrimaryKey(),
                        'Cím (HU)' => $item->nev_hu,
                        'Cím (EN)' => $item->nev_en,
                        'Cím (PL)' => $item->nev_pl,
                        'Cím (BG)' => $item->nev_bg,
                        'Cím (FR)' => $item->nev_fr,
                    ];
                }
            }
            $sheets['Fejezet'] = $data;

            $data = [];
            foreach (Tudastar::find()->all() as $i) {
                foreach (TudastarFejezet::find()->where(['tudastar_id' => $i->getPrimaryKey()])->orderBy('sorrend ASC, id ASC')->all() as $j) {
                    foreach (TudastarSzekcio::find()->where(['tipus' => 'szoveg', 'fejezet_id' => $j->getPrimaryKey()])->orderBy('sorrend ASC, id ASC')->all() as $item) {
                        $data[] = [
                            'ID' => $item->getPrimaryKey(),
                            'Tartalom (HU)' => $item->tartalom_hu,
                            'Tartalom (EN)' => $item->tartalom_en,
                            'Tartalom (PL)' => $item->tartalom_pl,
                            'Tartalom (BG)' => $item->tartalom_bg,
                            'Tartalom (FR)' => $item->tartalom_fr,
                        ];
                    }
                }
            }
            $sheets['Szekció'] = $data;

            $path = Excel::generateMultisheet($sheets);
        }

        if ($type === 'questions') {
            $sheets = [];
            foreach (Kerdoiv::find()->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Cím (HU)' => $item->cim_hu,
                    'Cím (EN)' => $item->cim_en,
                    'Cím (PL)' => $item->cim_pl,
                    'Cím (BG)' => $item->cim_bg,
                    'Cím (FR)' => $item->cim_fr,
                    'Leírás (HU)' => $item->leiras_hu,
                    'Leírás (EN)' => $item->leiras_en,
                    'Leírás (PL)' => $item->leiras_pl,
                    'Leírás (BG)' => $item->leiras_bg,
                    'Leírás (FR)' => $item->leiras_fr,
                ];
            }
            $sheets['Kérdőív'] = $data;

            $data = [];
            foreach (KerdoivKerdes::find()->where('kerdoiv_id is not null')->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Kérdés (HU)' => $item->kerdes_hu,
                    'Kérdés (EN)' => $item->kerdes_en,
                    'Kérdés (PL)' => $item->kerdes_pl,
                    'Kérdés (BG)' => $item->kerdes_bg,
                    'Kérdés (FR)' => $item->kerdes_fr,
                ];
            }
            $sheets['Kérdés'] = $data;

            $data = [];
            foreach (KerdoivKerdesFelelet::find()->where('kerdoiv_kerdes_id is not null')->all() as $item) {
                $data[] = [
                    'ID' => $item->getPrimaryKey(),
                    'Megnevezés (HU)' => $item->felelet_hu,
                    'Megnevezés (EN)' => $item->felelet_en,
                    'Megnevezés (PL)' => $item->felelet_pl,
                    'Megnevezés (BG)' => $item->felelet_bg,
                    'Megnevezés (FR)' => $item->felelet_fr,
                ];
            }
            $sheets['Válaszlehetőség'] = $data;

            $path = Excel::generateMultisheet($sheets);
        }

        return $this->redirect('/' . $path);
    }

    public function actionResetPassword() {
        $id = Yii::$app->request->post('id');
        $model = Felhasznalo::findOne($id);
        if (!$model) {
            return [
                'error' => 'A felhasználó nem található.',
            ];
        }

        $newPassword = Helpers::random_bytes(8);
        $model->jelszo_hash = password_hash($newPassword, PASSWORD_DEFAULT);
        $model->save(false);

        return [
            "error" => null,
            "success_message" => 'Az új jelszó a következő:<br><br><b><pre>'.$newPassword.'</pre></b>',
        ];
    }

    public function actionEdit2fa() {
        $enable2fa = Yii::$app->request->post('enable_f2a', '');
        $secret = Yii::$app->request->post('secret', '');
        $code = Yii::$app->request->post('code', '');

        $user = Felhasznalo::current();

        if ($user->ketfaktoros_kulcs) {
            if (!$enable2fa) {
                $user->ketfaktoros_kulcs = null;
                $user->save(false);
            }
            return [];
        }

        if (!TwoFactorAuth::auth($secret, $user->email, $code)) {
            return [
                'error' => [
                    'code' => 'Hibás ellenőrző kód!',
                ]
            ];
        }

        $user->ketfaktoros_kulcs = $secret;
        $user->save(false);

        return [

        ];
    }

    public function actionEnable2fa() {
        $user = Felhasznalo::current();

        $secret = \app\components\TwoFactorAuth::getSecret($user->email);
        $uri = $secret->getUri();
        $qrCode = \app\components\QR::generate($uri);

        return [
            'secret' => $secret->getSecretKey(),
            'qr' => $qrCode,
        ];
    }

    public function actionDisable2fa() {
        $user = Felhasznalo::current();

        /*
        $user->ketfaktoros_kulcs = null;
        $user->save(false);
        */

        return [

        ];
    }

    public function actionReset2fa() {
        $id = Yii::$app->request->post('id');
        $model = Felhasznalo::findOne($id);
        if (!$model) {
            return [
                'error' => 'A felhasználó nem található.',
            ];
        }

        $model->ketfaktoros_kulcs = null;
        $model->save(false);

        return [
            "error" => null,
            'redirect_after_success' => '(current)',
            "success_message" => 'Sikeresen törölve lett a felhasználóhoz tartozó kétfaktoros hitelesítés.',
        ];
    }

    public function actionLogout() {
        $session = Munkamenet::current();
        $user = $session->user;
        if ($session) {
            $session->delete();
        }
        Yii::$app->response->cookies->remove("session_token"); // cookie törlése

        $user->log('logout', [
            'Felhasználó ID' => $user->getPrimaryKey(),
            'E-mail cím' => $user->email,
            'Bejelentkezés időpontja' => date('Y-m-d H:i:s'),
            'IP cím' => ($_SERVER['REMOTE_ADDR'] ?: ''),
            'Eszköz típusa' => ClientInfo::deviceType(),
            'Operációs rendszer' => ClientInfo::osName(),
            'Operációs rendszer verzió' => ClientInfo::osVersion(),
            'Böngésző' => ClientInfo::browserName(),
            'Böngésző verzió' => ClientInfo::browserVersion(),
        ]);

        return [
            "error" => null,
            "redirect_url" => "/admin",
        ];
    }

    public function actionEditPassword() {
        $model = Felhasznalo::current();

        $password_1 = Yii::$app->request->post('password_1', '');
        $password_2 = Yii::$app->request->post('password_2', '');

        $error = [];

        if (strlen($password_1) < 10) {
            $error['password_1'] = 'Legalább 10 karakter hosszúnak kell lennie.';
        }
        if (!$password_2) {
            $error['password_2'] = 'Ismételje meg az új jelszavát!.';
        } else if ($password_2 !== $password_1) {
            $error['password_2'] = 'Nem egyeznek a beírt jelszavak.';
        }

        if (count($error)) {
            return [
                'error' => $error,
            ];
        }

        $model->jelszo_hash = password_hash($password_1, PASSWORD_DEFAULT);
        $model->save(false);

        return [
            'success_message' => 'Sikeresen módosította a jelszavát.',
        ];
    }

    public function actionEditProfile() {
        $model = Felhasznalo::current();

        $profilkep_id = Yii::$app->request->post('profilkep_id', '');
        $name = trim(Yii::$app->request->post('name', ''));
        $email = trim(Yii::$app->request->post('email', ''));

        $error = [];
        if (!$name) {
            $error['name'] = 'Nem lehet üres.';
        }
        if (!$email) {
            $error['email'] = 'Nem lehet üres.';
        } else if (!Helpers::is_valid_email($email)) {
            $error['email'] = 'Az e-mail formátuma helytelen.';
        }

        if (count($error)) {
            return [
                'error' => $error,
            ];
        }

        $model->nev = $name;
        $model->email = $email;
        if ($profilkep_id) {
            $model->profilkep_id = $profilkep_id;
        }
        $model->save(false);

        return [
            'redirect_url' => '(current)',
            'success_message' => 'Sikeresen módosította a profil adatait.',
        ];
    }

    public function actionVerify2fa() {
        $token = trim(Yii::$app->request->post('token'));
        $code = trim(Yii::$app->request->post('code'));
        $rememberMe = trim(Yii::$app->request->post('remember_me')) === "1";

        $login_2fa = Bejelentkezes2fa::findOne(['token' => $token]);
        if (!$login_2fa) {
            return [
                'redirect_url' => '/admin',
            ];
        }
        $now = time();
        $tokenCreated = strtotime($login_2fa->letrehozva);
        $limit = 60 * 3; // 3 min
        if ($now - $tokenCreated > $limit) {
            return [
                'error' => 'Lejárt a link érvényességi ideje. Próbáljon újra bejelentkezni!',
                'redirect_after_error' => '/admin',
            ];
        }

        if (!$code) {
            return [
                'error' => [
                    'code' => 'Kötelező megadni!',
                ]
            ];
        }

        $user = $login_2fa->user;

        if (!TwoFactorAuth::auth($user->ketfaktoros_kulcs, $user->email, $code)) {
            return [
                'error' => [ 'code' => 'Hibás ellenőrző kód!' ],
            ];
        }

        $session = new Munkamenet;
        $session->token = Helpers::random_bytes();
        $session->letrehozva = date('Y-m-d H:i:s');
        $session->felhasznalo_id = $user->getPrimaryKey();
        $session->save(false);

        // Set session cookie
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'session',
            'value' => $session->token,
            'expire' => $rememberMe ? time() + 86400 * 365 : time() + 60 * 60,
        ]));

        $user->log('login', [
            'Felhasználó ID' => $user->getPrimaryKey(),
            'E-mail cím' => $user->email,
            'Bejelentkezés időpontja' => date('Y-m-d H:i:s'),
            'IP cím' => ($_SERVER['REMOTE_ADDR'] ?: ''),
            'Eszköz típusa' => ClientInfo::deviceType(),
            'Operációs rendszer' => ClientInfo::osName(),
            'Operációs rendszer verzió' => ClientInfo::osVersion(),
            'Böngésző' => ClientInfo::browserName(),
            'Böngésző verzió' => ClientInfo::browserVersion(),
            '2FA' => true,
        ]);

        return [
            'redirect_url' => '/admin',
        ];
    }

    public function actionLogin() {
        $email = trim(Yii::$app->request->post('email'));
        $password = Yii::$app->request->post('password');
        $rememberMe = Yii::$app->request->post('remember-me') === 'true';

        $error = [];
        if (!$email) {
            $error['email'] = 'Ketelező mező.';
        }
        if (!$password) {
            $error['password'] = 'Kötelező mező.';
        }

        if (count($error) > 0) {
            return [
                'error' => $error,
            ];
        }

        $user = Felhasznalo::findOne(['email' => $email]);

        if (!$user) {
            return [
                'error' => 'Hibás felhasználónév vagy jelszó.',
            ];
        }

        if (!password_verify($password, $user->jelszo_hash)) {
            return [
                'error' => 'Hibás felhasználónév vagy jelszó.',
            ];
        }

        if ($user->ketfaktoros_kulcs) {
            $token = Helpers::random_bytes();

            $login_2fa = new Bejelentkezes2fa;
            $login_2fa->token = $token;
            $login_2fa->letrehozva = date('Y-m-d H:i:s');
            $login_2fa->felhasznalo_id = $user->getPrimaryKey();
            $login_2fa->save(false);

            return [
                'redirect_url' => '/admin/2fa?token=' . $token . '&remember_me=' . ($rememberMe ? 1 : 0),
            ];
        } else {
            $session = new Munkamenet;
            $session->token = Helpers::random_bytes();
            $session->letrehozva = date('Y-m-d H:i:s');
            $session->felhasznalo_id = $user->getPrimaryKey();
            $session->save(false);

            // Set session cookie
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'session',
                'value' => $session->token,
                'expire' => $rememberMe ? time() + 86400 * 365 : time() + 60 * 60,
            ]));

            $user->log('login', [
                'Felhasználó ID' => $user->getPrimaryKey(),
                'E-mail cím' => $user->email,
                'Bejelentkezés időpontja' => date('Y-m-d H:i:s'),
                'IP cím' => ($_SERVER['REMOTE_ADDR'] ?: ''),
                'Eszköz típusa' => ClientInfo::deviceType(),
                'Operációs rendszer' => ClientInfo::osName(),
                'Operációs rendszer verzió' => ClientInfo::osVersion(),
                'Böngésző' => ClientInfo::browserName(),
                'Böngésző verzió' => ClientInfo::browserVersion(),
                '2FA' => false,
            ]);

            return [
                'redirect_url' => '/admin'
            ];
        }
    }

    public function actionSaveProductAttributes($id) {
        $product = Termek::findOne($id);

        foreach ($_POST as $key => $value) {
            if (substr($key, 0, 4) === 'attr') {
                $attrId = str_replace('attr', '', $key);
                $attrRecord = TermekTulajdonsag::findOne($attrId);
                if ($attrRecord && !$attrRecord->attr->variaciokepzo) {
                    switch ($attrRecord->attr->ertek_tipus) {
                        case 'string':
                            $attrRecord->ertek_str = $value;
                            break;
                        case 'bool':
                            $attrRecord->ertek_num = $value ? 1 : 0;
                            break;
                        case 'number':
                            $attrRecord->ertek_num = floatval($value);
                            break;
                        case "file":
                            $attrRecord->ertek_file = $value ? $value : null;
                            break;
                        case 'select':
                            $attrRecord->ertek_id = $value ? $value : null;
                            break;
                        case 'multiselect':
                            // Reset
                            foreach (TermekTulajdonsagErtek::find()->where(['termek_tulajdonsag_id' => $attrRecord->getPrimaryKey()])->all() as $option) {
                                $option->delete();
                            }
                            foreach (json_decode($value, true) as $optionId) {
                                $prodAttrValue = new TermekTulajdonsagErtek;
                                $prodAttrValue->termek_tulajdonsag_id = $attrRecord->getPrimaryKey();
                                $prodAttrValue->tulajdonsag_opcio_id = $optionId;
                                $prodAttrValue->save(false);
                            }
                            break;
                    }
                    $attrRecord->save(false);
                } else {
                    // Variation
                    foreach (TermekTulajdonsagErtek::find()->where(['termek_tulajdonsag_id' => $attrRecord->getPrimaryKey()])->all() as $option) {
                        $option->delete();
                    }
                    foreach (json_decode($value, true) as $optionId) {
                        $prodAttrValue = new TermekTulajdonsagErtek;
                        $prodAttrValue->termek_tulajdonsag_id = $attrRecord->getPrimaryKey();
                        $prodAttrValue->tulajdonsag_opcio_id = $optionId;
                        $prodAttrValue->save(false);
                    }
                }
            }
        }

        // Update variations
        $product->createOrUpdateVariationsFromAttributes();

        return [
           'redirect_url' => '(current)',
        ];
    }

    // GENERAL

    public function actionRender() {
        $view = Yii::$app->request->post('view');
        $data = Yii::$app->request->post('data', []);
        return [
            'html' => Helpers::render($view, $data),
        ];
    }

    public function actionDelete($class = '') {
        $id = Yii::$app->request->post('id');
        $class = '\\app\\models\\' . $class;

        $model = $class::findOne($id);

        if ($model) {
            $model->delete();
        }

        return [
            'redirect_url' => '(current)',
            'id' => $id,
        ];
    }

    public function actionEdit($class, $id = '', $redirect_url = '') {
        $class = '\\app\\models\\' . $class;

        $data = Yii::$app->request->post();

        if (!$id) {
            // New record
            $model = new $class;
            $isNewRecord = true;
        } else {
            // Existing record
            $isNewRecord = false;
            $model = $class::findOne($id);
        }

        if (method_exists($class, 'casts')) {
            $data = $class::casts($data);
        }

        foreach ($data as $key => $value) {
            $model->$key = $value;
        }

        $model->validate();
        $errors = $model->errors;
        if (count($errors) > 0) {
            return [
                "error" => $errors,
            ];
        }

        if ($isNewRecord) {
            if (method_exists($model, 'beforeCreate')) {
                $model->beforeCreate($data);
            }
        } else {
            if (method_exists($model, 'beforeUpdate')) {
                $model->beforeUpdate($data);
            }
        }

        $model->save(false);

        if (method_exists($model, 'postProcess')) {
            $model->postProcess($data, $isNewRecord);
        }

        return [
            'error' => null,
            'id' => $model->getPrimaryKey(),
            'redirect_url' => $redirect_url,
        ];
    }

    public function actionRenderTableRow() {
        $class = Yii::$app->request->post('class');
        $id = Yii::$app->request->post('id');

        $columns = Yii::$app->request->post('columns', []);
        $actions = Yii::$app->request->post('actions', []);

        $model = $class::findOne($id);

        return [
            'html' => Helpers::render('ui/_table_row', [
                'model' => $model,
                'columns' => $columns,
                'actions' => $actions,
            ]),
        ];
    }

    public function actionUpload() {
        $data = Yii::$app->request->post('data', '');
        $filename = Yii::$app->request->post('filename', '');
        $binary = base64_decode($data);
        $sha1 = sha1($binary);

        // Save record

        $dirPath = 'storage/blobs/' . substr($sha1, 0, 2);
        $filePath = 'storage/blobs/' . substr($sha1, 0, 2) . '/' . $sha1;

        if (!file_exists($filePath)) {
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }

            // Save file
            file_put_contents($filePath, $binary);
        }

        // Create file model
        $fileModel = new Fajl;
        $fileModel->fajlnev = $filename;
        $fileModel->felhasznalo_id = Felhasznalo::current()->getPrimaryKey();
        $fileModel->feltoltve = date('Y-m-d H:i:s');
        $fileModel->sha1 = $sha1;
        $fileModel->meret = strlen($binary);
        $fileModel->save(false);

        return [
            'error' => null,
            'id' => $fileModel->getPrimaryKey(),
            'filename' => $fileModel->fajlnev,
            'size' => Helpers::humanFileSize($fileModel->meret),
            'sha1' => $sha1,
            'photoUrl' => $fileModel->resizePhotoCover(100, 100),
        ];
    }

    public function actionSearch($class, $attrs, $column = '', $except = '') {
        if ($class !== '(global)') {
            $class = '\\app\\models\\' . $class;
        }
        $attrs = explode(",",$attrs);
        $except = explode(',', $except);

        $q = Yii::$app->request->post('q', '');

        $results = [];

        $adminUser = Felhasznalo::current();

        if ($class === '(global)') {


                // Felhasználó neve
                foreach (Felhasznalo::find()->where([ 'or',  ['like', 'nev', $q], ['like', 'email', $q]])->limit(5)->all() as $item) {
                    $results[] = [
                        'id' => '/admin/user?id=' . $item->id,
                        'html' => '<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-indigo-200 text-gray-800">Felhasználó</span> '  . $item->nev . '</b>'
                    ];
                }


                // Termék neve
                foreach (Termek::find()->where([ 'or',  ['like', 'nev', $q], ['like', 'cikkszam', $q]])->limit(5)->all() as $item) {
                    $results[] = [
                        'id' => '/admin/edit-product?id=' . $item->id,
                        'html' => '<span class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-medium bg-indigo-200 text-gray-800">Termék</span> '  . $item->nev . '</b>'
                    ];
                }

        } else {
            if (count($except) > 0 && $except[0]) {
                foreach ($class::find()->where(['and', ['like', $attrs[0], $q], ['not in', 'id', $except]])->all() as $item) {
                    $results[] = [
                        'id' => $item->getPrimaryKey(),
                        'html' => $item->columnViews()[$column](),
                    ];
                }
            } else {
                foreach ($class::find()->where(['like', $attrs[0], $q])->all() as $item) {
                    $results[] = [
                        'id' => $item->getPrimaryKey(),
                        'html' => $item->columnViews()[$column](),
                    ];
                }
            }
        }

        return [
            'results' => array_slice($results, 0, 20),
        ];
    }

    public function actionError()
    {
        return [
            'error' => 'Végzetes hiba történt.',
        ];
    }
}