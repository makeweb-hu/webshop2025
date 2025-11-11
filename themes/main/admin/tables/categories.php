<div data-selected-menu="2.2"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kategóriák' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Kategóriák',
    'actions' => [
        ['type' => 'link', 'url' => '/admin/edit-category', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kategoria::class,
    'columns' => ['fancy_name', 'products'],
    'filter' => function ($query) {
        return $query->orderBy('sorrend ASC');
    },
    'search' => function ($query, $q) {
        return $query->andFilterWhere([
            'or',
            ['like', 'nev', $q],
        ]);
    },
    'nopagination' => true,
    'actions' => [
        [ 'type' => 'link', 'icon' =>'edit', 'title' => 'Szerkeszt', 'url' => '/admin/edit-category' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Kategoria' ],
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/view-category', 'target' => '_blank'  ],
    ]
])?>


