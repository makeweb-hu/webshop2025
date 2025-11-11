<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kosar_tetel".
 *
 * @property integer $id
 * @property integer $kosar_id
 * @property integer $termek_id
 * @property integer $variacio_id
 * @property string $termeknev
 * @property integer $mennyiseg
 * @property string $opciok
 * @property integer $egysegar
 * @property integer $afa
 * @property string $idopont
 *
 * @property Termek $termek
 * @property Variacio $variacio
 */
class KosarTetel extends \yii\db\ActiveRecord
{
    public $egyedi_nev = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kosar_tetel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kosar_id', 'mennyiseg', 'idopont', 'termek_id'], 'required'],
            [['kosar_id', 'termek_id', 'variacio_id', 'mennyiseg', 'egysegar', 'afa'], 'integer'],
            [['opciok'], 'string'],
            [['idopont'], 'safe'],
            [['termeknev'], 'string', 'max' => 255],
            [['termek_id'], 'exist', 'skipOnError' => true, 'targetClass' => Termek::className(), 'targetAttribute' => ['termek_id' => 'id']],
            [['variacio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Variacio::className(), 'targetAttribute' => ['variacio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kosar_id' => 'Kosar ID',
            'termek_id' => 'Termek ID',
            'variacio_id' => 'Variacio ID',
            'termeknev' => 'Termeknev',
            'mennyiseg' => 'Mennyiseg',
            'opciok' => 'Opciok',
            'egysegar' => 'Egységár',
            'afa' => 'Afa',
            'idopont' => 'Idopont',
            'product' => 'Tétel',
            'price' => 'Összesen',
        ];
    }

    public function getCart() {
        return Kosar::findOne($this->kosar_id);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Termek::className(), ['id' => 'termek_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVariation()
    {
        return $this->hasOne(Variacio::className(), ['id' => 'variacio_id']);
    }

    public function getUnitPrice() {
        if ($this->cart->megrendelve) {
            // Már megrendelés
            return $this->egysegar;
        } else {
            // Még csak kosár
            if ($this->variation) {
                return $this->variation->currentPrice();
            } else {
                return $this->product->currentPrice();
            }
        }
    }

    public function getVatRate() {
        if ($this->cart->megrendelve) {
            if (is_null($this->afa)) {
                if (is_null($this->cart->afa)) {
                    return 0;
                }
                return $this->cart->afa / 100;
            } else {
                return $this->afa / 100;
            }
        } else {
            if ($this->variation) {
                return $this->variation->product->getVatRate();
            } else {
                return $this->product->getVatRate();
            }
        }
    }

    public function getUnitPriceNet() {
        if ($this->cart->megrendelve) {
            // Már megrendelés
            return $this->egysegar / (1 + $this->getVatRate());
        } else {
            // Még csak kosár
            if ($this->variation) {
                return $this->variation->currentPrice() / (1 + $this->getVatRate());
            } else {
                return $this->product->currentPrice() / (1 + $this->getVatRate());
            }
        }
    }

    public function getPrice() {
        return $this->getUnitPrice() * $this->mennyiseg;
    }

    public function getPriceNet() {
        return $this->getUnitPriceNet() * $this->mennyiseg;
    }

    public function columnViews() {
        return [
            'mennyiseg' => function () {
                $unit = '';
                if ($this->product && $this->product->unit) {
                    $unit = ' ' . $this->product->unit->rovid_nev;
                }
                return $this->mennyiseg . ' ' . $unit;
            },
            'egysegar' =>function () {
                return number_format($this->getUnitPrice(), 0, '', ' ') . ' Ft';
            },
            'product' => function () {
                if ($this->variation) {
                    return '<a href="/admin/edit-product?id='.$this->product->id.'">' . $this->product->columnViews()['fancy_name']($this->termeknev, $this->variation->optionsAsString()) . '</a>';
                }
                return '<a href="/admin/edit-product?id='.$this->product->id.'">' . $this->product->columnViews()['fancy_name']($this->termeknev) . '</a>';
            },
            'price' => function () {
                return number_format($this->getPrice(), 0, '', ' ') . ' Ft';
            }
        ];
    }

    public function postProcess() {
        if (!$this->termeknev) {
            $this->termeknev = $this->product->nev;
            $this->save(false);
        }
        if (!$this->egysegar) {
            $this->egysegar = $this->product->ar;
            $this->save(false);
        }
    }
}
