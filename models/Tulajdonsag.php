<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tulajdonsag".
 *
 * @property integer $id
 * @property string $tipus
 * @property string $nev
 * @property string $ertek_tipus
 * @property integer $szurheto
 * @property integer $lathato
 * @property integer $kotelezo
 *
 * @property TulajdonsagOpcio[] $tulajdonsagOpcios
 */
class Tulajdonsag extends \yii\db\ActiveRecord
{
    public $options = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tulajdonsag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ertek_tipus'], 'string'],
            [['nev'], 'required'],
            [['szurheto', 'lathato', 'kotelezo', 'variaciokepzo'], 'integer'],
            [['nev'], 'string', 'max' => 255],
            [
                ['ertek_tipus'],
                'required',
                'when' => function($model) {
                    return $model->variaciokepzo == 0;
                },
            ],
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
            'ertek_tipus' => 'Ertek Tipus',
            'szurheto' => 'Szűrhető',
            'lathato' => 'Látható',
            'kotelezo' => 'Kötelező',
            'products' => 'Termékek',
            'type' => 'Típus',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptionValues()
    {
        return $this->hasMany(TulajdonsagOpcio::className(), ['tulajdonsag_id' => 'id']);
    }

    public static function dataTypesForSelect() {
       return [
           'bool' => 'Igen/nem',
           'string' => 'Szöveg',
           'number' => 'Szám',
           'select' => 'Választás',
           'multiselect' => 'Többszörös választás',
           'file' => 'Fájl',
       ];
    }

    public static function casts($data) {
        $data['variaciokepzo'] = boolval($data['variaciokepzo']) ? 1 : 0;
        $data['lathato'] = boolval($data['lathato']) ? 1 : 0;
        $data['kotelezo'] = boolval($data['kotelezo']) ? 1 : 0;
        $data['szurheto'] = boolval($data['szurheto']) ? 1 : 0;
        if ($data['options'] ?? null) {
           $data['options'] = json_decode($data['options'], true);
        }
        return $data;
    }

    public function columnViews() {
        return [
            'products' => function () {
                return '0 termék';
            },
            'nev' => function () {
                if ($this->variaciokepzo) {
                    return '<i class="fa-solid fa-bolt"></i> ' . $this->nev;
                }
                return $this->nev;
            },
            'type' => function () {
                if ($this->variaciokepzo) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        <i class="fa-solid fa-bolt mr-1"></i> Variációképző
                    </span>';
                } else {
                    $typeStr = self::dataTypesForSelect()[$this->ertek_tipus ?: 'string'];
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    '.$typeStr.'
                </span>';
            },
        ];
    }

    public function allValues() {
        $all = [];
        foreach ($this->optionValues as $item) {
            $all[$item->getPrimaryKey()] = $item->ertek;
        }
        return $all;
    }

    public function optionIds() {
        $ids = [];
        foreach ($this->optionValues as $option) {
            $ids[] = $option->getPrimaryKey();
        }
        return $ids;
    }

    public function postProcess() {
        if ($this->variaciokepzo) {
            $this->ertek_tipus = 'select';
            $this->save(false);
        }

        if ($this->ertek_tipus !== 'select' && $this->ertek_tipus !== 'multiselect') {
            foreach ($this->optionValues as $option) {
                $option->delete();
            }
        } else {
            foreach ($this->options as $optionId) {
                $record = TulajdonsagOpcio::findOne($optionId);
                $record->tulajdonsag_id = $this->getPrimaryKey();
                $record->save(false);
            }
        }
    }
}
