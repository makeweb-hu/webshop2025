<div data-selected-menu="5.2"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Vásárlók' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Vásárlók',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_customer', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Vasarlo::class,
    'columns' => ['fancy_name', 'email', 'letrehozas_idopontja', 'nr_of_orders', 'spent'],
    'search' => function ($query, $q) {
        return $query->andFilterWhere(['or',
            ['like', 'nev', $q],
            ['like', 'email', $q],
            ['like', 'telefonszam', $q],
        ]);
    },
    'filter' => function ($query) {
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/customer' ],
    ]
])?>

