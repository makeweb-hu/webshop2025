<form data-ajax-form data-action="/admin-api/create-invoice" class="text-sm">

<?php
$model = \app\models\Kosar::findOne($id);
$items = $model->getItemsForInvoice();

$total_gross = 0;
$total_net = 0;

?>


    <input type="hidden" name="id" value="<?=$id?>" />

    <div style="width: 170px;">
        <?=
        \app\components\Helpers::render('ui/date', [
            'label' => 'Dátum',
            "name" => 'date',
            'value' => date('Y-m-d', strtotime($model->idopont)),
        ]);
        ?>
    </div>

    <div>
        <div class="font-medium mb-2">Címzett</div>

        <?=$model->billingAddress->nev?><br>

        <?=$model->billingAddress->country->nev?><br>
        <?=$model->billingAddress->iranyitoszam?> <?=$model->billingAddress->telepules?><br>
        <?=$model->billingAddress->utca?>
        <?php if ($model->billingAddress->adoszam): ?>
            <br>
            Adószám: <?=$model->billingAddress->adoszam?>
        <?php endif; ?>

    </div>

    <br><br>

    <div class="font-medium mb-2">Tételek</div>

    <div>
        <div class="border-b pt-1 pb-1 last-border-b-0 flex items-center uppercase text-xs" style="color: #939393; letter-spacing: 1px;">
            <div style="width: 55%;" class="pr-2">Tétel neve</div>
            <div style="width: 10%;" class="text-right">Menny.</div>
            <div style="width: 15%;" class="text-right">ÁFA</div>
            <div style="width: 20%;" class="text-right">Br. ár</div>
        </div>
        <?php foreach ($items as $item): ?>
            <?php
                $total_gross += ($item['unit_price_gross'] * $item['amount']);
                $total_net += ($item['unit_price_net'] * $item['amount']);
            ?>
        <div class="border-b pt-1 pb-1 last-border-b-0 flex items-center">
            <div style="width: 55%;" class="pr-2"><?=$item['name']?></div>
            <div style="width: 10%;" class="text-right"><?=$item['amount'] . ' ' . $item['unit']?></div>
            <div style="width: 15%;" class="text-right"><?=$item['vat']?>%</div>
            <div style="width: 20%;" class="text-right"><?=\app\components\Helpers::formatMoney($item['price_gross'])?></div>
        </div>
        <?php endforeach; ?>
    </div>

    <br><br>

    <div class="font-medium mb-2">Végösszeg</div>

    <div>
        <div class="border-b pt-1 pb-1 last-border-b-0 flex items-center">
            <div style="width: 70%;">Nettó végösszeg</div>
            <div style="width: 30%;" class="text-right"><?=\app\components\Helpers::formatMoney($total_net)?></div>
        </div>
        <div class="border-b pt-1 pb-1 last-border-b-0 flex items-center">
            <div style="width: 70%;">ÁFA összesen</div>
            <div style="width: 30%;" class="text-right"><?=\app\components\Helpers::formatMoney($total_gross - $total_net)?></div>
        </div>
        <div class="border-b pt-1 pb-1 last-border-b-0 flex items-center">
            <div style="width: 70%;">Bruttó végösszeg</div>
            <div style="width: 30%;" class="text-right font-medium"><?=\app\components\Helpers::formatMoney($total_gross)?></div>
        </div>
    </div>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            <i class="fa-sharp fa-solid fa-receipt mr-2"></i> Számla elkészítése
        </button>

    </div>

</form>