<?php
$last30days = \app\models\Kosar::find()->leftJoin('cim', 'cim.id = kosar.szallitasi_cim_id')->where(['kosar.megrendelve' => 1])->andWhere(['>=', 'idopont', date('Y-m-d H:i:s', strtotime('-30 days'))])->orderBy('cim.id DESC')->all();

$total = 0;
$average = 0;
if (count($last30days) > 0) {
    foreach ($last30days as $order) {
        $total += $order->getTotal();
    }
    $average = $total / count($last30days);
}
?>

<div data-selected-menu="1"></div>

<h1 class="text-xl font-medium leading-6 text-gray-900 sm:truncate mb-2 mt-6">
    Hello, <?=\app\models\Felhasznalo::current()->nev?>!
</h1>
<p class="text-gray-500 text-sm">Itt vannak a <b class="font-medium"><?=\app\models\Beallitasok::get('domain')?></b> webáruház legfrissebb adatai.</p>


<div class="mt-4 mb-16"></div>

<div>
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        Elmúlt 30 nap
    </h3>
    <hr class="mt-2" />
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <i class="fa-solid fa-money-bill-trend-up" style="color: #fff; width: 24px; text-align: center; transform:scale(1.3)"></i>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Bevétel összesen</p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    <?=\app\components\Helpers::formatMoney( $total )?>
                </p>
                <!--
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">

                    <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
            Increased by
          </span>
                    122
                </p>
                -->
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="/admin/orders" class="font-medium text-indigo-600 hover:text-indigo-500"> Rendelések <i class="fa-light fa-arrow-right"></i></a>
                    </div>
                </div>
            </dd>
        </div>

        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <!-- Heroicon name: outline/mail-open -->
                    <i class="fa-regular fa-bag-shopping" style="color: #fff; width: 24px; text-align: center; transform:scale(1.3)"></i>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Átlagos kosárérték</p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    <?=\app\components\Helpers::formatMoney( $average )?>
                </p>
                <!--
                <p class="ml-2 flex items-baseline text-sm font-semibold text-green-600">

                    <svg class="self-center flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
            Increased by
          </span>
                    5.4%
                </p>
                -->
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="/admin/carts" class="font-medium text-indigo-600 hover:text-indigo-500"> Kosarak <i class="fa-light fa-arrow-right"></i></a>
                    </div>
                </div>
            </dd>
        </div>

        <div class="relative bg-white pt-5 px-4 pb-12 sm:pt-6 sm:px-6 shadow rounded-lg overflow-hidden">
            <dt>
                <div class="absolute bg-indigo-500 rounded-md p-3">
                    <i class="fa-regular fa-user" style="color: #fff; width: 24px; text-align: center; transform:scale(1.3)"></i>
                </div>
                <p class="ml-16 text-sm font-medium text-gray-500 truncate">Vásárlók száma </p>
            </dt>
            <dd class="ml-16 pb-6 flex items-baseline sm:pb-7">
                <p class="text-2xl font-semibold text-gray-900">
                    <?= count($last30days) ?>
                </p>
                <!--
                <p class="ml-2 flex items-baseline text-sm font-semibold text-red-600">

                    <svg class="self-center flex-shrink-0 h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">
            Decreased by
          </span>
                    3.2%
                </p>
                -->
                <div class="absolute bottom-0 inset-x-0 bg-gray-50 px-4 py-4 sm:px-6">
                    <div class="text-sm">
                        <a href="/admin/customers" class="font-medium text-indigo-600 hover:text-indigo-500"> Vásárlók <i class="fa-light fa-arrow-right"></i></a>
                    </div>
                </div>
            </dd>
        </div>
    </dl>
</div>

<h3 class="mt-16 text-lg leading-6 font-medium text-gray-900 flex justify-between items-center">
    Legújabb rendelések

    <a href="/admin/orders" class="text-sm font-medium text-indigo-600 hover:text-indigo-500"> Összes rendelés <i class="fa-light fa-arrow-right"></i></a>
</h3>

<hr class="mt-2 mb-4" />


<?=\app\components\Helpers::render('ui/table', [
    'class' => \app\models\Kosar::class,
    'columns' => ['rendelesszam', 'idopont', 'customer', 'payment_status', 'shipping_status', 'total'],
    'filter' => function ($query) {
        $query = $query->leftJoin('cim', 'cim.id = kosar.szallitasi_cim_id');
        return $query->where(['kosar.megrendelve' => 1])->orderBy('cim.id DESC');
    },
    'nopagination' => true,
    'hardlimit' => 10,
    'actions' => [
        [ 'type' => 'link', 'icon' =>'view', 'title' => 'Megtekint', 'url' => '/admin/order' ],
    ]
])?>

<h3 class="mt-16 text-lg leading-6 font-medium text-gray-900 flex justify-between items-center">
    Legújabb termékek
    <a href="/admin/products" class="text-sm font-medium text-indigo-600 hover:text-indigo-500"> Összes termék <i class="fa-light fa-arrow-right"></i></a>
</h3>

<hr class="mt-2 mb-4" />

<ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 mb-16">

    <?php foreach (\app\models\Termek::find()->orderBy('id DESC')->limit(4)->all() as $prod): ?>
    <li class="relative">
        <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
            <?php if ($prod->photo): ?>
            <img src="<?=$prod->photo->url?>" alt="" class="object-cover pointer-events-none group-hover:opacity-75">
            <?php else: ?>
                <img src="https://borago.local/img/no-photo.jpg" alt="" class="object-cover pointer-events-none group-hover:opacity-75">
            <?php endif; ?>
            <a href="/admin/edit-product?id=<?=$prod->id?>">
                <button type="button" class="absolute inset-0 focus:outline-none">
                <span class="sr-only"></span>
            </button>
            </a>
        </div>
        <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none"><?=$prod->nev?></p>
        <p class="block text-sm font-medium text-gray-500 pointer-events-none">
            <?=$prod->columnViews()['ar']()?>
        </p>
    </li>
    <?php endforeach; ?>

</ul>



<h3 class="mt-16 text-lg leading-6 font-medium text-gray-900 flex justify-between items-center">
    Elfogyott termékek
    <a href="/admin/products?tab=outofstock" class="text-sm font-medium text-indigo-600 hover:text-indigo-500"> Összes elfogyott termék<i class="fa-light fa-arrow-right"></i></a>
</h3>

<hr class="mt-2 mb-4" />

<ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8 mb-16">

    <?php foreach (\app\models\Termek::find()->where(['keszlet' => 0])->orderBy('id DESC')->limit(4)->all() as $prod): ?>
        <li class="relative">
            <div class="group block w-full aspect-w-10 aspect-h-7 rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-gray-100 focus-within:ring-indigo-500 overflow-hidden">
                <?php if ($prod->photo): ?>
                    <img src="<?=$prod->photo->url?>" alt="" class="object-cover pointer-events-none group-hover:opacity-75">
                <?php else: ?>
                    <img src="https://borago.local/img/no-photo.jpg" alt="" class="object-cover pointer-events-none group-hover:opacity-75">
                <?php endif; ?>
                <a href="/admin/edit-product?id=<?=$prod->id?>">
                    <button type="button" class="absolute inset-0 focus:outline-none">
                        <span class="sr-only"></span>
                    </button>
                </a>
            </div>
            <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none"><?=$prod->nev?></p>
            <p class="block text-sm font-medium text-gray-500 pointer-events-none">
                <?=$prod->columnViews()['ar']()?>
            </p>
        </li>
    <?php endforeach; ?>

</ul>
