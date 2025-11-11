<?php
$model = \app\models\Kosar::findOne($id) ?: new \App\Models\Kosar();
if (!$model->kupon_id) {
    $model->kupon_id = 0;
}
?>

<form data-ajax-form data-action="/admin-api/edit?class=Kosar&id=<?=$id?>" data-redirect-url="(current)">
    <?=\app\components\Helpers::render('ui/select', [
        'label' => 'Felhasznált kupon',
        'name' => 'kupon_id',
        'value' => $model->kupon_id,
        'values' => ['0' => '(egyedi kedvezmény)'] + \app\models\Kupon::allForSelect(),
    ])?>

    <div data-visible-if="kupon_id:0" style="display: none">
        <?=\app\components\Helpers::render('ui/input', [
            'label' => 'Kedvezmény összesen',
            'name' => 'kedvezmeny',
            'icon' => 'Ft',
            'value' => $model->kedvezmeny,
        ])?>

        <?=\app\components\Helpers::render('ui/select', [
            'label' => 'Kedvezmény hatása',
            'name' => 'kedvezmeny_hatasa',
            'tooltip' => 'Az ÁFA szempontjából van jelentősége.',
            'value' => $model->kedvezmeny_hatasa ?: 'termekek',
            'values' => [
                'termekek' => '<div style="white-space:normal;"><b class="font-medium">Termékek:</b> A megrendelt termékek összegéből vonódik le a kedvezmény.</div>',
                'szallitasi_dij' => '<div  style="white-space:normal;"><b class="font-medium">Szállítási díj:</b> A szállítási díjból vonódik le a kedvezmény..</div>',
                'vegosszeg' => '<div  style="white-space:normal;"><b class="font-medium">Végösszeg:</b> A rendelés teljes végösszegéből vonódik le a kedvezmény..</div>',
            ]
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

