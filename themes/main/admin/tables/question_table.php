<?php
$tab = Yii::$app->request->get('tab', '');

?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Kérdőívek' => '/admin/questions',
        ($model->cim_hu) => '#'
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => ($model->cim_hu) ,
    'actions' => [
        ['type' => 'modal', 'view' => 'forms/edit_question_q', 'icon'=>'add', 'title' => 'Új kérdés hozzáadása', 'data' => ['parent_id' => $model->getPrimaryKey()]],
    ]
])?>

<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\KerdoivKerdes::class,
    'columns' => ['kerdes_hu', 'tipus'],
    'filter' => function ($query) use ($model) {
        return $query->where(['kerdoiv_id' => $model->getPrimaryKey()])->orderBy('sorrend ASC, id ASC');
    },
    'actions' => [
        [ 'type' => 'modal', 'icon' =>'edit', 'title' => 'Szerkeszt', 'view' => 'forms/edit_question_q' ],
        [ 'type' => 'confirm', 'icon'=>'delete','title' => 'Töröl', 'description' => "Biztos végre szeretné hajtani a műveletet?", 'url' => '/admin-api/delete?class=Felhasznalo' ],
    ]
])?>

