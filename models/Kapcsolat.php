<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kapcsolat".
 *
 * @property integer $id
 * @property string $nev
 * @property string $email
 * @property string $telefonszam
 * @property string $uzenet
 * @property string $idopont
 * @property integer $termek_id
 * @property integer $variacio_id
 */
class Kapcsolat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kapcsolat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uzenet'], 'string'],
            [['idopont'], 'safe'],
            [['termek_id', 'variacio_id'], 'integer'],
            [['nev', 'email', 'telefonszam'], 'string', 'max' => 255],
            [['megtekintve'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev' => 'Név',
            'email' => 'E-mail cím',
            'telefonszam' => 'Telefonszám',
            'uzenet' => 'Üzenet',
            'idopont' => 'Időpont',
            'termek_id' => 'Kapcsolódó termék',
            'variacio_id' => 'Variacio ID',
            'termek' => 'Kapcsolódó termék',
        ];
    }

    public function columnViews() {
        return [
            'nev' => function () {
                if ($this->megtekintve) {
                    return $this->nev;
                }
                return '<span class="font-bold">
                       <span style="background-color: #e84c4c; min-width: 19px; text-align: center;border-radius: 30px; padding: 0 3px; position: relative; top: -1px; margin-right: -5px; left:-3px; display: inline-block; font-size: 80%; color: #fff;transform:scale(0.4)">&nbsp;</span> '
                        . $this->nev .
                    '</span>';
            },
            'termek' => function () {
                if (!$this->product) {
                    return '';
                }
                return '<a href="/admin/edit-product?id='.$this->product->id.'">' . $this->product->columnViews()['fancy_name']() . '</a>';
            },
        ];
    }

    public function getProduct() {
        return Termek::findOne($this->termek_id);
    }

    public static function nrOfUnseen() {
        return Kapcsolat::find()->where(['megtekintve' => 0])->count();
    }
}
