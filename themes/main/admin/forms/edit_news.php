<div data-selected-menu="6.10"></div>

<?php
$model = \app\models\Hir::findOne($id) ?: new \app\models\Hir();
$tab = '';
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Blog' => '/admin/news',
        $model->cim ?: 'Cikk létrehozása' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => $model->cim ?: 'Cikk létrehozása',

])?>

<?php if (!$model->isNewRecord): ?>
    <?=\app\components\Helpers::render('ui/tabs', [
        'tabs' => [
            '' => ['title'=>'Tartalom','url'=>'/admin/edit-news?id=' . $id],
            'seo' => ['title'=>'SEO', 'url'=>'/admin/edit-news-seo?id=' . $id],
        ],
        'active' => $tab,
    ]);?>
    <br>
<?php endif; ?>

<form data-ajax-form data-action="/admin-api/edit?class=Hir&id=<?=$id?>" data-redirect-url="/admin/news">

    <input type="hidden" name="nyelv" value="hu" />

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'cim',
        'label' => 'Cím',
        'type' => 'text',
        'value' => $model->cim,
    ])?>

    <?=\app\components\Helpers::render('ui/textarea', [
        'name' => 'bevezeto',
        'label' => 'Lead',
        'type' => 'text',
        'value' => $model->bevezeto,
        'rows' => 2,
    ])?>


    <?=\app\components\Helpers::render('ui/file', [
        'name' => 'kep_id',
        'label' => 'Kép',
        'type' => 'text',
        'value' => $model->kep_id,
    ])?>


    <div class="grid grid-cols-1 gap-y-8 gap-x-4 sm:grid-cols-8">
        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/select', [
                'name' => 'statusz',
                'label' => 'Státusz',
                'type' => 'text',
                'value' => $model->statusz ?: 'piszkozat',
                'values' => [
                    'piszkozat' => 'Piszkozat',
                    'publikalva' => 'Publikálva',
                    'inaktiv' => 'Inaktív',
                ]
            ])?>
        </div>

        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/date', [
                'name' => 'publikalas_datuma',
                'label' => 'Publikálás dátuma',
                'tooltip' => 'Jövőbeli dátum esetén a cikk időzítve lesz.',
                'type' => 'text',
                'value' => $model->publikalas_datuma,
            ])?>
        </div>

        <div class="sm:col-span-2">
            <?=\app\components\Helpers::render('ui/toggle', [
                'name' => 'kiemelt',
                'label' => 'Főoldali kiemelés',
                'tooltip' => 'Kerüljön-e főoldalra a hír?',
                'type' => 'text',
                'value' => $model->kiemelt ?: 0,
            ])?>
        </div>
    </div>

    <?=\app\components\Helpers::render('ui/summernote', [
        'label' => 'Tartalom',
        'name' => 'tartalom',
        'value' => $model->tartalom
    ])?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense" style="
        position: sticky;
    bottom: 0;
    background-color: #f3f4f6;
    padding-top: 15px;
    padding-bottom: 15px;
">
        <a href="/admin/news">
            <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                Mégse
            </button>
        </a>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>
