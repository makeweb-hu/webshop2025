<?php
$model = \app\models\StatikusSzoveg::findOne($id) ?: new \App\Models\StatikusSzoveg();

?>

<form data-ajax-form data-action="/admin-api/edit?class=StatikusSzoveg&id=<?=$id?>" data-redirect-url="(current)">
        <?php if ($model->isNewRecord): ?>

            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'nev',
                'label' => 'Név',
                'type' => 'text',
                'value' => $model->nev,
            ])?>

            <?=\app\components\Helpers::render('ui/select', [
                'name' => 'tipus',
                'label' => 'Típus',
                'type' => 'text',
                'values' => \app\models\StatikusSzoveg::types(),
                'value' => $model->tipus ?: 'rovid_szoveg',
            ])?>

        <?php elseif ($model->tipus === 'rovid_szoveg'): ?>

            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'tartalom_hu',
                'label' => 'Tartalom',
                'type' => 'text',
                'value' => $model->tartalom_hu,
            ])?>

        <?php  elseif ($model->tipus === 'hosszu_szoveg'): ?>

            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => 'tartalom_hu',
                'label' => 'Tartalom',
                'type' => 'text',
                'rows' => 5,
                'value' => $model->tartalom_hu,
            ])?>


        <?php  elseif ($model->tipus === 'html'): ?>

            <?=\app\components\Helpers::render('ui/codemirror', [
                'name' => 'tartalom_hu',
                'label' => 'Tartalom',
                'type' => 'text',
                'value' => $model->tartalom_hu,
            ])?>

        <?php  elseif ($model->tipus === 'formazott_szoveg'): ?>

            <?=\app\components\Helpers::render('ui/summernote', [
                'name' => 'tartalom_hu',
                'label' => 'Tartalom',
                'type' => 'text',
                'value' => $model->tartalom_hu,
            ])?>

        <?php  elseif ($model->tipus === 'fajl'): ?>

            <?=\app\components\Helpers::render('ui/file', [
                'name' => 'tartalom_hu',
                'label' => 'Tartalom',
                'type' => 'text',
                'value' => $model->tartalom_hu,
            ])?>

        <?php endif; ?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

