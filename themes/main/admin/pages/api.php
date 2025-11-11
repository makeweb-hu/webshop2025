
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'API napló' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'API napló',
    'actions' => [

    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\ApiNaplo::class,
    'columns' => ['method', 'url','response_status','idopont'],
    'filter' => function ($query) {
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'view', 'title' => 'Részletek', 'view' => 'forms/edit_api' ],
    ]
])?>

