<div data-selected-menu="9.9"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'URL-ek' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'URL-ek',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_meta', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Oldal::class,
    'columns' => ['url', 'tipus'],
    'filter' => function ($query) {
        return $query->orderBy("(tipus <> 'fooldal'), id DESC");
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_meta' ],
        // [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Fizetes' ],
    ]
])?>


