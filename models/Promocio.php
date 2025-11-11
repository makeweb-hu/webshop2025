<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "promocio".
 *
 * @property integer $id
 * @property string $tipus
 * @property string $ervenyesseg_kezdete
 * @property string $ervenyesseg_vege
 * @property integer $minimum_osszeg
 * @property string $kedvezmeny_tipusa
 * @property integer $kedvezmeny_merteke
 * @property integer $kategoria_id
 */
class Promocio extends \yii\db\ActiveRecord
{
    public $ervenyessegi_ido = null;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promocio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipus', 'kedvezmeny_tipusa', 'kedvezmeny_merteke'], 'required'],
            [['tipus', 'kedvezmeny_tipusa'], 'string'],
            [['ervenyesseg_kezdete', 'ervenyesseg_vege'], 'safe'],
            [['minimum_osszeg', 'kedvezmeny_merteke', 'kategoria_id', 'statusz'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipus' => 'Tipus',
            'ervenyesseg_kezdete' => 'Ervenyesseg Kezdete',
            'ervenyesseg_vege' => 'Ervenyesseg Vege',
            'minimum_osszeg' => 'Minimum Osszeg',
            'kedvezmeny_tipusa' => 'Kedvezmeny Tipusa',
            'kedvezmeny_merteke' => 'Kedvezmeny Merteke',
            'kategoria_id' => 'Kategoria ID',
            'discount' => 'Kedvezmény',
            'date' => 'Érvényesség',
            'statusz' => 'Státusz',
        ];
    }

    public function getCategory() {
        return Kategoria::findOne($this->kategoria_id);
    }


    public function postProcess() {
        if (!$this->ervenyessegi_ido || $this->ervenyessegi_ido === 'false') {
            $this->ervenyesseg_kezdete = null;
            $this->ervenyesseg_vege = null;
            $this->save(false);
        }
    }

    public function columnViews() {
        return [
            'statusz' => function () {
                if (!$this->statusz) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fa-regular fa-circle-xmark mr-1"></i> Inaktív
                            </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Aktív
                            </span>';
            },
            'discount' => function () {
                if ($this->kedvezmeny_tipusa === 'szazalek') {
                    if ($this->kedvezmeny_merteke >= 100) {
                        $amount = 'Ingyenesség';
                    } else {
                        $amount = '-' . $this->kedvezmeny_merteke . '%';
                    }
                } else {
                    $amount = '-' . Helpers::formatMoney($this->kedvezmeny_merteke);
                }

                $amount = '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">
                  '.$amount.'
                </span>';

                if ($this->tipus === 'termek') {
                    if ($this->category) {
                        $postfix = ' minden termékre a <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">'.$this->category->nev .'</span> kategóriából';
                    } else {
                        $postfix = ' az összes termékekre';
                    }
                } else {
                    $postfix = ' a szállítási díjra';

                    if ($this->minimum_osszeg) {
                        $postfix .= ' <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">' . Helpers::formatMoney($this->minimum_osszeg) . '</span> felett';
                    }
                }

                return $amount . $postfix;
            },
            'date' => function () {
                if ($this->ervenyesseg_kezdete && $this->ervenyesseg_vege) {
                    return date('Y.m.d.', strtotime($this->ervenyesseg_kezdete)) . ' – ' . date('Y.m.d.', strtotime($this->ervenyesseg_vege));
                }
                if ($this->ervenyesseg_kezdete) {
                    return 'Ettől: ' . date('Y.m.d.', strtotime($this->ervenyesseg_kezdete));
                }
                if ($this->ervenyesseg_vege) {
                    return 'Eddig: ' . date('Y.m.d.', strtotime($this->ervenyesseg_vege));
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                  Mindig érvényes
                </span>';
            }
        ];
    }
}
