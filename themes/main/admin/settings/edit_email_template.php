<div data-selected-menu="6.6"></div>

<?php
$model = \app\models\EmailSablon::findOne($id) ?: new \App\Models\EmailSablon();

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'E-mailek' => '/admin/email-templates',
        ($model->nev) => '/admin/email-template-preview?id=' . $model->id,
        'Szerkesztés' => '#',
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev),
    'no_margin' => !$model->isNewRecord,
    'actions' => [

    ]
])?>

<form data-ajax-form data-action="/admin-api/edit?class=EmailSablon&id=<?=$id?>" data-redirect-url="/admin/email-template-preview?id=<?=$model->getPrimaryKey()?>">

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'targy',
        'label' => 'Tárgy mező',
        'value' => $model->targy,
    ])?>


    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'cimsor',
        'label' => 'Címsor',
        'value' => $model->cimsor,
    ])?>

    <?=\app\components\Helpers::render('ui/summernote', [
        'label' => 'Tartalom',
        'name' => 'szoveg',
        'value' => $model->szoveg ?? '',
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


