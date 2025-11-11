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
        ['type' => 'link', 'url' => '/admin/edit-news', 'icon'=>'<i class="fa-regular fa-circle-plus"></i>',
            'title' => 'Cikk létrehozása', 'id' => '', 'data' => []],
    ]
])?>


<br>


<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Hir::class,
    'columns' => ['fancy_name',  'statusz', 'kiemelt', 'publikalas_datuma'],
    'wrap' => ['fancy_name'],
    'filter' => function ($query) use ($tab) {
        if (strlen($tab) == 2) {
            return $query->where(['nyelv' => $tab])->orderBy('id DESC');
        } else if ($tab === 'kiemelt') {
            return $query->where(['kiemelt' => 1])->orderBy('id DESC');
        } else if ($tab === 'piszkozat') {
            return $query->where(['statusz' => 'piszkozat'])->orderBy('id DESC');
        }
        return $query->orderBy('id DESC');
    },
    'search' => function ($query, $q) {
        return $query->andFilterWhere([
                'or',
            ['like', 'cim', $q],
        ]);
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'tooltip' => 'Megtekint', 'url' => '/admin/redirect-to-news', "target" => '_blank' ],
        [ 'type' => 'link', 'icon' =>'edit', 'tooltip' => 'Szerkeszt', 'url' => '/admin/edit-news' ],
        // [ 'type' => 'link', 'icon' =>'<i class="fa-sharp fa-solid fa-folder-magnifying-glass"></i>', 'title' => 'SEO', 'url' => '/admin/edit-news-seo' ],
        [ 'type' => 'confirm', 'icon'=>'delete','tooltip' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Hir' ],
    ]
])?>

