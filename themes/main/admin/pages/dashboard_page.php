
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Dashboard' => '/admin/dashboard',
        ($model->nev_hu) => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev_hu),
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_dashboard_card', 'icon'=>'add', 'title' => 'Új kártya', 'data' => ['dashboard_id' => $model->id]],
        ['type' => 'modal', 'view' => 'forms/edit_dashboard', 'icon'=>'edit', 'title' => 'Szerkesztés', 'id'=>$model->id],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\DashboardKartya::class,
    'columns' => [ 'szin', 'tipus', 'cim', 'kep', 'alkartyak'],
    'filter' => function ($query) use ($model) {
        return $query->where(['szulo_dashboard' => $model->id])->andWhere('szulo_kartya is NULL')->orderBy('sorrend ASC, id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_dashboard_card' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=DashboardKartya' ],
    ]
])?>

