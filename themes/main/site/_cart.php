<?php
$cart = \app\models\Kosar::current();
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}
?>


<div id="cart-sidebar" class="active">
    <div class="bg" data-close-cart=""></div>
    <div class="close-icon" data-close-cart=""><img src="/img/dragcards/cart/close-x-dark.svg"></div>
    <div class="sidebar">
        <div class="sidebar-header">
            Kosár
            <span class="badge" data-nr-of-cart-items style="display: none;">1</span>
        </div>
        <div class="sidebar-content">
            <div class="sidebar-content-products" data-cart-html>

                <?=Yii::$app->controller->renderPartial('@app/themes/main/site/_cart_content')?>

            </div>
        </div>
        <div class="sidebar-footer">
            <div class="total-row">
                <div class="caption">Termékek összesen:</div>
                <div class="value" data-cart-total><?=\app\components\Helpers::formatMoney($cart ? $cart->total : 0)?></div>
            </div>
            <div class="two-buttons-row">
                <div class="close-row">
                    <span data-close-cart="">Vásárlok még</span>
                </div>
                <div data-goto-checkout="" class="button-row active">
                    <a href="/checkout.php" style="<?=count($items)===0?'pointer-events: none;opacity:0.4;':''?>">Tovább a fizetéshez</a>
                </div>
            </div>

        </div>
    </div>
</div>
