<?php
$product_id = Yii::$app->request->get('product_id', '');
$product = \app\models\Termek::findOne($product_id);
?>
<div class="breadcrumbs">
    <div class="container">
        <div class="items">
            <a href="/">
                <img src="/img/home.svg" />
            </a>
            <img src="/img/breadcrumb-arrow.svg" class="arrow" />
            <span class="active"><?=$model->cim?></span>
        </div>

    </div>
</div>


<div id="static-page">
    <div class="container">
        <h1 class="page-title"><?=$model->cim?></h1>

        <div class="content">
            <?=$model->tartalom?>
        </div>


        <?php if ($model->id == 2): ?>

            <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="transition: 0.3s; opacity: 0; visibility: hidden; " data-contact-success>
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <!--
                      Background overlay, show/hide based on modal state.

                      Entering: "ease-out duration-300"
                        From: "opacity-0"
                        To: "opacity-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100"
                        To: "opacity-0"
                    -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                    <!-- This element is to trick the browser into centering the modal contents. -->
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <!--
                      Modal panel, show/hide based on modal state.

                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
                        <div>
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                <!-- Heroicon name: outline/check -->
                                <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-5">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Köszönjük levelét
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Hamarosan felvesszük Önnel a kapcsolatot.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6">
                            <button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm" data-close-contanct-success>
                                Rendben
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <div id="contact">

            <div class="left-right">

                <div class="left">
                    <div class="title">
                        Kérdése van?
                    </div>
                    <div class="description">
                        Írjon nekünk és mi 24 órán belül felveszük Önnel a kapcsolatot!
                    </div>
                </div>

                <form class="right" data-contact-form method="post" action="">
                    <input type="hidden" name="product_id" value="<?=$product_id?>">

                    <div class="half">
                        <div class="data">
                            <div class="input-row">
                                <input type="text" name="name" placeholder="Név" required>
                            </div>
                            <div class="input-row">
                                <input type="email" name="email" placeholder="E-mail cím" required>
                            </div>
                            <div class="input-row">
                                <input type="text" name="phone" placeholder="Telefonszám" required>
                            </div>
                        </div>
                        <div class="message">
                            <textarea placeholder="Üzenet" required name="message"><?=$product?'A következő termékkel kapcsolatban lenne kérdésem: ' . $product->nev . ' (Cikkszáma: ' . $product->cikkszam . ')':''?></textarea>
                        </div>
                    </div>

                    <div class="checkbox-row">
                        <div class="checkbox">
                            <input type="checkbox" required>
                        </div>
                        <b class="text">
                            Hozzájárul, hogy a www.treebox.hu a fent megadott személyes adatait a(z) <b><a href="/adatkezelesi-tajekoztato">Adatkezelési tájékoztató</a></b> oldalon rögzített, regisztrációs céllal kezeli.
                        </div>
                    </label>

                    <div class="button-row">
                        <button type="submit">Üzenet küldése</button>
                    </div>

                </form>

            </div>

            <div class="contact-data">

                <div class="data">
                    <div class="icon"><img src="/img/company.svg"></div>
                    <div class="title">Adószám</div>
                    <div class="value"><?=\app\models\Cim::findOne(\app\models\Beallitasok::get('ceg_cim_id'))->adoszam?></div>
                </div>

                <?php if (\app\models\Beallitasok::get('ceg_cim_id')): ?>
                <div class="data">
                    <div class="icon"><img src="/img/address.svg"></div>
                    <div class="title">Cím</div>
                    <div class="value"><?=\app\models\Cim::findOne(\app\models\Beallitasok::get('ceg_cim_id'))->toString()?></div>
                </div>
                <?php endif; ?>

                <a class="data" href="tel:<?=\app\models\Beallitasok::get('kozponti_telefonszam')?>">
                    <div class="icon"><img src="/img/phone.svg"></div>
                    <div class="title">Telefonszám</div>
                    <div class="value"><?=\app\models\Beallitasok::get('kozponti_telefonszam')?></div>
                </a>

                <a class="data" href="mailto:<?=\app\models\Beallitasok::get('kozponti_telefonszam')?>">
                    <div class="icon"><img src="/img/email.svg"></div>
                    <div class="title">E-mail</div>
                    <div class="value"><?=\app\models\Beallitasok::get('kozponti_email')?></div>
                </a>

            </div>

        </div>

        <?php endif; ?>

        <?php if ($_GET['gallery'] ?? null): ?>
            <div class="gallery">

                <div class="title">
                    Kapcsolódó galéria
                </div>

                <div class="photos">
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                    <div class="photo">
                        <div class="photo-frame">
                            <img src="/img/sample/gallery.jpg" />
                        </div>
                    </div>
                </div>

            </div>

        <?php endif; ?>

    </div>

</div>
