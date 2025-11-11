
<div class="input-row">
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700 mb-2"><?=$label?>


            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>
        </label>
    <?php endif; ?>

    <div data-toggle>
        <input type="hidden" value="<?=$value?>" name="<?=$name ?? ''?>" />

        <button type="button" class="<?=(strval($value) === '1')?'bg-indigo-500':'bg-gray-200'?> relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" role="switch" aria-checked="false">
            <span class="sr-only"></span>
            <!-- Enabled: "translate-x-5", Not Enabled: "translate-x-0" -->
            <span data-handle aria-hidden="true" class="<?=(strval($value)==='1')?'translate-x-5':''?> pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"></span>
        </button>
    </div>

    <p class="mt-2 text-sm text-red-600 hidden error-message" >Your password must be less than 4 characters.</p>
</div>

