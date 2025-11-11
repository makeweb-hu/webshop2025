
<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Üzenetek' => '/admin/messages',
        ($model->nev_hu) => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->nev_hu),
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_message', 'icon'=>'edit', 'title' => 'Szerkesztés', 'id' => $model->id],
    ]
])?>
<?=\app\components\Helpers::render('ui/fields', [
    'title' => 'Üzenet adatai',
    'columns' => ['nev_hu', 'tipus','push_uzenet','link', 'idopont', 'cimzettek', 'tartalom_hu'],
    'tooltips' => [
        'twofactor' => 'Kétfaktoros hitelesítés'
    ],
    'model' => $model
]);?>

<br><br>

<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        <i class="fa-light fa-users"></i> Címzettek
    </h3>
</div>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\UzenetCimzett::class,
    'columns' => ['mid','megtekintve','push_elkuldve'],
    'filter' => function ($query) use ($model) {
        return $query->where(['uzenet_id' => $model->id])->orderBy('id DESC');
    },
    'actions' => [
    ]
])?>

