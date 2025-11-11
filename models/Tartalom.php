<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tartalom".
 *
 * @property integer $id
 * @property string $tipus
 * @property integer $sorrend
 * @property string $adatok
 */
class Tartalom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tartalom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipus'], 'required'],
            [['sorrend'], 'integer'],
            [['adatok'], 'string'],
            [['tipus'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipus' => 'Tipus',
            'sorrend' => 'Sorrend',
            'adatok' => 'Adatok',
        ];
    }

    public static function getContentSchemas() {
        return [
            'Ajánló' => [
                'Cím' => 'input',
                'Leírás' => 'lookup:Ajánló',
                'Kép' => 'file',
                'Gyermek' => 'entity:Ajánló',
                'Gyermekek' => 'entities:Ajánló',
            ],
        ];
    }

    public function getChildren($name) {
        $schema = self::getContentSchemaByType($name);
        if (substr($schema[$name], 0, 8) === 'entities') {
            $ids = json_decode($this->adatok ?: '{}', true)[$name] ?? [];
            return Tartalom::find()->where(['in', 'id', $ids])->orderBy('sorrend ASC, id ASC')->all();
        }
        return [];
    }

    public function getChild($name) {
        $schema = self::getContentSchemaByType($name);
        if (substr($schema[$name], 0, 6) === 'entity') {
            $ids = json_decode($this->adatok ?: '{}', true)[$name] ?? [];
            return Tartalom::find()->where(['in', 'id', $ids])->orderBy('sorrend ASC, id ASC')->one();
        }
        return [];
    }

    public static function getContentSchemaByType($type) {
        return self::getContentSchemas()[$type];
    }

    public function postProcess($data, $isNewRecord) {
        $str = '';
        foreach ($data as $k => $v) {
            $str .= $v . ' ';
        }
        $this->kereses = trim($str);
        $this->save(false);
    }

    public function columnViews() {
        $schema = self::getContentSchemaByType($this->tipus);
        if (!$schema) {
            return [];
        }
        $columns = [
            'kereses' => function () {
                return $this->kereses;
            },
        ];
        $data = json_decode($this->adatok ?: '{}', true);
        foreach ($schema as $key => $type) {
            $columns[$key] = function () use ($data, $key, $type) {
                return $data[$key] ?? '-';
            };
        }
        return $columns;
    }
}
