<?php
$q = trim(Yii::$app->request->get('q', ''));
$sort = trim(Yii::$app->request->get('sort', 'newest'));
$page = intval(Yii::$app->request->get('page', '0'));
$minPrice = Yii::$app->request->get('min_price', '');
$maxPrice = Yii::$app->request->get('max_price', '');
$discounted = Yii::$app->request->get('discounted', '');
$new = Yii::$app->request->get('new', '');

$hasFilterClear = $minPrice || $maxPrice || $discounted || $new || $q;

$filterResult = \app\models\Termek::filterProducts($model ? $model->id : null, $page, $minPrice, $maxPrice, $discounted, $new, [], $sort, $q);

$products = $filterResult['query']->all();

$baseUrl = $model?$model->getUrl():'/site/search';

?>
<div class="breadcrumbs">
    <div class="container">
        <div class="items">
            <a href="/">
                <img src="/img/home.svg" />
            </a>
            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <a href="/site/search">Keresés</a>

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

                    <div class="button-row">
                        <a href="javascript:void(0)" data-filter-button><button>Szűrés</button></a>
                    </div>
                </div>
            </div>
            <div class="right">



                <div class="title-row">
                    <h1>Keresés</h1>
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