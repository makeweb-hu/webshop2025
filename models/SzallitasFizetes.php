<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szallitas_fizetes".
 *
 * @property integer $id
 * @property integer $szallitas_id
 * @property integer $fizetes_id
 *
 * @property Fizetes $fizetes
 * @property Szallitas $szallitas
 */
class SzallitasFizetes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szallitas_fizetes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['szallitas_id', 'fizetes_id'], 'required'],
            [['szallitas_id', 'fizetes_id', 'sorrend'], 'integer'],
            [['szallitas_id', 'fizetes_id'], 'unique', 'targetAttribute' => ['szallitas_id', 'fizetes_id'], 'message' => 'The combination of Szallitas ID and Fizetes ID has already been taken.'],
            [['fizetes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fizetes::className(), 'targetAttribute' => ['fizetes_id' => 'id']],
            [['szallitas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Szallitas::className(), 'targetAttribute' => ['szallitas_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'szallitas_id' => 'Szallitas ID',
            'fizetes_id' => 'Fizetes ID',
            'sorrend' => 'Sorrend',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Fizetes::className(), ['id' => 'fizetes_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Szallitas::className(), ['id' => 'szallitas_id']);
    }
}
