<div data-selected-menu="9.0"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Általános beállítások' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Általános beállítások',
    'actions' => [

    ]
])?>



<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Domainnév',
        'name' => 'domain',
        'value' => $model->domain,
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Központi e-mail cím',
        'name' => 'kozponti_email',
        'value' => $model->kozponti_email,
    ])?>


    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Központi telefonszám',
        'name' => 'kozponti_telefonszam',
        'value' => $model->kozponti_telefonszam,
    ])?>

    <?=\app\components\Helpers::render('ui/entity', [
        'label' => 'Cégadatok',
        'name' => 'ceg_cim_id',
        'value' => $model->ceg_cim_id,
        'class' => \app\models\Cim::class,
        'view' => 'forms/edit_address',
        'no_delete' => true,
        'columns' => ['full_address_with_name'],
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Facebook oldal',
        'name' => 'facebook_oldal',
        'value' => $model->facebook_oldal,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>
