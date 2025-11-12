var LIVE_HTML = (function () {
    var selectors = {};
    return {
        add: function (selector, fn) {
            selectors[selector] = fn;
        },
        update: function ($elem) {
            if (typeof $elem === "string") {
                $elem = $($elem);
            }
            Object.keys(selectors).forEach(function (selector) {
                $elem.find(selector).each(selectors[selector]);
            });
        }
    };
}());


LIVE_HTML.add('[data-close-modal]', function () {
    $(this).click(function () {
        $(this).closest('.modal-window').removeClass('shown');
    });
});

LIVE_HTML.add('[data-show-login-modal]', function () {
    $(this).click(function () {
        $('[data-login-modal]').addClass('shown');
    });
});

LIVE_HTML.add('[data-show-forgot-password-modal]', function () {
    $(this).click(function () {
        $('[data-forgot-password-modal]').addClass('shown');
    });
});

LIVE_HTML.add('[data-show-signup-modal]', function () {
    $(this).click(function () {
        $('[data-signup-modal]').addClass('shown');
    });
});

LIVE_HTML.add('[data-show-profile-modal]', function () {
    $(this).click(function () {
        $('[data-profile-modal]').addClass('shown');
    });
});

LIVE_HTML.add('[data-show-cart]', function () {
    $(this).click(function () {
        $('#cart-sidebar').addClass('shown');
        $('#cart-sidebar .sidebar-content').scrollTop(1000000);
    });
});

function formatMoney(amount) {
    return ((amount
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ' ')
        .replace(/^0+/g, '') + '') || '0') + ' Ft';
}

$('[data-product-meta-modal] form').submit(function (e) {
    e.preventDefault();
    /*
    var allFilled = true;
    $('[data-product-meta-modal] input[type="text"], [data-product-meta-modal] select').each(function () {
        if ($(this).data('required')==='true' && !$(this).val().trim()) {
            allFilled = false;
        }
    });

    if (!allFilled) {

    }

     */

    var amount = Number($('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text());
    var id = $(this).find('button[type="submit"]').data('product-id');

    addToCart(id, amount);
    updateCart();

    $('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text(1);

    $('#cart-sidebar').addClass('shown');
    $('#cart-sidebar .sidebar-content').scrollTop(1000000);

    $('[data-product-meta-modal]').removeClass('shown');

    // show cart

    $('#cart-sidebar').addClass('shown');
    $('#cart-sidebar .sidebar-content').scrollTop(1000000);

    // reset form

    $('[data-product-meta-modal] input[type="text"], [data-product-meta-modal] select').each(function () {
        $(this).val('');
    });

    return false;
});

$('[data-edit-product]').click(function () {
    $('[data-product-meta-modal]').addClass('shown');
});

$('.checkout-content  [data-payment-methods] [data-method]').click(function () {
    $('.checkout-content  [data-payment-methods] [data-method]').removeClass('active');
    $(this).addClass('active');
});


$('[data-product-meta-modal] [data-select-tab]').click(function () {
    var tab = $(this).data('select-tab');
    //alert(tab)

    $('[data-product-meta-modal] [data-tab]').hide();
    $('[data-product-meta-modal] [data-select-tab]').css('font-weight', 400);
    $('[data-product-meta-modal] [data-tab="'+String(tab)+'"]').show();
    $(this).css('font-weight', 700);
});

if ($('[data-product-meta-modal] [data-select-tab]')[0]) {
    // init first tab
    $('[data-product-meta-modal] [data-select-tab]:first-child').trigger('click');
}

function updateCart() {
    var cart = JSON.parse(window.localStorage.getItem('cart') || '[]');
    var total = 0;
    cart.forEach(function (item) {
        total += (Number(String(DB.products[item.product_id].ar).replace(/[^0-9]+/g, '')) * item.amount);
    });
    // update cart nr
    $('[data-nr-of-cart-items]').text(cart.length);
    $('[data-cart-total]').text(formatMoney(total) );
    $('.checkout-content [data-products-total]').text(formatMoney(total) );
    $('.checkout-content [data-vat-total]').text(formatMoney(Math.round((total + 1500) * 0.27)) );
    $('.checkout-content [data-total]').text(formatMoney(total + 1500) );
    if (cart.length > 0){
        $('[data-goto-checkout] a').css('pointer-events', 'all');
        $('[data-nr-of-cart-items]').show();
        $('[data-goto-checkout] a').css('opacity', '1');
    } else {
        $('[data-nr-of-cart-items]').hide();
        $('[data-goto-checkout] a').css('pointer-events', 'none');
        $('[data-goto-checkout] a').css('opacity', '0.5');
    }

    // Create product list
    var html = '';
    cart.forEach(function (item) {
        var product = DB.products[item.product_id];

        var str = `
              <div class="sidebar-product" data-cart-item="" data-product-id="${product.id}">
                    <a class="photo" href="/product.php?id=${product.id}">
                        <div class="photo-container">
                            <img src="${product.foto}">
                        </div>
                    </a>
                    <a class="product-name-and-price" href="/product.php?id=${product.id}">
                        <div class="name-row">
                            ${product.nev}                              </div>
                        <div class="desc-row"></div>
                        <div class="price-row">
                            <span class="current-price">${product.ar}</span>
                        </div>
                    </a>
                    <div class="amount-and-delete">
                        <div class="amount">
                            <span class="minus" data-cart-item-minus="" data-item-id="6">
                                <img src="/img/dragcards/cart/chevron-down.svg" alt="">
                            </span>
                            <span class="nr" data-cart-item-amount="" data-item-id="6">${item.amount}</span>
                            <span class="plus" data-cart-item-plus="" data-item-id="6">
                                <img src="/img/dragcards/cart/chevron-up.svg" alt="">
                            </span>
                        </div>
                        <div class="delete-row">
                            <span>Törlés</span>
                        </div>
                    </div>
                </div>
        `;

        html += str;
    });

    if (!html) {
        html += '<div style="padding: 15px; padding-top: 0;">A kosár üres.</div>';
    }

    var $html = $(html);

    $html.find('.amount-and-delete .delete-row span').click(function () {
        if (confirm('Biztos törlöd a tételt a kosárból?')) {
            deleteFromCart($(this).closest('[data-cart-item]').data('product-id'));
            updateCart();
        }
    });

    $html.find('div.amount span.plus').click(function () {
        var id = $(this).closest('[data-cart-item]').data('product-id');

        addToCart(id, 1);
        updateCart();
    });
    $html.find('div.amount span.minus').click(function () {
        var id = $(this).closest('[data-cart-item]').data('product-id');

        decrementCart(id);
        updateCart();
    })

    $('#cart-sidebar div.sidebar div.sidebar-content div.sidebar-content-products').html($html);


    // Update checkout page

    var otherHtml = '';
    cart.forEach(function (item) {
        var product = DB.products[item.product_id];

        var str = `
        <li class="flex items-start py-6 space-x-4 border-gray-half">
                            <img src="${product.foto}" alt="" class="flex-none w-20 h-20 object-center" style="object-fit: contain; border-radius: 8px;">
                            <div class="flex-auto space-y-1">
                                <h3>${product.nev}</h3>
                        
                                <p class="text-gray-500">${item.amount} db</p>
                            </div>
                            <p class="flex-none font-extrabold">
                                ${product.ar}                                                               </p>
                        </li>
        `;
        otherHtml += str;
    });


    var $otherHtml = $(otherHtml);

    $('.checkout-content [data-product-list]').html($otherHtml);
}

function addToCart(id, amount) {
    var cart = JSON.parse(window.localStorage.getItem('cart') || '[]');

    var found = null;
    cart.forEach(function (item) {
        if (item.product_id == id) {
            found = item;
        }
    });

    if (found) {
        found.amount += amount;
    } else {
        cart.push({
            product_id: id,
            amount: amount,
        });
    }

    window.localStorage.setItem('cart', JSON.stringify(cart));
}

function decrementCart(id) {
    var cart = JSON.parse(window.localStorage.getItem('cart') || '[]');

    var found = null;
    cart.forEach(function (item) {
        if (item.product_id == id) {
            found = item;
        }
    });

    if (found && found.amount > 1) {
        found.amount -= 1;
    }

    window.localStorage.setItem('cart', JSON.stringify(cart));
}

function deleteFromCart(id) {
    var cart = JSON.parse(window.localStorage.getItem('cart') || '[]');

    var all  = [];
    cart.forEach(function (item) {
        if (item.product_id != id) {
            all.push(item);
        }
    });

    window.localStorage.setItem('cart', JSON.stringify(all));
}

// updateCart();

$('[data-change-sort]').click(function () {
    var baseUrl = $(this).data('base-url');
    var value = $(this).data('value');
    if (baseUrl.indexOf('?') >= 0) {
        window.location.href = baseUrl + '&sort=' + value;
    } else {
        window.location.href = baseUrl + '?sort=' + value;
    }
});

(function () {
    var cookies = window.localStorage.getItem('cookies');
    if (!cookies) {
        $('#cookie-consent').addClass('shown');
    }

    $('[data-accept-cookies]').click(function () {
        window.localStorage.setItem('cookies', true);
        $('#cookie-consent').removeClass('shown');
    });
}());

(function () {
    var offset = -60;
    $('a[href^="#"]').on('click', function (event) {
        if (this.hash.substr(1)) {
            event.preventDefault();
            // create a dummy element on current scroll position so we can write hash to document.location without scrolling immediately
            $('body').prepend('<div style="position: absolute;top:' + window.scrollY + 'px" id="' + this.hash.substr(1) + '" class="scroll-placeholder"></div>');
            document.location.hash = this.hash.substr(1);
            $(this.hash + '.scroll-placeholder').remove();
            // animate scroll
            $('html,body').animate({scrollTop: $(this.hash).offset().top + offset}, 500);
        }
    });
}());

LIVE_HTML.add('[data-close-cart]', function () {
    $(this).click(function () {
        $('#cart-sidebar').removeClass('shown');
    });
});

$('#homepage-faq div.container div.faq div.q-and-a div.q, #faq-page div.container div.secrion div.faq div.q-and-a div.q').click(function () {
    $(this).closest('.q-and-a').toggleClass('active');
});

// AJAX FORM
(function () {
    var success_callbacks = {};
    var DEV_MODE = false; // delay

    window.AJAX_FORM = {
        onSuccess: function (id, callback) {
            success_callbacks[id] = callback;
        }
    };

    LIVE_HTML.add('[data-ajax-form]', function () {
        var $form = $(this);

        var method = ($form.attr("method") || 'post').toLowerCase();
        var redirect_url = $form.data("redirect-url");
        var reset_on_success = typeof $form.data("reset-on-success") === "string";
        var show_popup_on_success = typeof $form.data("show-popup-on-success") === "string";
        var scroll_to_error = typeof $form.data("scroll-to-error") === "string";
        var save_feedback = typeof $form.data("save-feedback") === "string";
        var confirm_text = $form.data("confirm");
        var submit_button_text = $form.find("button[type=submit]").html();
        var formId = $form.data('form-id');

        function collect_form_data() {
            var form_data = {};
            $form.find("[name]").each(function () {
                var $elem = $(this);
                var name = $elem.attr("name");
                var tag = $elem.prop("tagName").toLowerCase();
                if (tag === "input" && $elem.attr("type") === "checkbox") {
                    form_data[name] = $elem.is(":checked");
                } else if (tag === "input" && $elem.attr("type") === "radio") {
                    form_data[name] = $("input[name=" + name + "]:checked").val();
                } else {
                    form_data[name] = $elem.val();
                }
            });
            return form_data;
        }

        function reset_form() {
            $form.find("[name]").each(function () {
                var $elem = $(this);
                var name = $elem.attr("name");
                var tag = $elem.prop("tagName").toLowerCase();
                if (tag === "input" && ($elem.attr("type") === "checkbox" || $elem.attr("type") === "radio")) {
                    // ignore radio buttons and checkboxes
                } else if (tag === "select") {
                    $elem.prop('selectedIndex', 0);
                } else {
                    $elem.val("");
                }
            });
        }

        function disable_form() {
            $form.find(".input-row").removeClass("error"); // hide errors
            $form.find("button[type=submit]").prop("disabled", true).html('<i class="fa-solid fa-circle-notch fa-spin"></i> &nbsp; Betöltés...'); // spinner
            // remove feedback
            if (save_feedback) {
                $form.find(".feedback").hide();
            }
        }

        function enable_form() {
            $form.find("button[type=submit]").prop("disabled", false).html(submit_button_text);
        }

        $form.submit(function (e) {
            var url = $form.data("action");
            e.preventDefault();
            if (!confirm_text || (confirm_text && confirm(confirm_text))) {
                var form_data = collect_form_data();
                disable_form();
                setTimeout(function () {
                    $[method](url, form_data, function (response) {
                        enable_form();
                        var $first_wrong_input;
                        if (response.error) {
                            // show errors

                            if (typeof response.error === 'string') {
                                if (response.redirect_after_error) {
                                    POPUP.failure('<i class="fa-regular fa-circle-exclamation"></i>', 'Hiba', response.error, 'Rendben', function () {
                                        if (response.redirect_after_error === "(current)") {
                                            window.location.reload();
                                        } else {
                                            window.location.href = response.redirect_after_error;
                                        }
                                    });
                                } else {
                                    POPUP.failure('<i class="fa-regular fa-circle-exclamation"></i>', 'Hiba', response.error);
                                }
                            } else {

                                Object.keys(response.error).forEach(function (name) {
                                    var message = response.error[name];
                                    if (Array.isArray(message)) {
                                        message = message[0];
                                    }
                                    var $input_row = $form.find("[name='" + name + "']").closest(".input-row");
                                    $input_row.addClass("error").find(".error-message").html(message);
                                    if ($input_row) {

                                        if (!$first_wrong_input || $input_row.offset().top < $input_row.offset().top) {
                                            $first_wrong_input = $input_row;
                                        }


                                    }
                                });
                                // console.log($first_wrong_input.offset())

                                if ($first_wrong_input && scroll_to_error) {
                                    $("html, body").animate({
                                        scrollTop: Math.max(0, $first_wrong_input.offset().top - 50)
                                    }, 1000);
                                }
                                /*
                                                                try {
                                                                    grecaptcha.reset();
                                                                } catch (ignore) {}

                                                                 */
                            }
                        } else {
                            var success_callback = success_callbacks[formId];

                            $form.closest('[data-modal-window]').remove();

                            if (success_callback) {
                                success_callback(response, $form);
                            } else {
                                if (redirect_url) {
                                    if (redirect_url === '(current)') {
                                        window.location.reload();
                                    } else {
                                        window.location.href = redirect_url;
                                    }
                                } else if (response.success_message) {
                                    // Close modal if exists
                                    if ($form.closest('.modal-window')[0]) {
                                        $form.closest('.modal-window').removeClass('shown');
                                    }
                                    CONFIRM.show('<i class="fa-solid fa-circle-check" style="margin-right: 5px;"></i> ' + (response.success_title || 'SikerĂźlt'), response.success_message, null, function () {
                                        if (response.redirect_url) {
                                            if (response.redirect_url === "(current)") {
                                                window.location.reload();
                                            } else {
                                                window.location.href = response.redirect_url;
                                            }
                                        } else if (response.redirect_after_success) {
                                            if (response.redirect_after_success === "(current)") {
                                                window.location.reload();
                                            } else {
                                                window.location.href = response.redirect_after_success;
                                            }
                                        }
                                    });
                                } else if (response.redirect_url) {
                                    if (response.redirect_url === "(current)") {
                                        window.location.reload();
                                    } else {
                                        window.location.href = response.redirect_url;
                                    }
                                }
                            }

                            if (show_popup_on_success) {
                                POPUP.success('<i class="fa-regular fa-check"></i>', 'Sikeresen elmentve', 'A mĂłdosĂ­tĂĄsokat elmentette a rendszer.');
                            }
                            if (save_feedback) {
                                $form.find("button[type=submit]").prop("disabled", true).html('<i class="fas fa-check-circle"></i>');
                                setTimeout(enable_form, 2000);
                                if (response.feedback) {
                                    $form.find(".feedback .text").html(response.feedback).closest(".feedback").show();
                                }
                            }

                            if (reset_on_success) {
                                reset_form();
                                $form.closest('.modal-window').removeClass('shown');
                            }
                        }
                    }).fail(function () {
                        if (url === '/empty.json') {
                            return;
                        }
                        enable_form();
                        alert('Nem sikerült kapcsolódni a kiszolgálóhoz.');
                        // POPUP.failure('<i class="fa-regular fa-hexagon-exclamation"></i>', 'KapcsolĂłdĂĄsi hiba', 'Nem sikerĂźlt kapcsolĂłdni a kiszolgĂĄlĂłhoz. PrĂłbĂĄld Ăşjra vagy vedd fel a kapcsolatot a rendszer ĂźzemeltetĹivel', 'Rendben')
                    });
                }, DEV_MODE ? 1500 : 0);
            }
        });
    });
}());

(function () {

    var html = `
       <div class="modal-window">
            <div class="modal-bg" data-close-modal></div>
            <div class="modal-window-content slim">
                <div class="modal-box">
                    <div class="modal-box-header">
                        <div class="modal-title">Bejelentkezés</div>
                        <div class="modal-close" data-close-modal="">
                            <img src="/img/dragcards/cart/close-x-dark.svg" alt="Dragcards">
                        </div>
                    </div>
                    <div class="modal-box-content">
                    <div class="modal-box-content">
                        <div class="modal-instructions" data-description>
                            xxxxx
                        </div>
                        <form>
                            <div class="modal-button-row yes-no">
                                <button type="button" class="secondary" data-no data-close-modal>Mégsem</button>
                                <button type="button" data-button data-yes>Rendben</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;

    var eventHandlers = {};

    window.CONFIRM = {
        loading: function (title) {
            var yes = null;
            var $dialog = $(html);
            $dialog.find('[data-title]').html('<i class="fa-solid fa-circle-notch fa-spin"></i> ' + title);
            $dialog.find('[data-description]').html('KĂŠrjĂźk, vĂĄrjon...');
            $dialog.find('[data-yes]').html(yes);
            $dialog.find('[data-no], [data-close-modal], [data-bg]').click(function () {
                // do nothing
            });
            $dialog.find('.close-modal').hide();
            if (!yes) {
                $dialog.find('.modal-button-row').hide();
                $dialog.find('.modal-instructions').css({
                    'margin-bottom' : '0',
                });
            }

            $("body").append($dialog);
            setTimeout(function () {
                $dialog.addClass('shown');
            }, 100);

            return $dialog;
        },
        show: function (title, description, yes, callback) {
            var $dialog = $(html);
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-description]').html(description);
            $dialog.find('[data-yes]').html(yes);
            $dialog.find('[data-no], [data-close-modal], [data-bg]').click(function () {
                $dialog.removeClass('shown');
                setInterval(function () {
                    $dialog.remove();
                }, 1000);
            });
            if (!yes) {
                $dialog.find('.modal-button-row').hide();
                $dialog.find('.modal-instructions').css({
                    'margin-bottom' : '0',
                });
            }
            $dialog.find('[data-yes]').click(function () {
                callback();
                if (typeof eventHandlers[$dialog.data('confirm-id')] === 'function') {
                    eventHandlers[$dialog.data('confirm-id')]();
                }
                $dialog.removeClass('shown');
                setInterval(function () {
                    $dialog.remove();
                }, 1000);
            });
            $("body").append($dialog);
            setTimeout(function () {
                $dialog.addClass('shown');
            }, 100);
        },
        onConfirm: function (id, callback) {
            eventHandlers[id] = callback;
        }
    };

}());



(function () {
    function updateFancyPlaceholder($elem) {
        function updateClass($input) {
            if (!$input.val()) {
                $elem.removeClass('has-text');
            } else {
                $elem.addClass('has-text');
            }
        }

        $elem.find('input').each(function () {
            updateClass($(this)); // init
        });

        $elem.find('input').on('input', function () {
            updateClass($(this));
        });
    }

    LIVE_HTML.add('.fancy-placeholder', function () {
        updateFancyPlaceholder($(this));
    });

}());

$('[data-sort-dropdown]').click(function (e) {
    e.stopPropagation();
    $(this).addClass('active');
});

$('[data-show-filters]').click(function (e) {
    e.stopPropagation();
    $(this).addClass('active');
});

$('div.products-page div.container div.filters-row div.left div.filters-dropdown div.dropdown-content div.button-row div.btn').click(function () {
    setTimeout(function () {
        $('[data-show-filters]').removeClass('active');
    }, 10);
});

(function () {
    /*
    if ($('div.products-page div.container div.filters-row div.right div.sort-dropdown div.value')[0]) {
        var val = $('div.products-page div.container div.filters-row div.right div.sort-dropdown div.dropdown-content div.dropdown-item.selected div.text').text();
        $('div.products-page div.container div.filters-row div.right div.sort-dropdown div.value').text(val);
    }

     */
}());

$(document).click(function () {
    $('[data-sort-dropdown]').removeClass('active');
    $('[data-show-filters]').removeClass('active');
});

LIVE_HTML.add('[data-scroller]', function () {
    var $scroller = $(this);
    var $items = $scroller.find('> *');
    var nrOfItems = $items.length;
    var nrOfVisibleItems = Number( $scroller.data('default') );
    var breakpoints = $scroller.data('breakpoints');
    var gap = $scroller.data('gap');
    var animating = false;

    // Disable img drag
    $items.on('dragstart', function(event) { event.preventDefault(); });

    function update() {
        // Breakpoints
        var windowWidth = $(window).width();
        var found = false;
        var breakpointKeys = Object.keys(breakpoints);
        for (var i = 0; i < breakpointKeys.length; i += 1) {
            var w = Number(breakpointKeys[i]);
            if (windowWidth <= w) {
                // Apply breakpoint
                nrOfVisibleItems = breakpoints[w];
                found = true;
                break;
            }
        }
        if (!found) {
            nrOfVisibleItems = Number( $scroller.data('default') ); // default
        }

        var width = $scroller.width();
        var widthPerItemPercent = 100 / nrOfVisibleItems;
        var gapDiff = (gap * (nrOfVisibleItems - 1)) / nrOfVisibleItems;

        $items.css({'min-width': 'calc(' + String(widthPerItemPercent) + '% - ' + gapDiff + 'px)' });

        // $scroller.scrollLeft(0); // set start scroll position
    }

    function scrollLeft() {
        if (animating) {
            return;
        }
        animating = true;

        var width = $scroller.width();
        var widthPerItemPercent = 100 / nrOfVisibleItems;
        var widthPerItem = width * (widthPerItemPercent / 100);
        widthPerItem += gap;

        $scroller.animate({ scrollLeft: $scroller.scrollLeft() - widthPerItem }, 250, function () {
            animating = false;
        });
    }

    function scrollRight() {
        if (animating) {
            return;
        }
        animating = true;

        var width = $scroller.width();
        var widthPerItemPercent = 100 / nrOfVisibleItems;
        var widthPerItem = width * (widthPerItemPercent / 100);
        widthPerItem += gap;

        $scroller.animate({ scrollLeft: $scroller.scrollLeft() + widthPerItem }, 250, function () {
            animating = false;
        });
    }

    // Update on window resize
    $(window).resize(update);

    // Init
    update();

    // Arrows
    $scroller.closest('[data-scroller-container]').find('[data-scroll-next]').click(scrollRight);
    $scroller.closest('[data-scroller-container]').find('[data-scroll-prev]').click(scrollLeft);

    // Mobile swipe
    (function () {
        var mc = new Hammer($scroller.closest('[data-scroller-container]')[0]);

        mc.get('swipe').set({direction: Hammer.DIRECTION_HORIZONTAL});

        mc.on("swiperight", function (ev) {
            scrollLeft();
        });

        mc.on("swipeleft", function (ev) {
            scrollRight();
        });
    }());
});

$('#product-page div.container div.product-main-section div.right div.extra-boxes div.extra-box div.box-header').click(function () {
    $(this).closest('.extra-box').toggleClass('opened');
});

$('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.plus').click(function () {
    $('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text(
        Number($('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text()) + 1
    );
});

$('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.minus').click(function () {
    $('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text(
        Math.max(1, Number($('#product-page div.container div.product-main-section div.right div.amount-and-cart div.amount div.nr').text()) - 1)
    );
});

(function () {
    const header = document.querySelector('header');
    if (!header) return; // nincs header, akkor kilép

    function updateHeaderOnScroll() {
        if (window.scrollY >= 70) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }

    if (!$('header').hasClass('scrolled')) {
        // első hívás, hogy már betöltéskor is helyesen álljon
        updateHeaderOnScroll();

        // eseményfigyelő
        window.addEventListener('scroll', updateHeaderOnScroll);
    }
}());

(function () {
    function closeAllSubmenu() {
        $('[data-has-submenu] .caption').removeClass('selected');
        $('[data-has-product-submenu] .caption').removeClass('selected');
        $('[data-has-submenu] .submenu').removeClass("shown");
        $(".submenu-fade").removeClass("shown");
        $('header .product-submenu').removeClass('shown');
    }

    $('header .menu-item .caption').hover(function () {
        closeAllSubmenu();
    });

    $('[data-has-submenu] .caption').hover(function () {
        closeAllSubmenu();
        $(this).addClass('selected');
        $(this).closest('.menu-item').find('.submenu').addClass('shown');
        $(".submenu-fade").addClass('shown');
    });

    $('[data-has-product-submenu] .caption').hover(function () {
        closeAllSubmenu();
        $(this).addClass('selected');
        $('header .product-submenu').addClass('shown');
        $(".submenu-fade").addClass('shown');
    });

    $('header div.container div.menu div.hamburger-menu').click(function () {
        $('header .product-submenu').toggleClass('shown');
        $(".submenu-fade").toggleClass('shown');
    });

    $(".submenu-fade").hover(function () {
        closeAllSubmenu();
    });

    $('#homepage-slider video').on('click', function() {
        const video = this;
        if (video.paused) {
            $('#homepage-slider .box').removeClass('paused');
            video.play();
        } else {
            $('#homepage-slider .box').addClass('paused');
            video.pause();
        }
    });
}());

LIVE_HTML.update('body');

