<?php
$model = \app\models\Vasarlo::findOne($id) ?: new \App\Models\Vasarlo();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Vasarlo&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'nev',
        'label' => 'Név',
        'type' => 'text',
        'value' => $model->nev ?: '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'email',
        'label' => 'E-mail',
        'type' => 'text',
        'value' => $model->email ?: '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'telefonszam',
        'label' => 'Telefonszám',
        'placeholder' => 'Opcionális',
        'type' => 'text',
        'value' => $model->telefonszam ?: '',
    ])?>

    <?=\app\components\Helpers::render('ui/entity', [
        'label' => 'Szállítási cím',
        'name' => 'szallitasi_cim_id',
        'value' => $model->isNewRecord ? null : $model->szallitasi_cim_id,
        'class' => \app\models\Cim::class,
        'view' => 'forms/edit_address',
        'no_delete' => true,
        'columns' => ['full_address_with_name'],
    ])?>

    <?=\app\components\Helpers::render('ui/entity', [
        'label' => 'Számlázási cím',
        'name' => 'szamlazasi_cim_id',
        'value' => $model->isNewRecord ? null : $model->szamlazasi_cim_id,
        'class' => \app\models\Cim::class,
        'view' => 'forms/edit_address',
        'no_delete' => true,
        'columns' => ['full_address_with_name'],
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

