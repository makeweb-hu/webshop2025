<?php
$model = \app\models\ApiNaplo::findOne($id);
?>

<?=\app\components\Helpers::render('ui/fields', [
    'keyValues' => [
        'Method' => $model->method,
        'URL' => $model->url,
        'Payload' => $model->payload,
        'Response status' => $model->response_status,
        'Response body' => $model->response_body,
    ],
]);?>
