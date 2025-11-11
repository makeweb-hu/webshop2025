<?php
$model = \app\models\Tudastar::findOne($id) ?: new \app\models\Tudastar();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Tudastar&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Kategória',
        'name' => 'kategoria',
        'values' => [
            'termek' => 'Termék',
            'uzlet' => 'Üzlet',
        ],
        'value' => $model->kategoria,
    ])?>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Kép',
        'name' => 'fajl_id',
        'value' => $model->fajl_id ?? '',
    ])?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'nev_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Cím',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>


    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Publikálva',
        'name' => 'publikalva',
        'value' => $model->publikalva ?: 0,
    ])?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

