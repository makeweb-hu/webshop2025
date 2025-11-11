<?php
$sliders = \app\models\Slider::find()->orderBy('sorrend ASC, id ASC')->all();

// 3 hétnel régebbi termékekről leveszi az új címkét
foreach (\app\models\Termek::find()->where([
        'and',
        ['=', 'ujdonsag', 1],
        ['<=', 'letrehozva', date('Y-m-d H:i:s', strtotime('-3 weeks'))],
])->all() as $prod) {
    //$prod->ujdonsag = 0;
    //$prod->save(false);
}

?>

<div id="slider">
    <div class="container">
        <?php foreach ($sliders as $index => $slider): ?>
        <div class="photo-box <?=$index==0?'shown':''?>" data-slide data-slide-index="<?=$index?>">
            <img src="<?=\app\models\Fajl::findOne($slider->kep_id)->getUrl()?>" />
            <div class="content-box">
                <div class="title"><?=$slider->cim?></div>
                <div class="description">
                    <?=$slider->leiras?>
                </div>
                <div class="button-row">
                    <a href="<?=$slider->link?>">Tovább</a>
                </div>
            </div>
            <div class="arrow left" data-change-slide-prev><img src="/img/slider-arrow-left.svg" /></div>
            <div class="arrow right" data-change-slide-next><img src="/img/slider-arrow-right.svg" /></div>
            <div class="dots">
                <?php for ($i = 0; $i < count($sliders); $i += 1): ?>
                <div class="dot <?=$i==$index?'active':''?>"  data-change-slide-nth data-index="<?=$i?>"></div>
                <?php endfor; ?>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
</div>


<div id="welcome">
    <div class="container">
        <h1><?=\app\models\StatikusSzoveg::get('Főcím')?></h1>
        <div class="content">
            <?=\app\models\StatikusSzoveg::getMultiline('Főcím alatti szöveg')?>
        </div>
    </div>
</div>

<div id="new-products">

    <div class="container">

        <div class="submenu">Akciók és újdonságok</div>
        <h2>Újdonságok</h2>

        <div class="products">

            <?php foreach (\app\models\Termek::find()->where(['statusz' => 1, 'ujdonsag' => 1])->limit(8)->all() as $prod): ?>
                <?=Yii::$app->controller->renderPartial('_product', ['model' => $prod])?>
            <?php endforeach; ?>

        </div>

    </div>

</div>