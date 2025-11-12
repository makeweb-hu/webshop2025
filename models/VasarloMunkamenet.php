<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "vasarlo_munkamenet".
 *
 * @property integer $id
 * @property integer $vasarlo_id
 * @property string $letrehozva
 * @property string $token
 */
class VasarloMunkamenet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vasarlo_munkamenet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vasarlo_id', 'token'], 'required'],
            [['vasarlo_id'], 'integer'],
            [['letrehozva'], 'safe'],
            [['token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vasarlo_id' => 'Vasarlo ID',
            'letrehozva' => 'Letrehozva',
            'token' => 'Token',
        ];
    }

    public function getCustomer() {
        return Vasarlo::findOne($this->vasarlo_id);
    }

    public static function current() {
        $sessionToken = Yii::$app->request->cookies->getValue('customer', '');
        $session = VasarloMunkamenet::findOne(['token' => $sessionToken]);
        if ($session) {
            return $session;
        }
        return null;
    }
}
