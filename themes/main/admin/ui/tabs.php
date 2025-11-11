<div data-tabs>
    <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select a tab</label>
        <select data-mobile-select name="tabs" class="block w-full focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">

            <?php foreach (($tabs ?? []) as $tabKey => $tab): ?>

            <option <?=($active ?? null) === $tabKey?'selected':''?> data-url="<?=$tab['url'] ?? '#'?>"><?=$tab['title'] ?></option>

            <?php endforeach; ?>

        </select>
    </div>
    <div class="hidden sm:block">

        <div class="border-b border-gray-200">

            <?php if (($style ?? null) === 'big'): ?>

            <nav class="relative z-0 rounded-lg shadow flex divide-x divide-gray-200 overflow-hidden" aria-label="Tabs">


                <?php foreach (($tabs ?? []) as $tabKey => $tab): ?>

                    <?php if (($active ?? null) === $tabKey): ?>

                        <a href="<?=$tab['url'] ?? '#'?>" class="text-gray-900 group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10" aria-current="page">

                            <?php if ($tab['icon'] ?? ''): ?>
                                <span class="mr-2"><?=$tab['icon']?></span>
                            <?php endif; ?>

                            <span><?=$tab['title'] ?? '-'?></span>

                            <?php if ($tab['badge'] ?? ''): ?>
                                <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 text-xs font-medium md:inline-block"><?=$tab['badge']?></span>
                            <?php endif; ?>

                            <span aria-hidden="true" class="bg-indigo-500 absolute inset-x-0 bottom-0 h-0.5"></span>

                        </a>

                    <?php else: ?>

                        <a href="<?=$tab['url'] ?? '#'?>" class="text-gray-500 hover:text-gray-700 group relative min-w-0 flex-1 overflow-hidden bg-white py-4 px-4 text-sm font-medium text-center hover:bg-gray-50 focus:z-10">

                            <?php if ($tab['icon'] ?? ''): ?>
                                <span class="mr-2"><?=$tab['icon']?></span>
                            <?php endif; ?>

                            <span><?=$tab['title'] ?? '-'?></span>

                            <?php if ($tab['badge'] ?? ''): ?>
                                <span class="bg-gray-100 text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block"><?=$tab['badge']?></span>
                            <?php endif; ?>

                            <span aria-hidden="true" class="bg-transparent absolute inset-x-0 bottom-0 h-0.5"></span>
                        </a>

                    <?php endif; ?>

                <?php endforeach; ?>
            </nav>

            <?php else: ?>

            <nav class="-mb-px flex space-x-8" aria-label="Tabs">

                <?php foreach (($tabs ?? []) as $tabKey => $tab): ?>

                    <?php if (($active ?? null) === $tabKey): ?>

                        <a href="<?=$tab['url'] ?? '#'?>" class="border-indigo-500 text-indigo-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm" aria-current="page">

                            <?php if ($tab['icon'] ?? ''): ?>
                                <span class="mr-2"><?=$tab['icon']?></span>
                            <?php endif; ?>

                            <span><?=$tab['title'] ?? '-'?></span>

                            <?php if ($tab['badge'] ?? ''): ?>
                                <span class="bg-white text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block"><?=$tab['badge']?></span>
                            <?php endif; ?>

                        </a>

                    <?php else: ?>

                    <a href="<?=$tab['url'] ?? '#'?>" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm">

                        <?php if ($tab['icon'] ?? ''): ?>
                        <span class="mr-2"><?=$tab['icon']?></span>
                        <?php endif; ?>

                        <span><?=$tab['title'] ?? '-'?></span>

                        <?php if ($tab['badge'] ?? ''): ?>
                        <span class="bg-white text-gray-900 hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block"><?=$tab['badge']?></span>
                        <?php endif; ?>
                    </a>

                    <?php endif; ?>

                <?php endforeach; ?>
            </nav>

            <?php endif; ?>
        </div>
    </div>
</div>

