<?php
$actionId = Yii::$app->controller->action->uniqueId;
$metaRenderer = new \app\components\MetaRenderer($actionId);

$pages = \app\models\StatikusOldal::find()->where(['megjelenes'=>'fejlec'])->all();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?=$metaRenderer->render()?>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Dragcards" />
    <link rel="manifest" href="/favicons/site.webmanifest" />

    <!-- Style -->
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--
    <link rel="stylesheet" href="/css/tailwind.css">
    -->
    <link rel="stylesheet" href="/css/dragcards.css?v=<?=sha1_file('css/dragcards.css')?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
</head>
<body>
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$isScrolled = $path!=='/';

?>
<header class="<?=$isScrolled?'scrolled':''?>">
    <div class="container">
        <div class="menu">
            <div class="hamburger-menu">
                <img src="/img/dragcards/header/hamburger.svg" alt="Dragcards" />
            </div>
            <div class="logo">
                <a href="/">
                    <img class="dark-logo" src="/img/dragcards/logo/logo-color-dark.svg" alt="Dragcards" />
                    <img class="white-logo" src="/img/dragcards/logo/logo-color-white.svg" alt="Dragcards" />
                </a>
            </div>
            <div class="menu-items">
                <span class="menu-item" data-has-product-submenu>
                    <span class="caption">Termékek</span>
                </span>
                <span class="menu-item" data-has-submenu>
                    <span class="caption">Információ</span>
                    <div class="submenu">
                        <img src="/img/dragcards/header-dropdown/corner-left.svg" class="corner-left" />
                        <img src="/img/dragcards/header-dropdown/corner-right.svg" class="corner-right" />

                        <?php foreach ($pages as $page): ?>

                                <div class="submenu-item"><a href="<?=$page->url?>"><?=$page->cim?></a></div>

                        <?php endforeach; ?>

                        <div class="submenu-item"><a href="/site/blog">Blog</a></div>
                         <div class="submenu-item"><a href="/site/faq">GYIK</a></div>
                    </div>
                </span>
                <span class="menu-item">
                    <a class="caption" href="/site/contact">Kapcsolat</a>
                </span>
            </div>
            <div class="icons">
                <span class="icon" data-show-login-modal>
                    <?php if (\app\models\Vasarlo::current()): ?>
                        <img src="/img/dragcards/header/profile-2.svg" alt="" />
                    <?php else: ?>
                    <img src="/img/dragcards/header/profile.svg" alt="" />
                    <?php endif; ?>
                </span>
                <span class="icon" data-show-cart>
                    <img src="/img/dragcards/header/cart.svg" alt="" />
                    <span class="nr" data-nr-of-cart-items style="display: none;">2</span>
                </span>
            </div>

            <div class="product-submenu ">
                <img src="/img/dragcards/header-dropdown/corner-left.svg" class="corner-left" />
                <img src="/img/dragcards/header-dropdown/corner-right.svg" class="corner-right" />
                <div class="columns">
                    <div class="column">
                        <a href="/kartyak">
                            <div class="card">
                                <div class="image">
                                    <img src="/img/dragcards/prod-menu-1.png" alt="Dragcards" />
                                </div>
                                <div class="title">
                                    <span class="text">Kártyák</span>
                                    <span class="arrow">
                                                <img src="/img/dragcards/header-dropdown/arrow.svg" alt="Dragcards" />
                                            </span>
                                </div>
                                <div class="desc">
                                    Megnézem a termékeket
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="column">
                        <a href="/tablak">
                            <div class="card">
                                <div class="image">
                                    <img src="/img/dragcards/prod-menu-2.png" alt="Dragcards" />
                                </div>
                                <div class="title">
                                    <span class="text">Táblák</span>
                                    <span class="arrow">
                                                <img src="/img/dragcards/header-dropdown/arrow.svg" alt="Dragcards" />
                                            </span>
                                </div>
                                <div class="desc">
                                    Megnézem a termékeket
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="column">
                        <a href="/csomagok">
                            <div class="card">
                                <div class="image">
                                    <img src="/img/dragcards/prod-menu-3.png" alt="Dragcards" />
                                </div>
                                <div class="title">
                                    <span class="text">Csomagok</span>
                                    <span class="arrow">
                                                <img src="/img/dragcards/header-dropdown/arrow.svg" alt="Dragcards" />
                                            </span>
                                </div>
                                <div class="desc">
                                    Megnézem a termékeket
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mobile-menu">

                    <?php foreach ($pages as $page): ?>
                        <a href="<?=$page->url?>"><?=$page->cim?></a>
                    <?php endforeach; ?>

                    <a href="/site/blog">Blog</a>
                    <a href="/site/faq">GYIK</a>
                    <a href="/site/contact">Kapcsolat</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="submenu-fade"></div>

<?=$content?>
<footer>
    <div class="light-section">
        <div class="container">
            <div class="columns">
                <div class="column">
                    <div class="icon">
                        <img src="/img/dragcards/footer-top/users.svg" alt="Dragcards" />
                    </div>
                    <div class="text">
                        <div class="title">Kapcsolódj bárki felé</div>
                        <div class="desc">Elég, ha csak az egyik félnek van Dragcards kártyája – a kapcsolatfelvétel máris elindulhat.</div>
                    </div>
                </div>

                <div class="column">
                    <div class="icon">
                        <img src="/img/dragcards/footer-top/phone.svg" alt="Dragcards" />
                    </div>
                    <div class="text">
                        <div class="title">Nincs szükség applikációra</div>
                        <div class="desc">Egyszerűen böngészőn keresztül megoszthatod az elérhetőségeidet.</div>
                    </div>
                </div>

                <div class="column">
                    <div class="icon">
                        <img src="/img/dragcards/footer-top/platforms.svg" alt="Dragcards" />
                    </div>
                    <div class="text">
                        <div class="title">Működik minden telefonnal</div>
                        <div class="desc">Teljes kompatibilitás iOS és Android készülékekkel.</div>
                    </div>
                </div>

                <div class="column">
                    <div class="icon">
                        <img src="/img/dragcards/footer-top/customize.svg" alt="Dragcards" />
                    </div>
                    <div class="text">
                        <div class="title">Teljes testreszabhatóság</div>
                        <div class="desc">Válaszd ki a stílust, színeket és adatokat – a kártyád pont olyan lesz, amilyenre szükséged van.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="dark-section">
        <div class="container">
            <div class="columns">
                <div class="column first-column">
                    <div class="logo-row">
                        <a href="/"><img src="/img/dragcards/logo/logo-white.svg" alt="Dragcards" /></a>
                    </div>
                    <form data-ajax-form data-action="/subscribe" class="newsletter">
                        <div class="title">
                            Ne maradj le semmiről!<br/>
                            Iratkozz fel!
                        </div>
                        <div class="input-box">
                            <input type="text" placeholder="E-mail címed" />
                            <button class="btn" type="submit">OK</button>
                        </div>
                        <label class="gdpr">
                            <span class="checkbox">
                                <input type="checkbox" />
                            </span>
                            <span class="text">
                                Elolvastam és elfogadom az <a href="/adatkezelesi-tajekoztato" target="_blank">Adatkezelési tájékoztató</a>
                                tartalmát.
                            </span>
                        </label>
                    </form>
                </div>
                <div class="column second-column">
                    <div class="section-title">Termékek</div>
                    <div class="section">
                        <div class="menu-item">
                            <a href="/kartyak">Kártyák</a>
                        </div>
                        <div class="menu-item">
                            <a href="/tablak">Táblák</a>
                        </div>
                        <div class="menu-item">
                            <a href="/csomagok">Csomagok</a>
                        </div>
                    </div>

                    <div class="section-title">Információ</div>
                    <div class="section">
                        <?php foreach ($pages as $page): ?>
                            <div class="menu-item">
                                <a href="<?=$page->url?>"><?=$page->cim?></a>
                            </div>
                        <?php endforeach; ?>

                        <div class="menu-item">
                            <a href="/site/blog">Blog</a>
                        </div>

                        <div class="menu-item">
                            <a href="/site/faq">GYIK</a>
                        </div>

                        <div class="menu-item">
                            <a href="/site/contact">Kapcsolat</a>
                        </div>
                    </div>
                </div>
                <div class="column third-column">
                    <div class="section-title">Kapcsolat</div>
                    <div class="menu-item-with-caption">
                        <div class="caption">Értékesítés:</div>
                        <a href="tel:+36707701841">+36 70 770 1841</a>
                    </div>
                    <div class="menu-item-with-caption">
                        <div class="caption">Technikai segítség:</div>
                        <a href="tel:+36706112000">+36 70 611 2000</a>
                    </div>
                    <div class="menu-item-with-caption">
                        <div class="caption">Ügyfélszolgálat:</div>
                        <a href="mailto:info@dragcards.com">info@dragcards.com</a>
                    </div>
                    <div class="menu-item-with-caption">
                        <div class="caption">Cím:</div>
                        <a href="https://www.google.com/maps/place/netnyomda.hu/@47.9568254,21.6714455,17z/data=!3m1!4b1!4m6!3m5!1s0x47389f8f12e18cdf:0x7a6e8078c227441a!8m2!3d47.9568218!4d21.6740204!16s%2Fg%2F11g7_7ccgc?entry=ttu&g_ep=EgoyMDI1MTAxNC4wIKXMDSoASAFQAw%3D%3D" target="_blank">4400 Nyíregyháza,<br/>
                            Tiszavasvári út 40.</a>
                    </div>
                </div>
            </div>
            <div class="social-icons">
                <a href="https://www.instagram.com/dragcards/" target="_blank" class="icon">
                    <img src="/img/dragcards/footer/insta.svg" alt="Dragcards" />
                </a>
                <a href="https://www.youtube.com/@dragcards6436" target="_blank" class="icon">
                    <img src="/img/dragcards/footer/yt.svg" alt="Dragcards" />
                </a>
                <a href="https://www.tiktok.com/@dragcardseu" target="_blank" class="icon">
                    <img src="/img/dragcards/footer/tiktok.svg" alt="Dragcards" />
                </a>
                <!--
                <a href="#" class="icon">
                    <img src="/img/dragcards/footer/pinterest.svg" alt="Dragcards" />
                </a>
                <a href="#" class="icon">
                    <img src="/img/dragcards/footer/linkedin.svg" alt="Dragcards" />
                </a>
                -->
                <a href="https://www.facebook.com/dragcards" target="_blank" class="icon">
                    <img src="/img/dragcards/footer/fb.svg" alt="Dragcards" />
                </a>
            </div>
            <div class="copyright-row">
                <div class="left">
                    &copy; 2025 Dragcards.eu
                </div>
                <div class="right">
                    <img src="/img/dragcards/footer/stripe.svg" class="stripe" />
                    <img src="/img/dragcards/footer/cards.svg" class="cards" />
                </div>
            </div>
            <div class="info-row">
                <a href="/altalanos-szerzodesi-feltetelek" class="info-item">Általános szerződési feltételek</a>
                <a href="/adatkezelesi-tajekoztato" class="info-item">Adatkezelési tájékoztató</a>
                <a href="/impresszum" class="info-item">Impresszum</a>
            </div>
        </div>
    </div>
</footer>

<?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_cookie_consent')?>
<?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_login')?>
<?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_signup')?>
<?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_forgot_pass')?>

<script src="/js/jquery-3.2.1.min.js"></script>
<script src="https://hammerjs.github.io/dist/hammer.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
<script src="/js/dragcards.js?v=<?=sha1_file('js/dragcards.js')?>"></script>
</body>
</html>
