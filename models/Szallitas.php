<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "szallitas".
 *
 * @property integer $id
 * @property string $nev
 * @property string $leiras
 * @property integer $ar
 * @property string $szolgaltato
 * @property integer $statusz
 *
 * @property SzallitasFizetes[] $szallitasFizetes
 * @property Fizetes[] $fizetes
 */
class Szallitas extends \yii\db\ActiveRecord
{
    public $payments = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szallitas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev', 'ar'], 'required'],
            [['ar', 'statusz', 'sorrend'], 'integer'],
            [['szolgaltato'], 'string'],
            [['nev', 'leiras'], 'string', 'max' => 255],
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
            'leiras' => 'Leiras',
            'ar' => 'Ár',
            'szolgaltato' => 'Szolgaltato',
            'statusz' => 'Statusz',
            'sorrend' => 'Sorrend',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentLinks()
    {
        return $this->hasMany(SzallitasFizetes::className(), ['szallitas_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        $all = [];
        foreach ($this->paymentLinks as $link) {
            $all[] = $link->payment;
        }
        return $all;
    }

    public function allPaymentsForSelect() {
        $all = [];
        foreach ($this->getPayments() as $p) {
            $all[$p->id] = $p->nev;
        }
        return $all;
    }

    public function postProcess($data, $isNewRecord) {
        foreach ($this->paymentLinks as $link) {
            $link->delete();
        }

        foreach (json_decode($data['payments'] ?? '[]', true) as $id) {
            $link = new SzallitasFizetes;
            $link->szallitas_id = $this->getPrimaryKey();
            $link->fizetes_id = $id;
            $link->save(false);
        }
    }

    public function paymentIds() {
        $ids = [];
        foreach ($this->paymentLinks as $link) {
            $ids[] = $link->fizetes_id;
        }
        return $ids;
    }

    public function columnViews() {
        return [
            'ar' => function () {
                if (!$this->ar) {
                    return 'Ingyenes';
                }
                return Helpers::formatMoney($this->ar);
            },
            'statusz' => function () {
                if (!$this->statusz) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fa-regular fa-circle-xmark mr-1"></i> Inaktív
                            </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Aktív
                            </span>';
            }
        ];
    }

    public static function allForSelect() {
        $all = [];
        foreach (Szallitas::find()->where(['statusz' => 1])->all() as $item) {
            $all[$item->id] = $item->nev;
        }
        return $all;
    }
}
