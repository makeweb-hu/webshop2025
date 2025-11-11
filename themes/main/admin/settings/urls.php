<div data-selected-menu="9.9"></div>

<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'URL-ek' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'URL-ek',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_meta', 'icon'=>'add', 'title' => 'Átirányítás hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összes','url'=>'/admin/settings-urls'],
        'termek' => ['title'=>'Termék', 'url'=>'/admin/settings-urls?tab=termek'],
        'kategoria' => ['title'=>'Kategoria', 'url' => '/admin/settings-urls?tab=kategoria'],
        'statikus_oldal' => ['title'=>'Statikus oldal', 'url' => '/admin/settings-urls?tab=statikus_oldal'],
        'atiranyitas' => ['title'=>'Átirányítás', 'url' => '/admin/settings-urls?tab=atiranyitas'],
    ],
    'active' => $tab
]);?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Oldal::class,
    'columns' => ['url', 'tipus'],
    'filter' => function ($query) use ($tab) {
        if ($tab) {
            return $query->andFilterWhere(['tipus'=>$tab])->orderBy("(tipus <> 'fooldal'), id DESC");
        } else {
            return $query->orderBy("(tipus <> 'fooldal'), id DESC");
        }
    },
    'search' => function ($query, $q) {
        return $query->andFilterWhere(['or',
            ['like', 'url', $q],
        ]);
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Metaadatokg', 'view' => 'forms/edit_meta' ],
        // [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Fizetes' ],
    ]
])?>


