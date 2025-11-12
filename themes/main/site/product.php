<?php
$uj = $model->ujdonsag;

$category = $model->category;

$moreProducts = \app\models\Termek::find()->where(['and', ['=', 'kategoria_id', $model->kategoria_id], ['<>', 'id', $model->id]])
    ->limit(60)
    ->orderBy('id ASC')->all();

$variations = $model->variations;

$variation = \app\models\Variacio::findOne($variationId);

if (!$variation && count($variations) > 0) {
    $variation = $variations[0];
}

$photoUrl = $model->getThumbnail();
if ($variation) {
    $photoUrl = $variation->getThumbnail();
}
?>

<div id="product-page">
    <div class="container">
        <div class="product-main-section">
            <div class="left">
                <div class="photo-box">
                    <?php if ($uj): ?>
                        <div class="badge">Új termék</div>
                    <?php endif; ?>

                    <?php if ($regi_ar): ?>
                        <div class="badge">
                            <?=$percent?>%
                        </div>
                    <?php endif; ?>
                    <a href="<?=$photoUrl?>" data-fancybox>
                        <img src="<?=$photoUrl?>" alt="Dragcards" />
                    </a>
                </div>
                <div class="small-photos">
                    <div class="photo selected">
                        <img src="<?=$photoUrl?>" alt="Dragcards" />
                    </div>
                    <!--
                    <div class="photo">
                        <img src="/img/dragcards/product-list/prod-sample-2.png" alt="Dragcards" />
                    </div>
                    -->
                </div>
            </div>
            <div class="right">
                <div class="breadcrumbs">
                    <a href="/" class="item">
                        <img src="/img/dragcards/product-page/home.svg" alt="Dragcards" />
                    </a>
                    <span class="separator">/</span>
                    <a href="/termekek" class="item">Termékek</a>
                    <span class="separator">/</span>
                    <a href="<?=$category->url?>" class="item"><?=$category->nev?></a>
                </div>
                <h1 class="product-name">
                    <?=$model->nev?>
                    <?php if ($variation): ?>
                        - <?=$variation->optionsArray()[0]->ertek?>
                    <?php endif; ?>
                </h1>
                <div class="price-row">
                    <span class="current-price">
                        <?php if ($variation): ?>
                            <?=\app\components\Helpers::formatMoney($variation->currentPrice())?>
                        <?php else: ?>
                            <?=\app\components\Helpers::formatMoney($model->currentPrice())?>
                        <?php endif; ?>
                    </span>
                </div>
                <div class="short-description-row">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                </div>
                <div class="variations">
                    <?php foreach ($variations as $var): ?>
                    <a href="<?=$model->url?>?variation=<?=$var->id?>" class="variation <?=$var->id == $variation->id ? 'active': ''?>">
                        <?=$var->optionsArray()[0]->ertek?> változat
                    </a>
                    <?php endforeach; ?>
                </div>
                <div class="amount-and-cart">
                    <div class="amount">
                        <div class="minus">
                            <img src="/img/dragcards/product-page/chevron-left.svg" alt="Dragcards" />
                        </div>
                        <div class="nr">1</div>
                        <div class="plus">
                            <img src="/img/dragcards/product-page/chevron-right.svg" alt="Dragcards" />
                        </div>
                    </div>
                    <div class="add-to-cart">
                        <div class="btn" data-add-to-cart data-product-id="<?=$model->id?>" data-variation-id="<?=$variation?$variation->id:''?>">Kosárba rakom</div>
                    </div>
                </div>
                <div class="extra-boxes">
                    <div class="extra-box opened">
                        <div class="box-header">
                            <div class="icon">
                                <img src="/img/dragcards/product-page/percent.svg" alt="Dragcards" />
                            </div>
                            <div class="text">
                                Mennyiségi kedvezmény
                            </div>
                            <div class="close">
                                <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                            </div>
                        </div>
                        <div class="box-content">
                            1–4 kártya: 24 000 Ft / db<br/>
                            5–9 kártya: 22 600 Ft / db<br/>
                            10–24 kártya: 21 200 Ft / db<br/><br/>
                            25 vagy több kártya esetén kérje egyedi ajánlatunkat <a href="#">ide kattintva</a>.
                        </div>
                    </div>

                    <div class="extra-box">
                        <div class="box-header">
                            <div class="icon">
                                <img src="/img/dragcards/product-page/card.svg" alt="Dragcards" />
                            </div>
                            <div class="text">
                                Szállítás és fizetés
                            </div>
                            <div class="close">
                                <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                            </div>
                        </div>
                        <div class="box-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>

                    <div class="extra-box">
                        <div class="box-header">
                            <div class="icon">
                                <img src="/img/dragcards/product-page/person.svg" alt="Dragcards" />
                            </div>
                            <div class="text">
                                Kártya testreszabása
                            </div>
                            <div class="close">
                                <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                            </div>
                        </div>
                        <div class="box-content">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-description">
            <h2 class="title">Leírás</h2>
            <div class="description">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla facilisi. Integer eu feugiat orci. Vestibulum id nisl id felis pharetra tincidunt. Fusce porttitor, metus a tincidunt commodo, risus nisi sollicitudin urna, eget sollicitudin odio lectus vel orci. Sed malesuada ipsum non nibh imperdiet, vitae tincidunt nunc convallis.
                </p>
                <p>
                    Curabitur interdum elit eget orci hendrerit, sed imperdiet sapien gravida. Nunc id libero neque. Proin dignissim lectus in erat porta fringilla. Integer sit amet lobortis justo. Suspendisse et sapien lectus. Mauris consequat lectus id justo ultricies, vel fermentum justo mattis.
                </p>
            </div>
        </div>
    </div>
</div>


<div id="homepage-products">
    <div class="container">
        <div class="items-and-arrows" data-scroller-container>
            <h2 class="title">
                    <span class="left">
                        Inspirálódj!
                    </span>
                <span class="right">
                        <span class="arrow-left" data-scroll-prev>
                            <img src="/img/dragcards/homepage/arrow-left-blue.svg" alt="Dragcards" />
                        </span>
                        <span class="arrow-right" data-scroll-next>
                            <img src="/img/dragcards/homepage/arrow-right-blue.svg" alt="Dragcards" />
                        </span>
                    </span>
            </h2>
            <div class="columns" data-scroller data-gap="30" data-breakpoints="{&quot;800&quot;:2,&quot;512&quot;:1}" data-default="5">
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-1.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-1.png" alt="Dragcards" /></a>
                    </div>
                </div>
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-2.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-2.png" alt="Dragcards" /></a>
                    </div>
                </div>
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-3.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-3.png" alt="Dragcards" /></a>
                    </div>
                </div>
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-4.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-4.png" alt="Dragcards" /></a>
                    </div>
                </div>
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-1.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-1.png" alt="Dragcards" /></a>
                    </div>
                </div>
                <div class="column">
                    <div class="inspire-box">
                        <a href="/img/dragcards/product-page/inspire-2.png" data-fancybox="inspire"><img src="/img/dragcards/product-page/inspire-2.png" alt="Dragcards" /></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="product-learn-more">
    <div class="container">
        <h2 class="subtitle">Tudj meg többet!</h2>
        <div class="columns-and-arrows" data-scroller-container>
            <div class="arrow-left" data-scroll-prev>
                <img src="/img/dragcards/homepage/chevron-left-dark.svg" alt="Dragcards" />
            </div>
            <div class="arrow-right" data-scroll-next>
                <img src="/img/dragcards/homepage/chevron-right-dark.svg" alt="Dragcards" />
            </div>
            <div class="columns"  data-scroller data-gap="0" data-breakpoints="{&quot;800&quot;:1,&quot;512&quot;:1}" data-default="1">
                <div class="column">
                    <div class="content">
                        <div class="icon-row">
                            <div class="icon">
                                <img src="/img/dragcards/product-page/icon-sample-white.svg" alt="Dragcards" />
                            </div>
                        </div>
                        <div class="title-row">
                            Szerkesztő felület
                            minden <span class="color">DragCards</span>
                            felhasználónak
                        </div>
                        <div class="description-row">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                        </div>
                        <div class="button-row">
                            <a href="javascript:alert('A funkció nem elérhető.')">
                                További részletek
                                <img src="/img/dragcards/product-page/arrow-right-blue.svg" alt="Dragcards" />
                            </a>
                        </div>
                    </div>
                    <div class="photo">
                        <img src="/img/dragcards/product-page/learn-more-sample.png" alt="Dragcards" />
                    </div>
                </div>
                <div class="column with-left-photo">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/learn-more-sample.png" alt="Dragcards" />
                    </div>
                    <div class="content">
                        <div class="icon-row">
                            <div class="icon">
                                <img src="/img/dragcards/product-page/icon-sample-white.svg" alt="Dragcards" />
                            </div>
                        </div>
                        <div class="title-row">
                            Szerkeszthető cím
                            kép és elrendezés
                        </div>
                        <div class="description-row">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
                        </div>
                        <div class="button-row">
                            <a href="javascript:alert('A funkció nem elérhető.')">
                                További részletek
                                <img src="/img/dragcards/product-page/arrow-right-blue.svg" alt="Dragcards" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="homepage-how-it-works">
    <div class="container">
        <h2 class="title">Kiemelt funkciók</h2>
        <div class="columns-and-arrows" data-scroller-container>
            <div class="arrow-left" data-scroll-prev>
                <img src="/img/dragcards/homepage/chevron-left-dark.svg" alt="Dragcards" />
            </div>
            <div class="arrow-right" data-scroll-next>
                <img src="/img/dragcards/homepage/chevron-right-dark.svg" alt="Dragcards" />
            </div>
            <div class="columns" data-scroller data-gap="30" data-breakpoints="{&quot;900&quot;:3,&quot;600&quot;:2,&quot;450&quot;:1}" data-default="4">
                <div class="column">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/no-photo.svg" alt="Dragcards">
                    </div>
                    <div class="column-title">
                        Funkció neve
                    </div>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>

                <div class="column">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/no-photo.svg" alt="Dragcards">
                    </div>
                    <div class="column-title">
                        Még egy funkció neve
                    </div>
                    <div class="desc">
                        Labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut.
                    </div>
                </div>

                <div class="column">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/no-photo.svg" alt="Dragcards">
                    </div>
                    <div class="column-title">
                        Harmadik, legjobb
                        funkció neve
                    </div>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>

                <div class="column">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/no-photo.svg" alt="Dragcards">
                    </div>
                    <div class="column-title">
                        Negyedik funkció is van
                    </div>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>

                <div class="column">
                    <div class="photo">
                        <img src="/img/dragcards/product-page/no-photo.svg" alt="Dragcards">
                    </div>
                    <div class="column-title">
                        Nem más, mint az ötödik funkció
                    </div>
                    <div class="desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="homepage-products">
    <div class="container">
        <div class="items-and-arrows" data-scroller-container>
            <h2 class="title">
                    <span class="left">
                        Hasonló termékek
                    </span>
                <span class="right">
                        <span class="arrow-left" data-scroll-prev>
                            <img src="/img/dragcards/homepage/arrow-left-blue.svg" alt="Dragcards" />
                        </span>
                        <span class="arrow-right" data-scroll-next>
                            <img src="/img/dragcards/homepage/arrow-right-blue.svg" alt="Dragcards" />
                        </span>
                    </span>
            </h2>
            <div class="columns" data-scroller data-gap="30" data-breakpoints="{&quot;800&quot;:2,&quot;512&quot;:1}" data-default="4">
                <?php foreach ($moreProducts as $product): ?>

                    <?=Yii::$app->controller->renderPartial('_product', [
                        'model' => $product,
                    ])?>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="homepage-how-it-works">
    <div class="container">
        <h2 class="title">Hogyan működik?</h2>
        <div class="columns">
            <div class="column">
                <div class="photo">
                    <img src="/img/dragcards/homepage/how-it-works-1.png" alt="Dragcards" />
                </div>
                <div class="column-title">
                    <span class="blue">1. lépés: </span> Válassz egy terméket!
                </div>
                <div class="desc">
                    Válaszd ki a számodra legmegfelelőbb Dragcards terméket, attól függően, milyen mértékű testreszabást szeretnél.
                </div>
            </div>

            <div class="column">
                <div class="photo">
                    <img src="/img/dragcards/homepage/how-it-works-2.png" alt="Dragcards" />
                </div>
                <div class="column-title">
                    <span class="blue">2. lépés: </span> Építsd fel a profilodat!
                </div>
                <div class="desc">
                    Tedd lehetővé kapcsolataid számára, hogy jobban megismerjenek téged és a cégedet a profilod adatainak és megjelenésének szerkesztésével.
                </div>
            </div>

            <div class="column">
                <div class="photo">
                    <img src="/img/dragcards/homepage/how-it-works-3.png" alt="Dragcards" />
                </div>
                <div class="column-title">
                    <span class="blue">3. lépés: </span> Oszd meg és kapcsolódj!
                </div>
                <div class="desc">
                    Egyetlen érintéssel az okostelefonon a kapcsolatod azonnal hozzáfér minden információhoz, amit meg szeretnél osztani.
                </div>
            </div>
        </div>
    </div>
</div>


<div id="homepage-faq" class="gray">
    <div class="container">
        <div class="title-row">
            <div class="left">
                Gyakori kérdések
            </div>
            <div class="right">
                <a href="/site/faq" class="btn">
                    Összes kérdés
                </a>
            </div>
        </div>

        <div class="faq">
            <div class="q-and-a ">
                <div class="q">
                    <div class="text">Miért érdemes digitális kártyára váltani?</div>
                    <div class="plus">
                        <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                    </div>
                </div>
                <div class="a">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
            <div class="q-and-a">
                <div class="q">
                    <div class="text">Milyen technológiát használ a Dragcards?</div>
                    <div class="plus">
                        <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                    </div>
                </div>
                <div class="a">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
            <div class="q-and-a">
                <div class="q">
                    <div class="text">Mennyi idő alatt készül el egy Dragcards kártya?</div>
                    <div class="plus">
                        <img src="/img/dragcards/faq/plus.svg" alt="Dragcards" />
                    </div>
                </div>
                <div class="a">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-window " data-product-meta-modal="">
    <div class="modal-bg" data-close-modal=""></div>
    <div class="modal-window-content">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-title">Testreszabás</div>
                <div class="modal-close" data-close-modal="">
                    <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                </div>
            </div>
            <div class="modal-box-content">
                <form data-ajax-form="" data-action="/empty.json">
                    <?php foreach ($PRODUCT['meta'] as $meta): ?>

                        <?php if ($meta['type'] === 'checkbox'): ?>
                            <label class="input-row checkbox-row" style="background-color: #fff; padding: 12px; border-radius: 7px;">
                        <span class="checkbox">
                            <input type="checkbox" name="unique_graphics">
                        </span>
                                <span class="text" style="font-size: 100%">
                            Szeretnék egyedi grafikai tervezést
                                    <span style="background-color: #ddd; border-radius: 50px; font-size: 80%; padding: 2px 4px; font-weight: 700; color: #873CFF; ">+10 000 Ft</span>
                        </span>
                                <span class="error-message">Kötelező elfogadnia!</span>
                            </label>


                        <?php elseif ($meta['type'] === 'text' && !($meta['tab']??null)): ?>
                            <div class="input-row fancy-placeholder has-text">
                                <label><?=$meta['label']?></label>
                                <div class="input-box">
                                    <input type="text" name="email" <?=$meta['required']?'required':''?> placeholder="<?=$meta['label']?>">
                                </div>
                                <div class="error-message">Kötelező kitölteni!</div>
                                <?php if ($meta['help'] ?? null): ?>
                                    <div style="margin-top: 5px;">
                                        <small><?=$meta['help']?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    <?php endforeach; ?>

                    <?php if ($PRODUCT['id'] == 1 || $PRODUCT['id'] == 2 || $PRODUCT['id'] == 3): ?>


                        <div class="tabs" style="display: flex; align-items: stretch; border: 1px solid #d3d3d3; border-radius: 50px; margin-bottom: 20px;">
                            <div style="text-align: center; padding: 5px; width:100%; display:flex; border-right: 1px solid #d3d3d3;justify-content:center; align-items:center;cursor: pointer; font-weight: 700;" data-select-tab="a">
                                Általános
                            </div>
                            <div style="text-align: center; padding: 5px; width:100%; display:flex;border-right: 1px solid #d3d3d3; justify-content:center;align-items:center; cursor: pointer;"  data-select-tab="b">
                                Címadatok
                            </div>
                            <div style="text-align: center; padding: 5px; width:100%; display:flex; justify-content:center; align-items:center; cursor: pointer;"  data-select-tab="c">
                                Közösségi media
                            </div>
                        </div>

                        <?php foreach ($PRODUCT['meta'] as $meta): ?>

                            <?php if ($meta['type'] === 'text'): ?>
                                <div class="input-row fancy-placeholder has-text tab-visibility" style="display:none;" data-tab="<?=$meta['tab']?>">
                                    <label><?=$meta['label']?></label>
                                    <div class="input-box">
                                        <input type="text" name="email" <?=$meta['required']?'required':''?> placeholder="<?=$meta['label']?>">
                                    </div>
                                    <div class="error-message">Kötelező kitölteni!</div>
                                    <?php if ($meta['help'] ?? null): ?>
                                        <div style="margin-top: 5px;">
                                            <small><?=$meta['help']?></small>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>

                    <?php endif; ?>


                    <div class="modal-button-row">
                        <button type="submit" data-add-to-cart data-product-id="<?=$id?>">Mehet a kosárba</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?=Yii::$app->controller->renderPartial('@app/themes/main/site/_ratings')?>