<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "munkamenet".
 *
 * @property integer $id
 * @property integer $felhasznalo_id
 * @property string $token
 * @property string $letrehozva
 *
 * @property Felhasznalo $felhasznalo
 */
class Munkamenet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'munkamenet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['felhasznalo_id', 'letrehozva'], 'required'],
            [['felhasznalo_id'], 'integer'],
            [['letrehozva'], 'safe'],
            [['token', 'push_token'], 'string', 'max' => 255],
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
            'felhasznalo_id' => 'Felhasznalo ID',
            'token' => 'Token',
            'letrehozva' => 'Letrehozva',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Felhasznalo::className(), ['id' => 'felhasznalo_id']);
    }

    public static function current() {
        $sessionToken = Yii::$app->request->cookies->getValue('session', '');
        $session = Munkamenet::findOne(['token' => $sessionToken]);
        if ($session) {
            return $session;
        }
        return null;
    }
}
