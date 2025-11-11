<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "szamla".
 *
 * @property integer $id
 * @property string $bizonylatszam
 * @property string $idopont
 * @property string $szamlazo
 * @property integer $sztorno
 * @property string $sztornozott_bizonylat
 * @property integer $kosar_id
 */
class Szamla extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'szamla';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bizonylatszam', 'szamlazo'], 'required'],
            [['idopont'], 'safe'],
            [['szamlazo'], 'string'],
            [['sztorno', 'kosar_id'], 'integer'],
            [['bizonylatszam', 'sztornozott_bizonylat'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bizonylatszam' => 'Bizonylatszám',
            'idopont' => 'Kiállítás időpontja',
            'szamlazo' => 'Számlázó',
            'sztorno' => 'Sztornó?',
            'sztornozott_bizonylat' => 'Sztornózott bizonylat',
            'kosar_id' => 'Kosar ID',
            'tipus' => 'Típus',
        ];
    }

    public function isCancelled() {
        return !!Szamla::findOne(['sztornozott_bizonylat' => $this->bizonylatszam]);
    }

    public function getPdfUrl() {
        return '/storage/szamlazzhu/pdf/' . $this->bizonylatszam . '.pdf';
    }

    public function columnViews() {
        return [
            'bizonylatszam' => function () {
                if ($this->isCancelled()) {
                    return '<span style="text-decoration: line-through" data-tooltip="'.$this->bizonylatszam.'">' . $this->bizonylatszam . '</span>';
                }
                return $this->bizonylatszam;
            },
            'tipus' => function () {
                if (!$this->sztorno) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        Számla
                    </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        Sztornó számla
                    </span>';
            },
        ];
    }
}
