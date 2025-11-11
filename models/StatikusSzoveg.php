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
            [['nev', 'tartalom_hu'], 'required'],
            [['tartalom_hu'], 'string'],
            [['nev'], 'string', 'max' => 255],
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

    public static function get($name) {
        return StatikusSzoveg::findOne(["nev" => $name])->tartalom_hu;
    }

    public static function getMultiline($name) {
        $str = StatikusSzoveg::findOne(["nev" => $name])->tartalom_hu;
        $str = str_replace("\n", "<br>", $str);
        return $str;
    }
}
