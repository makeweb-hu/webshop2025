<?php
$cart = \app\models\Kosar::findOne([
    'rendelesszam' => Yii::$app->request->get('number'),
]);

?>

<div class="bg-white" data-checkout-page>
    <!-- Background color split screen for large screens -->
    <div class="hidden lg:block fixed top-0 left-0 w-1/2 h-full bg-white" aria-hidden="true"></div>
    <div class="hidden lg:block fixed top-0 right-0 w-1/2 h-full bg-gray-50" aria-hidden="true"></div>

    <header class="relative bg-white border-b border-gray-200 text-sm font-medium text-gray-700" style="background-color: #501E3F">
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

        <form data-checkout-form class="pt-16 pb-36 px-4 sm:px-6 lg:pb-16 lg:px-0 lg:row-start-1 lg:col-start-1">
            <div class="max-w-lg mx-auto lg:max-w-none">
                <section aria-labelledby="contact-info-heading">
                    <h2 id="contact-info-heading" class="text-lg font-medium text-gray-900 flex items-center" style="color: #78ae56">
                        <svg data-checkmark="" class="h-5 w-5 text-indigo-600 undefined mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>

                        Sikeres rendelés</h2>

                    <br>

                    Köszönjük a vásárlást!


                    <br><br>

                    Rendelését rögzítettük, melyről e-mail értesítést is küldtünk Önnek.


                    <br><br>

                    Amennyiben előre utalást választott, kérjük, a rendelés végösszegét (<?=\app\components\Helpers::formatMoney( $cart->getTotal() )?>) utalja el az alábbi banszámlaszámra.

                    <br><br>
                    <table>
                        <tr>
                            <td>Kedvezményezett:</td>
                            <td style="padding-left: 10px"><b>Markos Ágnes EV</b></td>
                        </tr>
                        <tr>
                            <td>Bankszámlaszám:</td>
                            <td style="padding-left: 10px; white-space: nowrap;"><b>11600006-00000000-97591612 (ERSTE Bank)</b></td>
                        </tr>
                        <tr>
                            <td>Összeg:</td>
                            <td style="padding-left: 10px"><b><?=\app\components\Helpers::formatMoney( $cart->getTotal() )?></b></td>
                        </tr>
                        <tr>
                            <td>Közlemény:</td>
                            <td style="padding-left: 10px"><b><?=$cart->rendelesszam?></b></td>
                        </tr>
                    </table>

                    <br>

                    Köszönettel,<br>
                    <b style="font-weight: 600">Borago.hu</b>

                </section>


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