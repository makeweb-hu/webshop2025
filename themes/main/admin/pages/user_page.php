<div data-selected-menu="9.1"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Felhasználók' => '/admin/users',
        $model->email => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => '<span class="flex items-center">' . $model->profileImg . $model->nev . '</span>',
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_user', 'icon'=>'edit', 'title' => 'Szerkesztés', 'id' => $model->id],
        ['type' => 'confirm', 'icon'=>'<i class="fa-regular fa-qrcode"></i>',
            'description'=>'Biztos resetelni szeretné a felhasználóhoz tartozó kétfaktoros hitelesítést?','title' => '2FA reset', 'id' => $model->id, 'url' => '/admin-api/reset-2fa'],
        ['type' => 'confirm', 'icon'=>'<i class="fa-regular fa-unlock"></i>',
            'description'=>'Biztos új jelszót szeretne generálni a felhasználóhoz?','title' => 'Jelszó reset', 'id' => $model->id, 'url' => '/admin-api/reset-password'],
    ]
])?>

<?=\app\components\Helpers::render('ui/fields', [
    'title' => 'Fiókadatok',
    'columns' => ['nev', 'email', 'jogosultsag', 'letrehozva', 'twofactor', 'ertesites'],
    'tooltips' => [
            'twofactor' => 'Kétfaktoros hitelesítés'
    ],
    'model' => $model
]);?>

    <br><br>

    <div class="pb-5 border-b border-gray-200">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            <i class="fa-regular fa-clock-rotate-left"></i> Tevékenység
        </h3>
    </div>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\FelhasznaloNaplo::class,
    'columns' => ['tipus', 'leiras', 'letrehozva'],
    'filter' => function ($query) use ($model) {
        return $query->where(['felhasznalo_id' => $model->id ])->orderBy('id DESC');
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
