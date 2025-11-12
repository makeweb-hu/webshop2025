<?php
$product_id = Yii::$app->request->get('product_id', '');
$product = \app\models\Termek::findOne($product_id);
?>

<div id="static-page">
    <div class="container">
        <h1 class="page-title">
            <?=$model->cim?>
        </h1>
        <div class="page-content">

            <?=$model->tartalom?>

        </div>
    </div>
</div>
