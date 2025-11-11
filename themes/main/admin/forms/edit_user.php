<?php
$model = \app\models\Felhasznalo::findOne($id) ?: new \app\models\Felhasznalo();

?>

<form data-ajax-form data-action="/admin-api/edit?class=Felhasznalo&id=<?=$id?>" data-redirect-url="(current)">

    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Név',
        'name' => 'nev',
        'value' => $model->nev ?? '',
    ])?>

    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'email',
        'label' => 'E-mail cím',
        'value' => $model->email ?? '',
    ])?>

    <?=\app\components\Helpers::render('ui/radios', [
        'label' => 'Jogosultság',
        'name' => 'jogosultsag',
        'value' =>  $model->jogosultsag,
        'values' => \app\models\Felhasznalo::roleNames(),

    ])?>

    <?php if ($model->isNewRecord): ?>
    <?=\app\components\Helpers::render('ui/input', [
        'label' => 'Ideiglenes jelszó',
        'name' => 'tempPassword',
        'tooltip' => 'Üres hagyva is generál a rendszer egy random jelszót.',
        'value' =>  \app\components\Helpers::random_bytes(8),
    ])?>
    <?php endif; ?>

    <?=\app\components\Helpers::render('ui/toggle', [
        'label' => 'Kér e-mail értesítése',
        'tooltip' => 'Pl. új rendelés beérkezéséről',
        'name' => 'ertesites',
        'value' => $model->ertesites ? 1 : 0,

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

