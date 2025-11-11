<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "vaiacio".
 *
 * @property integer $id
 * @property integer $termek_id
 * @property integer $opcio_1
 * @property integer $opcio_2
 * @property integer $opcio_3
 * @property integer $opcio_4
 * @property integer $opcio_5
 * @property string $nev
 * @property string $cikkszam
 * @property integer $foto_id
 * @property integer $ar
 * @property integer $akcios
 * @property string $akcio_tipusa
 * @property integer $akcios_ar
 * @property integer $akcio_szazalek
 * @property integer $statusz
 * @property integer $keszlet
 *
 * @property Termek $termek
 * @property Fajl $foto
 * @property TulajdonsagOpcio $opcio1
 * @property TulajdonsagOpcio $opcio2
 * @property TulajdonsagOpcio $opcio3
 * @property TulajdonsagOpcio $opcio4
 * @property TulajdonsagOpcio $opcio5
 */
class Variacio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'variacio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termek_id'], 'required'],
            [['termek_id', 'opcio_1', 'opcio_2', 'opcio_3', 'opcio_4', 'opcio_5', 'foto_id', 'ar', 'akcios', 'akcios_ar', 'akcio_szazalek', 'statusz', 'keszlet'], 'integer'],
            [['akcio_tipusa'], 'string'],
            [['nev', 'keszlet_info'], 'string', 'max' => 255],
            [['cikkszam'], 'string', 'max' => 20],
            [['termek_id'], 'exist', 'skipOnError' => true, 'targetClass' => Termek::className(), 'targetAttribute' => ['termek_id' => 'id']],
            [['foto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fajl::className(), 'targetAttribute' => ['foto_id' => 'id']],
            [['opcio_1'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['opcio_1' => 'id']],
            [['opcio_2'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['opcio_2' => 'id']],
            [['opcio_3'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['opcio_3' => 'id']],
            [['opcio_4'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['opcio_4' => 'id']],
            [['opcio_5'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['opcio_5' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'termek_id' => 'Termek ID',
            'opcio_1' => 'Opcio 1',
            'opcio_2' => 'Opcio 2',
            'opcio_3' => 'Opcio 3',
            'opcio_4' => 'Opcio 4',
            'opcio_5' => 'Opcio 5',
            'nev' => 'Név',
            'cikkszam' => 'Cikkszám',
            'foto_id' => 'Foto ID',
            'ar' => 'Ár',
            'akcios' => 'Akcios',
            'akcio_tipusa' => 'Akcio Tipusa',
            'akcios_ar' => 'Akcios Ar',
            'akcio_szazalek' => 'Akcio Szazalek',
            'statusz' => 'Státusz',
            'keszlet' => 'Készlet',
            'options' => 'Opciók',
            'fancy_name' => 'Név',
            'sku' => 'Cikkszám',
        ];
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
    public function getPhoto()
    {
        return $this->hasOne(Fajl::className(), ['id' => 'foto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcio1()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'opcio_1']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcio2()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'opcio_2']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcio3()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'opcio_3']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcio4()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'opcio_4']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpcio5()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'opcio_5']);
    }

    public function optionsArray() {
        $arr = [];
        foreach ([ $this->opcio1, $this->opcio2, $this->opcio3, $this->opcio4, $this->opcio5 ] as $item) {
            if ($item) {
                $arr[] = $item;
            }
        }
        return $arr;
    }

    public function currentPrice() {
        if ($this->ar) {
            if ($this->akcios && $this->akcios_ar) {
                return $this->akcios_ar;
            }
            return $this->ar;
        }
        return $this->product->currentPrice();
    }

    public function optionsAsString() {
        $all = [];
        foreach ($this->optionsArray() as $option) {
            $all[] = $option->ertek;
        }
        return implode(', ', $all);
    }

    public function hasOptionById($option_id) {
        if ($this->opcio_1 == $option_id) {
            return true;
        }
        if ($this->opcio_2 == $option_id) {
            return true;
        }
        if ($this->opcio_3 == $option_id) {
            return true;
        }
        if ($this->opcio_4 == $option_id) {
            return true;
        }
        if ($this->opcio_5 == $option_id) {
            return true;
        }
        return false;
    }

    public function getThumbnail() {
        $f = $this->photo;
        if ($f) {
            return $f->resizePhotoCover(320, 320);
        }
        return '/img/no-photo.jpg';
    }

    public function columnViews() {
        return [
            'nev' => function () {
                if (!$this->nev) {
                    return $this->product->nev;
                }
                return $this->nev;
            },
            'sku' => function () {
                return $this->cikkszam ?: $this->product->cikkszam;
            },
            'fancy_name' => function () {
                if (!$this->nev) {
                    $name = $this->product->nev;
                } else {
                    $name = $this->nev;
                }
                return '<span class="flex items-center"><img src="' . $this->thumbnail . '" class=" mr-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" />' . $name . '</span>';
            },
            'options' => function () {
                $str = '';
                foreach ($this->optionsArray() as $opt) {
                    $str .= '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                      '.$opt->ertek.'
                    </span>';
                }
                return $str;
            },
            'ar' => function () {
                $p = $this->ar ?: $this->product->ar;
                $sale_p = $this->akcios_ar ?: $this->product->akcios_ar;

                $price = Helpers::formatMoney($p);
                if ($this->akcios_ar) {
                    $price = '<span style="text-decoration:line-through;opacity:0.5">'.$price.'</span> ' . Helpers::formatMoney($sale_p);
                }
                return $price;
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

    public function postProcess() {
        $price = $this->ar ?: $this->product->ar;
        if (!$this->akcios) {
            $this->akcio_szazalek = null;
            $this->akcio_tipusa = 'szazalek';
            $this->akcios_ar = null;
            $this->save(false);
        } else if ($this->akcio_tipusa === "szazalek") {
            $this->akcios_ar = intval($price * (1 - ($this->akcio_szazalek / 100)));
            $this->save(false);
        } else if ($this->akcio_tipusa === "fix_ar") {
            $this->akcio_szazalek = intval(100 - ($this->akcios_ar / $price) * 100);
            $this->save(false);
        }
    }


}
