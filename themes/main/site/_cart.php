<?php
$cart = \app\models\Kosar::current();
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}
?>

<?php foreach ($items as $item): ?>
<li class="py-6 flex">
    <div class="flex-shrink-0 w-16 h-16 border border-gray-200 rounded-md overflow-hidden">
        <img src="<?=$item->product->getThumbnail()?>" class="w-full h-full object-center object-cover">
    </div>

    <div class="ml-4 flex-1 flex flex-col">
        <div>
            <div class="flex justify-between text-base font-medium text-gray-900">
                <h3 style="font-size: 14px; width: 200px;">
                    <a href="<?=$item->product->getUrl()?>">
                        <?=$item->product->nev?>
                    </a>
                </h3>
                <p class="ml-4" style="font-size: 14px;">
                    <?=\app\components\Helpers::formatMoney( $item->getPrice() )?>
                </p>
            </div>
            <p class="mt-1 text-sm text-gray-500" style="font-size: 13px;">
                <?php if ($item->variation): ?>
                    <?=$item->variation->optionsAsString()?>
                <?php else: ?>
                    Cikkszám: <?=$item->product->cikkszam?>
                <?php endif; ?>
            </p>
        </div>
        <div class="flex-1 flex items-end justify-between text-sm">
            <p class="text-gray-500">
                <b><?=$item->mennyiseg?> db</b>
            </p>

            <div class="flex">
                <button type="button" class="font-medium text-indigo-600 hover:text-indigo-500" data-delete-from-cart data-id="<?=$item->id?>">Törlés</button>
            </div>
        </div>
    </div>
</li>
<?php endforeach; ?>

<?php if (count($items) == 0): ?>
A kosár üres.
<?php endif; ?>
