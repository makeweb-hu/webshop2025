<?php
$model = \app\models\UtemezettUzenet::findOne($id) ?: new \App\Models\UtemezettUzenet();

?>

<form data-ajax-form data-action="/admin-api/edit?class=UtemezettUzenet&id=<?=$id?>" data-redirect-url="(current)">
    <input type="hidden" name="kerdoiv_id" value="<?=$model->kerdoiv_id ?: $parent_id?>">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?php foreach (['hu','en','pl','fr','bg'] as $lang): $name = 'cim_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Cím',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'leiras_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => $name,
                'label' => 'Leírás',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>



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
                    'kerdoiv' => 'Kérdőív',
                ],
            ])?>
        </div>

        <div style="width:50%;margin-left:15px;display: none" data-visible-if="deeplink_tipusa:dashboard,kerdoiv">

            <div data-visible-if="deeplink_tipusa:dashboard" >
                <?=\app\components\Helpers::render('ui/select', [
                    'name' => 'dashboard_id',
                    'label' => 'Dashboard oldal',
                    'values' => \app\models\Dashboard::allForSelect(),
                    'value' => $model->dashboard_id,
                ])?>
            </div>

            <div data-visible-if="deeplink_tipusa:kerdoiv" >
                <?=\app\components\Helpers::render('ui/select', [
                    'name' => 'kerdoiv_id',
                    'label' => 'Kérdőív',
                    'values' => \app\models\Kerdoiv::allForSelect(),
                    'value' => $model->kerdoiv_id,
                ])?>
            </div>
        </div>
    </div>

    <div>
        <?=\app\components\Helpers::render('ui/entities', [
            'label' => 'Feltételek',
            'name' => 'feltetelek',
            'value' => $model->isNewRecord ? [] : $model->conditionIds(),
            'view' => 'forms/edit_condition',
            'columns' => ['name'],
            'class' => \app\models\UtemezettUzenetFeltetel::class,
        ])?>
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

