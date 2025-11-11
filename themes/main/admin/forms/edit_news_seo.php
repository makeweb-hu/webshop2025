<div data-selected-menu="6.10"></div>

<?php
$model = \app\models\Hir::findOne($id) ?: new \app\models\Hir();
$tab = 'seo';
?>

<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'Blog' => '/admin/news',
        $model->cim => '/admin/edit-news?id=' . $id,
        'SEO' => '#',
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => $model->cim,

])?>

<?=\app\components\Helpers::render('ui/tabs', [
    'tabs' => [
        '' => ['title'=>'Tartalom','url'=>'/admin/edit-news?id=' . $id],
        'seo' => ['title'=>'SEO', 'url'=>'/admin/edit-news-seo?id=' . $id],
    ],
    'active' => $tab,
]);?>

<br>
<?=\app\components\Helpers::render('forms/edit_meta', [
    'id' => $model->oldal_id,
])?>
