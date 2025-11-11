<?php
$RESULTS_PER_PAGE = $resultsPerPage ?? (($nopagination ?? null) ? ($hardlimit ?? 1000) : 20);

$q = trim(Yii::$app->request->get('q', ''));

$actions = $actions ?? [];

$widths = $widths ?? [];
if (count($widths) === 0) {
    $widths = [6];
}

$page = intval(Yii::$app->request->get('page', '0'));
$prevUrl = \app\components\Helpers::urlWithParam(Yii::$app->request->url, ['page' => $page - 1 ], Yii::$app->request->get('id', ''));
$nextUrl = \app\components\Helpers::urlWithParam(Yii::$app->request->url, ['page' => $page + 1 ], Yii::$app->request->get('id', ''));
$data = $class::find();
if ($q && ($search ?? null)) {
    $data = $search($data, $q);
}
if (is_callable($filter ?? null)) {
    $data = $filter($data);
}

$results = $data->offset($RESULTS_PER_PAGE * $page)->limit($RESULTS_PER_PAGE)->all();
$total = intval($data->count());

$nrOfPages = ceil($total / $RESULTS_PER_PAGE);
$isFirst = $page == 0;
$isLast = $page == $nrOfPages - 1;

if ($total === 0) {
    $isLast = true;
}

?>

<?php if ($search ?? null): ?>
<div class="flex justify-end mb-4">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input data-table-search-input type="search" id="default-search" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-full focus:ring-indigo-500" placeholder="Keresés..." required value="<?=$q?>">
    </div>
</div>
<?php endif; ?>

<div class="flex flex-col custom-table" style="margin-bottom: 15px">
    <div class="-my-2 <?=($overflow??null)?'':'overflow-x-auto'?> sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow <?=($overflow??null)?'':'overflow-hidden'?> border-b border-gray-200 sm:rounded-lg">

                <?php if ($title ?? ''): ?>
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-white">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        <?=$title ?: '-'?>
                        <?php if (($badge ?? null) !== NULL): ?>
                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                          <?=$badge?>
                        </span>
                        <?php endif; ?>
                    </h3>
                    <?php if ($subtitle ?? ''): ?>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        <?=$subtitle?>
                    </p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>


                <table class="min-w-full divide-y divide-gray-200">
                    <?php if (!($headless ?? '')): ?>
                    <thead class="bg-gray-50">
                    <tr>
                        <?php foreach (($columns ?? []) as $index => $column): ?>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <?=(new $class)->attributeLabels()[$column] ?? $column?>
                        </th>
                        <?php endforeach; ?>
                        <?php if (count($actions) > 0): ?>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only"></span>
                        </th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <?php endif; ?>
                    <tbody class="bg-white divide-y divide-gray-200">
                    <?php foreach ($results as $result): ?>
                        <?=\app\components\Helpers::render('ui/_table_row', [
                            'model' => $result,
                            'columns' => $columns ?? [],
                            'actions' => $actions ?? [],
                        ])?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php if (!($nopagination ?? '')): ?>
<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="py-3 flex items-center justify-between border-t border-gray-200" aria-label="Pagination">
    <div class="">
        <p class="text-sm text-gray-700">

            <span class="font-medium"><?=count($results)?></span>
            sor megjelenítve a
            <span class="font-medium"><?=$total?></span>
            találatból.
        </p>
    </div>
    <div class="flex-1 flex justify-end">

        <span class="relative z-0 inline-flex shadow-sm rounded-md">

            <a href="<?=$prevUrl?>" style="<?=$isFirst?'opacity:0.5;pointer-events:none;':''?>">
                <button type="button" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Previous</span>

                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
                </a>

            <select data-table-page-select id="" style="background-image: none; padding-right: 8px; height:100%;height: 38px;text-align: center;">
                <?php for ($i = 1; $i <= $nrOfPages; $i += 1): ?>
                    <option value="<?=$i?>" <?=($page+1) == $i?'selected':''?>  data-url="<?=\app\components\Helpers::urlWithParam(Yii::$app->request->url, ['page' => $i - 1 ], Yii::$app->request->get('id', ''))?>" >
                        <?=$i?>
                    </option>
                <?php endfor; ?>
            </select>

            <a href="<?=$nextUrl?>" style="<?=$isLast?'opacity:0.5;pointer-events:none;':''?>">
              <button type="button" class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                <span class="sr-only">Next</span>

                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
              </button>
                </a>
</span>


    </div>
</nav>
<?php endif; ?>


