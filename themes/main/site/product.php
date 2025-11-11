<?php
$category = $model->category;
$breadcrumbs = $category ? $category->getBreadcrumbsWithItself() : [];
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

            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <span class="active"><?=$model->nev?></span>
        </div>

    </div>
</div>

<div id="product-page"
     data-prices="<?=htmlentities(json_encode($model->getAllPricesByOptions()))?>"
     data-variations="<?=htmlentities(json_encode($model->getAllVariationIdsByOptions()))?>"
     data-base-price="<?=$model->currentPrice()?>"
     data-stocks="<?=htmlentities(json_encode($model->getAllStocksByOptions()))?>"
     data-stock="<?=$model->keszlet?>"
>

    <div class="container">
        <div class="photo-and-details">
            <div class="photo">
                <?php if ($model->ujdonsag): ?>
                    <div class="new">
                        Új
                    </div>
                <?php endif; ?>
                <?php if ($model->hasDiscount()): ?>
                    <div class="percent">
                        <?=$model->getDiscountRate()?>%
                    </div>
                <?php endif; ?>
                <div class="photo-container">
                    <a href="<?=$model->photo ? $model->photo->getFilePath() : '/img/no-photo.jpg'?>"" data-fancybox="product">
                        <img src="<?=$model->photo ? $model->photo->getFilePath() : '/img/no-photo.jpg'?>" />
                    </a>
                </div>
                <div class="more-photos">

                    <!--
                    <div class="small-photo active">
                        <div class="small-photo-container">
                            <img src="<?=$model->getThumbnail()?>" />
                        </div>
                    </div>
                    -->

                    <?php foreach ($model->getMorePhotos() as $p): ?>
                    <a class="small-photo" data-fancybox="product" href="<?=$p->getFilePath()?>">
                        <div class="small-photo-container">
                            <img src="<?=$p->resizePhotoCover(600, 600)?>" />
                        </div>
                    </a>
                    <?php endforeach; ?>

                </div>
            </div>
            <div class="details">
                <h1 class="product-name"><?=$model->nev?></h1>
                <div class="properties">
                    <?php foreach ($model->getProductAttributes() as $productAttribute): ?>
                    <div class="property">
                        <div class="key">
                            <?=$productAttribute->attr->nev?>:
                        </div>

                        <div class="value">
                            <?php if ($productAttribute->attr->variaciokepzo): ?>
                                <?php $isFirst = true; foreach ($productAttribute->options as $option): ?>
                                <span class="variation <?=$isFirst ? 'active' : ''?>" data-option-id="<?=$option->getPrimaryKey()?>">
                                    <?=$option->ertek?>
                                </span>
                                <?php $isFirst = false; endforeach; ?>
                            <?php else: ?>
                                <?= $productAttribute->value ? $productAttribute->value->ertek : ($productAttribute->ertek_str ?:  $productAttribute->ertek_num) ?>
                            <?php endif;?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="property">
                        <div class="key">
                            Cikkszám:
                        </div>
                        <div class="value">
                            <?=$model->cikkszam?>
                        </div>
                    </div>
                    <div class="property">
                        <div class="key">
                            Készlet:
                        </div>
                        <div class="value">
                            <?php if (!$model->keszlet): ?>
                                <span class="green-circle" style="background-color: #b0b0b0;"><img src="/img/close.svg" /></span> Elfogyott
                                <?php if ($model->keszlet_info): ?>
                                    (<?=$model->keszlet_info?>)
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if ($model->keszlet > 0): ?>
                                <span class="green-circle"><img src="/img/checkmark.svg" /></span>
                                <?php else: ?>
                                    <span class="green-circle" style="background-color: #b0b0b0;"><img src="/img/close.svg" /></span>
                                <?php endif; ?>
                                <span data-stock-level><?=$model->keszlet?></span> db raktáron
                                <?php if ($model->keszlet_info): ?>
                                (<?=$model->keszlet_info?>)
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="short-description">
                    <?=htmlentities($model->rovid_leiras)?>
                </div>

                <div class="price">
                    <div class="current" data-product-price>
                        <?=$model->renderPrice()?>
                    </div>
                    <?php if ($model->hasDiscount()): ?>
                    <div class="old">
                        <?=$model->renderOriginalPrice()?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="buttons">
                    <?php if ($model->statusz): ?>
                    <div class="amount">
                        <span class="plus-minus minus">-</span>
                        <span class="nr">1</span>
                        <span class="plus-minus plus">+</span>
                    </div>


                    <div class="add-to-cart" data-add-to-cart data-product-id="<?=$model->getPrimaryKey()?>">
                        <img src="/img/add-to-cart-white.svg" />
                        <span>Kosárba</span>
                    </div>
                    <?php endif; ?>

                    <div class="like" data-like-product data-product-id="<?=$model->getPrimaryKey()?>">
                        <img src="/img/like-white.svg" />
                    </div>

                </div>

                <div class="features">

                    <a class="feature" href="/kapcsolat?product_id=<?=$model->getPrimaryKey()?>">
                        <div class="icon">
                            <img src="/img/question.svg" />
                        </div>
                        <div class="text">
                            Kérdése van a termékről?
                        </div>
                    </a>

                    <a class="feature" href="javascript:navigator.share({url:'https://borago.hu<?=str_replace("'", "\\'", $model->getUrl())?>'})">
                        <div class="icon">
                            <img src="/img/share.svg" />
                        </div>
                        <div class="text">
                            Termékadatlap megosztása
                        </div>
                    </a>

                    <a class="feature" href="/vasarlas-es-fizetes">
                        <div class="icon">
                            <img src="/img/shipping.svg" />
                        </div>
                        <div class="text">
                            Szállítás
                            és fizetés
                        </div>
                    </a>

                </div>

            </div>
        </div>

        <?php if (trim(strip_tags($model->leiras))): ?>
        <div class="description">

            <div class="description-title">
                Termékleírás
            </div>

            <div class="content">
                <?=$model->leiras?>
            </div>

        </div>
        <?php endif; ?>


        <?php if (count($model->getRecommendedProductIds()) > 0): ?>
        <div class="more-products">


            <div id="new-products">

                <div class="container">

                    <div class="submenu">Mások ezt vásárolták hozzá</div>
                    <h2>Ajánlott termékek</h2>

                    <div class="products">

                        <?php foreach ($model->getRecommendedProductIds() as $recProdId): ?>
                            <?=Yii::$app->controller->renderPartial('_product', [
                                'model' => \app\models\Termek::findOne(\app\models\TermekAjanlo::findOne($recProdId)->masik_termek_id),
                            ])?>
                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>
        <?php endif; ?>


        <div class="more-products">


            <div id="new-products">

                <div class="container">

                    <div class="submenu">Mások ezt is megnézték</div>
                    <h2>Hasonló termékek</h2>

                    <div class="products">

                        <?php foreach (\app\models\Termek::find()->orderBy('(rand()) ASC')->limit(4)->all() as $prod): ?>
                            <?=Yii::$app->controller->renderPartial('_product', [
                                    'model' => $prod,
                            ])?>
                        <?php endforeach; ?>

                    </div>

                </div>

            </div>

        </div>
    </div>

</div>