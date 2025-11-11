<?php
$tab = Yii::$app->request->get('tab', '');
?>

<div data-selected-menu="6.10"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Blog' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Blog',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_news_category', 'icon'=>'<i class="fa-regular fa-circle-plus"></i>',
            'title' => 'Kategória létrehozása', 'id' => '', 'data' => []],
    ]
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        'a' => ['title'=>'Cikkek','url'=>'/admin/news', 'icon' => '<i class="fa-regular fa-newspaper"></i>'],
        'b' => ['title'=>'Kategóriák','url'=>'/admin/news-categories', 'icon' => '<i class="fa-regular fa-tags"></i>'],
    ],
    'active' => 'b',
    'style' => 'big',
]);?>
<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\HirKategoria::class,
    'columns' => ['nev_hu', 'hirek'],
    'filter' => function ($query) {
        return $query->orderBy('nev_hu ASC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/redirect-to-news-category', "target" => '_blank' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_news_category' ],
        [ 'type' => 'modal', 'icon' =>'<i class="fa-sharp fa-solid fa-folder-magnifying-glass"></i>', 'title' => 'SEO', 'view' => 'forms/edit_news_category_seo' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=HirKategoria' ],
    ]
])?>

