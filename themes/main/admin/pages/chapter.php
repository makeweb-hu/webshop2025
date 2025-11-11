
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Tudástár' => '/admin/articles',
        ($model->article->nev_hu) => '/admin/article?id=' . $model->article->id,
        ($model->nev_hu) => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev_hu),
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_chapter_section', 'icon'=>'add', 'title' => 'Új szekció', 'data' => ['chapter_id' => $model->id]],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\TudastarSzekcio::class,
    'columns' => ['tipus', 'tartalom'],
    'filter' => function ($query) use ($model) {
        return $query->where(['fejezet_id' => $model->id])->orderBy('sorrend ASC, id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_chapter_section' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=TudastarSzekcio' ],
    ]
])?>

