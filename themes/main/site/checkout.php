<?php
$cart = \app\models\Kosar::current();
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}

$customer = \app\models\Vasarlo::current();

?>



<body class="checkout-body">


<header>
    <div class="container">
        <div class="checkout-header-content">
            <div class="logo">
                <a href="/">
                    <img src="/img/dragcards/logo/logo-color-dark.svg" alt="Dragcards">
                </a>
            </div>
            <div class="back-to-shop">
                <a href="/">
                    <div class="icon">
                        <img src="/img/dragcards/pagination/arrow-left.svg" alt="Dragcards">
                    </div>
                    <div class="text">Vissza <span class="hide-when-small">az áruházba</span></div>
                </a>
            </div>
        </div>
    </div>
</header>


<div class="checkout-content" data-checkout-page="">
    <!--
    <div class="hidden lg:block fixed top-0 left-0 w-1/2 h-full bg-white" aria-hidden="true"></div>
    <div class="hidden lg:block fixed top-0 right-0 w-1/2 h-full bg-gray-50" aria-hidden="true"></div>
    -->


    <div class="container">
        <main class="checkout-summary-and-form">
            <div class="extra-div"></div>
            <section aria-labelledby="summary-heading" class="products-summary  pt-16 pb-10 px-4 sm:px-6 lg:px-0 lg:pb-16 lg:bg-transparent lg:row-start-1 lg:col-start-2">
                <div class="lg:max-w-none">
                    <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Összesítés</h2>

                    <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200f" data-product-list>

                        <?php foreach ($items as $item): ?>

                            <?php

                            $photoUrl = $item->product->getThumbnail();
                            if ($item->variation) {
                                $photoUrl = $item->variation->getThumbnail();
                            }

                            ?>

                        <li class="flex items-start py-6 space-x-4 border-gray-half">
                            <img src="<?=$photoUrl?>" alt="" class="flex-none w-20 h-20 object-center" style="object-fit: contain; border-radius: 8px;">
                            <div class="flex-auto space-y-1">
                                <h3>

                                    <?=$item->product->nev?>

                                    <?php if ($item->variation): ?>
                                        - <?=$item->variation->optionsArray()[0]->ertek?>
                                    <?php endif; ?>

                                </h3>

                                <p class="text-gray-500"><?=$item->mennyiseg?> db</p>
                            </div>
                            <p class="flex-none font-extrabold">
                                <?php if ($item->variation): ?>
                                    <?=\app\components\Helpers::formatMoney($item->variation->currentPrice())?>
                                <?php else: ?>
                                    <?=\app\components\Helpers::formatMoney($item->product->currentPrice())?>
                                <?php endif; ?>

                            </p>
                        </li>
                        <?php endforeach; ?>

                    </ul>

                    <dl class=" text-sm font-medium text-gray-900 space-y-6 border-t border-gray-200 pt-6 lg:block border-gray-half">

                        <div class="flex items-center justify-between">
                            <dt class="text-gray-600">Termékek összesen</dt>
                            <dd class="font-extrabold" data-products-total><?=\app\components\Helpers::formatMoney( $cart->getItemsTotal() )?></dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="text-gray-600">Szállítási díj</dt>
                            <dd class="font-extrabold" data-shipping-price=""><?=\app\components\Helpers::formatMoney( $cart->getShippingPrice() )?></dd>
                        </div>

                        <div class="flex items-center justify-between">
                            <dt class="text-gray-600">ÁFA összesen</dt>
                            <dd class="font-extrabold" data-vat-total><?=\app\components\Helpers::formatMoney( $cart->getTotalVat() )?></dd>
                        </div>


                        <div class="flex items-center justify-between border-t border-gray-half pt-6" style="color: #873CFF!important;">
                            <dt class="text-base"><b class="font-extrabold">Fizetendő</b></dt>
                            <dd data-total="" class="text-base font-extrabold"><?=\app\components\Helpers::formatMoney( \app\models\Kosar::total() )?></dd>
                        </div>


                    </dl>

                    <div style="z-index: 50; display: none;" class="fixed bottom-0 inset-x-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden">

                        <div class="relative z-10 bg-white border-t border-gray-200 px-4 sm:px-6">
                            <div class="max-w-lg mx-auto">
                                <button type="button" class="w-full flex items-center py-6 font-medium" aria-expanded="false">
                                    <span class="text-base mr-auto">Fizetendő</span>
                                    <span class="text-base mr-2 font-extrabold" data-total="">3 000 Ft</span>

                                </button>
                            </div>
                        </div>


                        <div>

                        </div>
                    </div>
                </div>
            </section>

            <div class="checkout-form">
                <form data-ajax-form="" data-action="/api/order" data-scroll-to-error="" class=" lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
                    <div class="lg:max-w-none">
                        <section aria-labelledby="contact-info-heading">
                            <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                <span>Vásárló adatai</span>
                            </h2>

                            <p class="mt-4" style="font-size: 90%;">
                                <?php if ($customer): ?>
                                    Bejelentkezve mint: <?=$customer->nev?>
                                <?php else: ?>

                                Már van fiókod? <a data-show-login-modal style="color: #111827; text-decoration: underline; font-weight: 600; cursor: pointer;">Jelentkezz be!</a>

                                <?php endif; ?>
                            </p>

                            <div class="mt-6 input-row fancy-placeholder">
                                <label for="email-address" class="block text-sm font-medium text-gray-700">Név</label>
                                <div class="">
                                    <input type="text" name="name" value="<?=$customer->nev?>" placeholder="Név" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                </div>
                                <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                            </div>

                            <div class="mt-6 input-row fancy-placeholder">
                                <label for="email-address" class="block text-sm font-medium text-gray-700">E-mail cím</label>
                                <div class="" style="position: relative;">
                                    <input type="email" name="email" value="<?=$customer->email?>" <?=$customer?'readonly':''?> placeholder="E-mail cím" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                </div>
                                <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                            </div>

                            <div class="mt-6 input-row fancy-placeholder">
                                <label for="email-address" class="block text-sm font-medium text-gray-700">Telefonszám</label>
                                <div class="">
                                    <input type="text" name="phone" placeholder="Telefonszám" value="<?=$customer->telefonszam?>" title="A helyes formátum: +3620...." class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                </div>
                                <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                            </div>
                        </section>

                        <!--
                        <section aria-labelledby="contact-info-heading" class="mt-8">
                            <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                <span>Kuponkód</span>

                            </h2>

                            <div class="flex w-full">
                                <div class="mt-6 input-row w-full" style="">
                                    <div class="">
                                        <input type="text" name="coupon" placeholder="Írd ide, ha van kódod..." value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>
                                <div class="mt-6 input-row ml-2 flex-shrink-0" style="">
                                    <div data-add-coupon="" class="flex items-center justify-center px-4" style="">
                                        Aktivál
                                    </div>
                                </div>
                            </div>
                        </section>
                        -->

                        <div class="pt-10 input-row">
                            <fieldset>
                                <legend class="text-lg font-medium text-gray-900">
                                    Átvételi mód
                                </legend>

                                <input type="text" style="width:1px;height:1px;opacity:0.01" name="shipping" value="" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1">

                                <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

                                    <?php foreach (\app\models\Szallitas::find()->where(['statusz'=>1])->all() as $item): ?>
                                        <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none border-gray-300 undefined <?=$cart->szallitas_id == $item->id ? 'active' : ''?>" data-method data-id="<?=$item->id?>" data-field-name="shipping">
                                            <div class="flex-1 flex">
                                                <div class="flex flex-col">
                                            <span id="delivery-method-0-label" class="block text-sm font-medium text-gray-900">
                                              <?=$item->nev?>
                                            </span>
                                                    <!--
                                                            <span id="delivery-method-0-description-0" class="mt-1 flex items-center text-sm text-gray-500">
                                              <?=$item->leiras?>
                                            </span>
                                            -->
                                                    <span id="delivery-method-0-description-1" class="mt-2 text-sm text-gray-900">
                                              <?=\app\components\Helpers::formatMoney( $item->ar ) ?>
                                            </span>
                                                </div>
                                            </div>

                                            <svg data-checkmark class="h-5 w-5 text-indigo-600 undefined"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" style="display:none">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            <div class="absolute -inset-px rounded-lg pointer-events-none border-indigo-500 border-2" aria-hidden="true" style="display: none;" data-border></div>
                                        </label>
                                    <?php endforeach; ?>
                                    <!--
                                    <label class="relative border shadow-sm p-4 flex cursor-pointer focus:outline-none border-black undefined" data-method="" data-id="2" data-field-name="shipping">
                                        <div class="flex-1 flex">
                                            <div class="flex flex-col">
                                                    <span id="delivery-method-0-label" class="block text-sm font-bold text-gray-900">
                                                      Helyszíni átvétel                                                    </span>

                                                <span id="delivery-method-0-description-0" class="mt-1 flex items-center text-sm text-gray-500" style="font-size: 80%">
                                                      Átvétel üzletünkben: 4400 Nyíregyháza, ....                                                    </span>

                                                <span id="delivery-method-0-description-1" class="mt-2 text-sm text-gray-900">
                                                                                                              Ingyenes                                                                                                          </span>
                                            </div>
                                        </div>

                                        <div data-checkmark="" class="method-checkmark">
                                            <img src="/img/checkmark-white.svg" alt="Dragcards">
                                        </div>
                                        <div class="absolute -inset-px  pointer-events-none border-indigo-500 border-3" aria-hidden="true" style="display: none;" data-border=""></div>
                                    </label>
                                    -->


                                </div>
                            </fieldset>

                            <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                        </div>


                        <div class=" input-row">
                            <div data-payment-methods="">

                                <?=Yii::$app->controller->renderPartial('@app/themes/main/site/_payment_methods')?>
                            </div>

                            <input type="text" style="width:1px;height:1px;opacity:0.01" name="payment" value="" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1">

                        </div>

                        <section aria-labelledby="shipping-heading" class="mt-10">
                            <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Szállítási adatok</h2>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="company" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Név</label>
                                    <div class="">
                                        <input type="text" name="shipping_name" placeholder="Név" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="company" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Ország</label>
                                    <div class="">
                                        <select name="shipping_country" data-country="" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                            <option selected="" value="1">Magyarország</option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="sm:col-span-1 col-span-3 input-row fancy-placeholder">
                                    <label for="city" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Irányítószám</label>
                                    <div class="">
                                        <input type="text" data-zip="" name="shipping_zip" value="" placeholder="Irányítószám" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="sm:col-span-2 col-span-3 input-row fancy-placeholder">
                                    <label for="province" data-settlement="" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Település</label>
                                    <div class="">
                                        <input type="text" name="shipping_city" placeholder="Település" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>


                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Utca, házszám</label>
                                    <div class="">
                                        <input type="text" name="shipping_street" value="" placeholder="Utca, házszám" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <!--
                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Épület, emelet, ajtó</label>
                                    <div class="">
                                        <input type="text" name="shipping_building" placeholder="Épület, emelet, ajtó" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>
                                -->

                            </div>
                        </section>

                        <section aria-labelledby="billing-heading" class="mt-10">
                            <h2 id="billing-heading" class="text-lg font-medium text-gray-900">Számlázási adatok</h2>

                            <div class="mt-6 flex items-center">
                                <input id="same-as-shipping" data-same-as-shipping="" name="same-as-shipping" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 ">
                                <div class="ml-2">
                                    <label for="same-as-shipping" class="text-sm font-medium text-gray-900">Megegyezik a szállítási adatokkal</label>
                                </div>
                            </div>
                        </section>

                        <section aria-labelledby="shipping-heading" class="mt-2" data-billing-data="" style="">

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="company" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Név</label>
                                    <div class="">
                                        <input type="text" value="" placeholder="Név" name="billing_name" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="company" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Adószám</label>
                                    <div class="">
                                        <input type="text" placeholder="Adószám (opcionális)" value="" name="billing_tax_number" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="company" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Ország</label>
                                    <div class="">
                                        <select name="billing_country" data-country="" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                            <option selected="" value="1">Magyarország</option>
                                        </select>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="sm:col-span-1 col-span-3 input-row fancy-placeholder">
                                    <label for="city" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Irányítószám</label>
                                    <div class="">
                                        <input type="text" data-zip="" placeholder="Irányítószám" name="billing_zip" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <div class="sm:col-span-2 col-span-3 input-row fancy-placeholder">
                                    <label for="province" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Település</label>
                                    <div class="">
                                        <input type="text" data-settlement="" placeholder="Település" name="billing_city" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>


                                <div class="col-span-3 input-row fancy-placeholder">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Utca, házszám</label>
                                    <div class="">
                                        <input type="text" name="billing_street" placeholder="Utca, házszám" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>

                                <!--
                                <div class="col-span-3 input-row">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700" style="font-weight: 600; font-size: 85%;">Épület, emelet, ajtó</label>
                                    <div class="">
                                        <input type="text" placeholder="Opcionális" name="billing_building" value="" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;">
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>
                                -->

                            </div>
                        </section>

                        <section aria-labelledby="shipping-heading" class="mt-10">
                            <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Megjegyzés</h2>

                            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                                <div class="col-span-3 data-input-row">

                                    <div class="">
                                        <textarea type="text" name="comment" placeholder="Opcionális" rows="4" class="block w-full border-gray-300 rounded-md shadow-sm   sm:text-sm" style="background-color: #F1F1F1;border-color:#F1F1F1;"></textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                                </div>



                            </div>
                        </section>

                        <div class="mt-10 pt-6 border-t border-gray-200">

                            <div class="input-row">
                                <div class="flex items-center">
                                    <input id="aszf" name="accept1" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 ">
                                    <div class="ml-2">
                                        <label for="aszf" class="text-sm  text-gray-900">Elolvastam és elfogadom az <a target="_blank" href="/altalanos-szerzodesi-feltetelek" class="font-medium underline">Általános szerződési feltételekben</a> leírtakat.</label>
                                    </div>

                                </div>
                                <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                            </div>

                            <div class="input-row mt-6">
                                <div class="flex items-center">
                                    <input id="gdpr" name="accept2" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 ">
                                    <div class="ml-2">
                                        <label for="gdpr" class="text-sm  text-gray-900">Nyilatkozom, hogy az <a target="_blank" class="font-medium underline" href="/adatkezelesi-i">Adatkezelési tájékoztató</a> tartalmát megismertem, a személyes adataim kezeléséhez hozzájárulok.</label>
                                    </div>

                                </div>
                                <p class="mt-2 text-sm text-red-600 hidden error-message"></p>
                            </div>

                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 sm:flex sm:items-center sm:justify-end">
                            <button type="submit" class="checkout-button" style="">
                                Megrendelem
                            </button>

                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>


<style>

    [data-method].active [data-border] {
        display: block !important;
    }


    [data-method].active [data-checkmark] {
        display: flex;
    }

</style>




<div class="modal-window" data-checkout-login-modal="">
    <div class="modal-bg" data-close-modal=""></div>
    <div class="modal-window-content">
        <div class="modal-box">
            <div class="modal-box-header">
                <div class="modal-title">Bejelentkezés</div>
                <div class="modal-close" data-close-modal="">
                    <img src="/img/x-2.svg" alt="Dragcards">
                </div>
            </div>
            <div class="modal-box-content">
                <form data-ajax-form="" data-action="/api/login">
                    <div class="input-row">
                        <label>E-mail</label>
                        <div class="input-box">
                            <input type="text" name="email">
                        </div>
                        <div class="error-message">Kötelező kitölteni!</div>
                    </div>
                    <div class="input-row">
                        <label>Jelszó</label>
                        <div class="input-box">
                            <input type="password" name="password" placeholder="">
                        </div>
                        <div class="error-message">Kötelező kitölteni!</div>
                    </div>
                    <div class="modal-button-row">
                        <button type="submit">Bejelentkezés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<style>

    [data-method].active [data-border] {
        display: block !important;
    }


    [data-checkmark] {
        display: none!important;
    }

</style>