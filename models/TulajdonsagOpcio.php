<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tulajdonsag_opcio".
 *
 * @property integer $id
 * @property integer $tulajdonsag_id
 * @property string $ertek
 * @property integer $sorrend
 *
 * @property Tulajdonsag $tulajdonsag
 */
class TulajdonsagOpcio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tulajdonsag_opcio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'ertek'], 'required'],
            [['tulajdonsag_id', 'sorrend'], 'integer'],
            [['ertek'], 'string', 'max' => 255],
            [['tulajdonsag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tulajdonsag::className(), 'targetAttribute' => ['tulajdonsag_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tulajdonsag_id' => 'Tulajdonsag ID',
            'ertek' => 'Ertek',
            'sorrend' => 'Sorrend',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributeRecord()
    {
        return $this->hasOne(Tulajdonsag::className(), ['id' => 'tulajdonsag_id']);
    }
}
