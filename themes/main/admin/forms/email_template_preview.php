<div data-selected-menu="6.6"></div>

<?php
$model = \app\models\EmailSablon::findOne($id);
?>


<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'E-mailek' => '/admin/email-templates',
        ($model->nev) => '/admin/edit-email-template?id=' . $model->id,
    ]
])?>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => "'" . $model->nev . "' előnézete",
    'actions' => [
        ['type' => 'link', 'url' => '/admin/edit-email-template?id=' . $model->id, 'icon'=>'<i class="fa-regular fa-pen"></i>', 'title' => 'Szerkesztés'],
        ['type' => 'modal', 'view' => 'forms/template_test_email', 'icon'=>'<i class="fa-regular fa-envelope-circle-check"></i>', 'id' => $model->id,'title' => 'Teszt e-mail küldése', 'target' => '_blank'],
    ]
])?>

<iframe src="/admin/email-preview?id=<?=$model->id?>" style="width: 100%; height: 600px; border: 1px solid #ddd;" id="email_iframe"></iframe>

<script>
    $('#email_iframe').on('load', function(){
        this.style.height=(this.contentDocument.body.scrollHeight+20) +'px';
    });
</script>