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
        'active' => 'second'
    ]);?>

    <br>
<?php endif; ?>

<?=\app\components\Helpers::render('forms/edit_meta', [
    'id' => $model->oldal_id,
])?>