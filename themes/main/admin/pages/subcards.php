
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Dashboard' => '/admin/dashboard',
        ($model->parentDashboard->nev_hu) => '/admin/dashboard-page?id=' . $model->szulo_dashboard,
        'Alkártyák' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Alkártyák',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_dashboard_card', 'icon'=>'add', 'title' => 'Új alkártya', 'data' => ['dashboard_id' => $model->parentDashboard->id,'card_id'=>$model->id]],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\DashboardKartya::class,
    'columns' => ['cim', 'kep'],
    'filter' => function ($query) use ($model) {
        return $query->where(['szulo_kartya' => $model->id])->orderBy('sorrend ASC, id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_dashboard_card' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=DashboardKartya' ],
    ]
])?>

