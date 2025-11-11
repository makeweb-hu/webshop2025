
<div class="md:flex md:items-center md:justify-between" style="<?=($no_margin??null)?'margin-bottom:15px;':'margin-bottom:40px;'?>"">
    <div class="flex-1 min-w-0">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate" >
            <?=$title ?? ''?>
        </h2>
    </div>
    <div class="mt-4 flex md:mt-0 md:ml-4">
        <?php foreach (array_slice($actions ?? [], 1) as $action): ?>
            <?=\app\components\Helpers::render('ui/action', array_merge($action, [
                    'tag' => 'button',
            ]))?>
        <?php endforeach; ?>

        <?php if ($subactions ?? null): ?>
        <div class="relative inline-block text-left" data-subaction>
            <div>
                <button type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-indigo-500" id="menu-button" aria-expanded="true" aria-haspopup="true">
                    Műveletek
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div data-subaction-dropdown class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                <div class="py-1" role="none">
                    <?php foreach ($subactions as $subaction): ?>
                    <a href="javascript:void(0)" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0"  <?=$subaction[1]?>="<?=$subaction[2]?>" ><?=$subaction[0]?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (count($actions ?? []) > 0): ?>
            <?=\app\components\Helpers::render('ui/action', array_merge($actions[0], [
                'tag' => 'button',
                'primary' => true,
            ]))?>
        <?php endif; ?>
    </div>
</div>

