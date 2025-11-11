<div data-selected-menu="6.6"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'E-mailek' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'E-mailek',
    'actions' => [

    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\EmailSablon::class,
    'columns' => ['nev'],
    'filter' => function ($query) use ($tab) {
        if ($tab) {
            return $query->where(['jogosultsag' => $tab]);
        }
        return $query;
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Előnézet', 'url' => '/admin/email-template-preview' ],
        [ 'type' => 'link', 'icon' =>'edit', 'title' => 'Szerkeszt', 'url' => '/admin/edit-email-template' ],
        // [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Felhasznalo' ],
    ]
])?>

