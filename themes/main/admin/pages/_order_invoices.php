<div data-selected-menu="5.1"></div>


<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Szamla::class,
    'columns' => ['bizonylatszam', 'tipus', 'idopont'],
    'filter' => function ($query) use ($model) {
        return $query->where(['kosar_id' => $model->getPrimaryKey()])->orderBy('id DESC');
    },
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'fancybox' => true, 'url' => function ($id) {
            $model = \app\models\Szamla::findOne($id);
            return $model->getPdfUrl();
        } ],

        [ 'type' => 'modal', 'icon' =>'<i class="fa-solid fa-ban"></i>', 'title' => 'Sztornózás', 'view' => 'forms/cancel_invoice', 'show_if' => function ($id) {
            $model = \app\models\Szamla::findOne($id);
            return !$model->sztorno && !$model->isCancelled();
        } ],
    ]
])?>

