<?php

namespace app\models;

use app\components\Lang;
use Yii;

/**
 * This is the model class for table "hir_kategoria".
 *
 * @property integer $id
 * @property string $nev_hu
 * @property string $nev_en
 * @property string $nev_de
 * @property string $nev_sk
 * @property string $nev_cz
 * @property string $nev_pl
 * @property string $nev_ro
 * @property string $meta_cim_hu
 * @property string $meta_cim_en
 * @property string $meta_cim_de
 * @property string $meta_cim_sk
 * @property string $meta_cim_cz
 * @property string $meta_cim_pl
 * @property string $meta_cim_ro
 * @property string $meta_leiras_hu
 * @property string $meta_leiras_en
 * @property string $meta_leiras_de
 * @property string $meta_leiras_sk
 * @property string $meta_leiras_cz
 * @property string $meta_leiras_ro
 * @property string $meta_leiras_pl
 * @property integer $meta_kep_id
 * @property string $slug_hu
 * @property string $slug_en
 * @property string $slug_de
 * @property string $slug_cz
 * @property string $slug_sk
 * @property string $slug_pl
 * @property string $slug_ro
 */
class HirKategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hir_kategoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev_hu', 'slug_hu'], 'required'],
            [['meta_kep_id'], 'integer'],
            [['nev_hu', 'nev_en', 'nev_de', 'nev_sk', 'nev_cz', 'nev_pl', 'nev_ro', 'meta_cim_hu', 'meta_cim_en', 'meta_cim_de', 'meta_cim_sk', 'meta_cim_cz', 'meta_cim_pl', 'meta_cim_ro', 'meta_leiras_hu', 'meta_leiras_en', 'meta_leiras_de', 'meta_leiras_sk', 'meta_leiras_cz', 'meta_leiras_ro', 'meta_leiras_pl', 'slug_hu', 'slug_en', 'slug_de', 'slug_cz', 'slug_sk', 'slug_pl', 'slug_ro'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev_hu' => 'Név',
            'nev_en' => 'Nev En',
            'nev_de' => 'Nev De',
            'nev_sk' => 'Nev Sk',
            'nev_cz' => 'Nev Cz',
            'nev_pl' => 'Nev Pl',
            'nev_ro' => 'Nev Ro',
            'meta_cim_hu' => 'Meta Cim Hu',
            'meta_cim_en' => 'Meta Cim En',
            'meta_cim_de' => 'Meta Cim De',
            'meta_cim_sk' => 'Meta Cim Sk',
            'meta_cim_cz' => 'Meta Cim Cz',
            'meta_cim_pl' => 'Meta Cim Pl',
            'meta_cim_ro' => 'Meta Cim Ro',
            'meta_leiras_hu' => 'Meta Leiras Hu',
            'meta_leiras_en' => 'Meta Leiras En',
            'meta_leiras_de' => 'Meta Leiras De',
            'meta_leiras_sk' => 'Meta Leiras Sk',
            'meta_leiras_cz' => 'Meta Leiras Cz',
            'meta_leiras_ro' => 'Meta Leiras Ro',
            'meta_leiras_pl' => 'Meta Leiras Pl',
            'meta_kep_id' => 'Meta Kep ID',
            'slug_hu' => 'Slug Hu',
            'slug_en' => 'Slug En',
            'slug_de' => 'Slug De',
            'slug_cz' => 'Slug Cz',
            'slug_sk' => 'Slug Sk',
            'slug_pl' => 'Slug Pl',
            'slug_ro' => 'Slug Ro',
            'hirek' => 'Hírek',
        ];
    }

    public function getMetaImage() {
        return Fajl::findOne($this->meta_kep_id);
    }

    public function getUrl() {
        return '/blog/' . $this->slug_hu;
    }

    public static function allForSelect() {
        $all = [];
        foreach (HirKategoria::find()->orderBy('nev_hu ASC')->all() as $cat) {
            $all[$cat->getPrimaryKey()] = $cat->nev_hu;
        }
        return $all;
    }

    public function columnViews() {
        return [
            'hirek' => function () {
                $nr = Hir::find()->where(['kategoria_id' => $this->getPrimaryKey()])->count();
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    '.$nr.' hir
                </span>';
            }
        ];
    }

    public static function findNewsCategoryByPath($path) {
        $parts = explode('/', $path);
        if (count($parts) !== 2) {
            return null;
        }
        $lang = Lang::$current;
        $newsSlug = trim(Beallitasok::currentNewsSlug(), '/');
        if ($parts[0] !== $newsSlug) {
            return null;
        }
        $slug_prop = 'slug_' . $lang;
        return HirKategoria::findOne([
            $slug_prop => $parts[1],
        ]);
    }

    public function renderName() {
        $lang = Lang::$current;
        $prop = 'nev_' . $lang;
        return $this->$prop ?: $this->nev_en ?: $this->nev_hu;
    }

    public function getMetaImageUrl() {
        $file = Fajl::findOne($this->meta_kep_id);
        if ($file) {
            return $file->getUrl();
        }
        return '';
    }

    public function renderMetaTitle() {
        $lang = Lang::$current;
        $prop = 'meta_cim_' . $lang;
        $value = trim($this->$prop);
        if (!$value) {
            return $this->meta_cim_hu ?: $this->renderName();
        }
        return $value;
    }

    public function renderMetaDescription() {
        $lang = Lang::$current;
        $prop = 'meta_leiras_' . $lang;
        $value = trim($this->$prop);
        if (!$value) {
            return $this->meta_leiras_hu;
        }
        return $value;
    }

    public function nrOfNewsInCurrentLanguage() {
        return Hir::find()->where([
            'nyelv' => strtolower(Lang::$current),
            'kategoria_id' => $this->getPrimaryKey(),
        ])->count();
    }
}
