<div data-selected-menu="9.13"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'E-mail sablon' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'E-mail sablon',
    'actions' => [

    ]
])?>



<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Logó',
        'name' => 'email_logo_id',
        'value' => $model->email_logo_id,
    ])?>

    <?=\app\components\Helpers::render('ui/textarea', [
        'label' => 'Lábléc szöveg',
        'name' => 'email_lablec',
        'value' => $model->email_lablec,
    ])?>

    <?=\app\components\Helpers::render('ui/codemirror', [
        'label' => 'E-mail sablon: rendelés',
        'name' => 'email_sablon_rendeles',
        'value' => $model->email_sablon_rendeles,
    ])?>

    <?=\app\components\Helpers::render('ui/codemirror', [
        'label' => 'E-mail sablon: kapcsolat',
        'name' => 'email_sablon_kapcsolat',
        'value' => $model->email_sablon_kapcsolat,
    ])?>

    <?=\app\components\Helpers::render('ui/codemirror', [
        'label' => 'E-mail sablon: egyszerű',
        'name' => 'email_sablon_egyszeru',
        'value' => $model->email_sablon_egyszeru,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>
