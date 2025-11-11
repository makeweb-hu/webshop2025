<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "orszag".
 *
 * @property integer $id
 * @property string $nev
 *
 * @property Cim[] $cims
 */
class Orszag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orszag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev'], 'required'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCims()
    {
        return $this->hasMany(Cim::className(), ['orszag_id' => 'id']);
    }

    public static function allForSelect() {
        $all = [];
        foreach (Orszag::find()->all() as $item) {
            $all[$item->id] = $item->nev;
        }
        return $all;
    }
}
