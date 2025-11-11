<?php
/* TODO: tabok kategóriák szerint */
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Ütemezett üzenetek' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Ütemezett üzenetek',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_schedule', 'icon'=>'add', 'title' => 'Új hozzáadása'],
        ['type' => 'link', 'url' => '/admin-api/excel-export?type=schedule', 'icon'=>'<i class="fa-sharp fa-regular fa-download"></i>', 'title' => 'Exportálás', 'target' => '_blank'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\UtemezettUzenet::class,
    'columns' => ['cim_hu', 'leiras_hu', 'link_type'],
    'filter' => function ($query) {
        return $query->orderBy('id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_schedule' ],
    ]
])?>

