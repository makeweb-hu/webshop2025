<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "statikus_oldal".
 *
 * @property integer $id
 * @property integer $oldal_id
 * @property string $cim
 * @property string $tartalom
 * @property integer $statusz
 */
class StatikusOldal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'statikus_oldal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['oldal_id', 'statusz'], 'integer'],
            [['cim'], 'required'],
            [['tartalom'], 'string'],
            [['cim'], 'string', 'max' => 255],
            [['megjelenes'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oldal_id' => 'Oldal ID',
            'cim' => 'Cim',
            'tartalom' => 'Tartalom',
            'statusz' => 'Statusz',
        ];
    }

    public function getPage() {
        return Oldal::findOne($this->oldal_id);
    }

    public static function get($id) {
        return StatikusOldal::findOne($id);
    }

    public function postProcess()
    {
        if (!$this->page) {
            $record = new Oldal;
            $record->tipus = 'statikus_oldal';
            $record->url = Helpers::createUrl($this->cim);
            $record->model_id = $this->getPrimaryKey();
            $record->save(false);

            $this->oldal_id = $record->getPrimaryKey();
            $this->save(false);
        }
    }

    public function afterDelete()
    {
        $page = Oldal::findOne($this->oldal_id);
        if ($page) {
            $page->delete();
        }
    }

    public function columnViews() {
        return [
            'link' => function () {
                return  '<small><span class="text-gray-400">' . Beallitasok::get('domain') . '</span>/<span class="font-medium">' . $this->page->url . '</span></small>';
            },
            'statusz' => function () {
                if (!$this->statusz) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fa-regular fa-circle-xmark mr-1"></i> Inaktív
                            </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Aktív
                            </span>';
            }
        ];
    }
}
