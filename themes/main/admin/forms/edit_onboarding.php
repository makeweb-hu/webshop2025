<?php
$model = \app\models\Onboarding::findOne($id) ?: new \app\models\Onboarding();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Onboarding&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'sor_1_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Sor 1.',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'sor_2_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Sor 2.',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>

    <?=\app\components\Helpers::render('ui/file', [
        'label' => 'Kép',
        'name' => 'fajl_id',
        'value' => $model->fajl_id ?? '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'sorrend',
        'label' => 'Sorrend',
        'value' => $model->sorrend,
    ])?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

