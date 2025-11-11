
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Üzenetek' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Üzenetek',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_message', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Uzenet::class,
    'columns' => ['nev_hu','tipus','push_uzenet','cimzettek', 'idopont'],
    'filter' => function ($query) {
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/message' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_message' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Uzenet' ],
    ]
])?>

