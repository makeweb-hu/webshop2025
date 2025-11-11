<?php
$sort = trim(Yii::$app->request->get('sort', 'newest'));
$page = intval(Yii::$app->request->get('page', '0'));
$minPrice = Yii::$app->request->get('min_price', '');
$maxPrice = Yii::$app->request->get('max_price', '');
$cat = explode(',', Yii::$app->request->get('cat', ''));
$discounted = Yii::$app->request->get('discounted', '');
$new = Yii::$app->request->get('new', '');

if (count($cat) === 1 && !trim($cat[0])) {
    $cat = [];
}

$hasFilterClear = $minPrice || $maxPrice || count($cat) > 0 || $discounted || $new;

$subcats = ($model ? $model->children : \app\models\Kategoria::mainCats());
$breadcrumbs = $model ? $model->getBreadcrumbs() : [];

$filterResult = \app\models\Termek::filterProducts($model ? $model->id : null, $page, $minPrice, $maxPrice, $discounted, $new, $cat, $sort);

$products = $filterResult['query']->all();

$baseUrl = $model?$model->getUrl():'/termekek';

?>
<div class="breadcrumbs">
    <div class="container">
        <div class="items">
            <a href="/">
                <img src="/img/home.svg" />
            </a>
            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <a href="/termekek">Termékek</a>

            <?php foreach ($breadcrumbs as $breadcrumb): ?>

            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <a href="<?=$breadcrumb->getUrl()?>"><?=$breadcrumb->nev?></a>

            <?php endforeach; ?>

            <?php if ($model): ?>
            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <span class="active"><?=$model->nev?></span>
            <?php endif; ?>
        </div>

    </div>
</div>

<div id="product-list" data-base-url="<?=$baseUrl?>" data-page="<?=$page?>" data-sort="<?=$sort?>">
    <div class="container">

        <div class="filters-and-products">
            <div class="left">
                <div class="filters">
                    <div class="clear-filters">

                        <span data-filter-clear style="<?=$hasFilterClear?'':'visibility:hidden'?>">
                            <img src="/img/delete.svg" />
                            Szűrés törlése
                         </span>

                    </div>
                    <div class="section-title">
                        Ár
                    </div>
                    <div class="min-max">
                        <div class="min">
                            <input type="text" placeholder="Min. (Ft)" data-filter-min-price value="<?=$minPrice?>">
                        </div>
                        <div class="max">
                            <input type="text" placeholder="Max. (Ft)" data-filter-max-price value="<?=$maxPrice?>">
                        </div>
                    </div>
                    <div class="section-title">
                        Tulajdonság
                    </div>
                    <div class="items">
                        <label class="filter">
                            <input type="checkbox" data-filter-discount <?=$discounted ? 'checked' : ''?> > Akciós
                        </label>
                        <label class="filter">
                            <input type="checkbox" data-filter-new <?=$new ? 'checked' : ''?> > Újdonság
                        </label>
                    </div>
                    <?php if (count($subcats) > 0): ?>
                    <div class="section-title">
                        Kategória
                    </div>
                    <div class="items">
                        <?php foreach ($subcats as $subcat): ?>
                        <label class="filter">
                            <input type="checkbox" data-filter-category="<?=$subcat->id?>" <?=in_array($subcat->id, $cat)?'checked':''?> > <?=$subcat->nev?>
                        </label>

                        <?php foreach ($subcat->children as $subcatChild): ?>

                        <label class="filter subcat">
                            <input type="checkbox" data-filter-category="<?=$subcatChild->id?>" <?=in_array($subcatChild->id, $cat)?'checked':''?> > <?=$subcatChild->nev?>
                        </label>

                        <?php endforeach; ?>

                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="button-row">
                        <a href="javascript:void(0)" data-filter-button><button>Szűrés</button></a>
                    </div>
                </div>
            </div>
            <div class="right">

                <?php if (count($subcats) > 0): ?>

                    <div class="categories">
                        <?php foreach ($subcats as $childCat): ?>
                        <a class="category" href="<?=$childCat->getUrl()?>">
                            <div class="photo">
                                <div class="photo-container">
                                    <img src="<?=$childCat->getThumbnail()?>" />
                                </div>
                            </div>
                            <div class="name">
                                <?=$childCat->nev?>
                            </div>
                        </a>
                        <?php endforeach; ?>

                    </div>
                <?php endif;?>


                <div class="title-row">
                    <h1><?=$model->nev ?: ($discounted ? 'Akciós termékek' : ($new ? 'Újdonságok' : 'Termékek'))?></h1>
                    <div class="sort">
                        <select data-sort-select>
                            <option <?=$sort=='newest'?'selected':''?> value="newest">Újak elöl</option>
                            <option <?=$sort=='oldest'?'selected':''?> value="oldest">Régiek elöl</option>
                            <option <?=$sort=='lowest_price'?'selected':''?>  value="lowest_price">Ár szerint növekvő</option>
                            <option <?=$sort=='highest_pric'?'selected':''?> value="highest_price">Ár szerint csökkenő</option>
                        </select>
                    </div>
                </div>

                <div class="products">

                    <?php foreach ($products as $product): ?>

                        <?=Yii::$app->controller->renderPartial('_product', [
                                'model' => $product,
                        ])?>

                    <?php endforeach; ?>

                    <?php if (count($products) == 0): ?>
                    <div class="no-results" style="font-size: 150%; text-align: center; opacity: 0.4; width: 100%; padding: 80px;">
                        <div class="flex justify-center mb-4"><img src="/img/borago.svg" /></div>
                        Nincs találat
                    </div>
                    <?php endif; ?>

                </div>

                <?php if (count($products) > 0): ?>
                <div class="pagination">

                    <a class="item left" href="<?=$baseUrl?>?<?=http_build_query(array_merge($_GET, ['page' => max(0, $page - 1)]))?>">
                        <img src="/img/paginate-left.svg" />
                    </a>

                    <?php for ($i = 0; $i < $filterResult['pages']; $i += 1): ?>
                    <a class="item <?=$page==$i?'active':''?>" href="<?=$baseUrl?>?<?=http_build_query(array_merge($_GET, ['page' => $i]))?>" style="<?=abs($page-$i)>5?'display:none':''?>">
                        <?=$i + 1?>
                    </a>
                    <?php endfor; ?>

                    <a class="item right" href="<?=$baseUrl?>?<?=http_build_query(array_merge($_GET, ['page' => min($filterResult['pages'] - 1, $page + 1)]))?>">
                        <img src="/img/paginate-right.svg" />
                    </a>

                </div>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>