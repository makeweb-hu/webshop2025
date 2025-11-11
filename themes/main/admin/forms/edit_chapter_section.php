<?php
$model = \app\models\TudastarSzekcio::findOne($id) ?: new \App\Models\TudastarSzekcio();
$chapter = \app\models\TudastarFejezet::findOne(($model && $model->chapter) ? $model->chapter->id : ($chapter_id ?? 0));

?>

<form data-ajax-form data-action="/admin-api/edit?class=TudastarSzekcio&id=<?=$id?>" data-redirect-url="(current)">
    <input type="hidden" name="fejezet_id" value="<?=$chapter->getPrimaryKey()?>">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?=\app\components\Helpers::render('ui/select', [
        'name' => 'tipus',
        'label' => 'Típus',
        'value' => $model->tipus,
        'values' => [
            'szoveg' => 'Szöveg',
            'foto' => 'Kép',
            'video' => 'Videó',
            'gyik' => 'GYIK',
        ],
    ])?>
2
    <div data-visible-if="tipus:szoveg">
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
    </div>

    <div data-visible-if="tipus:video,foto">
        <?=\app\components\Helpers::render('ui/file', [
            'name' => 'fajl_id',
            'label' => 'Fotó',
            'value' => $model->fajl_id,
        ])?>
    </div>

    <div data-visible-if="tipus:video">
        <?=\app\components\Helpers::render('ui/input', [
            'name' => 'video_url',
            'label' => 'Videó URL',
            'value' => $model->video_url,
        ])?>
    </div>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'sorrend',
        'label' => 'Sorrend',
        'type' => 'text',
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

