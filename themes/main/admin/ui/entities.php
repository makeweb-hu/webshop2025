<?php
$className = explode('\\', $class);
$className = $className[count($className)-1];
$value = $value ?? [];
$entitiesId = \app\components\Helpers::random_bytes();

if ($no_edit ?? null) {
    $actions = [
        array_merge([
            'type' => 'confirm',
            'icon' => 'delete',
            //'title' => 'Töröl',
            'tooltip' => 'Töröl',
            'description' => 'Biztos törölni szeretnéd az elemet?',
            'url' => '/admin-api/delete?class=' . $className,
            'confirm_id' => $entitiesId . '-delete',
        ], $params ?? [])
    ];
} else {

    if ($no_delete) {
        $actions = [
            array_merge([
                'type' => 'modal',
                'icon' => 'edit',
                //'title' => 'Szerkeszt',
                'tooltip' => 'Szerkeszt',
                'view' => $view,
                'modal_id' => $entitiesId . '-edit',
            ], $params ?? []),
        ];
    } else {
        $actions = [
            array_merge([
                'type' => 'modal',
                'icon' => 'edit',
                //'title' => 'Szerkeszt',
                'tooltip' => 'Szerkeszt',
                'view' => $view,
                'modal_id' => $entitiesId . '-edit',
            ], $params ?? []),
            array_merge([
                'type' => 'confirm',
                'icon' => 'delete',
                //'title' => 'Töröl',
                'tooltip' => 'Töröl',
                'description' => 'Biztos törölni szeretnéd az elemet?',
                'url' => '/admin-api/delete?class=' . $className,
                'confirm_id' => $entitiesId . '-delete',
            ], $params ?? [])
        ];
    }
}

?>

<div class="input-row" data-entities data-max="<?=$max ?? ''?>" data-entities-id="<?=$entitiesId?>"
        data-columns="<?=htmlspecialchars(json_encode($columns ?? []))?>"
        data-actions="<?=htmlspecialchars(json_encode($actions))?>"
        data-class="<?=$class?>"
        data-force-reload="<?=$forceReload??''?>"
     >
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700 mb-2">

            <?=$label?>


            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>

        </label>
    <?php endif; ?>

    <input type="hidden" name="<?=$name ?? ''?>" value="<?=json_encode($value ?? [])?>"/>

    <?=\app\components\Helpers::render('ui/table', [
        'class' => $class,
        'columns' => $columns ?? [],
        'overflow' => $overflow ?? null,
        'filter' => function ($query) use ($value) {
            if (count($value) === 0) {
                return $query->where(['in', 'id', [ 0 ]]);
            }
            return $query->where(['in', 'id', $value]);
        },
        'actions' => $actions,
        'headless' => is_null($headless ?? null) ? true : $headless,
        'nopagination' => true,
    ])?>

    <button data-empty-state data-add-entity type="button" class="relative block w-full border-2 border-gray-300 border-dashed rounded-lg p-4 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            style="margin-bottom: 15px; display: none;"
            data-show-modal data-view="<?=$view?>" data-modal-id="<?=$entitiesId . '-add'?>"
            data-params="<?=htmlspecialchars(json_encode($params ?? [], true))?>"
            data-title="<?=($max ?? '') == 1 ? 'Hozzáadás':'Új hozzáadása'?>" >
        <span class="block text-sm font-medium text-gray-900" style="display: flex; align-items: center; justify-content: center; color: #2ab3e9;">
            <i class="fa-regular fa-circle-plus" style="font-size: 130%"></i> &nbsp; <?=($max ?? '') == 1 ? 'Hozzáadás':'Új hozzáadása'?>
        </span>
    </button>


    <button data-add-entity type="button" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            data-show-modal data-view="<?=$view?>" data-modal-id="<?=$entitiesId . '-add'?>" data-title="<?=($max ?? '') == 1 ? 'Hozzáadás':'Új hozzáadása'?>"
            data-params="<?=htmlspecialchars(json_encode($params ?? [], true))?>"
    >
        <i class="fa-regular fa-plus-circle"></i> &nbsp; <?=($max ?? '') == 1 ? 'Hozzáadás':'Új hozzáadása'?>
    </button>

    <p class="mt-2 text-sm text-red-600 hidden error-message" >Your password must be less than 4 characters.</p>

</div>

