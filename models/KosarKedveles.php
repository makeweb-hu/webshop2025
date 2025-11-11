<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kosar_kedveles".
 *
 * @property integer $id
 * @property integer $termek_id
 * @property integer $variacio_id
 * @property string $idopont
 */
class KosarKedveles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kosar_kedveles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termek_id', 'kosar_id'], 'required'],
            [['termek_id', 'variacio_id'], 'integer'],
            [['idopont'], 'safe'],
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
            'variacio_id' => 'Variacio ID',
            'idopont' => 'Idopont',
        ];
    }

    public function getProduct() {
        return Termek::findOne($this->termek_id);
    }

    public function getVariation()
    {
        return $this->hasOne(Variacio::className(), ['id' => 'variacio_id']);
    }

    public function getPrice() {
        // Még csak kosár
        if ($this->variation) {
            return $this->variation->currentPrice();
        } else {
            return $this->product->currentPrice();
        }
    }
}
