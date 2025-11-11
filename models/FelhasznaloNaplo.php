<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "felhasznalo_naplo".
 *
 * @property integer $id
 * @property string $letrehozva
 * @property integer $felhasznalo_id
 * @property string $tipus
 * @property string $parameterek
 */
class FelhasznaloNaplo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'felhasznalo_naplo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['letrehozva'], 'required'],
            [['letrehozva'], 'safe'],
            [['felhasznalo_id'], 'integer'],
            [['parameterek'], 'string'],
            [['tipus'], 'string', 'max' => 255],
        ];
    }

    public function getUser() {
        return Felhasznalo::findOne($this->felhasznalo_id);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'letrehozva' => 'Időpont',
            'felhasznalo_id' => 'Felhasznalo ID',
            'tipus' => 'Típus',
            'leiras' => 'Leírás',
            'parameterek' => 'Parameterek',
            'fancy_name' => 'Felhasználó',
        ];
    }

    public static function descriptions() {
        return [
            'login' => 'Bejelentkezett az admin felületre.',
            'logout' => 'Kijelentkezett az admin felületről.',
        ];
    }

    public function columnViews() {
        return [
            'tipus' => function () {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                  '.$this->tipus.'
                </span>';
            },
            'leiras' => function () {
                return self::descriptions()[$this->tipus] ?? '-';
            },
            'fancy_name' => function () {
                if (!$this->user) {
                    return '(törölt felhasználó)';
                }
                return '<span class="flex items-center">'.$this->user->getProfileImg(30) . $this->user->nev.'</span>';
            },
        ];
    }
}
