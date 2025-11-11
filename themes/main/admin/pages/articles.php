
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tudástár' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Tudástár',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_article', 'icon'=>'add', 'title' => 'Új hozzáadása'],
        ['type' => 'link', 'url' => '/admin-api/excel-export?type=articles', 'icon'=>'<i class="fa-sharp fa-regular fa-download"></i>', 'title' => 'Exportálás', 'target' => '_blank'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Tudastar::class,
    'columns' => ['kep', 'nev_hu', 'kategoria', 'fejezetek', 'statusz'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/article' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_article' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Tudastar' ],
    ]
])?>

