<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "email_sablon".
 *
 * @property integer $id
 * @property string $nev
 * @property string $targy
 * @property string $szoveg
 */
class EmailSablon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_sablon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev', 'targy'], 'required'],
            [['szoveg'], 'string'],
            [['nev', 'targy', 'cimsor'], 'string', 'max' => 255],
            [['sablon'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev' => 'Nev',
            'targy' => 'Targy',
            'szoveg' => 'Szoveg',
            'cimsor' => 'Címsor',
        ];
    }

    public static function setSmpt($givenLang = '') {
        Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => Beallitasok::get('smtp_host' . $lang),
            'username' => Beallitasok::get('smtp_username' . $lang),
            'password' => Beallitasok::get('smtp_password' . $lang),
            'port' => Beallitasok::get('smtp_port' . $lang),
            'encryption' => strtolower(Beallitasok::get('smtp_encryption' . $lang)),
            'streamOptions' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ],
        ]);
    }

    public static function replaceData($raw, $data) {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                // Repeat
                $raw = preg_replace_callback('@\[\s*begin\s*:\s*'.$key.'\s*\](.*?)\[\s*end\s*:\s*'.$key.'\s*\]@s', function ($matches) use ($key, $value) {
                    $subtext = $matches[0];
                    $subtext = preg_replace('@\[\s*begin\s*:\s*'.$key.'\s*\]@', '', $subtext);
                    $subtext = preg_replace('@\[\s*end\s*:\s*'.$key.'\s*\]@', '', $subtext);

                    $repeatedText = '';

                    foreach ($value as $item) {
                        $subtextForSingleItem = $subtext;
                        foreach ($item as $k => $v) {
                            if (is_array($v)) {
                                $subtextForSingleItem = str_replace('[' . $k . ']', '', $subtextForSingleItem);
                            } else {
                                $subtextForSingleItem = str_replace('[' . $k . ']', strval($v), $subtextForSingleItem);
                            }
                        }
                        $repeatedText .= $subtextForSingleItem;
                    }

                    // Elágazásként használható így
                    if (count($value) === 1 && is_string($value[0])) {
                        $repeatedText = str_replace('[' . $key . ']', $value[0], $repeatedText);
                    }

                    return $repeatedText;
                }, $raw);
            } else {
               $raw = str_replace('[' . $key . ']', strval($value), $raw);
            }
        }
        return $raw;
    }

    public function renderSubject($data = []) {
        return self::replaceData($this->targy, $data);
    }

    public function renderBody($data = []) {
        $html = $this->getRaw(); // RAW template

        // Replace footer
        $data['footer'] = Beallitasok::get('email_lablec');

        // Replace logo
        $logo = Fajl::findOne(Beallitasok::get('email_logo_id'));
        if ($logo) {
            $data['logo_url'] = Helpers::rootUrl() . $logo->getUrl();
        } else {
            $data['logo_url'] = Helpers::rootUrl() . '/img/makeweb.png';
        }

        // Title & body
        $data['cimsor'] = self::replaceData($this->cimsor, $data);
        $data['szoveg'] = self::replaceData($this->szoveg, $data);

        $html = self::replaceData($html, $data);

        return $html;
    }

    public function getRaw() {
        if ($this->sablon == 'megrendeles') {
            return Beallitasok::get('email_sablon_rendeles');
        } else if ($this->sablon == 'kapcsolat') {
            return Beallitasok::get('email_sablon_kapcsolat');
        } else if ($this->sablon == 'egyszeru') {
            return Beallitasok::get('email_sablon_egyszeru');
        } else {
            return '<b>[cimsor]</b><br><br>[szoveg]';
        }
    }

    public function testData() {
        if ($this->sablon == 'megrendeles') {
            return [
                'nev' => 'Teszt Béla',
                'email' => 'valaki@valami.hu',
                'telefonszam' => '06 30 123 4567',
                'rendelesszam' => 'ORD00001',
                'szallitasi_mod' => 'Futárszolgálat',
                'fizetesi_mod' => 'Utánvét',
                'szallitasi_cim' => 'Teszt Béla<br>Magyarország<br>4400 Nyíregyháza<br>Teszt utca 51/b.',
                'szamlazasi_cim' => 'Teszt Béla<br>Magyarország<br>4400 Nyíregyháza<br>Teszt utca 51/b.',
                'megjegyzes' => ['Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                'fizetes_menete' => ['Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.'],
                'termekek' => [
                    [
                        'termeknev' => 'Teszt termék 1',
                        'foto_url' => Helpers::rootUrl() . '/img/product-sample-1.jpg',
                        'opciok' => '',
                        'mennyiseg' => 1,
                        'ar' => '25 990 Ft',
                    ],
                    [
                        'termeknev' => 'Teszt termék 2',
                        'foto_url' => Helpers::rootUrl() . '/img/product-sample-2.jpg',
                        'opciok' => 'Szín: kék',
                        'mennyiseg' => 2,
                        'ar' => '11 990 Ft',
                    ]
                ],
                'termekek_osszesen' => '37 980 Ft',
                'szallitas_dija' => ['990 Ft'],
                'fizetes_dija' => ['–'],
                'kedvezmeny' => '-990 Ft',
                'afa_osszesen' => '8 074 Ft',
                'vegosszeg' => '37 980 Ft',
            ];
        }

        if ($this->sablon == 'kapcsolat') {
            return [
                'termeknev' => 'Teszt termék 2',
                'foto_url' => Helpers::rootUrl() . '/img/product-sample-2.jpg',
                'opciok' => 'Szín: kék',
                'termek' => [''],
                'nev' => 'Teszt Béla',
                'email' => 'teszt.bela@gmail.com',
                'telefon' => '06309552222',
                'uzenet' => 'Kedves Webshop!<br><br>Ez egy teszt üzenet...<br><br>Üdv,<br>Teszt Béla'
            ];
        }

        return [];
    }

    public function send($orderId, $toEmail, $attachment = '') {
        $order = Kosar::findOne($orderId);

        $template = $this;
        $testData = $order->getDataForEmailTemplate();

        try {
            Helpers::setSmpt();

            $fromName = Beallitasok::get('smtp_sender_name');
            $fromAddress = Beallitasok::get('smtp_sender_email');

            $mail = Yii::$app->mailer->compose()
                ->setTo($toEmail)
                ->setFrom([
                    $fromAddress => $fromName,
                ])
                ->setReplyTo('borago.74@gmail.com')
                ->setSubject($template->renderSubject($testData))
                ->setHtmlBody($template->renderBody($testData));

            if ($attachment) {
                $mail->attach($attachment);
            }

            $mail->send();

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
