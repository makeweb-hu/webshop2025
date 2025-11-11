<div data-selected-menu="6.9"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Blokkok' => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'Blokkok',
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Új hozzáadása', 'view' => 'forms/edit_text' ],
        // ['type' => 'link', 'url' => '/admin-api/excel-export?type=texts', 'icon'=>'<i class="fa-sharp fa-regular fa-download"></i>', 'title' => 'Exportálás', 'target' => '_blank'],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\StatikusSzoveg::class,
    'columns' => ['nev', 'tipus'],
    'search' => function ($query, $q) {
        return $query->andFilterWhere(['like', 'nev', $q]);
    },
    'filter' => function ($query) {
        return $query->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_text' ],
    ]
])?>

