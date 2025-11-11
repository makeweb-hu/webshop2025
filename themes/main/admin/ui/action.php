<?php

$isPrimary = $primary ?? false;
$tag = $tag ?? 'a';
$class = (
    $tag=='button'
    ? (
        $isPrimary
            ? 'items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
            : ' items-center mr-3 px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
    )
    : 'text-indigo-600 hover:text-indigo-900 ml-2'
);

$icon = trim($icon ?? '');
if (substr($icon, 0, 1) !== '<') {
    switch ($icon) {
        case 'delete':
            $icon = '<i class="fa-regular fa-trash"></i>'; break;
        case 'add':
            $icon = '<i class="fa-regular fa-circle-plus"></i>'; break;
        case 'edit':
            $icon = '<i class="fa-regular fa-pen"></i>'; break;
        case 'info':
            $icon = '<i class="fa-regular fa-circle-info"></i>'; break;
        case 'view':
            $icon = '<i class="fa-regular fa-eye"></i>'; break;
    }
}

?>

<?php if ($type === 'link'): ?>


    <<?=$tag?> href="<?=is_callable($url) ? $url($id) : \app\components\Helpers::urlWithId($url, $id ?? '')?>"

    <?php if ($tooltip ?? null): ?>
        data-tooltip="<?=htmlspecialchars($tooltip)?>"
    <?php endif; ?>

            class="<?=$class?>"
            <?=$tag==='button'?'onclick="window.location.href = \''.($url ?? '').'\';"':''?>

            <?=($fancybox??null)?'data-fancybox ':''?>

            target="<?=$target ?? ''?>">
        <?=$icon?> <?=$title ?>

    </<?=$tag?>>


<?php elseif ($type === 'modal'): ?>

    <?php if (!($show_if ?? null) || ($show_if($id))): ?>

        <<?=$tag?> href="javascript:void(0)" data-show-modal
           data-title="<?=htmlspecialchars(($title ?? '') ?: ($tooltip ?? ''))?>"
           data-view="<?=$view?>"
           data-modal-id="<?=$modal_id ?? ''?>"
           data-params="<?=htmlspecialchars(json_encode(array_merge($data ?? [], ['id' => $id ?? ''])))?>"
            <?php if ($tooltip ?? null): ?>
                data-tooltip="<?=htmlspecialchars($tooltip)?>"
            <?php endif; ?>
           class="<?=$class?>">

            <?=$icon?> <?=$title ?? ''?>

        </<?=$tag?>>

    <?php endif; ?>

<?php elseif ($type === 'confirm'): ?>
    <<?=$tag?> href="javascript:void(0)" data-confirm
        <?php if ($tooltip ?? null): ?>
            data-tooltip="<?=htmlspecialchars($tooltip)?>"
        <?php endif; ?>
       data-title="<?=htmlspecialchars($title ?? 'Biztos benne?')?>"
       data-description="<?=htmlspecialchars($description ?? '')?>"
       data-yes="<?=htmlspecialchars($yes ?? 'Igen')?>"
       data-url="<?=$url ?? Yii::$app->request->url?>"
       data-params="<?=htmlspecialchars(json_encode(array_merge($data ?? [], ['id' => $id ?? ''])))?>"
       data-confirm-id="<?=$confirm_id ?? ''?>"
       class="<?=$class?>">
        <?=$icon?> <?=$title ?? ''?>
    </<?=$tag?>>
<?php endif; ?>


