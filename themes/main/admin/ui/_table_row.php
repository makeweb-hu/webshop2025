<tr data-id="<?=$model->getPrimaryKey()?>">
    <?php foreach (($columns ?? []) as $column): ?>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <?=\app\components\Helpers::renderColumn($model, $column)?>
        </td>
    <?php endforeach; ?>

    <?php if (count($actions) > 0): ?>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
            <?php foreach ($actions as $action): ?>
                <?=\app\components\Helpers::render('ui/action', array_merge($action, ['id'=>$model->getPrimaryKey()]))?>
            <?php endforeach; ?>
        </td>
    <?php endif; ?>
</tr>

