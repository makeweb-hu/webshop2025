<div data-selected-menu="5.2"></div>

<?php

$subactions = [
    [ 'Szerkesztés', 'data-edit-customer', $model->id ]
];

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Vásárlók' => '/admin/customers',
        ($model->nev) => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => '
        <div class="md:flex md:items-center md:justify-between">
        <div class="flex-1 min-w-0">
            <div class="flex items-start space-x-5">
                <div class="flex-shrink-0">
                    <div class="relative">
                        <img class="h-16 w-16 rounded-full" src="'.\app\components\Gravatar::generate($model->getPrimaryKey(), 64).'" alt="">
                        <span class="absolute inset-0 shadow-inner rounded-full" aria-hidden="true"></span>
                    </div>
                </div>
                <div class="pt-1.5">
                    <div class="text-2xl font-bold text-gray-900">'.$model->nev.'</div>
                    <p class="text-sm font-normal text-gray-500">'.$model->email.'</p>
                </div>
            </div>
        </div>
    </div>
    ',
    'actions' => [
         // ['type' => 'modal', 'view' => 'forms/edit_message', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ],
    'subactions' => $subactions
])?>

<div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-6 sm:gap-y-0">
    <div class="sm:col-span-4">
        <div class="bg-white overflow-hidden shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">

                <div class="stack flex">

                    <div class="text-sm border-r border-gray-200" style="width:33%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Regisztrált</h2>
                        <?=$model->letrehozas_idopontja?>
                    </div>

                    <div class="text-sm border-r border-gray-200 pl-4 pl-4" style="width:33%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Elköltött összeg</h2>
                        <?=\app\components\Helpers::formatMoney($model->totalSpent())?>
                    </div>

                    <div class="text-sm border-gray-200 pl-4" style="width:33%">
                        <h2 class="text-sm font-medium text-gray-500 mb-2">Átlagos költés</h2>

                        <?=\app\components\Helpers::formatMoney($model->avrageSpent())?>
                    </div>




                </div>

            </div>
        </div>

        <?=\app\components\Helpers::render('ui/table', [
            'title' => 'Rendelései',
            'badge' => $model->nrOfOrders(),
            'class' => \app\models\Kosar::class,
            'columns' => ['rendelesszam', 'idopont','total'],
            'nopagination' => true,
            'filter' => function ($query) use ($model) {
                return $query->where(['megrendelve' => 1, 'vasarlo_id' => $model->getPrimaryKey()])->orderBy('id DESC');
            },
            'actions' => [
                [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/order' ],
            ]
        ])?>


    </div>
    <div class="sm:col-span-2">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6 text-sm">
                <h2 class="text-sm font-medium text-gray-500 mb-4">Kapcsolati adatok
                    <a data-tooltip="Adatok szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"
                       data-show-modal
                       data-title="Adatok szerkesztése"
                       data-view="forms/edit_customer"
                       data-params='{"id":<?=$model->id?>}'
                    ><i class="fa-regular fa-pen"></i></a>
                </h2>

                <?=$model->nev?><br>
                <?=$model->email?><br>
                <?=$model->telefonszam?>

                <h2 class="text-sm font-medium text-gray-500 mt-8 mb-4">Szállítási cím
                    <a data-tooltip="Cím szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"
                       data-show-modal
                       data-title="Cím szerkesztése"
                       data-view="forms/edit_address"
                       data-params='{"id":<?=$model->shippingAddress->id?>}'
                    ><i class="fa-regular fa-pen"></i></a>
                </h2>



                <?php if ($model->shippingAddress): ?>
                    <?=$model->shippingAddress->nev?><br>

                    <?=$model->shippingAddress->country->nev?><br>
                    <?=$model->shippingAddress->iranyitoszam?> <?=$model->shippingAddress->telepules?><br>
                    <?=$model->shippingAddress->utca?>
                    <?php if ($model->shippingAddress->adoszam): ?>
                        <br>
                        Adószám: <?=$model->shippingAddress->adoszam?>
                    <?php endif; ?>
                <?php endif; ?>

                <h2 class="text-sm font-medium text-gray-500 mb-4 mt-8">Számlázási cím
                    <a data-tooltip="Cím szerkesztése" href="javascript:void(0)" class="bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500" style="float:right"
                       data-show-modal
                       data-title="Cím szerkesztése"
                       data-view="forms/edit_address"
                       data-params='{"id":<?=$model->billingAddress->id?>}'
                    ><i class="fa-regular fa-pen"></i></a>
                </h2>

                <?=$model->billingAddress->nev?><br>

                <?=$model->billingAddress->country->nev?><br>
                <?=$model->billingAddress->iranyitoszam?> <?=$model->billingAddress->telepules?><br>
                <?=$model->billingAddress->utca?>
                <?php if ($model->billingAddress->adoszam): ?>
                    <br>
                    Adószám: <?=$model->billingAddress->adoszam?>
                <?php endif; ?>




            </div>
        </div>
    </div>
</div>