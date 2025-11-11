<?php

namespace app\models;

use app\components\Helpers;
use app\components\Lang;
use Yii;

/**
 * This is the model class for table "hir".
 *
 * @property integer $id
 * @property string $cim
 * @property integer $kategoria_id
 * @property string $bevezeto
 * @property integer $tartalom
 * @property string $publikalas_datuma
 * @property integer $kep_id
 * @property string $nyelv
 * @property string $meta_cim
 * @property string $meta_leiras
 * @property integer $meta_kep_id
 * @property string $slug
 * @property string $statusz
 * @property string $letrehozva
 * @property string $modositva
 */
class Hir extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hir';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cim', 'nyelv', 'bevezeto', 'kep_id'], 'required'],
            [['kategoria_id', 'kep_id', 'meta_kep_id'], 'integer'],
            [['bevezeto', 'nyelv', 'statusz', 'tartalom'], 'string'],
            [['publikalas_datuma', 'letrehozva', 'modositva'], 'safe'],
            [['cim', 'meta_cim', 'meta_leiras', 'slug'], 'string', 'max' => 255],
            [['slug'], 'unique'],
            [['kiemelt'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cim' => 'Cím',
            'kategoria_id' => 'Kategoria ID',
            'bevezeto' => 'Bevezeto',
            'tartalom' => 'Tartalom',
            'publikalas_datuma' => 'Publikalas Datuma',
            'kep_id' => 'Kep ID',
            'nyelv' => 'Nyelv',
            'meta_cim' => 'Meta Cim',
            'meta_leiras' => 'Meta Leiras',
            'meta_kep_id' => 'Meta Kep ID',
            'slug' => 'Slug',
            'statusz' => 'Státusz',
            'letrehozva' => 'Letrehozva',
            'modositva' => 'Modositva',
            'kategoria' => 'Kategória',
            'flag' => 'Nyelv',
            'fancy_name' => 'Cím',
        ];
    }

    public function getCategory() {
        return HirKategoria::findOne($this->kategoria_id);
    }

    public function columnViews() {
        return [
            'cim' => function () {
                return '<div style="white-space: normal;">' . $this->cim . '</div>';
            },
            'flag' => function () {
                return '<a href="/admin/news?tab='.$this->nyelv.'" class="flex"><span class="flex items-center mr-1">
                       <img src="/images/flags/'.$this->nyelv.'.svg" class="mr-1" style="width: 20px" /></span><span class="uppercase">' . $this->nyelv . '</span></a>';
            },
            'publikalas_datuma' => function () {
                if (!$this->publikalas_datuma) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        Nincs beállítva
                    </span>';
                }
                $isFuture = strtotime(date('Y-m-d')) < strtotime($this->publikalas_datuma);
                return $this->publikalas_datuma . (
                    $isFuture
                    ? '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 ml-2"><i class="fa-regular fa-clock mr-1"></i>Időzített</span>'
                    : ''
                );
            },
            'statusz' => function () {
                // TODO: időzítetten publikálva
                if ($this->statusz === 'piszkozat') {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                      <i class="fa-regular fa-pen-nib mr-1"></i>Piszkozat
                    </span>';
                } else if ($this->statusz == 'inaktiv') {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <i class="fa-regular fa-circle-xmark mr-1"></i>Inaktív
                    </span>';
                } else {
                    // Publikálva
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fa-regular fa-newspaper mr-1"></i>Publikálva
                    </span>';
                }
            },
            'kategoria' => function () {
                $cat = $this->getCategory();
                if (!$cat) {
                    return '-';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    '.$cat->nev_hu.'
                </span>';
            },
            'kiemelt' => function () {
                if ($this->kiemelt) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-600">
                      <i class="fa-regular fa-arrow-up-from-dotted-line mr-1"></i>Kiemelt
                    </span>';
                }
                return '&nbsp';
            },
            'fancy_name' => function () {
                return '<div class="flex items-center" style="white-space: normal;"><img src="'.$this->getImageUrl().'" class=" mr-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" /><div>' . $this->cim . '</div></div>';
            },
        ];
    }

    public function getUrl() {
        return '/' . $this->page->url;
    }

    public function beforeCreate() {
        $this->letrehozva = date('Y-m-d H:i:s');
    }

    public function postProcess() {
        $this->modositva = date('Y-m-d H:i:s');
        $this->save(false);

        if (!$this->page) {
            $record = new Oldal;
            $record->tipus = 'hir';
            $record->url = Helpers::createUrl($this->cim);
            $record->model_id = $this->getPrimaryKey();
            $record->save(false);

            $this->oldal_id = $record->getPrimaryKey();
            $this->save(false);
        }
    }

    public function getPage() {
        return Oldal::findOne($this->oldal_id);
    }

    public static function findNewsByPath($path) {
        $parts = explode('/', $path);
        if (count($parts) !== 2) {
            return null;
        }
        $lang = Lang::$current;
        $newsSlug = trim(Beallitasok::currentNewsSlug(), '/');
        if ($parts[0] !== $newsSlug) {
            return null;
        }
        return Hir::findOne([
            'slug' => $parts[1],
            'nyelv' => $lang,
        ]);
    }

    public static function filter($props = []) {
        $category = trim($props['category'] ?? '');
        $page = trim($props['page'] ?? '1');
        $limit = trim($props['limit'] ?? '15');

        if (!preg_match("@^[0-9]+$@", $category)) {
            $category = null;
        } else {
            $category = intval($category);
        }

        if (!preg_match("@^[0-9]+$@", $page)) {
            $page = 1;
        } else {
            $page = intval($page);
        }

        if (!preg_match("@^[0-9]+$@", $limit)) {
            $limit = 15;
        } else {
            $limit = intval($limit);
        }

        $query = Hir::find()
            ->where([
                'and',
                ['=', 'statusz', 'publikalva'],
                ['<=', 'publikalas_datuma', date('Y-m-d')]
            ])
            ->andWhere('publikalas_datuma is not null');

        if ($category) {
            $query = $query->andFilterWhere(['=', 'kategoria_id', $category]);
        }

        // Sort
        $query = $query->orderBy('publikalas_datuma DESC');

        $totalQuery = clone $query;
        $total = intval($totalQuery->count());
        $offset = ($page - 1) * $limit;

        $query = $query->offset($offset)->limit($limit);

        $resultItems = $query->all();

        return [
            'props' => $props,
            'items' => $resultItems,
            'page' => $page,
            'nr_of_pages' => ceil($total / $limit),
            'pages' => Helpers::createPages($total, $limit, $page),
            'total' => $total,
            'till' => $offset + count($resultItems),
            'rest' => $total - ($offset + count($resultItems)),
        ];
    }

    public function getImageUrl() {
        $file = Fajl::findOne($this->kep_id);
        if ($file) {
            return $file->resizePhotoContain(1280, 640);
        }
        return '';
    }

    public function getCoverPhoto() {
        $f = Fajl::findOne($this->kep_id);
        if ($f) {
            return $f->resizePhotoCover(340, 230);
        }
        return '/img/no-photo.svg';
    }

    public function getLargePhoto() {
        $f = Fajl::findOne($this->kep_id);
        if ($f) {
            return $f->resizePhotoCover(1320, 600);
        }
        return '/img/no-photo.svg';
    }

    public function getMetaImageUrl() {
        $file = Fajl::findOne($this->meta_kep_id);
        if ($file) {
            return $file->getUrl();
        }
        return '';
    }

    public function renderTitle() {
        return trim($this->cim);
    }

    public function renderLead() {
        return trim($this->bevezeto);
    }

    public function renderContent() {
        return trim($this->tartalom);
    }

    public function renderMetaTitle() {
        return trim($this->cim);
    }

    public function renderMetaDescription() {
        return trim($this->meta_leiras);
    }

    public static function nrOfHighlightedNews() {
        return Hir::find()->where(['kiemelt' => 1])->count();
    }

    public static function nrOfDraftNews() {
        return Hir::find()->where(['statusz' => 'piszkozat'])->count();
    }
}
