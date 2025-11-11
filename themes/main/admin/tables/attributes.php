<div data-selected-menu="2.3"></div>

<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tulajdonságok' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Tulajdonságok',
    'actions' => [
        ['type' => 'link', 'url' => '/admin/edit-attribute', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összes','url'=>'/admin/attributes'],
        'variation' => ['title'=>'Variációképző', 'url'=>'/admin/attributes?tab=variation'],
        'other' => ['title'=>'Egyéb', 'url' => '/admin/attributes?tab=other'],
    ],
    'active' => $tab
]);?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Tulajdonsag::class,
    'columns' => ['nev', 'type', 'products'],
    'filter' => function ($query) use ($tab) {
        if ($tab === 'variation') {
            return $query->where(['variaciokepzo' => 1]);
        } else if ($tab === 'other') {
            return $query->where(['variaciokepzo' => 0]);
        }
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'edit', 'title' => 'Szerkeszt', 'url' => '/admin/edit-attribute' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Tulajdonsag' ],
    ]
])?>


