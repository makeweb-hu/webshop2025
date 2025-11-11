<?php
$model = \app\models\UtemezettUzenetFeltetel::findOne($id) ?: new \app\models\UtemezettUzenetFeltetel();

?>

<form data-ajax-form data-action="/admin-api/edit?class=UtemezettUzenetFeltetel&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Feltétel típusa',
        'name' => 'tipus',
        'value' => $model->tipus ?: 'welcome',
        'values' => [
            'welcome' => 'Welcome (nincs feltétel)',
            'nap_eltelt' => 'X nap elteltével',
            'termeket_rendelt' => 'Adott terméket már rendelt',
            'valaszt_adott' => 'Adott választ adott egy kérdésre',
            'napja_rendelt' => 'X napja adott le rendelést',
            'szulot_nem_nyitotta_meg' => 'Előző üzenetet nem nyitotta meg',
            'idopont' => 'Idpőpont',
        ]
    ])?>

    <div data-visible-if="tipus:nap_eltelt,napja_rendelt" style="display: none">
        <?=\app\components\Helpers::render('ui/input', [
            'label' => 'Nap',
            'name' => 'nap',
            'value' => $model->nap,
        ])?>
    </div>

    <div data-visible-if="tipus:idopont" style="display: none">
        <?=\app\components\Helpers::render('ui/input', [
            'label' => 'Idpőpont',
            'name' => 'idopont',
            'value' => $model->idopont,
            'placeholder' => 'óó:pp',
        ])?>
    </div>

    <div data-visible-if="tipus:termeket_rendelt" style="display: none">
        <?=\app\components\Helpers::render('ui/select', [
            'label' => 'Termék',
            'name' => 'termek_id',
            'value' => $model->idopont,
            'values'=>\app\models\FlavonTermek::allForSelect(),
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

