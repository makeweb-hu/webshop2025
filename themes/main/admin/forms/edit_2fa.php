<?php
$user = \app\models\Felhasznalo::current();

$qrCode = '';
$secret = '';

if ($user->ketfaktoros_kulcs) {
    $secretModel = \app\components\TwoFactorAuth::getSecret($user->email);
    $secret = $secretModel->getSecretKey();
    $uri = $secretModel->getUri();
    $qrCode = \app\components\QR::generate($uri);
}
?>


<form data-ajax-form data-action="/admin-api/edit-2fa" data-redirect-url="(current)">

    <?=
    \app\components\Helpers::render('ui/toggle', [
        'label' => 'Kétfaktoros hitelesítés bekapcsolása',
        "name" => 'enable_2fa',
        'value' => $user->ketfaktoros_kulcs ? '1' : '0',
    ]);
    ?>

    <input type="hidden" name="secret" value="<?=$secret?>" />

    <div class="border-2 p-4 border-dashed rounded-md <?=$qrCode?'hidden':'hidden'?>" data-2fa-info>

        <?php if (!$qrCode): ?>
        <p class="mb-4 text-sm">
            <span class="flex-shrink-0 w-6 h-6 inline-flex items-center justify-center border-2 border-indigo-600 rounded-full mr-2">
              <span class="text-indigo-600 text-xs">01</span>
            </span>
            Olvassa be az alábbi QR kódot az <b class="font-semibold">Authenticator</b> applikációval!
        </p>
        <?php else: ?>
            <p class="mb-4 text-sm text-center">
            <span class="flex-shrink-0 w-6 h-6 inline-flex items-center justify-center border-2 border-green-600 rounded-full mr-2" style="border-color: #059669;">
              <span class="text-green-600 text-xs"><i class="fa-regular fa-check"></i></span>
            </span>
                Sikeresen beállítva az alábbi QR kóddak:
            </p>
        <?php endif; ?>

        <div class="flex justify-center mb-4">
            <img src="<?=$qrCode?>" style="width: 180px">
        </div>

        <div class="<?=!$qrCode?'':'hidden'?>">

            <hr class="mb-4">

            <p class="mb-4 text-sm">
                <span class="flex-shrink-0 w-6 h-6 inline-flex items-center justify-center border-2 border-indigo-600 rounded-full mr-2">
                  <span class="text-indigo-600 text-xs">02</span>
                </span>
                Majd írja be az aktuális ellenőrző kódot!
            </p>

            <div>
                <?=
                \app\components\Helpers::render('ui/input', [
                    "name" => 'code',
                    'placeholder' => 'Ellenőrző kód'
                ]);
                ?>
            </div>

        </div>
    </div>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>