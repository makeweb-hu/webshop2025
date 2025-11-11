<!-- This example requires Tailwind CSS v2.0+ -->
<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-2">
        <li>
            <div>
                <a href="/admin" class="flex items-center text-gray-500 hover:text-gray-700 text-sm font-medium">
                    <!-- Heroicon name: solid/home -->
                    <i class="fa-regular fa-house mr-2"></i>
                    <span >Admin</span>
                </a>
            </div>
        </li>

        <?php foreach (($items ?? []) as $caption => $url): ?>
        <li>
            <div class="flex items-center">
                <!-- Heroicon name: solid/chevron-right -->
                <svg class="flex-shrink-0 h-5 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <a href="<?=$url?>" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700"><?=$caption?></a>
            </div>
        </li>
        <?php endforeach; ?>

    </ol>
</nav>