<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bejelentkezes_2fa".
 *
 * @property integer $id
 * @property string $token
 * @property string $letrehozva
 * @property integer $felhasznalo_id
 *
 * @property Felhasznalo $felhasznalo
 */
class Bejelentkezes2fa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bejelentkezes_2fa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'letrehozva', 'felhasznalo_id'], 'required'],
            [['letrehozva'], 'safe'],
            [['felhasznalo_id'], 'integer'],
            [['token'], 'string', 'max' => 255],
            [['felhasznalo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Felhasznalo::className(), 'targetAttribute' => ['felhasznalo_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'letrehozva' => 'Letrehozva',
            'felhasznalo_id' => 'Felhasznalo ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Felhasznalo::className(), ['id' => 'felhasznalo_id']);
    }
}
