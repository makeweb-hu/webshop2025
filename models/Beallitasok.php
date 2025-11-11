<?php

namespace app\models;

use app\components\Lang;
use Yii;

/**
 * This is the model class for table "beallitasok".
 *
 * @property integer $id
 * @property integer $karbantartas_alatt
 * @property string $karbantartas_szoveg_hu
 * @property string $karbantartas_szoveg_en
 * @property string $karbantartas_szoveg_de
 * @property integer $statuszuzenet
 * @property string $statuszuzenet_hu
 * @property string $statuszuzenet_en
 * @property string $statuszuzenet_de
 * @property integer $demo_sav
 * @property integer $eur_huf
 * @property integer $afa
 * @property string $szamlazzhu_api_kulcs
 * @property string $szamlazzhu_elotag
 * @property string $twilio_send_url
 * @property string $twilio_sid
 * @property string $twilio_token
 * @property string $twilio_message_service_id
 * @property string $stripe_api_kulcs
 * @property string $nmfr_felhasznalonev
 * @property string $nmfr_jelszo
 * @property string $nmfr_purchase_url
 * @property string $smtp_host
 * @property string $smtp_username
 * @property string $smtp_password
 * @property string $smtp_port
 * @property string $smtp_encryption
 * @property string $simplepay_merchant
 * @property string $simplepay_secret_key
 * @property integer $simplepay_sandbox
 * @property string $kozponti_telefonszam
 * @property string $kozponti_email
 * @property integer $ceg_cim_id
 */
class Beallitasok extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'beallitasok';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['karbantartas_alatt', 'afa'], 'integer'],
            [['karbantartas_szoveg', 'domain'], 'string'],
            [['szamlazzhu_api_kulcs', 'szamlazzhu_elotag', 'smtp_host', 'smtp_username', 'smtp_password', 'smtp_port', 'smtp_encryption','szamlazzhu_nyugta_elotag',
                'twilio_send_url', 'twilio_sid', 'twilio_token', 'twilio_message_service_id', 'kozponti_telefonszam', 'kozponti_email'], 'string', 'max' => 255],
            [['facebook_oldal'], 'url'],
            [['ceg_cim_id', 'email_sablon_egyzeru'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'karbantartas_alatt' => 'Karbantartas Alatt',
            'karbantartas_alatt_szoveg' => 'Karbantartas Alatt Szöveg',
            'afa' => 'Afa',
            'szamlazzhu_api_kulcs' => 'Szamlazzhu Api Kulcs',
            'szamlazzhu_elotag' => 'Szamlazzhu Elotag',
            'szamlazzhu_nyugta_elotag' => 'Szamlazzhu Nyugta Elotag',
            'stripe_api_kulcs' => 'Stripe Api Kulcs',
            'smtp_host' => 'Smtp Host',
            'smtp_username' => 'Smtp Username',
            'smtp_password' => 'Smtp Password',
            'smtp_port' => 'Smtp Port',
            'smtp_encryption' => 'Smtp Encryption',
        ];
    }

    public static function get($prop) {
        return Beallitasok::findOne(1)->$prop;
    }

    public function beforeUpdate($data)
    {
        if ($data['ceg_cim_id'] ?? null) {
            $decoded = json_decode($data['ceg_cim_id'], true);
            if (count($decoded) === 1) {
                $this->ceg_cim_id = $decoded[0];
            } else {
                $this->ceg_cim_id = null;
            }
        }
    }
}
