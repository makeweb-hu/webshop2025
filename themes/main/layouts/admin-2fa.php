<?php
$token = Yii::$app->request->get('token', '');
$remember_me = Yii::$app->request->get('remember_me', '0');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Makeweb</title>
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
            <form class="space-y-6" data-ajax-form data-action="/admin-api/verify-2fa" method="POST" class="space-y-6">
                <input type="hidden" name="token" value="<?=$token?>">
                <input type="hidden" name="remember_me" value="<?=$remember_me?>">

                <?=\app\components\Helpers::render('ui/input', ['name' => 'code', 'label' => 'Hitelesítő kód', 'placeholder' => ''])?>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Hitelesítés
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