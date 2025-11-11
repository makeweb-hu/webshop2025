<?php
$tab = Yii::$app->request->get('tab', '');
?>

<div data-selected-menu="9.1"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Felhasználók' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Felhasználók',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_user', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>


<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összes','url'=>'/admin/users'],
        'superadmin' => ['title'=>'Szuperadmin', 'url'=>'/admin/users?tab=superadmin'],
        'admin' => ['title'=>'Admin', 'url' => '/admin/users?tab=admin'],
        'moderator' => ['title'=>'Moderator', 'url' => '/admin/users?tab=moderator'],
    ],
    'active' => $tab
]);?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Felhasznalo::class,
    'columns' => ['fancy_name', 'email', 'jogosultsag', 'twofactor'],
    'filter' => function ($query) use ($tab) {
        if ($tab) {
            return $query->where(['jogosultsag' => $tab]);
        }
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/user' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_user' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Felhasznalo' ],
    ]
])?>

