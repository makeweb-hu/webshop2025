<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "vasarlo".
 *
 * @property integer $id
 * @property string $email
 * @property string $telefonszam
 * @property integer $szallitasi_cim_id
 * @property integer $szamlazasi_cim_id
 * @property string $jelszo_hash
 * @property string $megjegyzes
 * @property integer $email_marketing
 *
 * @property Kosar[] $kosars
 * @property Cim $szallitasiCim
 * @property Cim $szamlazasiCim
 */
class Vasarlo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vasarlo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['szallitasi_cim_id', 'szamlazasi_cim_id', 'email_marketing'], 'integer'],
            [['megjegyzes'], 'string'],
            [['email', 'telefonszam', 'jelszo_hash', 'nev'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['email', 'nev', 'szallitasi_cim_id', 'szamlazasi_cim_id'], 'required'],
            [['email'], 'email'],
            [['szallitasi_cim_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cim::className(), 'targetAttribute' => ['szallitasi_cim_id' => 'id']],
            [['szamlazasi_cim_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cim::className(), 'targetAttribute' => ['szamlazasi_cim_id' => 'id']],
            [['letrehozas_idopontja'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'telefonszam' => 'Telefonszam',
            'szallitasi_cim_id' => 'Szallitasi Cim ID',
            'szamlazasi_cim_id' => 'Szamlazasi Cim ID',
            'jelszo_hash' => 'Jelszo Hash',
            'megjegyzes' => 'Megjegyzes',
            'email_marketing' => 'Email Marketing',
            'letrehozas_idopontja' => 'Regisztrálva',
            'spent' => 'Elköltött összeg',
            "nr_of_orders" => 'Rendelések',
            'fancy_name' => 'Név',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Kosar::className(), ['vasarlo_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingAddress()
    {
        return $this->hasOne(Cim::className(), ['id' => 'szallitasi_cim_id']);
    }

    public static function casts($data = []) {
        if ($data['szallitasi_cim_id'] ?? null) {
            $data['szallitasi_cim_id'] = json_decode($data['szallitasi_cim_id'])[0] ?? null;
        }
        if ($data['szamlazasi_cim_id'] ?? null) {
            $data['szamlazasi_cim_id'] = json_decode($data['szamlazasi_cim_id'])[0] ?? null;
        }
        return $data;
    }

    public function postProcess() {
        if (!$this->shippingAddress) {
            $model = new Cim;
            $model->nev = $this->nev;
            $model->iranyitoszam = '';
            $model->telepules = '';
            $model->utca = '';
            $model->orszag_id = 1; // Magyarország
            $model->save(false);

            $this->szallitasi_cim_id = $model->getPrimaryKey();
            $this->save(false);
        }

        if (!$this->billingAddress) {
            $model = new Cim;
            $model->nev = $this->nev;
            $model->iranyitoszam = '';
            $model->telepules = '';
            $model->utca = '';
            $model->orszag_id = 1; // Magyarország
            $model->save(false);

            $this->szamlazasi_cim_id = $model->getPrimaryKey();
            $this->save(false);
        }
    }

    public function nrOfOrders() {
        $nr = 0;
        foreach ($this->carts as $cart) {
            if ($cart->megrendelve) {
                $nr += 1;
            }
        }
        return $nr;
    }

    public function totalSpent() {
        $total = 0;
        foreach ($this->carts as $cart) {
            if ($cart->megrendelve) {
                $total += $cart->total;
            }
        }
        return $total;
    }

    public function avrageSpent() {
        if (!$this->nrOfOrders()) {
            return 0;
        }
        return $this->totalSpent() / $this->nrOfOrders();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillingAddress()
    {
        return $this->hasOne(Cim::className(), ['id' => 'szamlazasi_cim_id']);
    }

    public function columnViews() {
        return [
            'fancy_name' => function () {
                return '<div class="flex items-center"><img src="'.\app\components\Gravatar::generate($this->getPrimaryKey(), 50).'" width="50" class="mr-2" style="border-radius: 50%;" />' . $this->nev . '</div>';
            },
            'spent' => function () {
                return Helpers::formatMoney($this->totalSpent());
            },
            'nr_of_orders' => function () {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                  '.$this->nrOfOrders().' rendelés
                </span>';
            },
        ];
    }
}
