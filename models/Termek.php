<?php

namespace app\models;

use app\components\Helpers;
use Yii;
use yii\base\BaseObject;

/**
 * This is the model class for table "termek".
 *
 * @property integer $id
 * @property string $nev
 * @property string $cikkszam
 * @property integer $oldal_id
 * @property integer $foto_id
 * @property integer $ar
 * @property integer $akcios
 * @property string $akcio_tipusa
 * @property integer $akcios_ar
 * @property integer $akcio_szazalek
 * @property string $rovid_leiras
 * @property string $leiras
 * @property integer $afa
 * @property integer $statusz
 * @property integer $kategoria_id
 *
 * @property Oldal $oldal
 * @property Kategoria $kategoria
 * @property Fajl $foto
 * @property integer $ujdonsag
 */
class Termek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'termek';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nev', 'egyseg_id'], 'required'],
            [['cikkszam'], 'unique'],
            [['oldal_id', 'foto_id', 'ar', 'akcios', 'akcios_ar', 'akcio_szazalek', 'afa', 'statusz', 'kategoria_id', 'keszlet'], 'integer'],
            [['akcio_tipusa', 'rovid_leiras', 'leiras'], 'string'],
            [['nev','keszlet_info'], 'string', 'max' => 255],
            [['cikkszam'], 'string', 'max' => 20],
            [['oldal_id'], 'exist', 'skipOnError' => true, 'targetClass' => Oldal::className(), 'targetAttribute' => ['oldal_id' => 'id']],
            [['kategoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kategoria::className(), 'targetAttribute' => ['kategoria_id' => 'id']],
            [['foto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fajl::className(), 'targetAttribute' => ['foto_id' => 'id']],
            [['egyseg_id', 'ujdonsag'], 'safe'],
            [['foto_1','foto_2','foto_3','foto_4','foto_5','foto_6','foto_7','foto_8','foto_9','foto_10'], 'safe'],
            [['letrehozva'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev' => 'Terméknév',
            'cikkszam' => 'Cikkszam',
            'oldal_id' => 'Oldal ID',
            'foto_id' => 'Foto ID',
            'ar' => 'Ár',
            'akcios' => 'Akciós',
            'akcio_tipusa' => 'Akcio Tipusa',
            'akcios_ar' => 'Akcios Ar',
            'akcio_szazalek' => 'Akcio Szazalek',
            'rovid_leiras' => 'Rovid Leiras',
            'leiras' => 'Leiras',
            'afa' => 'ÁFA',
            'statusz' => 'Státusz',
            'kategoria_id' => 'Kategoria ID',
            'fancy_name' => 'Terméknév',
            'kategoria' => 'Kategória',
            'keszlet' => 'Készlet',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Oldal::className(), ['id' => 'oldal_id']);
    }

    public function getRecommendedProductIds() {
        $all = [];
        foreach (TermekAjanlo::find()->where(['termek_id' => $this->getPrimaryKey()])->all() as $m) {
            $all[] = $m->getPrimaryKey();
        }
        return $all;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Kategoria::className(), ['id' => 'kategoria_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhoto()
    {
        return $this->hasOne(Fajl::className(), ['id' => 'foto_id']);
    }

    public function getMorePhotos() {
        $all = [];
        if ($this->foto_1) {
            $all[] = Fajl::findOne($this->foto_1);
        }
        if ($this->foto_2) {
            $all[] = Fajl::findOne($this->foto_2);
        }
        if ($this->foto_3) {
            $all[] = Fajl::findOne($this->foto_3);
        }
        if ($this->foto_4) {
            $all[] = Fajl::findOne($this->foto_4);
        }
        if ($this->foto_5) {
            $all[] = Fajl::findOne($this->foto_5);
        }
        if ($this->foto_6) {
            $all[] = Fajl::findOne($this->foto_6);
        }
        return $all;
    }

    public function getUrl() {
        return '/' . $this->page->url;
    }

    public function getUnit() {
        return Egyseg::findOne($this->egyseg_id);
    }

    public function getThumbnail() {
        $f = $this->photo;
        if ($f) {
            return $f->resizePhotoCover(320, 320);
        }
        return '/img/no-photo.jpg';
    }

    public static function casts($data) {
        $data['statusz'] = intval($data['statusz']);
        $data['akcios'] = intval($data['akcios']);
        return $data;
    }

    public function getVatRate() {
        if (is_null($this->afa)) {
            return intval(Beallitasok::get('afa')) / 100;
        }
        return $this->afa / 100;
    }

    public function postProcess() {
        if (!$this->page) {
            $record = new Oldal;
            $record->tipus = 'termek';
            $record->url = Helpers::createUrl($this->nev);
            $record->model_id = $this->getPrimaryKey();
            $record->save(false);

            $this->oldal_id = $record->getPrimaryKey();
            $this->save(false);
        }

        if (!$this->cikkszam) {
            $this->cikkszam = 'PRD' . str_pad($this->getPrimaryKey(), 5, '0', STR_PAD_LEFT);
            $this->save(false);
        }

        if (!$this->akcios) {
            $this->akcio_szazalek = null;
            $this->akcio_tipusa = 'szazalek';
            $this->akcios_ar = null;
            $this->save(false);
        } else if ($this->akcio_tipusa === "szazalek") {
            $this->akcios_ar = intval($this->ar * (1 - ($this->akcio_szazalek / 100)));
            $this->save(false);
        } else if ($this->akcio_tipusa === "fix_ar") {
            $this->akcio_szazalek = intval(100 - ($this->akcios_ar / $this->ar) * 100);
            $this->save(false);
        }
    }

    public function getAllPricesByOptions() {
        $all = [];

        foreach ($this->variations as $variation) {
            $options = $variation->optionsArray();
            $ids = [];
            foreach ($options as $option) {
                $ids[] = $option->getPrimaryKey();
            }
            sort($ids);
            $all[implode('-', $ids)] = $variation->currentPrice();
        }
        // Csak egy variáció van
        if (count($all) === 1) {
            $all[ array_keys($all)[0] ] = $this->currentPrice();
        }
        return $all;
    }

    public function getAllStocksByOptions() {
        $all = [];

        foreach ($this->variations as $variation) {
            $options = $variation->optionsArray();
            $ids = [];
            foreach ($options as $option) {
                $ids[] = $option->getPrimaryKey();
            }
            sort($ids);
            $all[implode('-', $ids)] = (!is_null($variation->keszlet) ? $variation->keszlet : $this->keszlet) ?: 0;
        }
        // Csak egy variáció van
        if (count($all) === 1) {
            $all[ array_keys($all)[0] ] = $this->keszlet ?: 0;
        }
        return $all;
    }

    public function getAllVariationIdsByOptions() {
        $all = [];

        foreach ($this->variations as $variation) {
            $options = $variation->optionsArray();
            $ids = [];
            foreach ($options as $option) {
                $ids[] = $option->getPrimaryKey();
            }
            sort($ids);
            $all[implode('-', $ids)] = $variation->getPrimaryKey();
        }
        return $all;
    }

    public function afterDelete()
    {
        $page = Oldal::findOne($this->oldal_id);
        if ($page) {
            $page->delete();
        }
    }

    public function getProductAttributeIds() {
        $ids = [];
        foreach (TermekTulajdonsag::find()->where(['termek_id' => $this->getPrimaryKey()])->all() as $item) {
            $ids[] = $item->getPrimaryKey();
        }
        return $ids;
    }

    public function renderMainProductPriceForAdmin() {
        $variations = $this->variations;
        if (count($variations) <= 1) {
            if (!$this->ar) {
                return '(nincs ar)';
            }
            $price = Helpers::formatMoney($this->ar);
            if ($this->akcios_ar) {
                $price = '<span style="text-decoration:line-through;opacity:0.5">'.$price.'</span> ' . Helpers::formatMoney($this->akcios_ar);
            }
            return $price;
        }
        $smallest = 500000000000;
        $smallestVariation = null;
        foreach ($variations as $variation) {
            if (!$variation->currentPrice()) {
                continue;
            }
            if ($variation->currentPrice() < $smallest) {
                $smallest = $variation->currentPrice();
                $smallestVariation = $variation;
            }
        }
        if (!$smallestVariation) {
            return '(nincs ár)';
        }
        $price = Helpers::formatMoney($smallestVariation->currentPrice());
        if ($smallestVariation->akcios_ar) {
            $price = '<span style="text-decoration:line-through;opacity:0.5">'.$price.'</span> ' . Helpers::formatMoney($smallestVariation->akcios_ar);
        }
        return $price . '-tól';
    }

    public function columnViews() {
        return [
            'ar' => function () {
               return $this->renderMainProductPriceForAdmin();
            },
            'kategoria' => function () {
                $cat = $this->category;
                if (!$cat) {
                    return '-';
                }
                // return $cat->columnViews()['full_name']();
                return '<div style="white-space: normal;">' . $this->category->nev . '</div>';
            },
            'fancy_name' => function ($name = '', $subname = '') {
                return '<div class="flex items-center" style="white-space: normal;"><img src="'.$this->thumbnail.'" class=" mr-2" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;" /><div>' . ($name ?: $this->nev) . ($subname ? '<br/><span style="font-size: 88%;">' . $subname . '</span>' : '') . '</div></div>';
            },
            'keszlet' => function () {
                return intval($this->keszlet) . ' db';
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

    public function getVariationAttributes() {
        $all = [];
        foreach (TermekTulajdonsag::find()->where(['termek_id' => $this->getPrimaryKey()])->all() as $attrLink) {
            if ($attrLink->attr->variaciokepzo) {
                $all[] = $attrLink;
            }
        }
        return $all;
    }

    public function findVariationByOptions($options) {
        $allVariations = Variacio::find()->where(['termek_id' => $this->getPrimaryKey(), 'statusz' => 1])->all();
        foreach ($allVariations as $variation) {
            $foundAll = true;
            foreach ($options as $option) {
                if (!$variation->hasOptionById($option->getPrimaryKey())) {
                    $foundAll = false;
                    break;
                }
            }
            if ($foundAll) {
                return $variation;
            }
        }
        return null;
    }

    public function getProductAttributes() {
        return TermekTulajdonsag::find()->where(['termek_id' => $this->getPrimaryKey()])->all();
    }

    public function getVariations() {
        return Variacio::find()->where(['termek_id' => $this->getPrimaryKey()])->all();
    }

    public function hasRealVariations() {
        $variations = $this->variations;
        if (count($variations) === 0) {
            return false;
        }
        if (count($variations) === 1) {
            return boolval($variations[0]->opcio_1 || $variations[0]->opcio_2 || $variations[0]->opcio_3 || $variations[0]->opcio_4 || $variations[0]->opcio_5);
        }
        return true;
    }

    public function createOrUpdateVariationsFromAttributes() {
        $attrs = $this->getVariationAttributes();
        $allVariations = $this->variations;
        $allVariationIds = [];
        foreach ($allVariations as $v) {
            $allVariationIds[$v->getPrimaryKey()] = true;
        }
        foreach (($attrs[0] ? $attrs[0]->optionsWithNull : [null]) as $options0) {
            foreach (($attrs[1] ? $attrs[1]->optionsWithNull : [null]) as $options1) {
                foreach (($attrs[2] ? $attrs[2]->optionsWithNull : [null]) as $options2) {
                    foreach (($attrs[3] ? $attrs[3]->optionsWithNull : [null]) as $options3) {
                        foreach (($attrs[4] ? $attrs[4]->optionsWithNull : [null]) as $options4) {

                            $options = [];
                            foreach ([$options0, $options1, $options2, $options3, $options4] as $o) {
                                if ($o) {
                                    $options[] = $o;
                                }
                            }

                            $variation = $this->findVariationByOptions($options);
                            if (!$variation) {
                                $variation = new Variacio;
                                $variation->termek_id = $this->getPrimaryKey();
                            } else {
                                unset($allVariationIds[$variation->getPrimaryKey()]);
                            }

                            $variation->opcio_1 = $options0 ? $options0->getPrimaryKey() : null;
                            $variation->opcio_2 = $options1 ? $options1->getPrimaryKey() : null;
                            $variation->opcio_3 = $options2 ? $options2->getPrimaryKey() : null;
                            $variation->opcio_4 = $options3 ? $options3->getPrimaryKey() : null;
                            $variation->opcio_5 = $options4 ? $options4->getPrimaryKey() : null;

                            $variation->save(false);
                        }
                    }
                }
            }
        }
        foreach (array_keys($allVariationIds) as $varId) {
            $variation = Variacio::findOne($varId);
            if ($variation) {
                try {
                    $variation->delete();
                } catch (\Throwable $e) {
                    // MySQL constraint error
                    $variation->statusz = 0;
                    $variation->save(false);
                }
            }
        }
    }

    public function getPromotionPrice() {
        $promotions = Promocio::find()->where([ 'statusz' => 1 ])->all();
        $filteredPromotions = [];
        foreach ($promotions as $promotion) {
            if ($promotion->tipus !== 'termek') {
                continue;
            }
            if ($promotion->ervenyesseg_kezdete) {
                if (strtotime($promotion->ervenyesseg_kezdete) > time()) {
                    continue;
                }
            }
            if ($promotion->ervenyesseg_vege) {
                if (strtotime($promotion->ervenyesseg_vege) < time()) {
                    continue;
                }
            }
            if ($promotion->category) {
                if (!$this->isInsideCategory($promotion->category->getPrimaryKey())) {
                    continue;
                }
            }
            $filteredPromotions[] = $promotion;
        }


        // Ezen a ponton a `$filteredPromotions` tömbben az erre a termékre érvényes promóciók vannak
        if (count($filteredPromotions) > 0) {
            $promotion = $filteredPromotions[0];

            $newPrice = $this->ar;

            if ($promotion->kedvezmeny_tipusa === 'szazalek') {
                $newPrice = $newPrice * ((100 - $promotion->kedvezmeny_merteke) / 100);
            } else {
                $newPrice -= intval($promotion->kedvezmeny_merteke);
                if ($newPrice < 0) {
                    $newPrice = 1;
                }
            }

            if ($newPrice < $this->ar) {
                // Promóció által akciózott termék
                return $newPrice;
            }

            return $this->ar;
        }

        return $this->ar;
    }

    // Promóciókat is figyelembe vevő ár
    public function currentPrice() {
        $promotionPrice = $this->getPromotionPrice();

        if ($promotionPrice !== $this->ar) {
            return $promotionPrice;
        }

        if ($this->akcios_ar) {
            $price = $this->akcios_ar;
        } else {
            $price = $this->ar;
        }
        return $price;
    }

    public function originalPrice() {
        return $this->ar;
    }

    public function hasDiscount() {
        $promotionPrice = $this->getPromotionPrice();
        if ($promotionPrice < $this->ar) {
            return true;
        }
        return !!$this->akcios_ar;
    }

    public function getDiscountRate() {
        if (!$this->hasDiscount()) {
            return 0;
        }

        return round(100 - ($this->currentPrice() / $this->originalPrice()) * 100);
    }

    public function isInsideCategory($categoryId) {
        if (!$this->category) {
            // Kategorizálatlan termék, így nincs benne semmilyen kategóriában
            return false;
        }
        $cats = $this->category->getBreadcrumbsWithItself();
        foreach ($cats as $cat) {
            if ($cat->getPrimaryKey() == $categoryId) {
                return true;
            }
        }
        return false;
    }

    public function renderPrice() {
        $price = $this->currentPrice();
        return Helpers::formatMoney($price);
    }

    public function renderOriginalPrice() {
        $price = $this->originalPrice();
        return Helpers::formatMoney($price);
    }

    public static function filterProducts($categoryId = null, $page = 0, $minPrice = '', $maxPrice = '', $discounted = '', $isNew = '', $cat = [], $sort, $q = '') {
        $query = Termek::find()->andFilterWhere(['statusz' => 1]);

        if (count($cat) > 0) {
            $query = $query->andFilterWhere(['in', 'kategoria_id', $cat]);
        }

        if ($q) {
            $query = $query->andFilterWhere(['or', ['like', 'nev', $q], ['like', 'cikkszam', $q]]);
        }

        if ($categoryId) {
            $cat = Kategoria::findOne($categoryId);
            $query = $query->andFilterWhere(['in', 'kategoria_id', $cat->getAllChildrenIds()]);
        }

        if ($minPrice) {
            $query = $query->andFilterWhere(['>=', 'ar', $minPrice]);
        }
        if ($maxPrice) {
            $query = $query->andFilterWhere(['<=', 'ar', $maxPrice]);
        }

        if ($discounted) {
            $query = $query->andWhere('akcios_ar is not null AND akcios_ar > 0');
        }

        if ($isNew) {
            $query = $query->andFilterWhere(['ujdonsag' => 1]);
        }

        switch ($sort) {
            case "newest":
                $query = $query->orderBy('id DESC');
                break;
            case "oldest":
                $query = $query->orderBy('id ASC');
                break;
            case 'highest_price':
                $query = $query->orderBy('ar DESC');
                break;
            case 'lowest_price':
                $query = $query->orderBy('ar ASC');
                break;
        }

        $total = (clone $query)->count();

        $RESULTS_PER_PAGE = 9;
        $pages = ceil($total / $RESULTS_PER_PAGE);

        $query = $query->offset($page * $RESULTS_PER_PAGE)->limit($RESULTS_PER_PAGE);

        return [
            'query' => $query,
            'total' => $total,
            'pages' => $pages,
        ];
    }
}

