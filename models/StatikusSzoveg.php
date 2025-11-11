<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "statikus_szoveg".
 *
 * @property integer $id
 * @property string $nev
 * @property string $tartalom_hu
 * @property string $tartalom_en
 * @property string $tartalom_de
 */
class StatikusSzoveg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statikus_szoveg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev'], 'required'],
            [['tartalom_hu'], 'string'],
            [['nev'], 'string', 'max' => 255],
            [['tipus'], 'safe'],
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
            'tartalom_hu' => 'Tartalom Hu',
            'tartalom_en' => 'Tartalom En',
            'tartalom_de' => 'Tartalom De',
        ];
    }

    public static function types() {
        return [
            'rovid_szoveg' => 'Rövid szöveg',
            'hosszu_szoveg' => 'Hosszú szöveg',
            'formazott_szoveg' => 'Formazott szöveg',
            'html' => 'HTML',
            'fajl' => 'Fajl',
        ];
    }

    public static function get($name) {
        $raw = StatikusSzoveg::findOne(["nev" => $name])->tartalom_hu;
        $model = StatikusSzoveg::findOne(["nev" => $name]);
        if ($model->tipus === 'rovid_szoveg') {
            return htmlspecialchars($raw);
        } else if ($model->tipus === 'hosszu_szoveg') {
            $raw = htmlspecialchars($raw);
            $raw = str_replace("\n", "<br>", $raw);
            return $raw;
        } else if ($model->tipus === 'fajl') {
            $file = Fajl::findOne($raw);
            if (!$file) {
                return '/img/no-photo.jpg';
            }
            return $file->url;
        } else {
            // html, formazott_szoveg
            return $raw;
        }
    }

    public static function getMultiline($name) {
        $str = StatikusSzoveg::findOne(["nev" => $name])->tartalom_hu;
        $str = str_replace("\n", "<br>", $str);
        return $str;
    }

    public function columnViews() {
        return [
            'tipus' => function () {
                return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">'.self::types()[$this->tipus] . '</span>';
            },
        ];
    }
}
