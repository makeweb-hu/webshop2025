<?php
$cart = \app\models\Kosar::current();
if (!$cart) {
    $items = [];
} else {
    $items = $cart->items;
}

if (!$cart->shipping) {
    return;
}

?>


<div class="pt-10">
    <fieldset>
        <legend class="text-lg font-medium text-gray-900">
            Fizetési mód
        </legend>

        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">

            <?php foreach ($cart->shipping->getPayments() as $item): ?>
                <label class="relative bg-white border rounded-lg shadow-sm p-4 flex cursor-pointer focus:outline-none border-gray-300 undefined <?=$cart->fizetes_id == $item->id ? 'active' : ''?>" data-method data-id="<?=$item->id?>" data-field-name="payment">

                    <div class="flex-1 flex">
                        <div class="flex flex-col">
                                            <span id="delivery-method-0-label" class="block text-sm font-medium text-gray-900">
                                              <?=$item->nev?>
                                            </span>


                            <!--
                                            <span id="delivery-method-0-description-1" class="mt-6 text-sm font-medium text-gray-900">
                                              <?=\app\components\Helpers::formatMoney( $item->ar ) ?>
                                            </span>
                                            -->
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