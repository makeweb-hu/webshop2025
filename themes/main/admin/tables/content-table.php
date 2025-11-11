<?php
$schama = \app\models\Tartalom::getContentSchemaByType($type);
$hash = substr(sha1($type), 0, 8);

$columns = array_slice(array_keys($schama), 0, 4);
?>

<div data-selected-menu="6.<?=$hash?>"></div>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        ($type) => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($type),
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_content', 'icon'=>'add', 'title' => 'Új hozzáadása', 'data' => ['schema' =>$type]],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Tartalom::class,
    'columns' => $columns,
    'filter' => function ($query) use ($type) {
        return $query
            ->andFilterWhere(['tipus' => $type])
            ->orderBy('sorrend ASC, id ASC');
    },
    'wrap_columns' => $columns,
    /*
    'search' => function ($query, $q) {
        return $query->andFilterWhere([
            'or',
            ['like', 'nev', $q],
        ]);
    },
    */
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_content', 'icon'=>'edit', 'title' => 'Szerkeszt', 'data' => ['schema' =>$type]],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete-content' ],
    ]
])?>


