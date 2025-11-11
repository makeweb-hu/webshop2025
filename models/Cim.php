<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cim".
 *
 * @property integer $id
 * @property string $nev
 * @property string $cegnev
 * @property string $iranyitoszam
 * @property integer $orszag_id
 * @property string $telepules
 * @property string $utca
 * @property string $adoszam
 * @property string $megjegyzes
 *
 * @property Orszag $orszag
 * @property Kosar[] $kosars
 * @property Kosar[] $kosars0
 * @property Vasarlo[] $vasarlos
 * @property Vasarlo[] $vasarlos0
 */
class Cim extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cim';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev', 'iranyitoszam', 'orszag_id', 'telepules', 'utca'], 'required'],
            [['orszag_id', 'ceges'], 'integer'],
            [['nev', 'iranyitoszam', 'telepules', 'utca', 'adoszam'], 'string', 'max' => 255],
            [['megjegyzes'], 'string', 'max' => 512],
            [['orszag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orszag::className(), 'targetAttribute' => ['orszag_id' => 'id']],
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
            'iranyitoszam' => 'Iranyitoszam',
            'orszag_id' => 'Orszag ID',
            'telepules' => 'Telepules',
            'utca' => 'Utca',
            'adoszam' => 'Adoszam',
            'megjegyzes' => 'Megjegyzes',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Orszag::className(), ['id' => 'orszag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKosars()
    {
        return $this->hasMany(Kosar::className(), ['szallitasi_cim_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKosars0()
    {
        return $this->hasMany(Kosar::className(), ['szamlazasi_cim_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVasarlos()
    {
        return $this->hasMany(Vasarlo::className(), ['szallitasi_cim_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVasarlos0()
    {
        return $this->hasMany(Vasarlo::className(), ['szamlazasi_cim_id' => 'id']);
    }

    public function columnViews() {
        return [
            'full_address_with_name' => function () {
                return '<b class="font-bold">'.$this->nev.'</b><br>' .
                    $this->iranyitoszam . ' ' . $this->telepules . ', ' . $this->utca .
                    ($this->adoszam ? '<br>Adószám: ' . $this->adoszam : '');
            },
        ];
    }

    public function toString() {
        return $this->iranyitoszam . ' ' . $this->telepules . ', ' . $this->utca;
    }

    public function toMultilineHtml() {
        $html = $this->nev . '<br>';
        $html .= $this->country->nev . '<br>';
        $html .= $this->iranyitoszam . ' ' . $this->telepules . '<br>';
        $html .= $this->utca;

        if ($this->adoszam) {
            $html .= '<br>Adószám: ' . $this->adoszam;
        }

        return $html;
    }
}
