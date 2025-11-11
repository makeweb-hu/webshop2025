<div data-selected-menu="4.1"></div>


<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kuponok' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Kuponok',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_coupon', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kupon::class,
    'columns' => ['kod', 'discount', 'date', 'statusz', 'used'],
    'filter' => function ($query) use ($tab) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_coupon' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Kupon' ],
    ]
])?>


