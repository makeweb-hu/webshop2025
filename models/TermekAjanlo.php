<?php

namespace app\models;

use Yii;
use ZendSearch\Lucene\Index\Term;

/**
 * This is the model class for table "termekajanlo".
 *
 * @property integer $id
 * @property integer $termek_id
 * @property integer $masik_termek_id
 * @property integer $sorrend
 */
class TermekAjanlo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termekajanlo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termek_id', 'masik_termek_id'], 'required'],
            [['termek_id', 'masik_termek_id', 'sorrend'], 'integer'],
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
            'masik_termek_id' => 'Masik Termek ID',
            'sorrend' => 'Sorrend',
            'fancy_name' => 'Termék',
        ];
    }

    public function columnViews() {
        return [
            'fancy_name' => function () {
                return Termek::findOne($this->masik_termek_id)->columnViews()['fancy_name']();
            }
        ];
    }
}
