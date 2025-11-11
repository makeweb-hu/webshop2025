<?php
$uploadId = \app\components\Helpers::random_bytes();

$model = \app\models\Fajl::findOne($value ?? 0);
if (!$model) {
    $value = ''; // deleted file
}

?>

<div class="input-row <?=($tiny??false) ? 'tiny-file-input':''?>" data-file-input>
    <?php if ($label ?? ''): ?>
        <label for="<?=$name ?? ''?>" class="block text-sm font-medium text-gray-700"


        ><?=$label ?? ''?>


            <?php if ($tooltip ?? null): ?>
                <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=htmlspecialchars($tooltip)?>"></i>

            <?php endif; ?>
        </label>
    <?php endif; ?>

    <input type="hidden" name="<?=$name ?? ''?>" value="<?=$value?>">

    <div data-uploaded-file class="relative mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"  style="<?=$model?'':'display:none;'?>">


        <div class="mt-2 mb-2 ml-2 mr-2 flex items-center flex-wrapper">
              <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100 relative mr-4 flex items-center justify-center flex-shrink-0" style="background-color: #e5e7eb">
                  <img data-photo-url src="<?=$model ? $model->resizePhotoCover(100, 100) : '/static/img/no-photo.jpg'?>" style="position: absolute; left: 0; top: 0; width: 100%; height: 100%; " />
              </span>
            <span class="filename">
                <span class="font-medium text-gray-800" data-filename>
                  <?=$model->fajlnev ?? ''?>
                </span>

                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800" data-filesize>
                  <?=\app\components\Helpers::humanFileSize($model->meret ?? 0)?>
                </span>
            </span>
            <button data-reupload type="button" class="ml-2 bg-white px-2.5 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fa-regular fa-cloud-arrow-up"></i> Módosítás
            </button>
            <button type="button" class="ml-2 bg-white px-2.5 py-1.5 border border-gray-300 rounded-md shadow-sm text-xs leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    data-confirm
                    data-title="Fájl törlése"
                    data-description="Biztos törölni szeretnéd a fájlt?"
                    data-yes="Törlés"
                    data-url="/admin-api/delete?class=Fajl"
                    data-confirm-id="<?=$uploadId?>-delete"
                    data-params='{"id":<?=($model ?? null) ? $model->getPrimaryKey() : 0?>}'
                    >
                <i class="fa-regular fa-trash"></i> Törlés
            </button>
        </div>

    </div>


    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md" data-file-empty-state style="<?=!$model?'':'display:none;'?>">
        <div class="space-y-1 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            <div class="flex text-sm text-gray-600 justify-center">
                <label for="f<?=$uploadId?>" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                    <span>Fájl feltöltése</span>
                    <input data-file-upload-input id="f<?=$uploadId?>" type="file" class="sr-only">
                </label>

            </div>
            <p class="text-xs text-gray-500 upload-info">
                PNG, JPG, GIF és maximum 10MB
            </p>
        </div>
    </div>


    <p class="mt-2 text-sm text-red-600 hidden error-message" >Your password must be less than 4 characters.</p>
</div>

