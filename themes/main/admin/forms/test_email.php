<?php

?>

<form data-ajax-form data-action="/admin-api/send-test-email">

    <input type="hidden" name="lang" value="<?=$lang?>" />

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Címzett',
        'name' => 'email',
        'value' => \app\models\Felhasznalo::current()->email,
        'placeholder' => 'valami@example.com',
    ])?>

    <?=\app\components\Helpers::render('ui/textarea', [
        'label' => 'Tartalom',
        'name' => 'content',
        'value' => 'Ez egy teszt üzenet 😋',
    ])?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex items-center justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Küldés
        </button>

    </div>

</form>

