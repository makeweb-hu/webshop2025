<!DOCTYPE html>
<html>
<head>
    <title>Flavon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.2/css/all.css"/>

    <script src="/js/popper.min.js"></script>
    <script src="/js/tippy-bundle.umd.min.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-admin/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-admin/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-admin/favicon-16x16.png">
    <link rel="manifest" href="/favicon-admin/site.webmanifest">
    <link rel="shortcut icon" href="/favicon-admin/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon-admin/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="/css/tailwind.css" />
    <link rel="stylesheet" href="/css/admin.css?v=<?=sha1_file('css/admin.css')?>" />

</head>
<body>

<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <a href="/admin">
            <img class="mx-auto h-12 w-56" src="/img/makeweb-new.svg" >
        </a>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
            <form class="space-y-6" data-ajax-form data-action="/admin-api/login" method="POST" class="space-y-6">
                <?=\app\components\Helpers::render('ui/input', ['name' => 'email', 'label' => 'E-mail cím', 'placeholder' => ''])?>

                <?=\app\components\Helpers::render('ui/input', ['name' => 'password', 'type'=>'password', 'label' => 'Jelszó', 'placeholder' => ''])?>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                            Bejelentkezve maradok
                        </label>
                    </div>

                    <!--
                    <div class="text-sm">
                        <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Elfelejtette jelszavát?
                        </a>
                    </div>
                    -->
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Bejelentkezés
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="/js/admin.js?v=<?=sha1_file('js/admin.js')?>"></script>

</body>
</html>