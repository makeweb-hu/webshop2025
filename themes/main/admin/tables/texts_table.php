<?php
/* TODO: tabok kategóriák szerint */
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Szövegrészek' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Szövegrészek',
    'actions' => [
        ['type' => 'link', 'url' => '/admin-api/excel-export?type=texts', 'icon'=>'<i class="fa-sharp fa-regular fa-download"></i>', 'title' => 'Exportálás', 'target' => '_blank'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\StatikusSzoveg::class,
    'columns' => ['nev'],
    'filter' => function ($query) {
        return $query->orderBy('id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_text' ],
    ]
])?>

