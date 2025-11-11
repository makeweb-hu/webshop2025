<?php
$cart = \app\models\Kosar::current();
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}


?>

<div class="bg-white" data-checkout-page>
    <!-- Background color split screen for large screens -->
    <div class="hidden lg:block fixed top-0 left-0 w-1/2 h-full bg-white" aria-hidden="true"></div>
    <div class="hidden lg:block fixed top-0 right-0 w-1/2 h-full bg-gray-50" aria-hidden="true"></div>

    <header class="relative bg-white border-b border-gray-200 text-sm font-medium text-gray-700" style="background-color: #354E36">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="relative flex justify-end">
                <a href="/" class="absolute left-0 top-1/2 -mt-6">
                    <span class="sr-only">Workflow</span>
                    <img src="/img/borago-white.svg" alt="" class="h-12 w-auto">
                </a>
                <a href="/" class="text-white flex"><img src="/img/left.svg" style="width: 10px;" class="mr-4" /> Vissza az áruházba</a>

            </div>
        </div>
    </header>

    <main class="relative grid grid-cols-1 gap-x-16 max-w-7xl mx-auto lg:px-8 lg:grid-cols-2 xl:gap-x-48">
        <h1 class="sr-only">Order information</h1>

        <section aria-labelledby="summary-heading" class="bg-gray-50 pt-16 pb-10 px-4 sm:px-6 lg:px-0 lg:pb-16 lg:bg-transparent lg:row-start-1 lg:col-start-2">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Összesítés</h2>

                <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200">
                    <?php foreach ($items as $item): ?>
                    <li class="flex items-start py-6 space-x-4">
                        <img src="<?=$item->product->getThumbnail()?>" alt="" class="flex-none w-20 h-20 rounded-md object-center object-cover">
                        <div class="flex-auto space-y-1">
                            <h3><?=$item->product->nev?></h3>
                            <p class="text-gray-500">
                                <?php if ($item->variation): ?>
                                    <?=$item->variation->optionsAsString()?>
                                <?php else: ?>
                                    Cikkszám: <?=$item->product->cikkszam?>
                                <?php endif; ?>
                            </p>
                            <p class="text-gray-500"><?=$item->mennyiseg?> db</p>
                        </div>
                        <p class="flex-none text-base font-medium">
							<?=\app\components\Helpers::formatMoney(  $item->getPrice() ) ?>
						</p>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <dl class=" text-sm font-medium text-gray-900 space-y-6 border-t border-gray-200 pt-6 lg:block">
                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Termékek összesen</dt>
                        <dd><?=\app\components\Helpers::formatMoney( $cart->getItemsTotal() )?></dd>
                    </div>


                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">Szállítási díj</dt>
                        <dd data-shipping-price><?=\app\components\Helpers::formatMoney( $cart->getShippingPrice() )?></dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-gray-600">ÁFA</dt>
                        <dd><?=\app\components\Helpers::formatMoney( $cart->getTotalVat() )?></dd>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                        <dt class="text-base"><b>Fizetendő</b></dt>
                        <dd  data-total class="text-base"><b><?=\app\components\Helpers::formatMoney( \app\models\Kosar::total() )?></b></dd>
                    </div>

                    <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                        <dt class="text-base">Összes kedvezmény</dt>
                        <dd  data-total class="text-base"><?=\app\components\Helpers::formatMoney( $cart->getTotalDiscount() )?></dd>
                    </div>

                </dl>

                <div style="z-index: 50" class="fixed bottom-0 inset-x-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden">

                    <div class="relative z-10 bg-white border-t border-gray-200 px-4 sm:px-6">
                        <div class="max-w-lg mx-auto">
                            <button type="button" class="w-full flex items-center py-6 font-medium" aria-expanded="false">
                                <span class="text-base mr-auto">Fizetendő</span>
                                <span class="text-base mr-2" data-total><?=\app\components\Helpers::formatMoney( \app\models\Kosar::total() )?></span>

                                <!--
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                -->
                            </button>
                        </div>
                    </div>


                    <div>
                        <!--
                          Mobile summary overlay, show/hide based on mobile summary state.

                          Entering: "transition-opacity ease-linear duration-300"
                            From: "opacity-0"
                            To: "opacity-100"
                          Leaving: "transition-opacity ease-linear duration-300"
                            From: "opacity-100"
                            To: "opacity-0"
                        -->


                        <!--
                          Mobile summary, show/hide based on mobile summary state.

                          Entering: "transition ease-in-out duration-300 transform"
                            From: "translate-y-full"
                            To: "translate-y-0"
                          Leaving: "transition ease-in-out duration-300 transform"
                            From: "translate-y-0"
                            To: "translate-y-full"
                        -->

                        <!--
                        <div class="relative bg-white px-4 py-6 sm:px-6">
                            <dl class="max-w-lg mx-auto space-y-6">
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Termékek összesen</dt>
                                    <dd>27 980 Ft</dd>
                                </div>

                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Szállítási díj</dt>
                                    <dd>890 Ft</dd>
                                </div>

                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">ÁFA</dt>
                                    <dd>AAM</dd>
                                </div>
                            </dl>
                        </div>
                        -->
                    </div>
                </div>
            </div>
        </section>

        <form data-checkout-form class="pt-16 pb-36 px-4 sm:px-6 lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <section aria-labelledby="contact-info-heading">
                    <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900">Vásárló adatai</h2>


                    <div class="mt-6">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Név</label>
                        <div class="mt-1">
                            <input type="text" id="email-address" name="name" required autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">E-mail cím</label>
                        <div class="mt-1">
                            <input type="email" id="email-address" name="email" required autocomplete="email" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="email-address" class="block text-sm font-medium text-gray-700">Telefonszám</label>
                        <div class="mt-1">
                            <input type="text" name="phone" id="phone" title="Csak számokat írjon ide!" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                    </div>
                </section>

                <div class="pt-10">
                    <fieldset >
                        <legend class="text-lg font-medium text-gray-900">
                            Szállítási mód
                        </legend>

                        <input type="text" style="width:1px;height:1px;opacity:0.01" required name="shipping" value="<?=$cart->szallitas_id ?: ''?>" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1">

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


                        </div>
                    </fieldset>
                </div>


                <div data-payment-methods>
                    <?=Yii::$app->controller->renderPartial('@app/themes/main/site/_payment_methods')?>
                </div>

                <input  type="text" style="width:1px;height:1px;opacity:0.01" required name="payment"  value="<?=$cart->fizetes_id ?: ''?>" class="sr-only" aria-labelledby="delivery-method-0-label" aria-describedby="delivery-method-0-description-0 delivery-method-0-description-1">


                <section aria-labelledby="shipping-heading" class="mt-10">
                    <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Szállítási adatok</h2>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div class="col-span-3">
                            <label for="company" class="block text-sm font-medium text-gray-700">Név</label>
                            <div class="mt-1">
                                <input type="text" required name="shipping_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-1 col-span-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">Irányítószám</label>
                            <div class="mt-1">
                                <input type="text" required name="shipping_zip" id="zip1" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2 col-span-3">
                            <label for="province" class="block text-sm font-medium text-gray-700">Település</label>
                            <div class="mt-1">
                                <input type="text" required name="shipping_city" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>


                        <div class="col-span-3">
                            <label for="apartment" class="block text-sm font-medium text-gray-700">Utca, házszám</label>
                            <div class="mt-1">
                                <input type="text" required name="shipping_street" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>


                    </div>
                </section>

                <section aria-labelledby="billing-heading" class="mt-10">
                    <h2 id="billing-heading" class="text-lg font-medium text-gray-900">Számlázási adatok</h2>

                    <div class="mt-6 flex items-center">
                        <input id="same-as-shipping" data-same-as-shipping name="same-as-shipping" type="checkbox" checked class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-2">
                            <label for="same-as-shipping" class="text-sm font-medium text-gray-900">Megegyezik a szállítási adatokkal</label>
                        </div>
                    </div>
                </section>

                <section aria-labelledby="shipping-heading" class="mt-2" data-billing-data style="display: none">

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div class="col-span-3">
                            <label for="company" class="block text-sm font-medium text-gray-700">Név</label>
                            <div class="mt-1">
                                <input type="text" required  name="billing_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="col-span-3">
                            <label for="company" class="block text-sm font-medium text-gray-700">Adószám</label>
                            <div class="mt-1">
                                <input type="text" placeholder="Opcionális"  name="billing_tax_number" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-1 col-span-3">
                            <label for="city" class="block text-sm font-medium text-gray-700">Irányítószám</label>
                            <div class="mt-1">
                                <input type="text" required name="billing_zip" id="zip2" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="sm:col-span-2 col-span-3">
                            <label for="province" class="block text-sm font-medium text-gray-700">Település</label>
                            <div class="mt-1">
                                <input type="text" required name="billing_city" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>


                        <div class="col-span-3">
                            <label for="apartment" class="block text-sm font-medium text-gray-700">Utca, házszám</label>
                            <div class="mt-1">
                                <input type="text" required name="billing_street" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>


                    </div>
                </section>

                <section aria-labelledby="shipping-heading" class="mt-10">
                    <h2 id="shipping-heading" class="text-lg font-medium text-gray-900">Megjegyzés</h2>

                    <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-3">
                        <div class="col-span-3">

                            <div class="mt-1">
                                <textarea placeholder="" type="text" name="comment" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                            </div>
                        </div>



                    </div>
                </section>

                <div class="mt-10 pt-6 border-t border-gray-200">

                    <div class="flex items-center">
                        <input id="aszf" required name="same-as-shipping" type="checkbox"  class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-2">
                            <label for="aszf"  class="text-sm  text-gray-900">Elolvastam és elfogadom az <a target="_blank" href="/aszf" class="font-medium">Általános szerződési feltételekben</a> leírtakat.</label>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center">
                        <input id="gdpr" required name="same-as-shipping" type="checkbox"  class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-2">
                            <label for="gdpr"  class="text-sm  text-gray-900">Nyilatkozom, hogy az <a target="_blank" class="font-medium" href="/adatkezelesi-tajekoztato" target="_blank">Adatkezelési tájékoztató</a> tartalmát megismertem, a személyes adataim kezeléséhez hozzájárulok.</label>
                        </div>
                    </div>

                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 sm:flex sm:items-center sm:justify-end">
                    <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500 sm:ml-6 sm:order-last sm:w-auto">Megrendelem</button>

                </div>
            </div>
        </form>
    </main>
</div>


<style>

    [data-method].active [data-border] {
        display: block !important;
    }


    [data-method].active [data-checkmark] {
        display: block !important;
    }

</style>