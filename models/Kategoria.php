<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "kategoria".
 *
 * @property integer $id
 * @property integer $szulo_id
 * @property string $nev
 * @property integer $foto_id
 * @property integer $oldal_id
 *
 * @property Kategoria $szulo
 * @property Kategoria[] $kategorias
 * @property Fajl $foto
 * @property Oldal $oldal
 */
class Kategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kategoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['szulo_id', 'foto_id', 'oldal_id', 'sorrend'], 'integer'],
            [['nev'], 'string', 'max' => 255],
            [['nev'], 'required'],
            [['szulo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kategoria::className(), 'targetAttribute' => ['szulo_id' => 'id']],
            [['foto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fajl::className(), 'targetAttribute' => ['foto_id' => 'id']],
            [['oldal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oldal::className(), 'targetAttribute' => ['oldal_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'szulo_id' => 'Szulo ID',
            'nev' => 'Nev',
            'foto_id' => 'Foto ID',
            'oldal_id' => 'Oldal ID',
            'sorrend' => 'Sorrend',
            'fancy_name' => 'Kategória neve',
            'products' => 'Termékek',
        ];
    }

    public static function enumerateAll($parentId = null) {
        if ($parentId) {
            $all = Kategoria::find()->where(['szulo_id' => $parentId])->orderBy('lokalis_sorrend ASC, id ASC')->all();
        } else {
            $all = Kategoria::find()->where('szulo_id is null')->orderBy('lokalis_sorrend ASC, id ASC')->all();
        }
        $superAll = [];
        foreach ($all as $item) {
            $superAll[] = $item;
            foreach (self::enumerateAll($item->getPrimaryKey()) as $subItem) {
                $superAll[] = $subItem;
            }
        }
        return $superAll;
    }

    public static function recalculateCategoriesOrder() {
        $i = 0;
        foreach (self::enumerateAll() as $item) {
            $item->sorrend = $i;
            $item->save(false);
            $i += 1;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentCategory()
    {
        return $this->hasOne(Kategoria::className(), ['id' => 'szulo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(Kategoria::className(), ['szulo_id' => 'id']);
    }

    public function getThumbnail() {
        $f = $this->photo;
        if ($f) {
            return $f->resizePhotoCover(360, 360);
        }
        return '/img/no-photo.jpg';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Fajl::className(), ['id' => 'foto_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Oldal::className(), ['id' => 'oldal_id']);
    }

    public static function mainCats() {
        return Kategoria::find()->where('szulo_id is null')->all();
    }

    public function childrenExceptIds() {
        $ids = [ $this->getPrimaryKey() ];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->childrenExceptIds());
        }
        return $ids;
    }

    public function getAllChildrenIds() {
        $ids = [ $this->getPrimaryKey() ];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->childrenExceptIds());
        }
        return $ids;
    }

    public function allParents() {
        if ($this->parentCategory) {
            return array_merge($this->parentCategory->allParents(), [ $this->parentCategory ]);
        }
        return [];
    }

    public function getBreadcrumbs() {
        $parents = $this->allParents();
        return $parents;
    }

    public function getBreadcrumbsWithItself() {
        $parents = $this->allParents();
        $parents[] = $this;
        return $parents;
    }

    public function postProcess() {
        self::recalculateCategoriesOrder();

        if (!$this->page) {
            $record = new Oldal;
            $record->tipus = 'kategoria';
            $record->url = Helpers::createUrl($this->nev);
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

    public function getUrl() {
        return '/' . $this->page->url;
    }

    public function getFullName() {
        $parentHtml = '';
        $parents = $this->allParents();
        foreach ($parents as $p) {
            $parentHtml .= $p->nev . ' » ';
        }
        return ($parentHtml ? '<span style="opacity:0.6">'.$parentHtml.'</span>' : '') . $this->nev;
    }

    public function columnViews() {
        return [
            'fancy_name' => function () {
                $spaces = '';
                foreach ($this->allParents() as $_) {
                    $spaces .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                return $spaces . $this->nev;
            },
            'products' => function () {
                $nr = Termek::find()->where(['kategoria_id' => $this->getPrimaryKey()])->count();
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    '.$nr.' termék
                </span>';
            },
            'full_name' => function () {
                return $this->fullName;
            },
        ];
    }
}
