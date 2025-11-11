<div data-selected-menu="9.10"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Karbantartás' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Karbantartás',
    'actions' => [

    ]
])?>

<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>


    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Karbantartás alatt' ,
        'tooltip' => 'Bekapcsolva az oldal nem érhető el, csak bejelentkezett admin felhasználók számára.',
        'name' => 'karbantartas_alatt',
        'value' => $model->karbantartas_alatt,
    ])?>

        <?=\app\components\Helpers::render('ui/textarea', [
            'name' => 'karbantartas_szoveg',
            'label' => 'Karbantartás szöveg' ,
            'type' => 'text',
            'value' => $model->karbantartas_szoveg,
        ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>
