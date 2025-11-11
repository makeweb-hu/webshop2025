<div data-selected-menu="5.1"></div>

<?php
$tab = Yii::$app->request->get('tab', '');
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Rendelések' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Rendelések',
    'actions' => [
       // ['type' => 'modal', 'view' => 'forms/edit_message', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Összes','url'=>'/admin/orders'],
        'nincs_teljesitve' => ['title'=>'Új rendelés', 'url'=>'/admin/orders?tab=nincs_teljesitve'],
        'adatok_modositva' => ['title'=>'Adatok módosítva', 'url' => '/admin/orders?tab=adatok_modositva'],
        'atveheto' => ['title'=>'Átvehető', 'url' => '/admin/orders?tab=atveheto'],
        'kiszallitas_alatt' => ['title'=>'Kiszállítás alatt', 'url' => '/admin/orders?tab=kiszallitas_alatt'],
        'teljesitve' => ['title'=>'Teljesítve', 'url' => '/admin/orders?tab=teljesitve'],
        'elvetve' => ['title'=>'Törölve', 'url' => '/admin/orders?tab=elvetve'],
    ],
    'active' => $tab
]);?>

<br>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kosar::class,
    'columns' => ['rendelesszam_fancy', 'idopont', 'customer', 'status', 'total'],
    'search' => function ($query, $q) {
        return $query->andFilterWhere([
            'or',
            ['like', 'kosar.rendelesszam', $q],
            ['like', 'kosar.nev', $q],
            ['like', 'kosar.email', $q],
            ['like', 'kosar.telefonszam', $q],
        ]);
    },
    'filter' => function ($query) use ($tab) {
        if ($tab) {
            $query = $query->leftJoin('cim', 'cim.id = kosar.szallitasi_cim_id');
            return $query->andFilterWhere(['kosar.megrendelve' => 1, 'statusz' => $tab])->orderBy('cim.id DESC');
        } else {
            $query = $query->leftJoin('cim', 'cim.id = kosar.szallitasi_cim_id');
            return $query->andFilterWhere(['kosar.megrendelve' => 1])->orderBy('cim.id DESC');
        }
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/order' ],
    ]
])?>

