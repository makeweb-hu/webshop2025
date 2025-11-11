<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "oldal".
 *
 * @property integer $id
 * @property string $cim
 * @property string $leiras
 * @property integer $kep_id
 * @property string $url
 * @property string $tipus
 * @property integer $model_id
 *
 * @property Kategoria[] $kategorias
 * @property Fajl $kep
 */
class Oldal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oldal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kep_id', 'model_id', 'atiranyitas_statusz'], 'integer'],
            [['tipus', 'url'], 'required'],
            [['tipus'], 'string'],
            [['cim', 'leiras', 'url', 'hova'], 'string', 'max' => 255],
            [['url'], 'unique'],
            [['kep_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fajl::className(), 'targetAttribute' => ['kep_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cim' => 'Cim',
            'leiras' => 'Leiras',
            'kep_id' => 'Kep ID',
            'url' => 'Url',
            'tipus' => 'Tipus',
            'model_id' => 'Model ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKategorias()
    {
        return $this->hasMany(Kategoria::className(), ['oldal_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKep()
    {
        return $this->hasOne(Fajl::className(), ['id' => 'kep_id']);
    }

    public function getModel() {
        if ($this->tipus === 'kategoria') {
            return Kategoria::findOne($this->model_id);
        } else if ($this->tipus === 'termek') {
            return Termek::findOne($this->model_id);
        } else {
            return null;
        }
    }

    public function postProcess() {
        $this->url = Helpers::createUrl($this->url);
        $this->save(false);
    }

    public static function getAllTypes() {
        return [
            'termek' => 'Termék',
            'kategoria' => 'Kategória',
            'statikus_oldal' => 'Statikus oldal',
            'atiranyitas' => 'Átirányítás',
            'fooldal' => 'Főoldal',
            'hir' => 'Blogbejegyzés',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->url) {
            $record = Oldal::findOne(['url' => $this->url]);

            if ($record && $record->getPrimaryKey() !== $this->getPrimaryKey()) {
                // Duplikált URL
                $originalUrl = $this->url;
                $nr = 2;

                for (;;) {
                    $this->url = $originalUrl . '-' . $nr;

                    $record = Oldal::findOne(['url' => $this->url]);

                    if (!$record) {
                        break;
                    }

                    $nr += 1;
                }
            }
        }

        return parent::beforeSave($insert);
    }

    public function columnViews() {
        return [
            'url' => function () {
                $base = 'http://' . Beallitasok::get('domain');
                $open = '<a href="'.$base.'/'.$this->url.'" target="_blank"><i class="fa-solid fa-arrow-up-right-from-square"></i></a>';
                return  '<small><span class="text-gray-400">' . Beallitasok::get('domain') . '</span>/<span class="font-medium">' . $this->url . ' ' . $open . '</span></small>';
            },
            'tipus' => function () {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            '.self::getAllTypes()[$this->tipus].'
                        </span>';
            },
        ];
    }
}
