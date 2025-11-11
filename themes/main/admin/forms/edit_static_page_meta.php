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

<?php if (!$model->isNewRecord): ?>
    <?=\app\components\Helpers::render('ui/tabs', [
        'tabs' => [
            'first' => ['title'=>'Oldal adatai','url'=>'/admin/edit-static-page?id='.$model->getPrimaryKey()],
            'second' => ['title'=>'Meta', 'url'=>'/admin/edit-category-meta?id='.$model->getPrimaryKey()],
        ],
        'active' => 'second'
    ]);?>

    <br>
<?php endif; ?>

<?=\app\components\Helpers::render('forms/edit_meta', [
    'id' => $model->oldal_id,
])?>