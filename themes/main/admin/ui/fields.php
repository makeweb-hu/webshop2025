<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <?php if (($title ?? '') || ($description ?? '')): ?>
    <div class="px-4 py-5 sm:px-6">
        <?php if ($title ?? ''): ?>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            <?=$title?>
        </h3>
        <?php endif; ?>
        <?php if ($description ?? ''): ?>
        <p class="mt-1 max-w-2xl text-sm text-gray-500">
            <?=$description?>
        </p>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
        <dl class="sm:divide-y sm:divide-gray-200">
            <?php foreach (($columns ?? []) as $column): ?>

            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">
                    <?=(new $model)->attributeLabels()[$column] ?? $column?>

                    <?php if (($tooltips ?? [])[$column] ?? null): ?>
                        <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=$tooltips[$column]?>"></i>
                    <?php endif; ?>
                </dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <?=\app\components\Helpers::renderColumn($model, $column) ?? '-'?>
                </dd>
            </div>

            <?php endforeach; ?>

            <?php foreach (($keyValues ?? []) as $k => $v): ?>

                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                        <?=$k?>

                        <?php if (($tooltips ?? [])[$k] ?? null): ?>
                            <i class="fa-sharp fa-solid fa-circle-info" data-tooltip="<?=$tooltips[$k]?>"></i>
                        <?php endif; ?>
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2"  style="word-break: break-all;">
                        <?=$v?>
                    </dd>
                </div>

            <?php endforeach; ?>

        </dl>
    </div>
</div>

