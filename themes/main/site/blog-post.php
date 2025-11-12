<?php
$otherPosts = \app\models\Hir::find()->where(['and', ['=', 'statusz', 'publikalva'], ['<>', 'id', $model->id]])
    ->orderBy('publikalas_datuma DESC')->limit(3)->all();
?>

<div id="blog-post">
    <div class="blog-post-header">
        <div class="fade"></div>
        <div class="bg">
            <img src="<?=$model->photo->getUrl()?>" alt="Dragcards" />
        </div>
        <div class="header-content">
            <div class="container">
                <div class="date">
                    <div class="icon">
                        <img src="/img/dragcards/blog/calendar-white.svg" alt="Dragcards" />
                    </div>
                    <div class="text"><?=$model->publikalas_datuma?></div>
                </div>
                <h1 class="blog-post-title">
                    <?=$model->cim?>
                </h1>
            </div>
        </div>
    </div>
    <div class="blog-post-body">
        <div class="container">
            <?=$model->tartalom?>
        </div>
    </div>
</div>

<div id="recent-blog-posts">
    <div class="container">
        <div class="title-row">
            <div class="left">
                Legfrisebb hírek
            </div>
            <div class="right">
                <a href="/site/blog" class="btn">
                    <span class="text">Összes bejegyzés</span>
                    <span class="icon">
                        <img src="/img/dragcards/blog/arrow-right-blue.svg" alt="Dragcards" />
                    </span>
                </a>
            </div>
        </div>

        <div class="columns">
            <?php foreach ($otherPosts as $otherPost): ?>

                <?=Yii::$app->controller->renderPartial('_blog_post', [
                    'model' => $otherPost,
                ])?>

            <?php endforeach; ?>
        </div>
    </div>
</div>

