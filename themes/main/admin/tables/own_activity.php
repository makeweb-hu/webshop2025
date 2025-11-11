<?php
$model = \app\models\Felhasznalo::current();
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Saját tevékenység' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Saját tevékenység',

])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\FelhasznaloNaplo::class,
    'columns' => [/*'fancy_name',*/ 'tipus', 'leiras', 'letrehozva'],
    'filter' => function ($query) use ($model) {
        return $query->where(['felhasznalo_id' => $model->id ])->orderBy('id DESC');
    },
    'actions' => [
        [
            'type' =>'modal',
            'title' => 'Részletek',
            'icon' => 'info',
            'view' => 'forms/user_log_info'
        ]
    ]
])?>
