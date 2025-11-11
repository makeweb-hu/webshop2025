<?=\app\components\Helpers::render('ui/breadcrumbs', [
    'items' => [
        'SMTP' => '#',
    ]
])?>

<div data-selected-menu="9.3"></div>

<?=\app\components\Helpers::render('ui/heading', [
    'title' => 'SMTP',
    'actions' => [

    ]
])?>


<form data-ajax-form data-action="/admin-api/edit?class=Beallitasok&id=1" data-show-popup-on-success>



    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
        <div class="sm:col-span-4">



            <?=\app\components\Helpers::render('ui/input', [
                'label' => 'SMTP hosztnév',
                'name' => 'smtp_host',
                'value' => $model->smtp_host
            ])?>

        </div>
        <div class="sm:col-span-2">

                <?=\app\components\Helpers::render('ui/input', [
                    'label' => 'SMTP port' ,
                    'name' => 'smtp_port',
                    'value' => $model->smtp_port
                ])?>
        </div>
        <div class="sm:col-span-2">

                <?=\app\components\Helpers::render('ui/select', [
                    'label' => 'SMTP titkosítás'  ,
                    'name' => 'smtp_encryption',
                    'value' => $model->smtp_encryption,
                    'values' => ['tls' => 'TLS', 'ssl' => 'SSL'],
                ])?>

        </div>
        <div class="sm:col-span-6">

                <?=\app\components\Helpers::render('ui/input', [
                    'label' => 'SMTP felhasználónév' ,
                    'name' => 'smtp_username',
                    'value' => $model->smtp_username
                ])?>
        </div>
        <div class="sm:col-span-6">

                    <?=\app\components\Helpers::render('ui/input', [
                        'label' => 'SMTP jelszó',
                        'type' => 'password',
                        'name' => 'smtp_password',
                        'icon' => '<i class="fa-regular fa-key"></i>',
                        'value' => $model->smtp_password
                    ])?>

        </div>
        <div class="sm:col-span-3">

                    <?=\app\components\Helpers::render('ui/input', [
                        'label' => 'Küldő neve',
                        'name' => 'smtp_sender_name',
                        'value' => $model->smtp_sender_name
                    ])?>

        </div>
        <div class="sm:col-span-3">

                <?=\app\components\Helpers::render('ui/input', [
                    'label' => 'Küldő e-mail címe',
                    'name' => 'smtp_sender_email',
                    'value' => $model->smtp_sender_email
                ])?>

        </div>
    </div>


    <div class="mt-10 flex justify-end">
        <button type="button" data-show-modal data-title="Teszt e-mail küldése" data-view="forms/test_email" data-params='{"lang":"<?=$lang?>"}' class=" items-center mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <i class="fa-solid fa-envelope"></i> Teszt e-mail küldése
        </button>


        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

