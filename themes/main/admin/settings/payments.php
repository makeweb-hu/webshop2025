<div data-selected-menu="9.8"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Fizetési módok' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Fizetési módok',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_payment', 'icon'=>'add', 'title' => 'Új hozzáadása'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Fizetes::class,
    'columns' => ['nev', 'ar'],
    'filter' => function ($query) {
        return $query;
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_payment' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Fizetes' ],
    ]
])?>


