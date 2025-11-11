<?php
$model = \app\models\Kosar::findOne($id) ?: new \App\Models\Kosar();
?>

<form data-ajax-form data-action="/admin-api/edit?class=Kosar&id=<?=$id?>" data-redirect-url="(current)">
    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Fizetés státusza',
        'name' => 'fizetve',
        'value' => $model->fizetve,
        'values' => [
            0 => 'Nincs fizetve',
            1 => 'Fizetve',
            2 => 'Visszatérítve'
        ],
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

