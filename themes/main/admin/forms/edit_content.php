<?php
$model = \app\models\Tartalom::findOne($id) ?: new \app\models\Tartalom();
$data = json_decode($model->adatok ?: '{}', true);

$schemaName = $schema;
$schema = \app\models\Tartalom::getContentSchemaByType($schema);

if (!$schema && $model->tipus) {
    $schema = \app\models\Tartalom::getContentSchemaByType($model->tipus);
}
?>


<form data-ajax-form data-action="/admin-api/edit-content?schema=<?=$schemaName?>&id=<?=$id?>" data-redirect-url="(current)">

    <?php foreach ($schema as $name => $type): ?>

        <?php if ($type === 'input'): ?>

            <?=\app\components\Helpers::render('ui/input', [
                'name' => $name,
                'label' => $name,
                'type' => 'text',
                'value' => $data[$name] ?? '',
            ])?>

        <?php elseif ($type === 'textarea'): ?>

            <?=\app\components\Helpers::render('ui/textarea', [
                'name' => $name,
                'label' => $name,
                'value' => $data[$name] ?? '',
            ])?>

        <?php elseif ($type === 'codemirror'): ?>

            <?=\app\components\Helpers::render('ui/codemirror', [
                'name' => $name,
                'label' => $name,
                'value' => $data[$name] ?? '',
            ])?>

        <?php elseif ($type === 'summernote'): ?>

            <?=\app\components\Helpers::render('ui/summernote', [
                'name' => $name,
                'label' => $name,
                'value' => $data[$name] ?? '',
            ])?>

        <?php elseif ($type === 'file'): ?>

        <?=\app\components\Helpers::render('ui/file', [
            'name' => $name,
            'label' => $name,
            'type' => 'text',
            'value' => $data[$name] ?? '',
        ])?>


        <?php elseif ($type === 'toggle'): ?>

            <?=\app\components\Helpers::render('ui/toggle', [
                'name' => $name,
                'label' => $name,
                'type' => 'text',
                'value' => $data[$name] ?? 0,
            ])?>

        <?php elseif (substr($type, 0, 6) === 'entity'): ?>
            <?php
               $otherContentType = explode(':', $type)[1];
               $otherContentSchema = \app\models\Tartalom::getContentSchemaByType($otherContentType);
               $otherContentColumns = array_slice(array_keys($otherContentSchema), 0, 1);
               $val = $data[$name] ?? null;
               if ($val) {
                   $val = json_decode($val, true)[0];
               }
            ?>
            <?=\app\components\Helpers::render('ui/entity', [
                'label' => $name,
                'name' => $name,
                'value' => $val,
                // 'overflow' => true,
                'class' => \app\models\Tartalom::class,
                'view' => 'forms/edit_content',
                'params' => [
                    'schema' => $otherContentType,
                ],
                // 'no_delete' => true,
                'columns' => ['kereses'],
            ])?>


        <?php elseif (substr($type, 0, 8) === 'entities'): ?>
            <?php
            $otherContentType = explode(':', $type)[1];
            $otherContentSchema = \app\models\Tartalom::getContentSchemaByType($otherContentType);
            $otherContentColumns = array_slice(array_keys($otherContentSchema), 0, 1);
            $val = $data[$name] ?? null;
            if ($val) {
                $val = json_decode($val, true)[0];
            }
            ?>
            <?=\app\components\Helpers::render('ui/entities', [
                'label' => $name,
                'name' => $name,
                'value' => $val,
                // 'overflow' => true,
                'class' => \app\models\Tartalom::class,
                'view' => 'forms/edit_content',
                'params' => [
                    'schema' => $otherContentType,
                ],
                // 'no_delete' => true,
                'columns' => ['kereses'],
            ])?>

        <?php elseif (substr($type, 0, 6) === 'lookup'): ?>
            <?php
            $otherContentType = explode(':', $type)[1];
            $otherContentSchema = \app\models\Tartalom::getContentSchemaByType($otherContentType);
            $otherContentColumns = array_slice(array_keys($otherContentSchema), 0, 1);
            $val = $data[$name] ?? null;
            ?>

            <?=\app\components\Helpers::render('ui/lookup', [
                'label' => $name,
                'name' => $name,
                'value' => $val,
                'class' => \app\models\Tartalom::class,
                'attrs' => ['kereses'],
                'except' => [],
                'column' => 'kereses',
            ])?>

        <?php endif; ?>

    <?php endforeach; ?>


    <?=\app\components\Helpers::render('ui/input', [
        'name' => 'sorrend',
        'label' => 'Sorrend',
        'placeholder' => 'Opcionális',
        'type' => 'text',
        'value' => $model->sorrend,
    ])?>

    <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
        <button type="button" data-close class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
            Mégse
        </button>
        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm">
            Mentés
        </button>

    </div>

</form>