<div data-selected-menu="6.1"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Statikus oldalak' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Statikus oldalak',
    'actions' => [
        ['type' => 'link', 'url' => '/admin/edit-static-page', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\StatikusOldal::class,
    'columns' => ['cim', 'link', 'statusz'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'edit', 'title' => 'Szerkeszt', 'url' => '/admin/edit-static-page' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=StatikusOldal' ],
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/view-static-page', 'target' => '_blank' ],
    ]
])?>

