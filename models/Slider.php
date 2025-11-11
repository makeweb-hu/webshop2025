<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "slider".
 *
 * @property integer $id
 * @property string $cim
 * @property string $leiras
 * @property string $link
 * @property integer $sorrend
 * @property integer $kep_id
 */
class Slider extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'slider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cim', 'leiras', 'link'], 'required'],
            [['sorrend', 'kep_id'], 'integer'],
            [['cim', 'leiras', 'link'], 'string', 'max' => 255],
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
            'link' => 'Link',
            'sorrend' => 'Sorrend',
            'kep_id' => 'Kep ID',
        ];
    }

    public function getPhoto() {
        return Fajl::findOne($this->kep_id);
    }
}
