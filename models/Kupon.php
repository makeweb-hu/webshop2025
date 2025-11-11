<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "kupon".
 *
 * @property integer $id
 * @property string $kod
 * @property string $ervenyesseg_kezdete
 * @property string $ervenyesseg_vege
 * @property string $kedvezmeny_hatasa
 * @property string $kedvezmeny_tipusa
 * @property integer $kedvezmeny_merteke
 * @property integer $statusz
 */
class Kupon extends \yii\db\ActiveRecord
{
    public $ervenyessegi_ido = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kod', 'kedvezmeny_hatasa', 'kedvezmeny_tipusa', 'kedvezmeny_merteke'], 'required'],
            [['ervenyesseg_kezdete', 'ervenyesseg_vege'], 'safe'],
            [['kedvezmeny_hatasa', 'kedvezmeny_tipusa'], 'string'],
            [['kedvezmeny_merteke', 'statusz'], 'integer'],
            [['kod'], 'string', 'max' => 30],
            [['kod'], 'unique'],
            [['kod'], 'match', 'pattern' => '@^[0-9A-Z]+$@', 'message' => 'Csak angol nagybetűt és számokat tartalmazhat: A-Z és 0-9'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kod' => 'Kód',
            'ervenyesseg_kezdete' => 'Ervenyesseg Kezdete',
            'ervenyesseg_vege' => 'Ervenyesseg Vege',
            'kedvezmeny_hatasa' => 'Kedvezmeny Hatasa',
            'kedvezmeny_tipusa' => 'Kedvezmeny Tipusa',
            'kedvezmeny_merteke' => 'Kedvezmeny Merteke',
            'statusz' => 'Státusz',
            'discount' => 'Kedvezmény',
            'date' => 'Érvényesség',
            'used' => 'Felhasználás',
        ];
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

                if ($this->kedvezmeny_hatasa === 'termekek') {
                    $postfix = ' a termékekből';
                } else if ($this->kedvezmeny_hatasa === 'szallitasi_dij') {
                    $postfix = ' a szállítási díjból';
                } else {
                    $postfix = ' a végösszegből';
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
            },
            'used' => function () {
                $count = 0;
                // TODO: megszámolni a rendeléseket
                return '<a href="/admin/coupon-usage?id='.$this->id.'"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  '.$count.' felhasználás
                </span></a>';
            },
        ];
    }

    public static function allForSelect() {
        $all = [];
        foreach (Kupon::find()->where(['statusz' => 1])->all() as $item) {
            $all[$item->id] = $item->kod;
        }
        return $all;
    }
}
