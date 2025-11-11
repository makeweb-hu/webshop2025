<div data-selected-menu="6.8"></div>


<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Ajánló' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Ajánló',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_slider', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Slider::class,
    'columns' => ['cim'],
    'filter' => function ($query) {
        return $query->orderBy('sorrend ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_slider' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Slider' ],
    ]
])?>


