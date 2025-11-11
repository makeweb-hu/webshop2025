$('[data-accept-cookies]').click(function () {
    $('#cookie-consent').removeClass('shown');
    $.post('/api/accept-cookies')
        .then(function () {

        });
});

// Global search
(function () {

    var q = '';
    var results = [];
    var loading = false;
    var nextFetchId = 0;

    $('[data-global-search]').focusin(function () {
        $('[data-global-search-results]').addClass('shown');
    });

    $('[data-global-search]').focusout(function () {
        $('[data-global-search-results]').removeClass('shown');
    });

    $('[data-global-search]').on('input', function () {
        q = $(this).val().trim();
        loading = true;
        nextFetchId += 1;
        fetch(nextFetchId);
        refresh();
    });

    $('[data-global-search]').keypress(function (e) {
        if (e.key === 'Enter' || e.which == 13) {
            window.location.href = '/site/search?q=' + encodeURIComponent($('[data-global-search]').val());
        }
    });

    $('header .logo-row .search-box .search-btn').click(function () {
        window.location.href = '/site/search?q=' + encodeURIComponent($('[data-global-search]').val());
    });

    function fetch(id) {
        $.post('/api/search', {
            q: q
        }).then(function (response) {
            loading = false;
            if (id == nextFetchId) {
                results = response;
                refresh();
            }
        });
    }

    function renderResults() {
        var html = '';
        results.forEach(function (result) {
            html += `<a class="search-result" href="${result.url}">
                <div class="photo">
                    <div class="photo-box">
                        <img src="${result.photo}"/>
                    </div>
                </div>
                <div class="name">
                    ${result.name}
                </div>
                <div class="price">
                    ${result.price}
                </div>

            </a>`;
        });
        return html;
    }

    function refresh() {
        if (q) {
            if (loading) {
                $('[data-global-search-results]').html('<i class="fa-solid fa-circle-notch fa-spin"></i> Kérjük, várjon...');
            } else {
                if (results.length === 0) {
                    $('[data-global-search-results]').html('<b>Nincs találat</b>');
                } else {
                    $('[data-global-search-results]').html(renderResults());
                }
            }
        } else {
            $('[data-global-search-results]').html('Kezdjen el gépelni...');
        }
    }

    refresh();

}());

$('[data-close-contanct-success]').click(function () {
    $('[data-contact-success]').css({
        'opacity' : 0,
        'visibility' : 'hidden',
    });
})

$("[data-contact-form]").submit(function (e) {
    e.preventDefault();
    e.stopPropagation();

    var $this = $(this);


    var data = {};
    $this.find('input, textarea').each(function () {
        var name = $(this).attr('name');
        if (name) {
            data[name] = $(this).val();
        }
    });

    $('[data-contact-success]').css({
        'opacity' : 1,
        'visibility' : 'visible',
    });

    $.post('/api/contact', data)
        .then(function () {
            $this.find('input, textarea').each(function () {
                var name = $(this).attr('name');
                if (name) {
                    $(this).val('');
                }
            });
        });

    return false;
});

$('[data-close-cart]').click(function () {
    $('[data-cart]').removeClass('shown');
});

$('[data-show-cart]').click(function () {
    $('[data-cart]').addClass('shown');
});

$('[data-show-likes]').click(function () {
    $('[data-likes]').addClass('shown');
});

(function () {
    function getOptionsString($product) {
        var ids = [];
        $('#product-page .photo-and-details > .details .property .value').each(function () {
            if ($(this).find('.variation')[0]) {
                ids.push( Number($(this).find('.variation.active').data('option-id')) );
            }
        });
        ids = ids.sort(function (a, b) {
            return a - b;
        });
        return ids.join('-');
    }

    $('[data-like-product]').click(function () {
        var variations = $(this).closest('#product-page').data('variations');
        var variation = variations[getOptionsString($(this).closest('#product-page'))];

        if (!variation) {
            // alert('A termékváltozat nem található!');
            // return;
        }

        $.post("/api/like", {
            id: $(this).data("product-id"),
            variation_id: variation,
        }).then(function (response) {
            $('[data-likes]').addClass('shown');
            $('[data-likes-html]').html(response.html);
            $('[data-nr-of-likes]').html(response.nr_of_items);
        });
    });

    $('[data-like-product-thumbnail]').click(function () {
        var id = $(this).data("product-id");
        var variations = $(this).closest('.product').data('variations');
        var variation = '';


        if (Object.keys(variations).length === 0) {

        } else if (Object.keys(variations).length === 1) {
            variation = Object.values(variations)[0];
        } else {
            window.location.href = $(this).closest('.product').data('url');
            return;
        }

        $.post("/api/like", {
            id: id,
            variation_id: variation,
        }).then(function (response) {
            $('[data-likes]').addClass('shown');
            $('[data-likes-html]').html(response.html);
            $('[data-nr-of-likes]').html(response.nr_of_items);
        });
    });

    $('[data-add-to-cart-thumbnail]').click(function () {
        var nr = 1;
        var variations = $(this).closest('.product').data('variations');
        var id = $(this).data("product-id");
        var stock = Number($(this).closest('.product').data('stock'));
        var variation = '';

        if (!stock) {
            alert('A termék jelenleg nincs készleten. Kérjük, érdeklődjön ügyfélszolgálatunkon a termékkel kapcsolatban!');
            return;
        }

        if (Object.keys(variations).length === 0) {

        } else if (Object.keys(variations).length === 1) {
            variation = Object.values(variations)[0];
        } else {
            window.location.href = $(this).closest('.product').data('url');
            return;
        }

        $.post("/api/add-to-cart", {
            id: id,
            variation_id: variation,
            amount: nr,
        }).then(function (response) {
            $('[data-cart]').addClass('shown');
            $('[data-cart-html]').html(response.html);
            $('[data-nr-of-cart-items]').html(response.nr_of_items);
            $('[data-cart-total]').html(response.total);
            $('[data-goto-checkout]').css(response.nr_of_items == 0 ? {
                'pointer-events': 'none',
                'opacity': '0.4',
            } : {
                'opacity': '1',
                'pointer-events': 'all',
            });
        });
    });

    $('[data-add-to-cart]').click(function () {
        var nr = Number($('#product-page .photo-and-details > .details .buttons .amount .nr').html().replace(/[^0-9]+/g, ''));
        var variations = $(this).closest('#product-page').data('variations');
        var variation = variations[getOptionsString($(this).closest('#product-page'))];
        var stock = Number($(this).closest('#product-page').data('stock'));

        console.log(variations, variation, getOptionsString($(this).closest('#product-page')))

        if (!stock) {
            alert('A termék jelenleg nincs készleten. Kérjük, érdeklődjön ügyfélszolgálatunkon a termékkel kapcsolatban!');
            return;
        }

        if (!variation) {
            //alert('A termékváltozat nem található!');
            //return;
        }

        $.post("/api/add-to-cart", {
            id: $(this).data("product-id"),
            variation_id: variation,
            amount: nr,
        }).then(function (response) {
            $('[data-cart]').addClass('shown');
            $('[data-cart-html]').html(response.html);
            $('[data-nr-of-cart-items]').html(response.nr_of_items);
            $('[data-cart-total]').html(response.total);
            $('[data-goto-checkout]').css(response.nr_of_items == 0 ? {
                'pointer-events': 'none',
                'opacity': '0.4',
            } : {
                'opacity': '1',
                'pointer-events': 'all',
            });
        });
    });
}());

$('[data-likes]').on('click', '[data-delete-like]', function () {
    $.post("/api/delete-like", {
        id: $(this).data("product-id"),
    }).then(function (response) {
        $('[data-likes-html]').html(response.html);
        $("[data-nr-of-likes]").html(response.nr_of_items)
    });
});

$('[data-cart]').on('click', '[data-delete-from-cart]', function () {
    $.post("/api/remove-from-cart", {
        id: $(this).data("id"),
    }).then(function (response) {
        $('[data-cart-html]').html(response.html);
        $('[data-nr-of-cart-items]').html(response.nr_of_items);
        $('[data-cart-total]').html(response.total);
        $('[data-goto-checkout]').css(response.nr_of_items == 0 ? {
            'pointer-events': 'none',
            'opacity': '0.4',
        } : {
            'opacity': '1',
            'pointer-events': 'all',
        });
    });
});

// Payment and shipping
(function () {

    function updateSameAsShipping() {
        if ($('[data-same-as-shipping]').prop('checked')) {
            $('[data-billing-data]').hide();
            // Copy data
            $('input[name="billing_name"]').val( $('input[name="shipping_name"]').val() );
            $('input[name="billing_zip"]').val( $('input[name="shipping_zip"]').val() );
            $('input[name="billing_city"]').val( $('input[name="shipping_city"]').val() );
            $('input[name="billing_street"]').val( $('input[name="shipping_street"]').val() );
        } else {
            $('[data-billing-data]').show();
        }
    }

    if ($('[data-same-as-shipping]')[0]) {
        setInterval(updateSameAsShipping, 1000);
    }

    $('body').on('click', '[data-method]', function () {
        $(this).closest('fieldset').find('[data-method]').removeClass('active');
        $(this).addClass('active');
        var id = $(this).data('id');
        if ($(this).data('field-name') == 'shipping') {
            $('input[name="shipping"]').val(id);

            $.post('/api/change-shipping-method', {
                id: id,
            }, function (response) {
                $('[data-payment-methods]').html(response.html);
                $('[data-shipping-price]').html(response.shipping_price);
                $('[data-total]').html(response.total);
            });
        } else {
            $('input[name="payment"]').val(id);
            $.post('/api/change-payment-method', {
                id: id,
            }, function (response) {
                $('[data-shipping-price]').html(response.shipping_price);
                $('[data-total]').html(response.total);
            });
        }
    });

    var orderLoading = false;

    $('[data-checkout-form]').submit(function (e) {
        e.preventDefault();

        if (orderLoading) {
            return;
        }

        $('button[type="submit"]').html('Kérjük, várjon...');

        orderLoading = true;

        var data = {};
        $('input, textarea').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });

        $.post('/api/order', data, function (response) {
            window.location.href = response.redirect_url;
        });
    })

}());

$('#product-page .photo-and-details > .details .buttons .amount .plus-minus.plus').click(function () {
    $('#product-page .photo-and-details > .details .buttons .amount .nr').html(
        Number($('#product-page .photo-and-details > .details .buttons .amount .nr').text().replace(/[^0-9]/g, '')) + 1
    );
});

$('#product-page .photo-and-details > .details .buttons .amount .plus-minus.minus').click(function () {
    if (Number($('#product-page .photo-and-details > .details .buttons .amount .nr').text()) === 1) {
        return;
    }
    $('#product-page .photo-and-details > .details .buttons .amount .nr').html(
        Number($('#product-page .photo-and-details > .details .buttons .amount .nr').text()) - 1
    );
});

// Product price
(function () {
    function formatPrice(n) {
        return n.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ').replace('.00', '') + ' Ft';
    }

    function updatePriceForProduct($product) {
        var basePrice = $product.data('base-price');
        var baseStock = $product.data('stock');
        var amount = Number($('#product-page .photo-and-details > .details .buttons .amount .nr').html().replace(/[^0-9]+/g, ''));
        var prices = $product.data('prices');
        var stocks = $product.data('stocks');
        var ids = [];
        $('#product-page .photo-and-details > .details .property .value').each(function () {
            if ($(this).find('.variation')[0]) {
                ids.push($(this).find('.active').data('option-id'));
            }
        });
        ids = ids.sort(function (a, b) {
            return a - b;
        });

        // console.log(prices, ids.join('-'))
        console.log(stocks)
        var price = (prices[ids.join('-')] || basePrice) * amount;
        var stock = stocks[ids.join('-')] || baseStock || '-';
        if (!price) {
            $product.find('[data-product-price]').html('-');
            $product.find('.button-row').hide();
        } else {
            $product.find('[data-product-price]').html(formatPrice(price));
            $product.find('.button-row').show();
        }

        $product.find('[data-stock-level]').html(stock);
    }

    function updateAllPrice() {
        updatePriceForProduct($('#product-page'));
    }

    $('.variation[data-option-id]').click(function () {
        setTimeout(function () {
            updateAllPrice();
        }, 100);
    });
    $('#product-page .photo-and-details > .details .buttons .amount .plus-minus.minus').click(updateAllPrice);
    $('#product-page .photo-and-details > .details .buttons .amount .plus-minus.plus').click(updateAllPrice);

    $("#products .product .details .parameters select").change(updateAllPrice);

    if ($('#product-page')[0]) {
        updateAllPrice();
    }
}());

$('[data-close-likes]').click(function () {
    $('[data-likes]').removeClass('shown');
});

$('header  .menu .menu-item.has-submenu').click(function (e) {
    e.stopPropagation();
    $(this).toggleClass('shown');
});

$('body').click(function () {
    $('header  .menu .menu-item.has-submenu').removeClass('shown');
});

$('header .menu .menu-item.has-submenu.shown .submenu').click(function (e) {
    e.stopPropagation();
});

$('[data-change-slide-nth]').click(function () {
    var index = $(this).data('index');
    var a = $('#slider .photo-box')[index];

    $('#slider .photo-box').removeClass('shown');

    $(a).addClass('shown');
});

$('[data-change-slide-next]').click(function () {
    var index = Math.abs(($('#slider .photo-box.shown').index() + 1) % $('#slider .photo-box').length);

    var a = $('#slider .photo-box')[index];
    $('#slider .photo-box').removeClass('shown');
    $(a).addClass('shown');
});

$('[data-change-slide-prev]').click(function () {
    var index = $('#slider .photo-box.shown').index() - 1;
    if (index < 0) {
        index = $('#slider .photo-box').length + index;
    }

    var a = $('#slider .photo-box')[index];
    $('#slider .photo-box').removeClass('shown');
    $(a).addClass('shown');
});

/*
$('#product-page .photo-and-details > .photo .more-photos .small-photo').click(function () {
    $('#product-page .photo-and-details > .photo .more-photos .small-photo').removeClass('active');
    $(this).addClass('active');
    $("#product-page .photo-and-details > .photo .photo-container img").attr('src', $(this).find('img').attr('src'))
});

 */

$('#product-page .photo-and-details > .details .property .value .variation').click(function () {
    $(this).closest('.property').find('.value .variation').removeClass('active');
    $(this).addClass('active');
});

$('[data-filter-clear]').click(function () {
    window.location.href = $('#product-list').data('base-url');
});

(function () {
    $('[data-filter-button]').click(function () {
        var baseUrl = $('#product-list').data('base-url');
        var page = $('#product-list').data('page');
        var discounted = $('[data-filter-discount]').prop('checked');
        var isNew = $('[data-filter-new]').prop('checked');
        var minPrice = $('[data-filter-min-price]').val();
        var maxPrice = $('[data-filter-max-price]').val();
        var sort = $('#product-list').data('sort');
        var q = $('[data-global-search]').val();

        var cat = [];
        $('[data-filter-category]').each(function () {
            if ($(this).prop('checked'))
            cat.push($(this).data('filter-category'));
        });
        window.location.href = baseUrl + '?page=' + String(page) + '&discounted=' + String(discounted ? 1 : '') + '&new=' + String(isNew ? 1 : '') + '&cat=' + String(cat.join(',')) + '&max_price=' + String(maxPrice) + '&min_price=' + String(minPrice) + '&sort=' + String(sort) + '&q=' + encodeURIComponent(q);
    });

    $('[data-sort-select]').change(function () {
        var baseUrl = $('#product-list').data('base-url');
        var page = $('#product-list').data('page');
        var discounted = $('[data-filter-discount]').prop('checked');
        var isNew = $('[data-filter-new]').prop('checked');
        var minPrice = $('[data-filter-min-price]').val();
        var maxPrice = $('[data-filter-max-price]').val();
        var sort = $(this).val();
        var q = $('[data-global-search]').val();
        var cat = [];
        $('[data-filter-category]').each(function () {
            if ($(this).prop('checked'))
                cat.push($(this).data('filter-category'));
        });
        window.location.href = baseUrl + '?page=' + String(page) + '&discounted=' + String(discounted ? 1 : '') + '&new=' + String(isNew ? 1 : '') + '&cat=' + String(cat.join(',')) + '&max_price=' + String(maxPrice) + '&min_price=' + String(minPrice) + '&sort=' + String(sort)  + '&q=' + encodeURIComponent(q);


    })
}());
