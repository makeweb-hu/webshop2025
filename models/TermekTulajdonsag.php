<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "termek_tulajdonsag".
 *
 * @property integer $id
 * @property integer $termek_id
 * @property integer $tulajdonsag_id
 * @property integer $ertek_id
 * @property string $ertek_str
 * @property double $ertek_num
 * @property integer $ertek_file
 *
 * @property Termek $termek
 * @property Tulajdonsag $tulajdonsag
 * @property TulajdonsagOpcio $ertek
 * @property Fajl $ertekFile
 */
class TermekTulajdonsag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek_tulajdonsag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['termek_id', 'tulajdonsag_id'], 'required'],
            [['termek_id', 'tulajdonsag_id', 'ertek_id', 'ertek_file'], 'integer'],
            [['ertek_num'], 'number'],
            [['ertek_str'], 'string', 'max' => 255],
            [['termek_id'], 'exist', 'skipOnError' => true, 'targetClass' => Termek::className(), 'targetAttribute' => ['termek_id' => 'id']],
            [['tulajdonsag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tulajdonsag::className(), 'targetAttribute' => ['tulajdonsag_id' => 'id']],
            [['ertek_id'], 'exist', 'skipOnError' => true, 'targetClass' => TulajdonsagOpcio::className(), 'targetAttribute' => ['ertek_id' => 'id']],
            [['ertek_file'], 'exist', 'skipOnError' => true, 'targetClass' => Fajl::className(), 'targetAttribute' => ['ertek_file' => 'id']],
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
            'tulajdonsag_id' => 'Tulajdonsag ID',
            'ertek_id' => 'Ertek ID',
            'ertek_str' => 'Ertek Str',
            'ertek_num' => 'Ertek Num',
            'ertek_file' => 'Ertek File',
            'attribute' => 'Tulajdonság',
            'value' => 'Érték',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTermek()
    {
        return $this->hasOne(Termek::className(), ['id' => 'termek_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(Tulajdonsag::className(), ['id' => 'tulajdonsag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getValue()
    {
        return $this->hasOne(TulajdonsagOpcio::className(), ['id' => 'ertek_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getErtekFile()
    {
        return $this->hasOne(Fajl::className(), ['id' => 'ertek_file']);
    }

    public function getOptionIds() {
        $ids = [];
        foreach (TermekTulajdonsagErtek::find()->where(['termek_tulajdonsag_id' => $this->getPrimaryKey()])->all() as $item) {
            $ids[] = $item->tulajdonsag_opcio_id;
        }
        return $ids;
    }

    public function getOptions() {
        $links = TermekTulajdonsagErtek::find()
            ->leftJoin('tulajdonsag_opcio', 'tulajdonsag_opcio.id = termek_tulajdonsag_ertek.tulajdonsag_opcio_id')
            ->where(['termek_tulajdonsag_id' => $this->getPrimaryKey()])->orderBy('tulajdonsag_opcio.ertek ASC')->orderBy('CAST(tulajdonsag_opcio.ertek as signed integer) ASC')->all();
        $all = [];
        foreach ($links as $link) {
            $all[] = $link->option;
        }
        return $all;
    }

    public function getOptionsWithNull() {
        $links = TermekTulajdonsagErtek::find()->where(['termek_tulajdonsag_id' => $this->getPrimaryKey()])->all();
        $all = [];
        foreach ($links as $link) {
            $all[] = $link->option;
        }
        if (count($all) === 0) {
            return [null];
        }
        return $all;
    }

    public function columnViews() {
        return [
            'attribute' => function () {
                if ($this->attr->variaciokepzo) {
                    return '<i class="fa-solid fa-bolt"></i> ' . $this->attr->nev;
                }
                return $this->attr->nev;
            },
            'value' => function () {
                if (!$this->attr->variaciokepzo) {
                    if ($this->attr->ertek_tipus === 'select') {
                        return \app\components\Helpers::render('ui/select', [
                            //'label' => 'Akció típusa',
                            'name' => 'attr' . $this->getPrimaryKey(),
                            'value' => $this->ertek_id,
                            'values' => $this->attr->allValues(),
                        ]);
                    } else if ($this->attr->ertek_tipus === 'bool') {
                        return \app\components\Helpers::render('ui/toggle', [
                            //'label' => 'Akció típusa',
                            'name' => 'attr' . $this->getPrimaryKey(),
                            'value' => boolval(intval($this->ertek_num)) ? 1 : 0,
                        ]);
                    } else if ($this->attr->ertek_tipus === 'string') {
                        return \app\components\Helpers::render('ui/input', [
                            //'label' => 'Akció típusa',
                            'name' => 'attr' . $this->getPrimaryKey(),
                            'value' => $this->ertek_str,
                        ]);
                    } else if ($this->attr->ertek_tipus === 'number') {
                        return \app\components\Helpers::render('ui/input', [
                            //'label' => 'Akció típusa',
                            'name' => 'attr' . $this->getPrimaryKey(),
                            'icon' => '<i class="fa-solid fa-input-numeric"></i>',
                            'value' => $this->ertek_num,
                        ]);
                    } else if ($this->attr->ertek_tipus === 'file') {
                        return \app\components\Helpers::render('ui/file', [
                            'name'  => 'attr' . $this->getPrimaryKey(),
                            'value' => $this->ertek_file ?? '',
                        ]);
                    } else if ($this->attr->ertek_tipus === 'multiselect') {
                        return \app\components\Helpers::render('ui/multiselect', [
                            //'label' => 'Akció típusa',
                            'name' => 'attr' . $this->getPrimaryKey(),
                            'value' => $this->getOptionIds(),
                            'values' => $this->attr->allValues(),
                        ]);
                    }
                } else {
                    return \app\components\Helpers::render('ui/multiselect', [
                        //'label' => 'Akció típusa',
                        'name' => 'attr' . $this->getPrimaryKey(),
                        'value' => $this->getOptionIds(),
                        'values' => $this->attr->allValues(),
                    ]);
                }
            },
        ];
    }
}
