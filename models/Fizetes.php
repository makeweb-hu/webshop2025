<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "fizetes".
 *
 * @property integer $id
 * @property string $nev
 * @property string $leiras
 * @property integer $ar
 * @property string $szolgaltato
 * @property string $fizetesi_instrukcio
 * @property string $megnevezes_szamlan
 *
 * @property SzallitasFizetes[] $szallitasFizetes
 * @property Szallitas[] $szallitas
 */
class Fizetes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fizetes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev'], 'required'],
            [['ar'], 'integer'],
            [['szolgaltato', 'fizetesi_instrukcio'], 'string'],
            [['nev', 'leiras', 'megnevezes_szamlan'], 'string', 'max' => 255],
            [['utanvet'], 'safe'],
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
            'leiras' => 'Leiras',
            'ar' => 'Ár',
            'szolgaltato' => 'Szolgaltato',
            'fizetesi_instrukcio' => 'Fizetesi Instrukcio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSzallitasFizetes()
    {
        return $this->hasMany(SzallitasFizetes::className(), ['fizetes_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSzallitas()
    {
        return $this->hasMany(Szallitas::className(), ['id' => 'szallitas_id'])->viaTable('szallitas_fizetes', ['fizetes_id' => 'id']);
    }

    public function columnViews() {
        return [
            'ar' => function () {
                if (!$this->ar) {
                    return 'Ingyenes';
                }
                return Helpers::formatMoney($this->ar);
            },
        ];
    }

    public static function allForSelect() {
        $all = [];
        foreach (Fizetes::find()->all() as $record) {
            $all[$record->id] = $record->nev;
        }
        return $all;
    }
}
