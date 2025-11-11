<?php
$model = \app\models\Kapcsolat::findOne($id);
$model->megtekintve = 1;
$model->save(false);
?>

<div data-selected-menu="15"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kapcsolat' => '/admin/contact',
        ('Kapcsolat #' . $model->id) => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => '<span class="flex items-center">' . ('Kapcsolat  #' . $model->id)  . '</span>',
    'actions' => [

    ]
])?>

<?=\app\components\Helpers::render('ui/fields', [

    'columns' => ['idopont', 'nev', 'email', 'telefonszam'],

    'model' => $model
]);?>

<br><br>

<div class="pb-2 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        <i class="fa-regular fa-envelope"></i> Üzenet
    </h3>
</div>


<div class="mt-8 text-sm">
    <?=$model->uzenet?>
</div>