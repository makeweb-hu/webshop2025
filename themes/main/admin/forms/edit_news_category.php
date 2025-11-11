<?php
$model = \app\models\HirKategoria::findOne($id) ?: new \App\Models\HirKategoria();

?>

<form data-ajax-form data-action="/admin-api/edit?class=HirKategoria&id=<?=$id?>" data-redirect-url="(current)">


    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'nev_hu',
        'label' => 'Név',
        'type' => 'text',
        'value' => $model->nev_hu,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'slug_hu',
        'label' => 'Slug',
        'type' => 'text',
        'value' => $model->slug_hu,
    ])?>

    <div class="-mt-4 mb-4">
        <small>
            <?=\app\models\Beallitasok::currentDomain()?>/<?=\app\models\Beallitasok::currentNewsSlug()?>/<strong class="font-medium" data-clone-input-value data-input-name="slug_hu"></strong>
        </small>
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

