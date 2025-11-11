<div data-selected-menu="2.2"></div>

<?php
$model = \app\models\Kategoria::findOne($id) ?: new \App\Models\Kategoria();
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kategóriák' => '/admin/categories',
        ($model->nev ?: 'Új kategória') => '#'
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev ?: 'Új kategória'),
    'no_margin' => !$model->isNewRecord,
    'actions' => [

    ]
])?>

<?php if (!$model->isNewRecord): ?>
<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        'first' => ['title'=>'Kategória adatai','url'=>'/admin/edit-category?id='.$model->getPrimaryKey()],
        'second' => ['title'=>'Meta', 'url'=>'/admin/edit-category-meta?id='.$model->getPrimaryKey()],
    ],
    'active' => 'first'
]);?>

    <br>
<?php endif; ?>

<form data-ajax-form data-action="/admin-api/edit?class=Kategoria&id=<?=$id?>" data-redirect-url="/admin/categories">

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'nev',
        'label' => 'Név',
        'type' => 'text',
        'value' => $model->nev,
    ])?>

    <?=\app\components\Helpers::render('ui/lookup', [
        'name' => 'szulo_id',
        'tooltip' => 'Üresen hagyva főkategória lesz.',
        'label' => 'Szülő kategória',
        'value' => $model->szulo_id,
        'class' => \app\models\Kategoria::class,
        'attrs' => ['nev'],
        'except' => $model->childrenExceptIds(),
        'column' => 'full_name',
    ])?>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Kategória fotó',
        'name' => 'foto_id',
        'value' => $model->foto_id ?? '',
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>


