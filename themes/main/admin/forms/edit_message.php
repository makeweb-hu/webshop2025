<?php
$model = \app\models\Uzenet::findOne($id) ?: new \App\Models\Uzenet();
?>

<form data-ajax-form data-action="/admin-api/edit?class=Uzenet&id=<?=$id?>" data-redirect-url="(current)">
    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?php if ($model->isNewRecord): ?>
        <input type="hidden" name="idopont" value="<?=date('Y-m-d H:i:s')?>">
    <?php endif; ?>

    <?=\app\components\Helpers::render('ui/select', [
        'name' => 'tipus',
        'label' => 'Típus',
        'value' => $model->tipus,
        'values' => [
                'info' => 'Infó',
            'hirlevel' => 'Hírlevél',
        ],
    ])?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'nev_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Címsor',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'tartalom_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => $name,
                'label' => 'Tartalom',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>


    <?=\app\components\Helpers::render('ui/toggle', [
        'name' => 'push_uzenet',
        'label' => 'Push üzenet',
        'type' => 'text',
        'value' => $model->push_uzenet ?: 0,
    ])?>

    <div style="display:flex" data-visible-if="push_uzenet:1">
        <div style="width:50%">
            <?=\app\components\Helpers::render('ui/select', [
                'name' => 'deeplink_tipusa',
                'label' => 'Link',
                'value' => $model->deeplink_tipusa ?: 'tartalom',
                'values' => [
                    'tartalom' => '(üzenet tartalma)',
                    'termekek' => 'Terméklista',
                    'termek' => 'Termék',
                    'tudastar' => 'Tudástár',
                    'tudastar_anyag' => 'Tudástár tananyag',
                    'dashboard' => 'Dashboard oldal',
                ],
            ])?>
        </div>

        <div style="width:50%;margin-left:15px" data-visible-if="deeplink_tipusa:dashboard">

            <div data-visible-if="deeplink_tipusa:dashboard" >
                <?=\app\components\Helpers::render('ui/select', [
                    'name' => 'dashboard_id',
                    'label' => 'Dashboard oldal',
                    'values' => \app\models\Dashboard::allForSelect(),
                    'value' => $model->dashboard_id,
                ])?>
            </div>
        </div>
    </div>


    <?php if ($model->isNewRecord): ?>
        <?=\app\components\Helpers::render('ui/textarea', [
            'name' => 'cimzettek',
            'label' => 'Címzettek',
            'tooltip' => 'M-azonosítók vesszővel elválasztva. Üresen hagyva a rendszer mindenkinek elküldi az üzenetet.'
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

