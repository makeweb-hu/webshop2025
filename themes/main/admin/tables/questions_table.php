<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kérdőívek' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Kérdőívek',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_question', 'icon'=>'add', 'title' => 'Új hozzáadása'],
        ['type' => 'link', 'url' => '/admin-api/excel-export?type=questions', 'icon'=>'<i class="fa-sharp fa-regular fa-download"></i>', 'title' => 'Exportálás', 'target' => '_blank'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kerdoiv::class,
    'columns' => ['cim_hu', 'questions'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/question' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_question' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Felhasznalo' ],
    ]
])?>

