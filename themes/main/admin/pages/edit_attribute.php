<div data-selected-menu="2.3"></div>

<?php
$model = \app\models\Tulajdonsag::findOne($id) ?: new \App\Models\Tulajdonsag();

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tulajdonságok' => '/admin/attributes',
        ($model->nev ?: 'Új tulajdonság') => '#'
    ]
])?>


<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev ?: 'Új tulajdonság'),
    'no_margin' => !$model->isNewRecord,
    'actions' => [

    ]
])?>


<form data-ajax-form data-action="/admin-api/edit?class=Tulajdonsag&id=<?=$id?>" data-redirect-url="/admin/attributes">


    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'nev',
        'label' => 'Név',
        'type' => 'text',
        'value' => $model->nev,
    ])?>

    <?php if ($model->isNewRecord): ?>
        <?=\app\components\Helpers::render('ui/toggle', [
            'name' => 'variaciokepzo',
            'label' => '<i class="fa-solid fa-bolt"></i> Variációképző',
            'type' => 'text',
            'value' => $model->variaciokepzo ?: 0,
        ])?>
    <?php else: ?>
        <input type="hidden" name="variaciokepzo" value="<?=$model->variaciokepzo ?: 0?>">
    <?php endif; ?>

    <?php if (!$model->variaciokepzo): ?>

        <div data-visible-if="variaciokepzo:0">
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'ertek_tipus',
            'label' => 'Típus',
            'type' => 'text',
            'values' => \app\models\Tulajdonsag::dataTypesForSelect(),
            'value' => $model->ertek_tipus,
        ])?>
        </div>

    <?php else: ?>

        <input type="hidden" name="ertek_tipus" value="<?=$model->ertek_tipus?>">

    <?php endif; ?>

    <div data-visible-if="ertek_tipus:select,multiselect|variaciokepzo:1" style="display: none">
    <?=\app\components\Helpers::render('ui/entities', [
        'name' => 'options',
        'view' => 'forms/edit_option',
        'label' => 'Válaszlehetőségek',
        'class' => \app\models\TulajdonsagOpcio::class,
        'columns' => ['ertek'],
        'value' => $model->optionIds(),
        'headless' => true,
        //'max' => 1,
    ])?>
    </div>

    <?=\app\components\Helpers::render('ui/toggle', [
        'name' => 'lathato',
        'label' => 'Látható',
        'type' => 'text',
        'value' => $model->isNewRecord ? 1 : ($model->lathato ?: 0),
    ])?>

    <?=\app\components\Helpers::render('ui/toggle', [
        'name' => 'szurheto',
        'label' => 'Szűrhető',
        'type' => 'text',
        'value' => $model->szurheto ?: 0,
    ])?>

    <?=\app\components\Helpers::render('ui/toggle', [
        'name' => 'kotelezo',
        'label' => 'Kötelező',
        'type' => 'text',
        'value' => $model->kotelezo ?: 0,
    ])?>


    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>


