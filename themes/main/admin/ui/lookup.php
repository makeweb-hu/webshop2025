<?php
if ($class === '(global)') {
    $columnHtml = '';
} else {
    $model = $class::findOne($value ?? null);
    $columnHtml = $model ? $model->columnViews()[$column]() : '';
}

?>

<div class="input-row" data-lookup data-except="<?=implode(',', $except ?? [])?>" data-class="<?=$class?>" data-column="<?=$column ?? ''?>" data-attrs="<?=htmlspecialchars(json_encode($attrs ?: []))?>">
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700"


        ><?=$label?>

            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>

        </label>
    <?php endif; ?>

    <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none" data-icon style="z-index: 1; <?=$model?'display:none':''?>">
            <i class="fa-regular fa-magnifying-glass" style="font-size: 15px"></i>
        </div>

        <div class="absolute inset-y-0 right-4 pl-3 flex items-center text-gray-400 cursor-pointer" data-remove style="z-index: 1; <?=!$model?'display:none':''?> ">
            <i class="fa-regular fa-times"></i>
        </div>

        <input type="hidden" name="<?=$name ?? ''?>" value="<?=$value ?? ''?>" />

        <div class="relative w-full bg-white border-gray-300 rounded-md shadow-sm text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <input type="text" data-search-input class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-9 sm:text-sm border-gray-300 rounded-md"
                   placeholder="Keresés..." style="<?=!$columnHtml?'':'display:none;'?>" />

            <div data-value-html class="pl-3 pr-10 py-2 bg-gray-100 rounded-md border border-gray-300" style="<?=$columnHtml?'':'display:none'?>">
                <?=$columnHtml?>
            </div>
        </div>

        <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm" data-dropdown style="display: none">

            <li class="text-gray-900 cursor-default select-none relative py-2 pl-4 pr-4" id="listbox-option-0" role="option" data-key="0">

                <span class="font-normal block truncate" data-item-text="">fdsfsdf</span>

            </li>

        </ul>

    </div>

    <p class="mt-2 text-sm text-red-600 hidden error-message" >Your password must be less than 4 characters.</p>
</div>