<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "egyseg".
 *
 * @property integer $id
 * @property string $nev
 * @property string $rovid_nev
 */
class Egyseg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'egyseg';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev', 'rovid_nev'], 'required'],
            [['nev'], 'string', 'max' => 255],
            [['rovid_nev'], 'string', 'max' => 10],
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
            'rovid_nev' => 'Rovid Nev',
        ];
    }

    public static function allForSelect() {
        $all = [];

        foreach (Egyseg::find()->all() as $item) {
            $all[$item->id] = $item->nev . ' (' . $item->rovid_nev . ')';
        }

        return $all;
    }
}
