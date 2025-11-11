<?=\app\components\Helpers::render('ui/entities', [
    'name' => $name ?? '',
    'label' => $label ?? '',
    'class' => $class ?? null,
    'columns' => $columns ?? [],
    'headless' => $headless ?? null,
    'max' => 1,
    'no_delete' => $no_delete ?? false,
    'view' => $view,
    'value' => is_null($value) ? [] : [$value],
    'params' => $params ?? [],
])?>

