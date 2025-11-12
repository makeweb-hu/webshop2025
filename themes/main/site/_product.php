<?php
$ar = $model->renderMainProductPriceForAdmin();
$regi_ar = null;

//var_dump($foto);
?>

<div class="product-list-item">
    <div class="photo-box">
        <?php if ($model->ujdonsag): ?>
            <span class="product-list-badge">Új termék</span>
        <?php endif; ?>

        <?php if ($regi_ar): ?>
            <span class="product-list-badge">
                <?=$percent?>%
            </span>
        <?php endif; ?>
        <a href="<?=$model->url?>">
            <img src="<?=$model->thumbnail?>" alt="Dragcards" />
        </a>
    </div>
    <div class="product-title">
        <a href="<?=$model->url?>">
            <?=$model->nev?>
        </a>
    </div>
    <div class="product-price">
        <span class="current-price"><?=$ar?></span>
        <?php if ($regi_ar): ?>
            <span class="old-price"><?=$regi_ar?></span>
        <?php endif; ?>
    </div>
</div>