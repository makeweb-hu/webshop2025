<?php
$posts = \app\models\Hir::find()->where(['and', ['=', 'statusz', 'publikalva']])
    ->orderBy('publikalas_datuma DESC')->all();
?>


<div id="blog">
    <div class="container">
        <h1 class="page-title">Blog</h1>
        <div class="desc">
            Maradj naprakész a legújabb megjelenésekkel, funkciófrissítésekkel, Dragcards eseményekkel és ügyféltörténetekkel kapcsolatban!
        </div>
        <div class="columns">

            <?php foreach ($posts as $post): ?>

                <?=Yii::$app->controller->renderPartial('_blog_post', [
                    'model' => $post,
                ])?>

            <?php endforeach; ?>

        </div>

        <div class="pagination">
            <a href="#" class="prev">
                <span class="icon"><img src="/img/dragcards/pagination/arrow-left.svg" alt="Dragcards" /></span>
                <span class="text">Előző</span>
            </a>
            <a href="javascript:void(0)" class="page active">1</a>
            <!--
            <a href="#" class="page ">2</a>
            <a href="#" class="page ">3</a>
            -->
            <a href="javascript:void(0)" class="next">
                <span class="text">Következő</span>
                <span class="icon"><img src="/img/dragcards/pagination/arrow-right.svg" alt="Dragcards" /></span>
            </a>
        </div>
    </div>
</div>