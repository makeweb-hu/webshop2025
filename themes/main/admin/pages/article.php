
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tudástár' => '/admin/articles',
        ($model->nev_hu) => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev_hu),
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_chapter', 'icon'=>'add', 'title' => 'Új fejezet', 'data' => ['article_id' => $model->id]],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\TudastarFejezet::class,
    'columns' => ['nev_hu'],
    'filter' => function ($query) use ($model) {
        return $query->where(['tudastar_id' => $model->id]);
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/chapter' ],
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_chapter' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=TudastarFejezet' ],
    ]
])?>

