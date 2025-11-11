<div data-selected-menu="6.1"></div>

<?php
$model = \app\models\StatikusOldal::findOne($id) ?: new \App\Models\StatikusOldal();

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Statikus oldalak' => '/admin/static-pages',
        ($model->cim ?: 'Új statikus oldal') => '#'
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->cim ?: 'Új statikus oldal'),
    'no_margin' => !$model->isNewRecord,
    'actions' => [

    ]
])?>

<?php if (!$model->isNewRecord && $model->page): ?>
    <?=\app\components\Helpers::render('ui/tabs', [
        'tabs' => [
            'first' => ['title'=>'Oldal adatai','url'=>'/admin/edit-category?id='.$model->getPrimaryKey()],
            'second' => ['title'=>'Meta', 'url'=>'/admin/edit-static-page-meta?id='.$model->getPrimaryKey()],
        ],
        'active' => 'first'
    ]);?>

    <br>
<?php endif; ?>

<form data-ajax-form data-action="/admin-api/edit?class=StatikusOldal&id=<?=$id?>" data-redirect-url="/admin/static-pages">

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'cim',
        'label' => 'Cím',
        'type' => 'text',
        'value' => $model->cim,
    ])?>

    <?=\app\components\Helpers::render('ui/select', [
        'name' => 'megjelenes',
        'label' => 'Megjelenés',
        'values' => [
            'sehol' => 'Sehol',
            'fejlec' => 'Fejlécben',
            'lablec' => 'Láblécben',
        ],
        'value' => $model->megjelenes ?: 'sehol',
    ])?>

    <?=\app\components\Helpers::render('ui/summernote', [
        'label' => 'Tartalom',
        'name' => 'tartalom',
        'value' => $model->tartalom ?? '',
    ])?>

    <div class="mt-2 flex justify-end" style="
        position: sticky;
    bottom: 0;
    background-color: #f3f4f6;
    padding-top: 15px;
    padding-bottom: 15px;
">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>


