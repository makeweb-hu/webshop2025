<?php
$model = \app\models\Termek::findOne($id) ?: new \App\Models\Termek();

$model->createOrUpdateVariationsFromAttributes();

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
        'active' => 'third'
    ]);?>

    <br>
<?php endif; ?>

<form data-ajax-form data-action="/admin-api/save-product-attributes?id=<?=$id?>" data-show-popup-on-success="Adatok sikeresen elmentve.">

    <?=\app\components\Helpers::render('ui/entities', [
        'name' => 'options',
        'view' => 'forms/edit_product_attribute',
        'overflow' => true,
        //'label' => 'Válaszlehetőségek',
        'class' => \app\models\TermekTulajdonsag::class,
        'columns' => ['attribute', 'value'],
        'no_edit' => true,
        'forceReload' => true,
        'value' => $model->getProductAttributeIds(),
        'params' => ['product_id' => $model->getPrimaryKey()],
        'headless' => false,
        //'max' => 1,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>
</form>
