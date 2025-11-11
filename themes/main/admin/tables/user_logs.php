<div data-selected-menu="9.2"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tevékenység napló' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Tevékenység napló',

])?>


<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\FelhasznaloNaplo::class,
    'columns' => ['fancy_name', 'tipus', 'leiras', 'letrehozva'],
    'filter' => function ($query){
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [
            'type' =>'modal',
            'title' => 'Részletek',
            'icon' => 'info',
            'view' => 'forms/user_log_info'
        ]
    ]
])?>
