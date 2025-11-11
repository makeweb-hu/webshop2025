<div data-selected-menu="5.1"></div>

<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?php
$edit_mode = boolval(Yii::$app->request->get('edit_mode', false));


$subactions = [
    $edit_mode ? ['Szerkesztési mód kikapcsolása', 'data-leave-edit-mode', $model->id] : ['Szerkesztési mód', 'data-enter-edit-mode', $model->id]
];

$subactions[] = ['Számla elkészítése', 'data-create-invoice', $model->id];

if ($model->csomagszam) {
    $subactions[] = ['GLS címke megtekintése', 'data-view-label', $model->csomagszam];
} else {
    $subactions[] = ['GLS címke elkészítése', 'data-create-label', $model->id];
}

$subactions[] = ['Nyomtatás', 'data-print-order', $model->id];

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Rendelések' => '/admin/orders',
        ($model->rendelesszam) => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Rendelés ' . $model->rendelesszam,
    'actions' => [
        // ['type' => 'modal', 'view' => 'forms/edit_message', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ],
    'subactions' => $subactions
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összesítő','url'=>'/admin/order?id=' . $model->getPrimaryKey()],
        'invoices' => ['title'=>'Számlák', 'badge'=>count($model->invoices), 'url'=>'/admin/order?tab=invoices&id=' . $model->getPrimaryKey()],
    ],
    'active' => $tab,
]);?>

<br>

<?php if ($tab == ''): ?>
<div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6 sm:gap-y-0">
    <div class="sm:col-span-4">
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">

                <div class="stack flex">

                    <div class="text-sm border-r border-gray-200" style="width:15%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Dátum</h2>
                        <span data-tooltip="<?=$model->idopont?>"><?=date('Y-m-d', strtotime($model->idopont))?></span>
                    </div>

                    <div class="text-sm border-r border-gray-200 pl-4 pl-4" style="width:20%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Szállítási mód</h2>

                        <?php if ($edit_mode): ?>
                        <a href="javascript:void(0)" data-show-modal data-title="Szállítási mód szerkesztése" data-view="forms/edit_order_shipping" data-params='{"id":<?=$model->id?>}'> <?=$model->shipping->nev?>
                            <i class="fa-regular fa-pen text-purple-600" data-tooltip="Szállítási mód szerkesztése"></i>
                        </a>
                        <?php else: ?>
                            <?=$model->shipping->nev?>
                        <?php endif; ?>
                    </div>

                    <div class="text-sm border-r border-gray-200 pl-4" style="width:20%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Fizetési mód</h2>

                        <?php if ($edit_mode): ?>
                            <a href="javascript:void(0)" data-show-modal data-title="Fizetési mód szerkesztése" data-view="forms/edit_order_payment" data-params='{"id":<?=$model->id?>}'>
                            <?=$model->payment->nev?>
                                <i class="fa-regular fa-pen text-purple-600" data-tooltip="Fizetési mód szerkesztése"></i>
                            </a>
                        <?php else: ?>
                            <?=$model->payment->nev?>
                        <?php endif; ?>
                    </div>

                    <div class="text-sm pl-4" style="width:45%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Státuszok</h2>

                        <span class="cursor-pointer" data-show-modal data-view="forms/edit_order_paid" data-params='{"id":<?=$model->id?>}' data-title="Fizetés státusza">
                            <?=$model->columnViews()['payment_status']()?>
                        </span>

                        <span class="cursor-pointer" data-show-modal data-view="forms/edit_order_status" data-params='{"id":<?=$model->id?>}' data-title="Teljesítés státusza">
                            <?=$model->columnViews()['shipping_status']()?>
                        </span>
                    </div>



                </div>

            </div>
        </div>

        <?php
        $item_actions = [];
        if ($edit_mode) {
            $item_actions = [
                [ 'type' => 'modal', 'tooltip'=>'Tétel szerkesztése', 'icon' =>'edit', 'title' => '', 'view' => 'forms/edit_order_item' ],
                [ 'type' => 'confirm', 'icon'=>'delete','title' => '',  'tooltip'=>'Tétel törlése', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=KosarTetel' ],
            ];
        }

        ?>
        <?=\app\components\Helpers::render('ui/table', [
            'class' => \app\models\KosarTetel::class,
            'columns' => ['product', 'mennyiseg', 'egysegar', 'price'],
            'nopagination' => true,
            'filter' => function ($query) use ($model) {
                return $query->where(['kosar_id' => $model->getPrimaryKey()])->orderBy('id DESC');
            },
            'actions' =>$item_actions
        ])?>

        <?php if ($edit_mode): ?>
        <div class="flex justify-end mb-4">
            <button type="button" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    data-show-modal data-title="Tétel hozzáadása" data-view="forms/edit_order_item" data-params='{"kosar_id":<?=$model->id?>}' >
                <i class="fa-regular fa-plus mr-1"></i> Tétel hozzáadása
            </button>
        </div>
        <?php endif; ?>

        <hr class="mb-2 mt-2">

        <div class="text-sm">


            <div class="flex justify-end">

                <div style="width: 200px;" class="text-right pr-4">

                        Termékek összesen:

                </div>
                <div style="width: 100px;" class="text-right pr-2">

                        <?=number_format($model->getItemsTotal(), 0, '', ' ')?> Ft

                </div>
            </div>
        </div>

        <div class="text-sm mt-2 mb-2">


            <div class="flex justify-end">

                <div style="width: 300px;" class="text-right pr-4">

                    Szállítási díj:

                </div>
                <div style="width: 100px;" class="text-right pr-2">

                    <?php if (!$model->getShippingPrice()): ?>

                        —

                    <?php else: ?>

                        <?=number_format($model->getShippingPrice(), 0, '', ' ')?> Ft

                    <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="text-sm mt-2 mb-2">


            <div class="flex justify-end">

                <div style="width: 300px;" class="text-right pr-4">

                    Fizetés díja:

                </div>
                <div style="width: 100px;" class="text-right pr-2">

                    <?php if (!$model->getPaymentPrice()): ?>

                        —

                    <?php else: ?>

                    <?=number_format($model->getPaymentPrice(), 0, '', ' ')?> Ft

                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="text-sm mt-2 mb-2">


            <div class="flex justify-end">

                <div style="width: 300px;" class="text-right pr-4">

                    Kedvezmény:

                </div>
                <div style="width: 100px;" class="text-right pr-2">



                        <?=number_format($model->getTotalDiscount(), 0, '', ' ')?> Ft


                </div>
            </div>
        </div>

        <hr class="mb-2 mt-2">

        <div class="flex justify-end">

            <div style="width: 300px;" class="text-right pr-4">

                    Nettó végösszeg:

            </div>
            <div style="width: 100px;" class="text-right pr-2">

                    <?=number_format($model->getNetTotal(), 0, '', ' ')?> Ft

            </div>
        </div>

        <div class="flex justify-end">

            <div style="width: 300px;" class="text-right pr-4">

                    ÁFA összesen:
            </div>
            <div style="width: 100px;" class="text-right pr-2">

                    <?=number_format($model->getTotalVat(), 0, '', ' ')?> Ft

            </div>
        </div>
        <hr class="mb-2 mt-2">
        <div class="flex justify-end">

            <div style="width: 300px;" class="text-right pr-4">
                <strong>
                    Bruttó végösszeg:
                </strong>
            </div>
            <div style="width: 100px;" class="text-right pr-2">
                <strong>
                <?=number_format($model->getTotal(), 0, '', ' ')?> Ft
                </strong>
            </div>
        </div>

    </div>
    <div class="sm:col-span-2">
        <div class="bg-white overflow-hidden shadow rounded-lg">


            <div class="px-4 py-5 sm:p-6 text-sm">

                <?php if ($edit_mode): ?>
                    <a data-tooltip="Vásárló szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"

                       data-show-modal
                       data-title="Vásárló szerkesztése"
                       data-view="forms/edit_order_customer"
                       data-params='{"id":<?=$model->id?>}'

                    ><i class="fa-regular fa-pen"></i></a>
                <?php endif; ?>

                <div style="display: flex; justify-content: center" class="mb-4">
                     <img src="<?=\app\components\Gravatar::generate($model->getPrimaryKey(), 80)?>" width="80" style="border-radius: 50%; <?=$edit_mode?'transform:translateX(8px)':''?>" />
                </div>

                <div class="text-center">
                    <a href="/admin/customer?id=<?=$model->customer->id?>" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500"><?=$model->nev?></a>
                </div>
                <div class="text-center text-sm">
                    <?=$model->email?>
                </div>
                <div class="text-center text-sm">
                    <?=$model->telefonszam?>
                </div>



                <hr class="mt-4 mb-4">

                <h2 class="text-sm font-medium text-gray-500 mb-4">Szállítási cím

                    <?php if ($edit_mode): ?>
                    <a data-tooltip="Cím szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"

                       data-show-modal
                       data-title="Cím szerkesztése"
                       data-view="forms/edit_address"
                       data-params='{"id":<?=$model->shippingAddress->id?>}'

                        ><i class="fa-regular fa-pen"></i></a>
                    <?php endif; ?>
                </h2>

                <?=$model->shippingAddress->toMultilineHtml()?>

                <h2 class="text-sm font-medium text-gray-500 mb-4 mt-8">Számlázási cím
                    <?php if ($edit_mode): ?>
                    <a data-tooltip="Cím szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"

                       data-show-modal
                       data-title="Cím szerkesztése"
                       data-view="forms/edit_address"
                       data-params='{"id":<?=$model->billingAddress->id?>}'
                    ><i class="fa-regular fa-pen"></i></a>
                    <?php endif; ?>
                </h2>

                <?=$model->billingAddress->toMultilineHtml()?>

                <h2 class="text-sm font-medium text-gray-500 mb-4 mt-8">Megjegyzés

                    <?php if ($edit_mode): ?>
                        <a data-tooltip="Cím szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"

                           data-show-modal
                           data-title="Megjegyzés szerkesztése"
                           data-view="forms/edit_cart_comment"
                           data-params='{"id":<?=$model->id?>}'
                        ><i class="fa-regular fa-pen"></i></a>
                    <?php endif; ?>
                </h2>
                <?=$model->megjegyzes ?: '—'?>

                <h2 class="text-sm font-medium text-gray-500 mb-4 mt-8">Kedvezmény

                    <?php if ($edit_mode): ?>
                        <a data-tooltip="Kupon szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"

                           data-show-modal
                           data-title="Kupon szerkesztése"
                           data-view="forms/edit_order_coupon"
                           data-params='{"id":<?=$model->id?>}'
                        ><i class="fa-regular fa-pen"></i></a>
                    <?php endif; ?>
                </h2>

                <?=$model->coupon?'Kuponkód: '.$model->coupon->kod:($model->kedvezmeny?'-' . \app\components\Helpers::formatMoney($model->kedvezmeny):'—')?>

            </div>
        </div>
    </div>
</div>

<?php elseif ($tab == 'invoices'): ?>

    <?=Yii::$app->controller->renderPartial('pages/_order_invoices', [
            'model' => $model,
    ])?>

<?php endif; ?>
