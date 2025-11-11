<?php
$model = \app\models\Slider::findOne($id) ?: new \App\Models\Slider();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Slider&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'cim',
        'label' => 'Cím',
        'type' => 'text',
        'value' => $model->cim,
    ])?>

    <?=\app\components\Helpers::render('ui/textarea', [
        'name' => 'leiras',
        'label' => 'Leírás',
        'rows' => 2,
        'type' => 'text',
        'value' => $model->leiras,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'link',
        'label' => 'Link',
        'type' => 'text',
        'value' => $model->link,
    ])?>

    <?=\app\components\Helpers::render('ui/file', [
        'name' => 'kep_id',
        'label' => 'Kép',
        'value' => $model->kep_id ?: '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'sorrend',
        'label' => 'Sorrend',
        'type' => 'text',
        'value' => $model->sorrend,
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

