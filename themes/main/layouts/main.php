<?php
$actionId = Yii::$app->controller->action->uniqueId;
$metaRenderer = new \app\components\MetaRenderer($actionId);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <?=$metaRenderer->render()?>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <meta name="google-site-verification" content="dQnCmIZW1I-kVW1mLf7xlucFfVaAlOvo-n50XH8u8-I" />

    <!-- Style -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/css/tailwind.css">
    <link rel="stylesheet" href="/css/borago.css?v=<?=sha1_file('css/borago.css')?>">

    <script src="https://cdn.jsdelivr.net/npm/share-api-polyfill/dist/share-min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
</head>
<body>
<header>
    <div class="container">
        <div class="logo-row">
            <div class="logo">
                <a href="/">
                    <img src="/img/logo-header.svg" />
                </a>
            </div>
            <div class="search">
                <div class="search-box">
                    <img src="/img/search.svg" />
                    <div class="search-btn">Keres</div>
                    <input type="text" placeholder="Keresés az oldalunkon" data-global-search value="<?=trim(Yii::$app->request->get('q', ''))?>" />

                    <div class="search-results" data-global-search-results>

                        <a class="search-result" href="#">

                            <div class="photo">
                                <div class="photo-box">
                                    <img src="#" />
                                </div>
                            </div>
                            <div class="name">
                                Ez egy teszt termék..
                            </div>
                            <div class="price">
                                1 250 Ft
                            </div>

                        </a>

                        <div class="search-result">

                            <div class="photo">
                                <div class="photo-box">
                                    <img src="#" />
                                </div>
                            </div>
                            <div class="name">
                                Ez egy teszt termék..
                            </div>
                            <div class="price">
                                1 250 Ft
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="icons">
                <a href="#" class="icon cart" data-show-cart>
                    <img src="/img/cart.svg" />
                    <span class="nr" data-nr-of-cart-items><?=\app\models\Kosar::nr()?></span>
                </a>
                <a href="#" class="icon favorite" data-show-likes>
                    <img src="/img/favorite.svg" />
                    <span class="nr" data-nr-of-likes><?=\app\models\Kosar::nrOfLikes()?></span>
                </a>
                <a href="mailto:info@borago.hu" target="_blank" class="icon">
                    <img src="/img/email.svg" />
                </a>
                <a href="https://www.facebook.com/boragokerteszet" target="_blank" class="icon">
                    <img src="/img/facebook.svg" />
                </a>
            </div>
        </div>
        <div class="menu">
            <?php foreach (\app\models\Kategoria::find()->where('szulo_id is null')->orderBy('sorrend ASC')->all() as $mainCat): ?>

            <div class="menu-item <?=count($mainCat->children) > 0 ? 'has-submenu' : ''?>">
                <a href="<?=count($mainCat->children) == 0 ? $mainCat->getUrl() : 'javascript:void(0)'?>"><?=$mainCat->nev?></a>
                <?php if (count($mainCat->children) > 0): ?>
                    <img src="/img/menu-arrow.svg" class="arrow" />
                <?php endif; ?>
                <div class="submenu">
                    <?php foreach ($mainCat->children as $childCat): ?>
                    <div class="submenu-item">
                        <a href="<?=$childCat->getUrl()?>"><?=$childCat->nev?></a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php endforeach; ?>

            <div class="menu-item">
                <a href="/termekek?discounted=1">Akciók</a>
            </div>

            <div class="menu-item">
                <a href="/termekek?new=1">Újdonságok</a>
            </div>

            <?php foreach (\app\models\StatikusOldal::find()->where(['megjelenes' => 'fejlec'])->all() as $page): ?>
                <div class="menu-item">
                    <a href="/<?=$page->page->url?>"><?=$page->cim?></a>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</header>


<div data-cart  style="z-index: 50; transition: 0.3s; opacity: 0; visibility: hidden;" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">
        <!--
          Background overlay, show/hide based on slide-over state.

          Entering: "ease-in-out duration-500"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-500"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div data-close-cart class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <!--
              Slide-over panel, show/hide based on slide-over state.

              Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-full"
                To: "translate-x-0"
              Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-0"
                To: "translate-x-full"
            -->
            <div class="w-screen max-w-md" style="transform: translateX(100%); transition: 0.3s">
                <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                Kosár tartalma
                            </h2>
                            <div class="ml-3 h-7 flex items-center">
                                <button data-close-cart type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Close panel</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 divide-y divide-gray-200" data-cart-html>

                                    <?=Yii::$app->controller->renderPartial('_cart')?>
                                    <!-- More products... -->
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                        <div class="flex justify-between text-base font-medium text-gray-900">
                            <p>Összesen</p>
                            <p data-cart-total><?=\app\components\Helpers::formatMoney(\app\models\Kosar::current(true)->getItemsTotal())?></p>
                        </div>
                        <p class="mt-0.5 text-sm text-gray-500"></p>

                        <div class="mt-6" data-goto-checkout style="<?=\app\models\Kosar::nr() == 0 ? 'pointer-events:none;opacity:0.4':''?>">
                            <a href="/site/checkout" class="flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">Pénztárhoz</a>
                        </div>

                        <div class="mt-6 flex justify-center text-sm text-center text-gray-500">
                            <p>
                                <button type="button" class="text-indigo-600 font-medium hover:text-indigo-500" data-close-cart>Vásárlás folytatása<span aria-hidden="true"> &rarr;</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div data-likes  style="z-index: 50; transition: 0.3s; opacity: 0; visibility: hidden;" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="absolute inset-0 overflow-hidden">
        <!--
          Background overlay, show/hide based on slide-over state.


          Entering: "ease-in-out duration-500"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-500"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div data-close-likes class="absolute inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
            <!--
              Slide-over panel, show/hide based on slide-over state.

              Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-full"
                To: "translate-x-0"
              Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-0"
                To: "translate-x-full"
            -->
            <div class="w-screen max-w-md" style="transform: translateX(100%); transition: 0.3s">
                <div class="h-full flex flex-col bg-white shadow-xl overflow-y-scroll">
                    <div class="flex-1 py-6 overflow-y-auto px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                            <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                Kedvencek
                            </h2>
                            <div class="ml-3 h-7 flex items-center">
                                <button data-close-likes type="button" class="-m-2 p-2 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Close panel</span>
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-8">
                            <div class="flow-root">
                                <ul role="list" class="-my-6 divide-y divide-gray-200" data-likes-html>

                                    <?=Yii::$app->controller->renderPartial('_likes')?>

                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-6 px-4 sm:px-6">

                        <div class="flex justify-center text-sm text-center text-gray-500">
                            <p>
                                <button type="button" class="text-indigo-600 font-medium hover:text-indigo-500" data-close-likes>Vásárlás folytatása<span aria-hidden="true"> &rarr;</span></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=$content?>

<footer>
    <div class="container">
        <div class="news">
            <div class="column">
                <div class="photo">
                    <div class="photo-container">
                        <img src="/img/sample/news-1.jpg" />
                    </div>
                    <div class="inner-circle"></div>
                </div>
                <div class="text">
                    <div class="category">
                        <?=\app\models\StatikusSzoveg::get('Lábléc alcím 1')?>
                    </div>
                    <div class="title">
                        <?=\app\models\StatikusSzoveg::get('Lábléc cím 1')?>
                    </div>
                    <div class="description">
                        <?=\app\models\StatikusSzoveg::get('Lábléc leírás 1')?>
                    </div>
                    <div class="button-row">
                        <a href="<?=\app\models\StatikusSzoveg::get('Lábléc link 1')?>">Részletek</a>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="photo">
                    <div class="photo-container">
                        <img src="/img/sample/news-2.jpg" />
                    </div>
                    <div class="inner-circle"></div>
                </div>
                <div class="text">
                    <div class="category">
                        <?=\app\models\StatikusSzoveg::get('Lábléc alcím 2')?>
                    </div>
                    <div class="title">
                        <?=\app\models\StatikusSzoveg::get('Lábléc cím 2')?>
                    </div>
                    <div class="description">
                        <?=\app\models\StatikusSzoveg::get('Lábléc leírás 2')?>
                    </div>
                    <div class="button-row">
                        <a href="<?=\app\models\StatikusSzoveg::get('Lábléc link 2')?>">Részletek</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-footer">
            <div class="column logo">
                <a href="/">
                    <img src="/img/logo-footer.svg" />
                </a>
            </div>
            <div class="column">
                <div class="section-title">Menü</div>
                <?php foreach (\app\models\StatikusOldal::find()->where(['megjelenes' => 'fejlec'])->all() as $page): ?>
                    <div class="menu-item">
                        <a href="/<?=$page->page->url?>"><?=$page->cim?></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="column">
                <div class="section-title">Információ</div>
                <?php foreach (\app\models\StatikusOldal::find()->where(['megjelenes' => 'lablec'])->all() as $page): ?>
                <div class="menu-item">
                    <a href="/<?=$page->page->url?>"><?=$page->cim?></a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="column">
                <div class="section-title">Kapcsolat</div>
                <div class="menu-item with-icon">
                    <a href="tel:<?=\app\models\Beallitasok::get('kozponti_telefonszam')?>">
                        <img src="/img/phone.svg" />
                        <span class="text">Telefon: <?=\app\models\Beallitasok::get('kozponti_telefonszam')?></span>
                    </a>
                </div>
                <div class="menu-item with-icon">
                    <a href="mailto:<?=\app\models\Beallitasok::get('kozponti_email')?>">
                        <img src="/img/email.svg" />
                        <span class="text">E-mail: <?=\app\models\Beallitasok::get('kozponti_email')?></span>
                    </a>
                </div>
                <?php if (\app\models\Beallitasok::get('ceg_cim_id')): ?>
                <div class="menu-item with-icon">
                    <a href="https://www.google.com/maps/dir/?api=1&destination=<?=urlencode(\app\models\Cim::findOne(\app\models\Beallitasok::get('ceg_cim_id'))->toString())?>" target="_blank">
                        <img src="/img/address.svg" />
                        <span class="text">Cím: <?=\app\models\Cim::findOne(\app\models\Beallitasok::get('ceg_cim_id'))->toString()?></span>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="copyright">
            <div class="left">
                Copyright © www.borago.hu.  Minden jog fentartva!
            </div>
            <div class="right">
                <a href="https://makeweb.hu" target="_blank">
                    <img src="/img/makeweb-footer.svg" />
                </a>
            </div>
        </div>
    </div>
</footer>

<?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_cookie_consent')?>

<script src="/js/borago.js?v=<?=sha1_file('js/borago.js')?>"></script>
</body>
</html>
