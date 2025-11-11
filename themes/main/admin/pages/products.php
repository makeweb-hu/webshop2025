<?php
$tab = Yii::$app->request->get('tab', '');
?>

<div data-selected-menu="2.1"></div>


<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Termékek' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Termékek',
    'actions' => [
        ['type' => 'link', 'url' => '/admin/edit-product', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összes','url'=>'/admin/products'],
        'active' => ['title'=>'Aktív', 'url'=>'/admin/products?tab=active'],
        'inactive' => ['title'=>'Inaktív', 'url' => '/admin/products?tab=inactive'],
        'sale' => ['title'=>'Akciós', 'url' => '/admin/products?tab=sale'],
        'outofstock' => ['title'=>'Nincs készleten', 'url' => '/admin/products?tab=outofstock'],
    ],
    'active' => $tab,
]);?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Termek::class,
    'columns' => ['fancy_name', 'cikkszam', 'kategoria', 'ar', 'statusz', 'keszlet'],
    'search' => function ($query, $q) {
        return $query->andFilterWhere(['or',
            ['like', 'nev', $q],
            ['like', 'cikkszam', $q],
        ]);
    },
    'filter' => function ($query) use ($tab) {
        if (!$tab) {
            return $query->orderBy('id DESC');
        } else if ($tab === "sale") {
            return $query->andFilterWhere(['>', 'akcios_ar', 0])->orderBy('id DESC');
        } else if ($tab === 'outofstock') {
            return $query->andFilterWhere(['and', ['=', 'keszlet', 0], ['=', 'statusz', 1]])->orderBy('id DESC');
        } else if ($tab === 'active') {
            return $query->andFilterWhere(['=', 'statusz', 1])->orderBy('id DESC');
        } else {
            return $query->andFilterWhere(['=', 'statusz', 0])->orderBy('id DESC');
        }
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'edit', 'title' => 'Szerkeszt', 'url' => '/admin/edit-product' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Termek' ],
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/view-product', 'target' => '_blank'  ],
    ]
])?>

