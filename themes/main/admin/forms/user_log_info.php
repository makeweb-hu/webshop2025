<?php
$model = \app\models\FelhasznaloNaplo::findOne($id);
?>

<?=\app\components\Helpers::render('ui/fields', [
    'keyValues' => json_decode($model->parameterek, true),
]);?>
