<?php
$category = $model;

if ($category) {
    $products = \app\models\Termek::find()->where(['kategoria_id' => $category->id])->orderBy('id ASC')->all();
} else {
    $products = \app\models\Termek::find()->orderBy('id ASC')->all();
}

$baseUrl = $category ? $category->url : '/termekek';

$sort = Yii::$app->request->get('sort', 'ar_asc');
$sorts = [
    'ar_desc' => 'Olcsóbb elöl',
    'ar_asc' => 'Drágább elöl',
    'nev_asc' => 'Ábécé növekvő',
    'nev_desc' => 'Ábécé csökkenő',
];
$sortName = $sorts[$sort] ?? 'Olcsóbb elöl';

$productCounts = [
        'all' => \app\models\Termek::find()->where(['statusz' => 1])->count(),
];
foreach (\app\models\Kategoria::find()->all() as $cat) {
    $productCounts[$cat->page->url] = \app\models\Termek::find()->where(['kategoria_id' => $cat->id, 'statusz' => 1])->count();
}
?>

<div class="products-page">
    <div class="container">
        <h1 class="page-title">
            <?=$category ? $category->nev : 'Összes termék'?>
        </h1>
        <div class="filters-row">
            <div class="left">
                <div class="filters-dropdown" data-show-filters="">
                    <div class="icon">
                        <img src="/img/dragcards/product-list/filters.svg" alt="Dragcards">
                    </div>
                    <div class="text">
                        Szűrők <span class="hide-on-mobile">megjelenítése</span>
                    </div>
                    <div class="arrow">

                    </div>

                    <div class="dropdown-content">
                        <!--
                        <div class="dropdown-section">
                            <div class="dropdown-section-title">Telefon</div>
                            <div class="dropdown-row">
                                <div class="value">
                                    <div class="logo"><img src="/img/apple-black.svg" alt="Dragcards" /></div>
                                    <div class="text">
                                        Apple iPhone 15 PRO
                                    </div>
                                </div>
                                <div class="dropdown-arrow">
                                    <img src="/img/chevron-down.svg" alt="Dragcards" />
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-section">
                            <div class="dropdown-section-title">Tok színe</div>
                            <div class="checkbox-row">
                                <div class="checkbox checked">
                                    <img src="/img/checkmark-white.svg" alt="Dragcards" />
                                </div>
                                <div class="value">
                                    Átlátszó
                                </div>
                            </div>
                            <div class="checkbox-row">
                                <div class="checkbox">
                                    <img src="/img/checkmark-white.svg" alt="Dragcards" />
                                </div>
                                <div class="value">
                                    Fehér
                                </div>
                            </div>
                            <div class="checkbox-row">
                                <div class="checkbox">
                                    <img src="/img/checkmark-white.svg" alt="Dragcards" />
                                </div>
                                <div class="value">
                                    Fekete
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-section">
                            <div class="dropdown-section-title">MagSafe</div>
                            <div class="checkbox-row">
                                <div class="checkbox">
                                    <img src="/img/checkmark-white.svg" alt="Dragcards" />
                                </div>
                                <div class="value">
                                    Igen
                                </div>
                            </div>
                            <div class="checkbox-row">
                                <div class="checkbox">
                                    <img src="/img/checkmark-white.svg" alt="Dragcards" />
                                </div>
                                <div class="value">
                                    Nem
                                </div>
                            </div>
                        </div>
                        <div class="button-row">
                            <div class="btn">
                                Szűrés
                            </div>
                        </div>
                        <div class="delete-filters-row">
                            <div class="btn">
                                <div class="icon"><img src="/img/x-red.svg" alt="Dragcards" /></div>
                                <div class="text">Szűrők törlése</div>
                            </div>
                        </div>
                        -->
                        <div style="margin-bottom: 15px; text-align: center">
                            <!--
                            <i class="fa-solid fa-circle-notch fa-spin"></i> Szűrők betöltése...
                            -->

                            <?php if (!$category): ?>



                                <div style="text-align: left; margin-bottom: 10px; text-align: center">
                                    <b>Kategória</b>
                                </div>

                            <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                <span style="padding: 15px 0; display: flex; align-items: center; justify-content: space-between;">
                                            <span>Összes termék <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['all']?>)</span></span>
                                            <span style="font-size: 200%;">&middot;</span>
                                        </span>
                            </div>

                                <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                    <a href="/kartyak" style="padding: 15px 0;  color: #7600ff; display: flex; align-items: center; justify-content: space-between;">
                                        <span>Kártyák <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['kartyak']?>)</span></span>

                                        <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>
                                </div>

                                <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                    <a href="/tablak" style="padding: 15px 0; color: #7600ff;display: flex; align-items: center; justify-content: space-between;">

                                        <span>Kártyák <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['tablak']?>)</span></span>

                                        <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>
                                </div>

                                <div style="text-align: left;">
                                    <a href="/csomagok" style="padding: 15px 0; color: #7600ff;display: flex; align-items: center; justify-content: space-between; ">

                                        <span>Csomagok <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['csomagok']?>)</span></span>

                                        <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>
                                </div>

                            <?php else: ?>

                                <div style="text-align: left; margin-bottom: 10px; text-align: center">
                                    <b>Kategória</b>
                                </div>

                                <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                    <a href="/termekek" style="padding: 15px 0;  color: #7600ff; display: flex; align-items: center; justify-content: space-between;">
                                        <span>Összes termék <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['all']?>)</span></span>

                                        <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>
                                </div>

                                <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                    <?php if ($category->page->url === 'kartyak'): ?>
                                        <span style="padding: 15px 0; display: flex; align-items: center; justify-content: space-between;">
                                            <span>Kártyák <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['kartyak']?>)</span></span>
                                            <span style="font-size: 200%;">&middot;</span>
                                        </span>
                                    <?php else: ?>
                                    <a href="/kartyak" style="padding: 15px 0;  color: #7600ff; display: flex; align-items: center; justify-content: space-between;">
                                        Kártyák <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>
                                    <?php endif; ?>
                                </div>

                                <div style="border-bottom: 1px solid #eaeaea; text-align: left;">
                                    <?php if ($category->page->url === 'tablak'): ?>

                                        <span style="padding: 15px 0; display: flex; align-items: center; justify-content: space-between;">
                                            <span>Táblák <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['tablak']?>)</span></span>
                                            <span style="font-size: 200%;">&middot;</span>
                                        </span>

                                    <?php else: ?>

                                        <a href="/tablak" style="padding: 15px 0; color: #7600ff;display: flex; align-items: center; justify-content: space-between;">Táblák <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>

                                    <?php endif; ?>
                                </div>

                                <div style="text-align: left;">
                                    <?php if ($category->page->url === 'csomagok'): ?>

                                        <span style="padding: 15px 0; display: flex; align-items: center; justify-content: space-between;">
                                            <span>Csomagok <span style="font-size: 80%; opacity: 0.5;">(<?=$productCounts['csomagok']?>)</span></span>

                                            <span style="font-size: 200%;">&middot;</span>
                                        </span>

                                    <?php else: ?>

                                        <a href="/csomagok" style="padding: 15px 0; color: #7600ff;display: flex; align-items: center; justify-content: space-between; ">Csomagok <img src="/img/dragcards/header-dropdown/arrow.svg" width="12" alt="Dragcards"></a>

                                    <?php endif; ?>
                                </div>

                            <?php endif; ?>
                        </div>
                        <div class="button-row">
                            <div class="btn">
                                Szűrés
                            </div>
                        </div>
                        <!--
                        <div class="delete-filters-row">
                            <div class="btn">
                                <div class="icon"><img src="/img/x-red.svg" alt="Dragcards" /></div>
                                <div class="text">Szűrők törlése</div>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
            </div>
            <div class="right">
                <span>Sorrend:</span>
                <div class="sort-dropdown" data-sort-dropdown="">
                    <div class="value"><?=$sortName?></div>
                    <div class="arrow">
                        <img src="/img/dragcards/product-list/chevron-down.svg" alt="Dragcards">
                    </div>

                    <div class="dropdown-content">
                        <div class="dropdown-item <?=$sort=='ar_asc'?'selected':''?>" data-change-sort="" data-value="ar_asc" data-base-url="<?=$baseUrl?>">
                            <div class="text">Olcsóbb elöl</div>
                            <div class="checkmark"><img src="/img/dragcards/product-list/checkmark.svg" alt="Dragcards"></div>
                        </div>
                        <div class="dropdown-item <?=$sort=='ar_desc'?'selected':''?>" data-change-sort="" data-value="ar_desc" data-base-url="<?=$baseUrl?>">
                            <div class="text">Drágább elöl</div>
                            <div class="checkmark"><img src="/img/dragcards/product-list/checkmark.svg" alt="Dragcards"></div>
                        </div>
                        <div class="dropdown-item <?=$sort=='nev_asc'?'selected':''?>" data-change-sort="" data-value="nev_asc" data-base-url="<?=$baseUrl?>">
                            <div class="text">Ábécé növekvő</div>
                            <div class="checkmark"><img src="/img/dragcards/product-list/checkmark.svg" alt="Dragcards"></div>
                        </div>
                        <div class="dropdown-item <?=$sort=='nev_desc'?'selected':''?>" data-change-sort="" data-value="nev_desc" data-base-url="<?=$baseUrl?>">
                            <div class="text">Ábécé csökkenő</div>
                            <div class="checkmark"><img src="/img/dragcards/product-list/checkmark.svg" alt="Dragcards"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="columns">

                <?php foreach ($products as $product): ?>

                    <?=Yii::$app->controller->renderPartial('_product', [
                        'model' => $product,
                    ])?>

                <?php endforeach; ?>

            </div>

            <?php if (!$products): ?>
                <div style="font-size: 400%; text-align: center; padding: 50px 0; opacity: 0.3;">
                    <div style="text-align: center;">
                        <img src="/favicons/favicon.svg" style="width: 150px; filter:grayscale(1)" />
                    </div>
                    <div>
                        Nincs találat.
                    </div>
                </div>
            <?php endif; ?>

            <div class="pagination">
                <a href="javascript:void(0)" class="prev">
                    <span class="icon"><img src="/img/dragcards/pagination/arrow-left.svg" alt="Dragcards" /></span>
                    <span class="text">Előző</span>
                </a>
                <a href="#" class="page active">1</a>
                <!--
                <a href="#" class="page ">2</a>
                <a href="#" class="page ">3</a>
                -->
                <a href="javascript:void(0)" class="next">
                    <span class="text">Következő</span>
                    <span class="icon"><img src="/img/dragcards/pagination/arrow-right.svg" alt="Dragcards" /></span>
                </a>
            </div>
        </div>
    </div>
</div>
