<?php
$model = \app\models\Szamla::findOne($id);
?>
Biztos sztornózni szeretnéd a(z) <b class="font-medium"><?=$model->bizonylatszam?></b> számú bizonylatot?

<form data-ajax-form data-action="/admin-api/cancel-invoice" class="text-sm">


    <input type="hidden" name="id" value="<?=$id?>" />

<div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
    <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
        Mégse
    </button>
    <button type="submit" class="w-full inline-flex justify-center items-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
        <i class="fa-solid fa-ban mr-2"></i> Sztornózás
    </button>

</div>

</form>