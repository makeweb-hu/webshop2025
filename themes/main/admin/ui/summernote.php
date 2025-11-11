<div data-summernote style="width: 100%" class="input-row">

    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700 mb-2"


        ><?=$label?>


            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input type="hidden" name="<?=$name ?? ''?>">
    <div class="summernote-container"><?=$value??''?></div>
    <div class="html-view"></div>

    <p class="mt-2 text-sm text-red-600 hidden error-message" ></p>
</div>

