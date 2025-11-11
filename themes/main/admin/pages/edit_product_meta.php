<?php
$model = \app\models\Termek::findOne($id) ?: new \App\Models\Termek();

$tabs = [
    'first' => ['title'=>'Termék adatai','url'=>'/admin/edit-product?id='.$model->getPrimaryKey()],
];

$hasVariations = $model->hasRealVariations();

$tabs['third'] = ['title'=>'Tulajdonságok','url'=>'/admin/edit-product-attributes?id='.$model->getPrimaryKey()];

if ($hasVariations) {
    $tabs['variations'] = ['title'=>'Variációk', 'badge' => count($model->variations), 'url'=>'/admin/edit-product-variations?id='.$model->getPrimaryKey()];
}

$tabs['second'] = ['title'=>'Meta', 'url'=>'/admin/edit-product-meta?id='.$model->getPrimaryKey()];


?>

    <div data-selected-menu="2.1"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Termékek' => '/admin/products',
        ($model->nev) => '#'
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev),
    'no_margin' => true,
    'actions' => [

    ]
])?>

<?php if (!$model->isNewRecord): ?>
    <?=\app\components\Helpers::render('ui/tabs', [
        'tabs' => $tabs,
        'active' => 'second'
    ]);?>

    <br>
<?php endif; ?>

<?=\app\components\Helpers::render('forms/edit_meta', [
    'id' => $model->oldal_id,
])?>