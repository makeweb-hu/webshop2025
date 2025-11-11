<?php
$user = \app\models\Felhasznalo::current();
?>
<!DOCTYPE html>
<html>
<head>
    <title>makeweb admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-admin/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-admin/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-admin/favicon-16x16.png">
    <link rel="manifest" href="/favicon-admin/site.webmanifest">
    <link rel="shortcut icon" href="/favicon-admin/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon-admin/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.2/css/all.css"/>

    <script src="/js/popper.min.js"></script>
    <script src="/js/tippy-bundle.umd.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">

    <link rel="stylesheet" href="/css/tailwind.css" />
    <link rel="stylesheet" href="/css/admin.css?v=<?=sha1_file('css/admin.css')?>" />

    <link rel="stylesheet" href="/css/summernote.min.css">

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0-dev.2/quill.snow.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/quill/2.0.0-dev.2/quill.min.js"></script>

    <!--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css">
    -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>

</head>
<body>
<div class="h-screen flex overflow-hidden bg-gray-100">
    <div class="fixed inset-0 flex z-40 md:hidden hidden" role="dialog" aria-modal="true" data-mobile-menu>

        <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true" data-close-mobile-menu></div>

        <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">

            <div class="absolute top-0 right-0 -mr-12 pt-2">

                <button data-close-mobile-menu type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <span class="sr-only">Close sidebar</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex-shrink-0 flex items-center justify-center px-4">
                <a href="/admin">
                    <img class="h-6 w-auto" src="/img/makeweb-new-white.svg" alt="Workflow">
                </a>
            </div>
            <div class="mt-5 flex-1 h-0 overflow-y-auto">
                <nav class="px-2 space-y-1">


                    <?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_admin_menu')?>

                </nav>
            </div>
        </div>

        <div class="flex-shrink-0 w-14" aria-hidden="true">
            <!-- Dummy element to force sidebar to shrink to fit close icon -->
        </div>
    </div>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:flex md:flex-shrink-0">
        <div class="flex flex-col w-64">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex-1 flex flex-col min-h-0">
                <div class="flex items-center justify-center h-16 flex-shrink-0 px-4 bg-gray-900">
                    <a href="/admin">
                        <img class="h-6 w-auto" src="/img/makeweb-new-white.svg" alt="Workflow">
                    </a>
                </div>
                <div class="flex-1 flex flex-col overflow-y-auto">
                    <nav class="flex-1 px-2 py-4 bg-gray-800 space-y-1">


                        <?=Yii::$app->controller->renderPartial('@app/themes/main/layouts/_admin_menu')?>









                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="flex flex-col w-0 flex-1 overflow-hidden">
        <div class="relative z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button data-hamburger-icon type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-between" data-global-search>
                <div class="flex-1 flex">
                    <form class="w-full flex md:ml-0" action="#" method="GET" style="font-size:0">

                        <?=\app\components\Helpers::render('ui/lookup', [
                            'class' => '(global)',
                            'attrs' => ['code', 'name'],
                            'column' => 'typed_name'
                        ])
                        ?>
                    </form>
                </div>
                <div class="ml-4 flex items-center md:ml-6">

                    <div class="ml-3 relative">
                        <div>
                            <button data-navbar-profile-pic type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 mr-2 w-8 rounded-full" src="<?=\app\models\Felhasznalo::current()->profilePic?>" alt="">
                                <span class="overflow-ellipsis whitespace-nowrap overflow-hidden" style="max-width: 100px;">
                                    <?=\App\Models\Felhasznalo::current()->nev?>
                                </span>
                            </button>
                        </div>

                        <div data-profile-context-menu class="origin-top-right absolute right-0 mt-2 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none invisible" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="min-width: 200px;">
                            <div class="px-4 py-3" role="none" style="border-bottom: 1px solid rgba(243,244,246,1);">
                                <p class="text-sm whitespace-nowrap" role="none">
                                    Bejelentkezve mint:
                                </p>
                                <p class="text-sm font-bold text-gray-900 truncate" role="none">
                                    <?=\App\Models\Felhasznalo::current()->email?>
                                </p>
                            </div>
                            <div class="py-1" role="none" style="border-bottom: 1px solid rgba(243,244,246,1);">
                                <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->

                                <a href="#" data-show-modal="" data-title="Profilom szerkesztése" data-view="forms/edit_profile" data-modal-id="" data-params="" class="text-gray-700 block px-4 py-2 text-sm whitespace-nowrap" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <i class="fa-regular fa-user-pen"></i> Profilom szerkesztése
                                </a>
                                <a href="#" data-show-modal="" data-title="Jelszó módosítása" data-view="forms/edit_password" data-modal-id="" data-params="" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <i class="fa-regular fa-key"></i> Jelszó módosítása
                                </a>
                                <a href="#" data-show-modal="" data-title="2FA beállítása" data-view="forms/edit_2fa" data-modal-id="" data-params="" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <i class="fa-regular fa-key-skeleton"></i> 2FA beállítása
                                </a>
                                <a href="/admin/own-activity" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                                    <i class="fa-regular fa-clock-rotate-left"></i> Saját tevékenység
                                </a>


                            </div>
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2" data-logout><i class="fa-regular fa-arrow-right-from-bracket"></i> Kijelentkezés</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <?=$content?>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="/js/admin.js?v=<?=sha1_file('js/admin.js')?>"></script>
</body>
</html>

