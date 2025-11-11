<?php
$schemas = \app\models\Tartalom::getContentSchemas();
?>

                    <a href="/admin" data-menu="1" class="menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/chart-bar -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
				<i class="fa-regular fa-house-blank"></i>
			  </span>
                        <span class="text">Kezdőoldal</span>

                    </a>



                    <a href="javascript:void(0)" data-menu="5" class="dropdown-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/chart-bar -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
				<i class="fa-duotone fa-bags-shopping"></i>
			  </span>
                        <span class="text">Rendelések</span>

                        <span class="arrow">
                                <i class="fa-regular fa-chevron-down"></i>
                            </span>
                    </a>

                    <div class="submenu">
                        <a href="/admin/orders" data-menu="5.1" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Összes rendelés
                        </a>

                        <a href="/admin/customers" data-menu="5.2" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Vásárlók
                        </a>

                        <!--
                       <a href="/admin/texts" data-menu="5.3" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">

                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                        <i class="fa-regular fa-align-center"></i>
                      </span>
                            Kosarak
                        </a>
                        -->
                    </div>


                    <a href="javascript:void(0)" data-menu="2" class="dropdown-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/chart-bar -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
				<i class="fa-duotone fa-tags"></i>
			  </span>
                        <span class="text">Termékek</span>

                        <span class="arrow">
                                <i class="fa-regular fa-chevron-down"></i>
                            </span>
                    </a>

                    <div class="submenu">
                        <a href="/admin/products" data-menu="2.1" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Összes termék
                        </a>

                        <a href="/admin/categories" data-menu="2.2" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Kategóriák
                        </a>

                        <a href="/admin/attributes" data-menu="2.3" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Tulajdonságok
                        </a>
                    </div>


                    <a href="javascript:void(0)" data-menu="4" class="dropdown-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/inbox -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                    <i class="fa-duotone fa-badge-percent"></i>
                                  </span>
                        <span class="text">Kedvezmények</span>

                        <span class="arrow">
                                    <i class="fa-regular fa-chevron-down"></i>
                                </span>
                    </a>

                    <div class="submenu">
                        <a href="/admin/coupons" data-menu="4.1" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Kuponok
                        </a>

                        <a href="/admin/promotions" data-menu="4.2" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Promóciók
                        </a>
                    </div>

                    <a href="javascript:void(0)" data-menu="6" class="dropdown-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/chart-bar -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
				<i class="fa-regular fa-align-center"></i>
			  </span>

                        <span class="text">Tartalom</span>

                        <span class="arrow">
                            <i class="fa-regular fa-chevron-down"></i>
                    </a>

                    <div class="submenu">

                        <a href="/admin/static-pages" data-menu="6.1" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Statikus oldalak
                        </a>

                        <a href="/admin/news" data-menu="6.10" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">

                                <span class=" group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Blog
                        </a>

                        <!--
                        <a href="/admin/texts" data-menu="6.2" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">

                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                        <i class="fa-regular fa-align-center"></i>
                      </span>
                            Hírek
                        </a>
                        -->

                        <a href="/admin/texts" data-menu="6.9" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Blokkok
                        </a>

                        <!--
                        <a href="/admin/sliders" data-menu="6.8" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">

                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Ajánló
                        </a>
                        -->

                        <a href="/admin/email-templates" data-menu="6.6" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            E-mailek
                        </a>

                        <?php foreach ($schemas as $schemaName => $schema): ?>
                            <?php
                                if (substr($schemaName, 0, 1) === '_') {
                                    continue;
                                }
                            ?>


                            <?php
                                $hash = substr(sha1($schemaName), 0, 8);
                            ?>

                            <a href="/admin/content-table?type=<?=urlencode($schemaName)?>" data-menu="6.<?=$hash?>" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                                <!-- Heroicon name: outline/chart-bar -->
                                <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                                <?=$schemaName?>
                            </a>

                        <?php endforeach; ?>

                    </div>

                    <a href="/admin/contact" data-menu="15" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/inbox -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                    <i class="fa-duotone fa-messages"></i>
                                  </span>
                        <span class="text">Kapcsolat

                                <?php if (\app\models\Kapcsolat::nrOfUnseen() > 0): ?>
                                    <span class="ml-2" style="background-color: #e84c4c; min-width: 19px; text-align: center;border-radius: 30px; padding: 0 3px; display: inline-block; font-size: 80%; color: #fff;transform:scale(1)">
                                    <?=\app\models\Kapcsolat::nrOfUnseen()?>
                                </span>
                                <?php endif; ?>
                            </span>


                    </a>

                    <div class="submenu">

                    </div>


                    <a href="javascript:void(0)" data-menu="9" class="dropdown-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/inbox -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                    <i class="fa-duotone fa-gears"></i>
                                  </span>
                        <span class="text">Beállítások</span>

                        <span class="arrow">
                                    <i class="fa-regular fa-chevron-down"></i>
                                </span>
                    </a>

                    <div class="submenu">
                        <a href="/admin/settings-general" data-menu="9.0" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Általános
                        </a>

                        <a href="/admin/users" data-menu="9.1" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Felhasználók
                        </a>

                        <a href="/admin/user-logs" data-menu="9.2" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                            <i class="fa-regular fa-align-center"></i>
                          </span>
                            Tevékenység napló
                        </a>

                        <a href="/admin/settings-smtp" data-menu="9.3" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            SMTP
                        </a>

                        <a href="/admin/settings-email-template" data-menu="9.13" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            E-mail sablon
                        </a>


                        <a href="/admin/settings-invoice" data-menu="9.4" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Számlázás
                        </a>

                        <a href="/admin/settings-shipping" data-menu="9.7" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Szállítási módok
                        </a>

                        <a href="/admin/settings-payments" data-menu="9.8" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Fizetési módok
                        </a>

                        <a href="/admin/settings-urls" data-menu="9.9" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            URL-ek
                        </a>

                        <a href="/admin/maintenance" data-menu="9.10" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Karbantartás
                        </a>

                        <a href="/admin/settings-countries" data-menu="9.11" class="text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                            <!-- Heroicon name: outline/chart-bar -->
                            <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="opacity:0;align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                <i class="fa-regular fa-align-center"></i>
                              </span>
                            Országok
                        </a>
                    </div>

                    <a href="/" target="_blank" class="link-menu-item text-gray-300 hover:bg-gray-700 hover:text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <!-- Heroicon name: outline/inbox -->
                        <span class="text-gray-400 group-hover:text-gray-300 mr-3 flex-shrink-0 h-6 w-6" style="align-items: center; display: flex;justify-content: center;font-size: 140%;">
                                    <i class="fa-duotone fa-store"></i>
                                  </span>
                        <span class="text"><small>Webáruház megnyitása</small></span>

                        <span class="arrow">
                                <i class="fa-light fa-arrow-up-right-from-square"></i>
                             </span>
                    </a>
                    <div class="submenu"></div>