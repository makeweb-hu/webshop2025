<div class="product"
     data-prices="<?=htmlentities(json_encode($model->getAllPricesByOptions()))?>"
     data-variations="<?=htmlentities(json_encode($model->getAllVariationIdsByOptions()))?>"
     data-stock="<?=$model->keszlet?>"
     data-url="<?=$model->getUrl()?>"
>
    <div class="product-box">
        <?php if ($model->hasDiscount()): ?>
        <div class="percent">
            <?=$model->getDiscountRate()?>%
        </div>
        <?php endif; ?>

        <?php if ($model->ujdonsag): ?>
        <div class="new">
            Új
        </div>
        <?php endif; ?>

        <!--
        <div class="zoom">
            <img src="/img/zoom.svg" />
        </div>
        -->

        <div class="photo-container">
            <a href="<?=$model->getUrl()?>">
                <img src="<?=$model->getThumbnail()?>" />
            </a>
        </div>
        <div class="title">
            <a href="<?=$model->getUrl()?>">
                <?=$model->nev?>
            </a>
        </div>
        <div class="price-and-actions">
            <div class="price">
                <div class="current">
                    <?=$model->renderPrice()?>
                </div>
                <?php if ($model->hasDiscount()): ?>
                <div class="old">
                    <?=$model->renderOriginalPrice()?>
                </div>
                <?php endif; ?>
            </div>
            <div class="actions">
                <div class="action" data-add-to-cart-thumbnail data-product-id="<?=$model->getPrimaryKey()?>">
                    <img src="/img/add-to-cart.svg" />
                </div>
                <div class="action" data-like-product-thumbnail data-product-id="<?=$model->getPrimaryKey()?>">
                    <img src="/img/like.svg" />
                </div>
            </div>
        </div>
    </div>
</div>