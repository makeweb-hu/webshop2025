<div data-selected-menu="5.1"></div>

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

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kosar::class,
    'columns' => ['rendelesszam', 'idopont', 'customer', 'status', 'total'],
    'search' => function ($query, $q) {
        return $query->andFilterWhere([
            'or',
            ['like', 'kosar.rendelesszam', $q],
            ['like', 'kosar.nev', $q],
            ['like', 'kosar.email', $q],
            ['like', 'kosar.telefonszam', $q],
        ]);
    },
    'filter' => function ($query) {
        $query = $query->leftJoin('cim', 'cim.id = kosar.szallitasi_cim_id');
        return $query->andFilterWhere(['kosar.megrendelve' => 1])->orderBy('cim.id DESC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/order' ],
    ]
])?>

