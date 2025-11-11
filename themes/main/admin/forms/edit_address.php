<?php
$model = \app\models\Cim::findOne($id) ?: new \App\Models\Cim();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Cim&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Név',
        'name' => 'nev',
        'value' => $model->nev ?? '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Adószám',
        'name' => 'adoszam',
        'placeholder' => 'Opcionális',
        'value' => $model->adoszam ?? '',
    ])?>

    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Ország',
        'name' => 'orszag_id',
        'value' => $model->orszag_id ?: '',
        'values' => \app\models\Orszag::allForSelect(),
    ])?>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'label' => 'Irányítószám',
                'name' => 'iranyitoszam',
                'value' => $model->iranyitoszam ?? '',
            ])?>
        </div>
        <div class="sm:col-span-4">
            <?=\app\components\Helpers::render('ui/input', [
                'label' => 'Település',
                'name' => 'telepules',
                'value' => $model->telepules ?? '',
            ])?>
        </div>
    </div>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Utca, házszám',
        'name' => 'utca',
        'value' => $model->utca ?? '',
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

