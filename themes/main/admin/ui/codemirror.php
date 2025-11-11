<div class="input-row cm">
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700"


        ><?=$label?>


            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>

        </label>
    <?php endif; ?>
    <div class="mt-1">
        <textarea name="<?=$name?>" rows="5" placeholder="<?=$placeholder ?? ''?>" class="hidden-textarea shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"><?=$value?></textarea>
        <div data-code-mirror class="overflow-hidden shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></div>
    </div>
    <p class="mt-2 text-sm text-red-600 hidden error-message" >Your password must be less than 4 characters.</p>
</div>

