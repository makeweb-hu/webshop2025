<div data-selected-menu="9.7"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Szállítási módok' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Szállítási módok',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_shipping', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Szallitas::class,
    'columns' => ['nev', 'ar', 'statusz'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_shipping' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Szallitas' ],
    ]
])?>


