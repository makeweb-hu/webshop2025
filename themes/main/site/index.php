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

$posts = \app\models\Hir::find()->where(['and', ['=', 'statusz', 'publikalva']])
    ->orderBy('publikalas_datuma DESC')->limit(3)->all();

$products = \app\models\Termek::find()->orderBy('RAND() ASC')->limit(10)->all();
?>


<div id="homepage-slider">
    <div class="container">
        <img class="left-slide" src="/img/dragcards/slider/sample-2.png" alt="Dragcards" />
        <img class="right-slide" src="/img/dragcards/slider/sample-3.png" alt="Dragcards" />
        <div class="box">
            <video  src="/img/dragcards/slider/video.mp4" autoplay loop muted poster="/img/dragcards/slider/sample-1.png"></video>
            <span class="play">
                    <img src="/img/dragcards/slider/play.svg" alt="Dragcards" />
                </span>
            <div class="title-row">
                <div class="left">
                    Egy kártya.<br/>
                    Végtelen lehetőség.
                </div>
                <div class="right">
                    <a href="/kartyak">Megvásárolom</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="homepage-logo-slider">
    <div class="logos">
        <div class="logos-content">
            <?php for ($i = 0; $i <= 8; $i += 1): ?>
                <img src="/img/dragcards/slider/logo-1.png" alt="Dragcards" />
                <img src="/img/dragcards/slider/logo-2.png" alt="Dragcards" />
                <img src="/img/dragcards/slider/logo-3.png" alt="Dragcards" />
                <img src="/img/dragcards/slider/logo-4.png" alt="Dragcards" />
                <img src="/img/dragcards/slider/logo-5.png" alt="Dragcards" />
                <img src="/img/dragcards/slider/logo-6.png" alt="Dragcards" />
            <?php endfor; ?>
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

<div id="homepage-products">
    <div class="container">
        <div class="items-and-arrows" data-scroller-container>
            <h2 class="title">
                    <span class="left">
                        Termékek neked
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
            <div class="columns" data-scroller data-gap="30" data-breakpoints="{&quot;800&quot;:3,&quot;512&quot;:2}" data-default="4">
                <?php foreach ($products as $product): ?>
                    <?=Yii::$app->controller->renderPartial('@app/themes/main/site/_product', [
                            'model' => $product,
                    ])?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div id="homepage-faq">
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
            <?php foreach ($posts as $post): ?>

                <?=Yii::$app->controller->renderPartial('_blog_post', [
                    'model' => $post,
                ])?>

            <?php endforeach; ?>
        </div>
    </div>
</div>

<?=Yii::$app->controller->renderPartial('@app/themes/main/site/_ratings')?>







<?php if (Yii::$app->request->get('password_reset_token')): ?>

    <?php
    $isValid = false;
    $customer = \app\models\Vasarlo::findOne(['jelszo_beallito_token' => Yii::$app->request->get('password_reset_token')]);
    if ($customer && (time() - strtotime($customer->jelszo_beallito_token_idopont)) < 60*10) {
        $isValid = true;
    }
    ?>

    <?php if ($isValid): ?>
        <div class="modal-window shown" data-set-password-modal>
            <div class="modal-bg" data-close-modal></div>
            <div class="modal-window-content">
                <div class="modal-box">
                    <div class="modal-box-header">
                        <div class="modal-title">Jelszó beállítása</div>
                        <div class="modal-close" data-close-modal>
                            <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                        </div>
                    </div>
                    <div class="modal-box-content">
                        <form  data-ajax-form data-action="/api/set-password">
                            <input type="hidden" name="password_reset_token" value="<?=Yii::$app->request->get('password_reset_token')?>" />
                            <div class="input-row fancy-placeholder">
                                <label>Új jelszó</label>
                                <div class="input-box">
                                    <input type="password" placeholder="Új jelszó" name="password" />
                                </div>
                                <div class="error-message">Kötelező kitölteni!</div>
                            </div>
                            <div class="input-row fancy-placeholder">
                                <label>Új jelszó ismét</label>
                                <div class="input-box">
                                    <input type="password"  placeholder="Új jelszó ismét" name="password_repeat" placeholder="" />
                                </div>
                                <div class="error-message">Kötelező kitölteni!</div>
                            </div>
                            <div class="modal-button-row">
                                <button type="submit">Mentés</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>

        <div class="modal-window shown" data-expired-reset-password-modal>
            <div class="modal-bg" data-close-modal></div>
            <div class="modal-window-content">
                <div class="modal-box">
                    <div class="modal-box-header">
                        <div class="modal-title">Lejárt link</div>
                        <div class="modal-close" data-close-modal>
                            <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                        </div>
                    </div>
                    <div class="modal-box-content">
                        <div class="modal-instructions">
                            Sajnos ezzel a linkkel már nem tudsz jelszót változtatni. Kattints az alábbi gombra, hogy ismét megpróbáld!
                        </div>
                        <form>
                            <div class="modal-button-row">
                                <button type="button" data-close-modal data-show-forgot-password-modal>Megpróbálom újra</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endif; ?>

