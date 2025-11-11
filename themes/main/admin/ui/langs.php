<?php

?>

<div>
    <div class="">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 " aria-label="Tabs">

                <?php foreach (['hu','en','pl','bg','fr'] as $lang): ?>

                <a href="javascript:void(0)" data-lang-tab data-lang="<?=$lang?>" class="<?=$lang=='hu'?'active':''?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm ">
                    <img src="/images/flags/<?=$lang?>.svg" style="width: 20px" class="mr-2"/>
                    <span><?=\app\components\Lang::$names[$lang]?></span>
                </a>

                <?php endforeach; ?>

            </nav>
        </div>
    </div>
</div>

<br>