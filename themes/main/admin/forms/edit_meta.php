<?php
$model = $id ? \app\models\Oldal::findOne($id) : new \app\models\Oldal;

?>

<form data-ajax-form data-action="/admin-api/edit?class=Oldal&id=<?=$id?>" data-show-popup-on-success="Adatok sikeresen elmentve." data-redirect-url="(current)">

    <?php if ($model->isNewRecord || $model->tipus === 'atiranyitas'): ?>
        <?php if ($model->isNewRecord): ?>
        <?=\app\components\Helpers::render('ui/select', [
            'name' => 'tipus',
            'label' => 'Típus',
            'value' => 'atiranyitas',
            'values' => [
                    'atiranyitas' => 'Átirányítás'
            ],
        ])?>
        <?php endif; ?>
    <?php else: ?>

        <div>
            <?=\app\components\Helpers::render('ui/input', [
                'name' => 'cim',
                'label' => 'Meta cím',
                'type' => 'text',
                'placeholder' => !$model ? '' : $model->getModel()->nev,
                'value' => $model->cim,
            ])?>

            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => 'leiras',
                'label' => 'Meta leírás',
                'rows' => 3,
                'value' => $model->leiras,
            ])?>

            <?=\app\components\Helpers::render('ui/file', [
                'label' => 'Meta kép',
                'name' => 'kep_id',
                'value' => $model->kep_id ?? '',
            ])?>
        </div>
    <?php endif; ?>

    <?php if ($model->tipus !== 'fooldal'): ?>

        <?=\app\components\Helpers::render('ui/input', [
            'label' => 'URL',
            'name' => 'url',
            'value' => $model->url ?? '',
        ])?>

        <div style="font-size: 80%; opacity: 0.65; margin-top: -10px; margin-bottom: 15px;">
            <?=\app\models\Beallitasok::get('domain')?>/<b data-clone-input="url"><?=$model->url?></b>
        </div>

    <?php endif; ?>

    <?php if ($model->isNewRecord || $model->tipus === "atiranyitas"): ?>


    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Hová irányítson?',
        'name' => 'hova',
        'value' => $model->hova ?? '',
    ])?>

    <div style="font-size: 80%; opacity: 0.65; margin-top: -10px; margin-bottom: 15px;">
        <?=\app\models\Beallitasok::get('domain')?>/<b data-clone-input="hova"><?=$model->hova?></b>
    </div>

        <?=\app\components\Helpers::render('ui/select', [
            'label' => 'Típus',
            'name' => 'atiranyitas_statusz',
            'value' => $model->atiranyitas_statusz ?: 301,
            'values' => [
                '301' => '301-es átirányítás',
                '302' => '302-es átirányítás',
            ],
        ])?>

    <?php endif; ?>

    <div class="mt-10 flex justify-end">

        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>

