<?php
$model = \app\models\Variacio::findOne($id) ?: new \App\Models\Variacio();


?>

<div class="flex">
    <div class="mr-4"><small class="font-medium">Opciók:</small></div>
    <div>
        <?=$model->columnViews()['options']()?>
    </div>
</div>

<hr class="mt-4 mb-4">


<form data-ajax-form data-action="/admin-api/edit?class=Variacio&id=<?=$id?>" data-redirect-url="(current)" >
    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-4">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'nev',
                'label' => 'Név',
                'type' => 'text',
                'placeholder' => 'Opcionális',
                'value' => $model->nev,
            ])?>
        </div>
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'cikkszam',
                'label' => 'Cikkszám',
                'type' => 'text',
                'placeholder' => 'Opcionális',
                'value' => $model->cikkszam,
            ])?>
        </div>
    </div>

    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Státusz',
        'name' => 'statusz',
        'value' => $model->statusz ?: 0,
    ])?>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Fő termékfotó',
        'name' => 'foto_id',
        'value' => $model->foto_id ?? '',
    ])?>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'ar',
                'label' => 'Eltérő ár',
                'icon' => 'Ft',
                'type' => 'text',
                'value' => $model->ar,
            ])?>
        </div>
        <div class="sm:col-span-2">

        </div>
    </div>

    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Akciós',
        'name' => 'akcios',
        'value' => $model->akcios ?: 0,
    ])?>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0" data-visible-if="akcios:1" style="display: none;">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/select', [
                'label' => 'Akció típusa',
                'name' => 'akcio_tipusa',
                'value' => $model->akcio_tipusa ?: 'szazalek',
                'values' => [
                    'szazalek' => 'Százalék',
                    'fix_ar' => 'Fix ár',
                ]
            ])?>
        </div>
        <div class="sm:col-span-2" data-visible-if="akcio_tipusa:szazalek" style="display: none;">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'akcio_szazalek',
                'label' => 'Akció százaléka',
                'icon' => '<i class="fa-solid fa-percent"></i>',
                'type' => 'text',
                'value' => $model->akcio_szazalek,
            ])?>
        </div>
        <div class="sm:col-span-2" data-visible-if="akcio_tipusa:fix_ar" style="display: none;">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'akcios_ar',
                'label' => 'Akciós ár',
                'icon' => 'Ft',
                'type' => 'text',
                'value' => $model->akcios_ar,
            ])?>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'keszlet',
                'label' => 'Készlet',
                //'icon' => '<small>db</small>',
                'type' => 'text',
                'value' => $model->keszlet,
                'placeholder' => 'Opcionális',
            ])?>

        </div>
        <div class="sm:col-span-4">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'keszlet_info',
                'label' => 'Készlet infó',
                'type' => 'text',
                'value' => $model->keszlet_info,
            ])?>
        </div>
    </div>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

