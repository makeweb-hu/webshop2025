<div class="input-row">
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700 mb-2"><?=$label?>

            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>

        </label>
    <?php endif; ?>

    <fieldset>
        <legend class="sr-only"></legend>
        <div class="bg-white rounded-md -space-y-px border" style="overflow: hidden">
            <!-- Checked: "bg-indigo-50 border-indigo-200 z-10", Not Checked: "border-gray-200" -->

            <?php foreach (($values ?? []) as $key => $caption): ?>

            <label class="relative border-b p-4 flex cursor-pointer focus:outline-none last-border-b-0">
                <input type="radio" <?=($value??'')==$key?'checked':''?> name="<?=$name ?? ''?>" value="<?=$key?>" class="h-4 w-4 mt-0.5 cursor-pointer text-indigo-600 border-gray-300 focus:ring-indigo-500" aria-labelledby="privacy-setting-0-label" aria-describedby="privacy-setting-0-description">
                <div class="ml-3 flex flex-col">
                    <?php if (is_array($caption)): ?>

                    <!-- Checked: "text-indigo-900", Not Checked: "text-gray-900" -->
                    <span  class="block text-sm font-medium">
                      <?=$caption[0]?>
                    </span>
                            <!-- Checked: "text-indigo-700", Not Checked: "text-gray-500" -->
                   <span  class="block text-sm text-gray-500">
                      <?=$caption[1]?>
                    </span>

                    <?php else: ?>

                    <span id="privacy-setting-0-label" class="block text-sm font-medium">
                      <?=$caption?>

                        <?php if ($tooltips[$key] ?? null): ?>
                            <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltips[$key])?>"></i>

                        <?php endif; ?>
                    </span>

                    <?php endif; ?>
                </div>
            </label>

            <?php endforeach; ?>

        </div>
    </fieldset>

    <p class="mt-2 text-sm text-red-600 hidden error-message" ></p>
</div>

