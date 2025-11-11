<div data-selected-menu="15"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kapcsolat' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Kapcsolat',
    'actions' => [

    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kapcsolat::class,
    'columns' => ['nev', 'email', 'telefonszam', 'idopont'],
    'filter' => function ($query) {
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/contact-page' ],
    ]
])?>


