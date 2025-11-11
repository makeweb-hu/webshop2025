<?php
$model = \app\models\Kupon::findOne($id) ?: new \App\Models\Kupon();
$model->ervenyessegi_ido = boolval($model->ervenyesseg_kezdete  || $model->ervenyesseg_vege) ? 1 : 0;
?>

<form data-ajax-form data-action="/admin-api/edit?class=Kupon&id=<?=$id?>" data-redirect-url="(current)">


    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'kod',
        'label' => 'Kód',
        'tooltip' => 'Ezt a kódot fogják beírni a vásárlók.',
        'type' => 'text',
        'value' => $model->kod ?: '',
    ])?>


    <?=\app\components\Helpers::render('ui/radios', [
        'label' => 'Kedvezmény hatása',
        'name' => 'kedvezmeny_hatasa',
        'value' => $model->kedvezmeny_hatasa ?: 'termekek',
        'values' => [
            'termekek' => ['Termékek', 'A kosárban lévő termékek összegéből vonódik le a kedvezmény.'],
            'szallitasi_dij' => ['Szállítási díj', 'Az esetleges szállítási díjból vonódik le a kedvezmény.'],
            'vegosszeg' => ['Végösszeg', 'A kosár teljes végösszegéből vonódik le a kedvezmény.'],
        ]
    ])?>

    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
        <div class="sm:col-span-3">
        <?=\app\components\Helpers::render('ui/select', [
            'label' => 'Kedvezmény típusa',
            'name' => 'kedvezmeny_tipusa',
            'value' => $model->kedvezmeny_tipusa ?: 'szazalek',
            'values' => [
                'szazalek' => 'Százalék',
                'fix_osszeg' => 'Fix összeg',
            ],
        ])?>
            </div>

        <div class="sm:col-span-3">
            <?=\app\components\Helpers::render('ui/input', [
                'label' => 'Kedvezmény mértéke',
                'name' => 'kedvezmeny_merteke',
                'value' => $model->kedvezmeny_merteke ?: '',
            ])?>
        </div>
    </div>

    <hr class="mb-4">

    <?=\app\components\Helpers::render('ui/checkbox', [
        'label' => 'Érvényességi idő megadása',
        'name' => 'ervenyessegi_ido',
        'value' => $model->ervenyessegi_ido ?: 0,
    ])?>

    <div data-visible-if="ervenyessegi_ido:1" style="display: none;">
        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6 sm:gap-y-0">
            <div class="sm:col-span-3">
                <?=\app\components\Helpers::render('ui/date', [
                    'label' => 'Érvényesség kezdete',
                    'name' => 'ervenyesseg_kezdete',
                    'tooltip' => 'Üresen hagyva azonnal érvényes lesz.',
                    'value' => $model->ervenyesseg_kezdete ?: '',
                ])?>
            </div>

            <div class="sm:col-span-3">
                <?=\app\components\Helpers::render('ui/date', [
                    'label' => 'Érvényesség vége',
                    'name' => 'ervenyesseg_vege',
                    'tooltip' => 'Üresen hagyva nem lesz lejárata.',
                    'value' => $model->ervenyesseg_vege ?: '',
                ])?>
            </div>
        </div>
    </div>


    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Státusz',
        'name' => 'statusz',
        'value' => $model->statusz ?: '0',
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

