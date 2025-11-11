<div data-selected-menu="4.2"></div>


<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Promóciók' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Promóciók',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_promotion', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Promocio::class,
    'columns' => ['discount', 'date', 'statusz'],
    'filter' => function ($query) use ($tab) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_promotion' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Promocio' ],
    ]
])?>


