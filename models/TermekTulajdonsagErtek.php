<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "termek_tulajdonsag_ertek".
 *
 * @property integer $id
 * @property integer $termek_tulajdonsag_id
 * @property integer $tulajdonsag_opcio_id
 *
 * @property TermekTulajdonsag $termekTulajdonsag
 * @property TulajdonsagOpcio $tulajdonsagOpcio
 */
class TermekTulajdonsagErtek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek_tulajdonsag_ertek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termek_tulajdonsag_id', 'tulajdonsag_opcio_id'], 'required'],
            [['termek_tulajdonsag_id', 'tulajdonsag_opcio_id'], 'integer'],
            [['termek_tulajdonsag_id'], 'exist', 'skipOnError' => true, 'targetClass' => TermekTulajdonsag::className(), 'targetAttribute' => ['termek_tulajdonsag_id' => 'id']],
            [['tulajdonsag_opcio_id'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['tulajdonsag_opcio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'termek_tulajdonsag_id' => 'Termek Tulajdonsag ID',
            'tulajdonsag_opcio_id' => 'Tulajdonsag Opcio ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductAttribute()
    {
        return $this->hasOne(TermekTulajdonsag::className(), ['id' => 'termek_tulajdonsag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'tulajdonsag_opcio_id']);
    }
}
