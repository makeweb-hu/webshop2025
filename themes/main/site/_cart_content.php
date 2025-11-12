<?php

$cart = \app\models\Kosar::current() ?: ($customer_cart ?? null);
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}

?>

<?php foreach ($items as $item): ?>

    <?php

    $photoUrl = $item->product->getThumbnail();
    if ($item->variation) {
        $photoUrl = $item->variation->getThumbnail();
    }

    ?>

    <div class="sidebar-product" data-cart-item="" data-item-id="<?=$item->id?>">
        <a class="photo" href="/termek/fsdfsdf">
            <div class="photo-container">
                <img src="<?=$photoUrl?>">
            </div>
        </a>
        <a class="product-name-and-price" href="<?=$item->product->url?>?variation=<?=$item->variation?$item->variation->id:''?>">
            <div class="name-row">
                <?=$item->product->nev?>

                <?php if ($item->variation): ?>
                    - <?=$item->variation->optionsArray()[0]->ertek?>
                <?php endif; ?>

            </div>
            <div class="desc-row">



            </div>
            <div class="price-row">
                <span class="current-price">

                    <?php if ($item->variation): ?>
                        <?=\app\components\Helpers::formatMoney($item->variation->currentPrice())?>
                    <?php else: ?>
                        <?=\app\components\Helpers::formatMoney($item->product->currentPrice())?>
                    <?php endif; ?>

                </span>


            </div>
        </a>
        <div class="amount-and-delete">
            <div class="amount">
                            <span class="minus" data-cart-item-minus="">
                                <img src="/img/dragcards/cart/chevron-down.svg" alt="">
                            </span>
                <span class="nr" data-cart-item-amount=""><?=$item->mennyiseg?></span>
                <span class="plus" data-cart-item-plus="">
                                <img src="/img/dragcards/cart/chevron-up.svg" alt="">
                            </span>
            </div>
            <div class="delete-row" data-delete-cart-item>
                <span>Törlés</span>
            </div>
        </div>
    </div>


<?php endforeach; ?>

