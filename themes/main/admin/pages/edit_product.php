<div data-selected-menu="2.1"></div>

<?php
$model = \app\models\Termek::findOne($id) ?: new \App\Models\Termek();
if ($model->isNewRecord) {
    $model->afa = 27;
}

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

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Termékek' => '/admin/products',
        ($model->nev ?: 'Új termék') => '#'
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev ?: 'Új termék'),
    'no_margin' => !$model->isNewRecord,
    'actions' => [

    ]
])?>


<?php if (!$model->isNewRecord): ?>
    <?=\app\components\Helpers::render('ui/tabs', [
        'tabs' => $tabs,
        'active' => 'first'
    ]);?>

    <br>
<?php endif; ?>


<form data-ajax-form data-action="/admin-api/edit?class=Termek&id=<?=$id?>" data-redirect-url="/admin/products">


    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-4">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'nev',
                'label' => 'Név',
                'type' => 'text',
                'value' => $model->nev,
            ])?>
        </div>
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'cikkszam',
                'tooltip' => 'Üresen hagyva a rendszer generálja automatikusan.',
                'label' => 'Cikkszám',
                'type' => 'text',
                'placeholder' => 'Opcionális',
                'value' => $model->cikkszam,
            ])?>
        </div>
    </div>


    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Státusz',
        'name' => 'statusz',
        'value' => $model->isNewRecord ? 1 : ($model->statusz ?: 0),
    ])?>

    <?=\app\components\Helpers::render('ui/lookup', [
        'name' => 'kategoria_id',
        'label' => 'Kategória',
        'value' => $model->kategoria_id,
        'class' => \app\models\Kategoria::class,
        'attrs' => ['nev'],
        'except' => [],
        'column' => 'full_name',
    ])?>

    <?=\app\components\Helpers::render('ui/textarea', [
        'name' => 'rovid_leiras',
        'label' => 'Rövid leírás',
        'type' => 'text',
        'rows' => 2,
        'value' => $model->rovid_leiras,
    ])?>


    <?=\app\components\Helpers::render('ui/summernote', [
        'name' => 'leiras',
        'label' => 'Hosszú leírás',
        'type' => 'text',
        'value' => $model->leiras,
    ])?>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Fő termékfotó',
        'name' => 'foto_id',
        'value' => $model->foto_id ?? '',
    ])?>

    <div style="display: flex;" class="more-product-photos">
        <?=\app\components\Helpers::render('ui/file', [
                // 'label' => 'Fotó 1',
                'name' => 'foto_1',
                'value' => $model->foto_1 ?? '',
                'tiny' => true,
            ])?>
        <?=\app\components\Helpers::render('ui/file', [
            // 'label' => 'Fotó 1',
            'name' => 'foto_2',
            'value' => $model->foto_2 ?? '',
            'tiny' => true,
        ])?>
        <?=\app\components\Helpers::render('ui/file', [
            // 'label' => 'Fotó 1',
            'name' => 'foto_3',
            'value' => $model->foto_3 ?? '',
            'tiny' => true,
        ])?>
        <?=\app\components\Helpers::render('ui/file', [
            // 'label' => 'Fotó 1',
            'name' => 'foto_4',
            'value' => $model->foto_4 ?? '',
            'tiny' => true,
        ])?>
        <?=\app\components\Helpers::render('ui/file', [
            // 'label' => 'Fotó 1',
            'name' => 'foto_5',
            'value' => $model->foto_5 ?? '',
            'tiny' => true,
        ])?>
        <?=\app\components\Helpers::render('ui/file', [
            // 'label' => 'Fotó 1',
            'name' => 'foto_6',
            'value' => $model->foto_6 ?? '',
            'tiny' => true,
        ])?>
    </div>


    <div class="pb-3 border-b border-gray-200 mt-8 mb-8">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Termék ára
        </h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">
            Adja meg a termék árát, akár akciót is bevezethet!
        </p>
    </div>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-2">
        <?=\app\components\Helpers::render('ui/input', [
            'name' => 'ar',
            'label' => 'Ár',
            'icon' => 'Ft',
            'type' => 'text',
            'value' => $model->ar,
        ])?>
        </div>
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'afa',
                'label' => 'ÁFA',
                'icon' => '<i class="fa-solid fa-percent"></i>',
                'type' => 'text',
                'value' => $model->afa,
            ])?>
        </div>
    </div>

    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Akciós',
        'name' => 'akcios',
        'value' => $model->akcios ?: 0,
    ])?>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0" data-visible-if="akcios:1" style="display: none;">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/select', [
                'label' => 'Akció típusa',
                'name' => 'akcio_tipusa',
                'value' => $model->akcio_tipusa ?: 'szazalek',
                'values' => [
                        'szazalek' => 'Százalék',
                    'fix_ar' => 'Fix ár',
                ]
            ])?>
        </div>
        <div class="sm:col-span-2" data-visible-if="akcio_tipusa:szazalek" style="display: none;">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'akcio_szazalek',
                'label' => 'Akció százaléka',
                'icon' => '<i class="fa-solid fa-percent"></i>',
                'type' => 'text',
                'value' => $model->akcio_szazalek,
            ])?>
        </div>
        <div class="sm:col-span-2" data-visible-if="akcio_tipusa:fix_ar" style="display: none;">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'akcios_ar',
                'label' => 'Akciós ár',
                'icon' => 'Ft',
                'type' => 'text',
                'value' => $model->akcios_ar,
            ])?>
        </div>
    </div>


    <?php if (!$model->isNewRecord): ?>
    <div class="pb-3 border-b border-gray-200 mt-8 mb-8">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Ajánlott egyéb termékek
        </h3>
    </div>

    <?=\app\components\Helpers::render('ui/entities', [
        //'name' => 'options',
        'view' => 'forms/edit_recommended_product',
        'overflow' => true,
        'class' => \app\models\TermekAjanlo::class,
        'columns' => ['fancy_name'],
        'no_edit' => true,
        // 'forceReload' => true,
        'value' => $model->getRecommendedProductIds(),
        'params' => ['product_id' => $model->getPrimaryKey()],
        'headless' => false,
        //'max' => 1,
    ])?>
    <?php endif; ?>

    <div class="pb-3 border-b border-gray-200 mt-8 mb-8">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Készlet információ
        </h3>
        <p class="mt-2 max-w-4xl text-sm text-gray-500">
            Hány darab van a termékből készleten?
        </p>
    </div>


    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'keszlet',
                'label' => 'Készlet',
                //'icon' => '<small>db</small>',
                'type' => 'text',
                'value' => $model->keszlet,
            ])?>

        </div>
        <div class="sm:col-span-4">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'keszlet_info',
                'label' => 'Készlet infó',
                'type' => 'text',
                'value' => $model->keszlet_info,
            ])?>
        </div>
    </div>


    <div style="width: 150px;">

        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'egyseg_id',
            'label' => 'Mennyiségi egység',
            'value' => $model->egyseg_id ?: 1,
            'values' => \app\models\Egyseg::allForSelect(),
        ])?>

    </div>

    <br>

    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Újdonság',
        'name' => 'ujdonsag',
        'value' => $model->ujdonsag ?: 0,
    ])?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>


