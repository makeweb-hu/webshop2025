<?php

$email = $cart->email;

$customer = \app\models\Vasarlo::current();

$items = $cart->items;

?>


<div class="checkout-content" data-checkout-page>
    <!--
    <div class="hidden lg:block fixed top-0 left-0 w-1/2 h-full bg-white" aria-hidden="true"></div>
    <div class="hidden lg:block fixed top-0 right-0 w-1/2 h-full bg-gray-50" aria-hidden="true"></div>
    -->


    <div class="container">
        <main class="checkout-summary-and-form ordered">
            <section aria-labelledby="summary-heading" class="products-summary  pt-16 pb-10 px-4 sm:px-6 lg:px-0 lg:pb-16 lg:bg-transparent lg:row-start-1 lg:col-start-2">
                <div class="lg:max-w-none">
                    <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Összesítés</h2>

                    <ul role="list" class="text-sm font-medium text-gray-900 divide-y divide-gray-200f">
                        <?php foreach ($items as $item): ?>
                            <li class="flex items-start py-6 space-x-4 border-gray-half">
                                <img src="<?=$item->getThumbnail()?>" alt="" class="flex-none w-20 h-20 object-center" style="object-fit: contain;">
                                <div class="flex-auto space-y-1">
                                    <h3><?=$item->product->nev?></h3>
                                    <p class="text-gray-500" style="font-size: 80%;">
                                        <?=$item->product->renderInfo()?>
                                    </p>
                                    <p class="text-gray-500"><?=$item->mennyiseg?> db</p>
                                </div>
                                <p class="flex-none font-extrabold">
                                    <?php if ($customer && $customer->viszontelado): ?>
                                        <?=\app\components\Helpers::formatMoney(  round($item->getPrice() / 1.27) ) ?>
                                    <?php else: ?>
                                        <?=\app\components\Helpers::formatMoney(  $item->getPrice() ) ?>
                                    <?php endif; ?>
                                </p>
                            </li>
                        <?php endforeach; ?>

                        <?php if ($giftProduct && (!$customer || !$customer->viszontelado)): ?>

                            <li class="flex items-start py-6 space-x-4 border-gray-half">
                                <img src="<?=$giftProduct->getThumbnail()?>" alt="" class="flex-none w-20 h-20 object-center" style="object-fit: contain;">
                                <div class="flex-auto space-y-1">
                                    <h3><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Ajándék</span> <?=$giftProduct->nev?></h3>
                                    <p class="text-gray-500" style="font-size: 80%;">
                                        <?=$item->product->renderInfo()?>
                                    </p>
                                    <p class="text-gray-500">1 db</p>
                                </div>
                                <p class="flex-none font-extrabold">
                                    <?php if ($customer && $customer->viszontelado): ?>
                                        0 Ft
                                    <?php else: ?>
                                        0 Ft
                                    <?php endif; ?>
                                </p>
                            </li>

                        <?php endif; ?>
                    </ul>

                    <dl class=" text-sm font-medium text-gray-900 space-y-6 border-t border-gray-200 pt-6 lg:block border-gray-half">
                        <?php if ($customer && $customer->viszontelado): ?>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">Termékek összesen (nettó)</dt>
                                <dd class="font-extrabold"><?=\app\components\Helpers::formatMoney( round($cart->getItemsTotal() / 1.27) )?></dd>
                            </div>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">Szállítási díj (nettó)</dt>
                                <dd class="font-extrabold" data-shipping-price><?=\app\components\Helpers::formatMoney( round($cart->getShippingPrice() / 1.27) )?></dd>
                            </div>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">ÁFA (a rendelés áfatartalma összesen)</dt>
                                <dd class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->getTotalVat() )?></dd>
                            </div>

                            <?php if ($cart->getTotalDiscount() > 0): ?>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Összes kedvezmény (nettó)</dt>
                                    <dd  class="font-extrabold"><?=\app\components\Helpers::formatMoney( round($cart->getTotalDiscount() / 1.27) )?></dd>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center justify-between border-t border-gray-half pt-6" style="color: #3E6DA1!important;">
                                <dt class="text-base"><b class="font-extrabold">Összesen</b></dt>
                                <dd  class="font-extrabold"  data-total class="text-base"><b class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->total )?></b></dd>
                            </div>

                        <?php else: ?>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">Termékek összesen</dt>
                                <dd class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->getItemsTotal() )?></dd>
                            </div>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">Szállítási díj</dt>
                                <dd class="font-extrabold" data-shipping-price><?=\app\components\Helpers::formatMoney( $cart->getShippingPrice() )?></dd>
                            </div>

                            <div class="flex items-center justify-between">
                                <dt class="text-gray-600">ÁFA összesen</dt>
                                <dd class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->getTotalVat() )?></dd>
                            </div>

                            <?php if ($cart->getTotalDiscount() > 0): ?>
                                <div class="flex items-center justify-between">
                                    <dt class="text-gray-600">Összes kedvezmény</dt>
                                    <dd class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->getTotalDiscount() )?></dd>
                                </div>
                            <?php endif; ?>

                            <div class="flex items-center justify-between border-t border-gray-half pt-6" style="color: #3E6DA1!important;">
                                <dt class="text-base"><b class="font-extrabold">Összesen</b></dt>
                                <dd  data-total class="text-base"><b class="font-extrabold"><?=\app\components\Helpers::formatMoney( $cart->total )?></b></dd>
                            </div>

                        <?php endif; ?>

                    </dl>

                    <div style="z-index: 50; display: none;" class="fixed bottom-0 inset-x-0 flex flex-col-reverse text-sm font-medium text-gray-900 lg:hidden">

                        <div class="relative z-10 bg-white border-t border-gray-200 px-4 sm:px-6">
                            <div class="max-w-lg mx-auto">
                                <button type="button" class="w-full flex items-center py-6 font-medium" aria-expanded="false">
                                    <span class="text-base mr-auto">Összesen</span>
                                    <span class="text-base mr-2" data-total><?=\app\components\Helpers::formatMoney( $cart->total )?></span>

                                </button>
                            </div>
                        </div>


                        <div>

                        </div>
                    </div>
                </div>
            </section>

            <div class="checkout-form">
                <form data-ajax-form  data-scroll-to-error class=" lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
                    <div class="lg:max-w-none">

                        <!-- Ezeket max egy óriáig mutatja --->
                        <?php if (true || (time() - strtotime($cart->megrendelve)) <= 2 * 60 * 60): ?>
                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                <span><i class="fa-solid fa-circle-check" style="margin-right: 5px;"></i> Sikeres rendelés</span>
                                <!--
                                <span style="font-weight: 400; font-family: Inter; text-transform: none; font-size: 70%;">Rendelésszám: <?=$cart->rendelesszam?></span>
                                -->
                            </h2>

                            <p class="mb-2">
                                Köszönjük a vásárlást!
                            </p>

                            <p class="mb-2">
                                Rendelésed rögzítettük, melyről e-mail értesítést is küldtünk Neked.
                            </p>


                            <?php if ($customer && $customer->nrOfOrders() == 1 && password_verify('FIRST_OrDeR_001*', $customer->jelszo_hash)): ?>
                                <p class="mb-4">
                                    Az első vásárlásoddal létre is jött egy felhasználói fiók a rendszerben, amelyhez az alábbi gombra kattintva tudsz jelszót beállítani:
                                </p>
                                <p class="mb-2">
                                <a data-show-set-first-password class="checkout-success-btn">
                                    Jelszó beállítása
                                </a>
                                </p>
                            <?php else: ?>

                                <a href="/" class="checkout-success-btn">
                                    Vissza az áruházba
                                </a>

                            <?php endif; ?>

                        </div>
                        <?php endif; ?>

                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                Rendelés adatai
                            </h2>

                            <div class="order-info-table">
                                <div class="row">
                                    <div class="key">Rendelésszám</div>
                                    <div class="value"><?=$cart->rendelesszam?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Rendelés időpontja</div>
                                    <div class="value"><?=date('Y.m.d. H:i', strtotime($cart->megrendelve))?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Rendelés státusza</div>
                                    <div class="value">
                                        <span class="status"><?=$cart->renderStatus()?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Kuponkód</div>
                                    <div class="value">
                                        <?=$cart->coupon?$cart->coupon->kod:'&#8212;'?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Fizetés státusza</div>
                                    <div class="value">
                                        <?=$cart->renderPaymentStatus()?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Átvételi mód</div>
                                    <div class="value">
                                        <?=$cart->shipping->nev?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Fizetési mód</div>
                                    <div class="value">
                                        <?=$cart->payment->nev?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                Vásárló adatai
                            </h2>
                            <div class="order-info-table">
                                <div class="row">
                                    <div class="key">Név</div>
                                    <div class="value"><?=$cart->nev?></div>
                                </div>
                                <div class="row">
                                    <div class="key">E-mail cím</div>
                                    <div class="value"><?=$cart->email?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Telefonszám</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->telefonszam?></div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                Szállítási cím
                            </h2>

                            <div class="order-info-table">
                                <div class="row">
                                    <div class="key">Név</div>
                                    <div class="value"><?=$cart->shippingAddress->nev?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Ország</div>
                                    <div class="value"><?=$cart->shippingAddress->country->nev?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Irányítószám</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->shippingAddress->iranyitoszam?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Település</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->shippingAddress->telepules?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Utca, házszám</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->shippingAddress->utca?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Épület, emelet, ajtó</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->shippingAddress->epulet ?: '&#8212;'?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                Számlázási cím
                            </h2>

                            <div class="order-info-table">
                                <div class="row">
                                    <div class="key">Név</div>
                                    <div class="value"><?=$cart->billingAddress->nev?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Adószám</div>
                                    <div class="value"><?=$cart->billingAddress->adoszam ?: '&#8212;'?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Ország</div>
                                    <div class="value"><?=$cart->billingAddress->country->nev?></div>
                                </div>
                                <div class="row">
                                    <div class="key">Irányítószám</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->billingAddress->iranyitoszam?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Település</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->billingAddress->telepules?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Utca, házszám</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->billingAddress->utca?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="key">Épület, emelet, ajtó</div>
                                    <div class="value">
                                        <div class="value"><?=$cart->billingAddress->epulet ?: '&#8212;'?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h2 id="contact-info-heading" class="mb-2 text-lg font-medium text-gray-900 flex items-center" style="justify-content: space-between;">
                                Megjegyzés
                            </h2>

                            <p><?=$cart->megjegyzes ?: '&#8212;'?></p>
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