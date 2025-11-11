<div data-selected-menu="9.11"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Országok' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Országok',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_country', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Orszag::class,
    'columns' => ['nev'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_country' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Orszag' ],
    ]
])?>

