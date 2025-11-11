<?php
$model = \app\models\DashboardKartya::findOne($id) ?: new \app\models\DashboardKartya();
$dashboard = \app\models\Dashboard::findOne($dashboard_id ?? $model->szulo_dashboard);
$card = \app\models\DashboardKartya::findOne($card_id ?? ($model->szulo_kartya));

?>

<form data-ajax-form data-action="/admin-api/edit?class=DashboardKartya&id=<?=$id?>" data-redirect-url="(current)">

    <input type="hidden" name="szulo_dashboard" value="<?=$dashboard->id?>">
    <input type="hidden" name="szulo_kartya" value="<?=$card?$card->id:''?>">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <div style="<?=$card?'display:none;':''?>">
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'tipus',
            'label' => 'Típus',
            'values' => [
                 'half' => 'Fél kártya',
                'full' => 'Teljes kártya',
                'scroll' => 'Görgethető kártyák',
                'half_random' => 'Random fél kártya',
                'welcome' => 'Welcome kártya',
                'kpi' => 'KPI kártya'
            ],
            'value' => $card ? 'full' : $model->tipus,
        ])?>
    </div>

    <div data-visible-if="tipus:half,full">
        <?=\app\components\Helpers::render('ui/file', [
            'label' => 'Kép',
            'name' => 'fajl_id',
            'value' => $model->fajl_id ?? '',
        ])?>
    </div>

    <div data-visible-if="tipus:half,full">
        <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'cim_1_' . $lang; ?>
            <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
                <?=\app\components\Helpers::render('ui/input', [
                    'name' => $name,
                    'label' => 'Cím 1',
                    'type' => 'text',
                    'value' => $model->$name,
                ])?>
            </div>
        <?php endforeach; ?>
    </div>

    <div data-visible-if="tipus:full">
    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'cim_2_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Cím 2',
                'tooltip' => 'Nem kötelező.',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>
    </div>

    <div data-visible-if="tipus:half,full">
    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'badge_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => 'Badge',
                'tooltip' => 'Nem kötelező.',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>
    </div>

    <div style="display:flex">
        <div data-visible-if="tipus:welcome,half,full" style="width:50%">
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'link_tipusa',
            'label' => 'Link',
            'value' => $model->link_tipusa ?: 'none',
            'values' => [
                'none' => '(nem linkel)',
                'url' => 'URL',
                'termekek' => 'Terméklista',
                'termek' => 'Termék',
                'tudastar' => 'Tudástár',
                'tudastar_anyag' => 'Tudástár tananyag',
                'dashboard' => 'Dashboard oldal',
            ],
        ])?>
        </div>

    <div style="width:50%;margin-left:15px" data-visible-if="link_tipusa:dashboard,url">
        <div data-visible-if="link_tipusa:url" >
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'url',
                'label' => 'URL',
                'type' => 'text',
                'value' => $model->url,
            ])?>
        </div>

        <div data-visible-if="link_tipusa:dashboard" >
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'dashboard_id',
            'label' => 'Dashboard oldal',
            'values' => \app\models\Dashboard::allForSelect(),
            'value' => $model->dashboard_id,
        ])?>
        </div>
    </div>
    </div>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'sorrend',
        'label' => 'Sorrend',
        'type' => 'text',
        'value' => $model->sorrend,
    ])?>

    <div data-visible-if="tipus:welcome,half,full">
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'szin',
            'label' => 'Szín',
            'value' => $model->szin ?: 'kek',
            'values' => [
                'kek' => '<span class="flex items-center"><span class="mr-1 rounded-full w-4 h-4" style="background-color: #2AB3E9"></span>Kék</span>',
                'piros' => '<span class="flex items-center"><span class="mr-1 rounded-full w-4 h-4" style="background-color: #CC2D59"></span>Piros</span>',
                'narancs' => '<span class="flex items-center"><span class="mr-1 rounded-full w-4 h-4" style="background-color: #F8A31E"></span>Narancs</span>',
                'zold' => '<span class="flex items-center"><span class="mr-1 rounded-full w-4 h-4" style="background-color: #77A534"></span>Zöld</span>',
                'lila' => '<span class="flex items-center"><span class="mr-1 rounded-full w-4 h-4" style="background-color: #A15BBA"></span>Lila</span>'
            ],
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

