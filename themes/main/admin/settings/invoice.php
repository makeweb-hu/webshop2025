<div data-selected-menu="9.4"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Számlázás' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Számlázás',
    'actions' => [

    ]
])?>



<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>


    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Számlázz.hu APU kulcs',
        'name' => 'szamlazzhu_api_kulcs',
        'value' => $model->szamlazzhu_api_kulcs,
    ])?>


    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Számlázz.hu számla előtag',
        'name' => 'szamlazzhu_elotag',
        'value' => $model->szamlazzhu_elotag,
    ])?>


    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Számlázz.hu nyugta előtag',
        'name' => 'szamlazzhu_nyugta_elotag',
        'value' => $model->szamlazzhu_nyugta_elotag,
    ])?>

    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Számla típus',
        'name' => 'szamlazzhu_szamla_tipus',
        'value' => $model->szamlazzhu_szamla_tipus,
        'values' => [
                'elektronikus' => 'E-számla',
            'papir' => 'Papír alapú számla',
        ],
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Alapértelmezett ÁFA',
        'name' => 'afa',
        'icon' => '<i class="fa-solid fa-percent"></i>',
        'value' => $model->afa,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>
