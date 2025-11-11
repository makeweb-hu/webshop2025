<?php
$model = \app\models\KerdoivKerdes::findOne($id) ?: new \App\Models\KerdoivKerdes();

?>

<form data-ajax-form data-action="/admin-api/edit?class=KerdoivKerdes&id=<?=$id?>" data-redirect-url="(current)">
    <input type="hidden" name="kerdoiv_id" value="<?=$model->kerdoiv_id ?: $parent_id?>">

    <?=\app\components\Helpers::render('ui/langs', [

    ])?>

    <?php foreach (['hu','de','en','pl','fr','bg'] as $lang): $name = 'kerdes_' . $lang; ?>
        <div data-visible-if-lang data-lang="<?=$lang?>" style="display: none">
            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => $name,
                'label' => 'Kérdés',
                'type' => 'text',
                'value' => $model->$name,
            ])?>
        </div>
    <?php endforeach; ?>

    <?=\app\components\Helpers::render('ui/select', [
        'name' => 'tipus',
        'label' => 'Típus',
        'value' => $model->tipus,
        'placeholder' => 'Válasszon...',
        'values' => [
                // 'feleletvalasztos','igennem','likedislike','egytolotig','hangulatemoji','szomoruvidam','egytoltizig'
             '' => 'Válasszon...',
            'feleletvalasztos' => 'Feleletválasztós',
            'igennem' => 'Igen/nem',
            'likedislike' => 'Like/dislike',
            'egytolotig' => '1-5 skála',
            'egytoltizig' => '1-10 skála',
            'hangulatemoji' => 'Hangulat emoji',
            'szomoruvidam' => 'Szomorú/vidám emoji',
        ],
    ])?>


    <div data-visible-if="tipus:feleletvalasztos">
        <?=\app\components\Helpers::render('ui/entities', [
            'label' => 'Válaszlehetőségek',
            'name' => 'opciok',
            'value' => $model->isNewRecord ? [] : $model->optionIds(),
            'view' => 'forms/edit_question_option',
            'columns' => ['felelet_hu'],
            'class' => \app\models\KerdoivKerdesFelelet::class,
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

