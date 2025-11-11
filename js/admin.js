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
            })
        }
    };
}());



LIVE_HTML.add('[data-code-mirror]', function () {
    var $this = $(this);

    var myCodeMirror = CodeMirror($(this)[0], {
        value: $(this).prev().val(),
        lineNumbers: true,
        mode: "htmlmixed",
        htmlMode: true,
        indentWithTabs: true,
        lineWrapping: true,
        matchBrackets: true,
    });
    $(document).keyup(function () {
        $this.prev().val( myCodeMirror.getValue() );
    });
    $(document).click(function () {
        $this.prev().val( myCodeMirror.getValue() );
    });
    setTimeout(function () {
        myCodeMirror.refresh();

    }, 500);
});

$('[data-table-page-select]').change(function () {
    var val = $(this).val();
    var url = $(this).find('option[value="'+String(val)+'"]').data('url');
    window.location.href = url;
});

$('[data-table-search-input]').on('keypress', function(e) {
    function updateQueryParam(key, value) {
        const params = new URLSearchParams(window.location.search);
        params.set(key, value);
        return '?' + params.toString();
    }

    if (e.which == 13) {

        window.location.href = updateQueryParam('q', $(this).val());
    }
});

$(".dropdown-menu-item").click(function () {
    $(this).toggleClass('opened');
});

LIVE_HTML.add('[data-selected-menu]', function () {
    var selectedMenu = String($(this).data('selected-menu'));
    $('[data-menu="'+String(selectedMenu.split('.')[0])+'"]').addClass('selected').addClass('opened');
    $('[data-menu="'+String(selectedMenu)+'"]').addClass('submenu-selected');
});

LIVE_HTML.add('[data-create-invoice]', function () {
    $(this).click(function () {
        var id = String($(this).data('create-invoice'));
        MODAL.ajax('Számla kiállítása', 'forms/create_invoice', { id: id });
    });
});

LIVE_HTML.add('[data-view-label]', function () {
    $(this).click(function () {
        var id = String($(this).data('view-label'));
        window.open("/storage/gls/" + id + '.pdf', "_blank");
    });
});

LIVE_HTML.add('[data-create-label]', function () {
    $(this).click(function () {
        var id = String($(this).data('create-label'));
        MODAL.ajax('GLS címke elkészítése', 'forms/create_label', { id: id });
    });
});

LIVE_HTML.add('[data-print-order]', function () {
    $(this).click(function () {
        var id = String($(this).data('print-order'));
        window.open('/admin/order-print?id=' + id, '_blank').focus();
    });
});


LIVE_HTML.add('[data-edit-customer]', function () {
    $(this).click(function () {
        var id = String($(this).data('edit-customer'));
        MODAL.ajax('Adatok szerkesztése', 'forms/edit_customer', { id: id });
    });
});


LIVE_HTML.add('[data-enter-edit-mode]', function () {
    $(this).click(function () {
        window.location.href = '/admin/order?id=' + String($(this).data('enter-edit-mode')) + '&edit_mode=1';
    })
});

LIVE_HTML.add('[data-leave-edit-mode]', function () {
    $(this).click(function () {
        window.location.href = '/admin/order?id=' + String($(this).data('leave-edit-mode'));
    })
});

LIVE_HTML.add('[data-date-input]', function () {
    var $this = $(this);
    var $table = $(this).find("table");
    var $remove = $(this).closest('.input-box').find('[data-remove]');
    var $input = $(this).find('input[type="hidden"]');

    var month_names = ['január', 'február', 'március', 'április', 'május', 'június', 'július', 'augusztus', 'szeptember', 'október', 'november', 'december'];

    var selectedYear = '';
    var selectedMonth = '';
    var selectedDay = '';

    if ($input.val()) {
        selectedYear = $input.val().substr(0, 4);
        selectedMonth = $input.val().substr(5, 2);
        selectedDay = $input.val().substr(8, 2);
    }

    var currentYear = selectedYear || String((new Date()).getFullYear()); // init
    var currentMonth = selectedMonth || ('0'+String(((new Date()).getMonth()) + 1)).slice(-2) ; // init

    function nextMonth(e) {
        e.stopPropagation();
        var nextMonthDate = new Date(Number(currentYear), Number(currentMonth), 1);
        currentYear = String(nextMonthDate.getFullYear());
        currentMonth = ('0' + String(nextMonthDate.getMonth() + 1)).slice(-2);
        // update view
        rerenderCalendar();
    }

    function prevMonth(e) {
        var prevMonthDate = new Date(Number(currentYear), Number(currentMonth) - 1, 0);
        currentYear = String(prevMonthDate.getFullYear());
        currentMonth = ('0' + String(prevMonthDate.getMonth() + 1)).slice(-2);
        // update view
        rerenderCalendar();
    }

    function rerenderCalendar() {
        var todayDate = new Date();
        var monthDate = new Date(Number(currentYear), Number(currentMonth)-1, 1);
        var startDay = monthDate.getDay();
        if (startDay === 0) {
            startDay = 6;
        } else {
            startDay -= 1;
        }
        var nrOfDays = (new Date(Number(currentYear), Number(currentMonth), 0)).getDate();
        var prevMonthDate = new Date(Number(currentYear), Number(currentMonth) - 1, 0);
        var nextMonthDate = new Date(Number(currentYear), Number(currentMonth), 1);
        var nrOfDaysPrevMonth = prevMonthDate.getDate();
        var days = [];
        var i;
        // prev month
        for (i = startDay - 1; i >= 0; i -= 1) {
            days.push({
                date: String(prevMonthDate.getFullYear()) + '-' + ('0'+String(prevMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0'+String(nrOfDaysPrevMonth - i)).slice(-2),
                nr: String(nrOfDaysPrevMonth - i),
                isOtherMonth: true
            });
        }
        // current month
        for (i = 1; i <= nrOfDays; i += 1) {
            days.push({
                date: String(monthDate.getFullYear()) + '-' + ('0'+String(monthDate.getMonth() + 1)).slice(-2) + '-' + ('0'+String(i)).slice(-2),
                nr: String(i),
                isOtherMonth: false,
            });
        }
        // next month
        var max = (42 - days.length);
        for (i = 1; i <= max; i += 1) {
            days.push({
                date: String(nextMonthDate.getFullYear()) + '-' + ('0'+String(nextMonthDate.getMonth() + 1)).slice(-2) + '-' + ('0'+String(i)).slice(-2),
                nr: String(i),
                isOtherMonth: true,
            });
        }

        i = 0;

        // Refresh days
        $table.find('td').each(function () {
            var nextYear = new Date((new Date()).getFullYear() + 1, 0, 1); // next year, 1th of january
            var MAX_FUTURE_DAYS = (nextYear.valueOf() - Date.now()) / 1000 / 60 / 60 / 24;
            //console.log(nextYear.valueOf(), Date.now())
            var daysFromToday = -Math.round((new Date(todayDate.getFullYear(), todayDate.getMonth(), todayDate.getDate()).valueOf() - (new Date(days[i].date)).valueOf()) / 24 / 1000 / 60 / 60);
            if (daysFromToday < 0) {
                //$(this).find('.day').addClass('non-selectable');
                $(this).find('.day').html(days[i].nr);
            } else if (daysFromToday > MAX_FUTURE_DAYS) {
                //$(this).find('.day').addClass('non-selectable');
                $(this).find('.day').html(days[i].nr);
            } else {
                //$(this).find('.day').removeClass('non-selectable');
                $(this).find('.day').html(days[i].nr);
            }
            //$(this).find('.day').html(daysFromToday < 0 ? '&nbsp;' : (daysFromToday > MAX_FUTURE_DAYS ? '&nbsp;' : days[i].nr));
            $(this).find('.day').data('day', days[i].date);
            $(this).removeClass('today');
            $(this).removeClass('other-month');
            $(this).removeClass('selected');
            if (days[i].isOtherMonth) {
                $(this).addClass('other-month');
            }
            if (days[i].date === (selectedYear + '-' + selectedMonth + '-' + selectedDay)) {
                $(this).addClass('selected');
            }
            if (days[i].date === String(todayDate.getFullYear()) + '-' + ('0'+String(todayDate.getMonth() + 1)).slice(-2) + '-' + ('0'+String(todayDate.getDate())).slice(-2)) {
                $(this).addClass('today');
            }
            i += 1;
        });

        // Refresh current year and month
        $this.find('.header .month').html(currentYear + '. ' + month_names[Number(currentMonth) - 1]);

        // Refresh
        if (selectedYear) {
            $input.val(selectedYear + '-' + selectedMonth + '-' + selectedDay);
            $input.trigger('input');
            var endDate = new Date((new Date(selectedYear + '-' + selectedMonth + '-' + selectedDay)).valueOf() + Number($this.data('days')) * 1000 * 60 * 60 * 24);
            var endDateStr = String(endDate.getFullYear()) + '.' + ('0'+String(endDate.getMonth() + 1)).slice(-2) + '.' + ('0'+String(endDate.getDate())).slice(-2);
            if (Number($this.data('days'))) {
                $this.find('input[type="text"]').val(selectedYear + '-' + selectedMonth + '-' + selectedDay );
            } else {
                $this.find('input[type="text"]').val(selectedYear + '-' + selectedMonth + '-' + selectedDay);
            }
            $remove.show();
        } else {
            $this.find('input[type="text"]').val('');
            $remove.hide();
        }
    }

    $this.find('.header .prev').click(prevMonth);
    $this.find('.header .next').click(nextMonth);

    $this.find('.calendar').click(function (e) { e.stopPropagation(); })

    $this.click(function (e) {
        e.stopPropagation();
        currentYear = selectedYear || String((new Date()).getFullYear()); // init
        currentMonth = selectedMonth || ('0'+String(((new Date()).getMonth()) + 1)).slice(-2) ; // init
        $this.toggleClass("shown");
        rerenderCalendar();
    });

    // Select date
    $this.find('.calendar table td .day').click(function (e) {
        e.stopPropagation();
        if (!$(this).hasClass('non-selectable')) {
            var date = $(this).data('day');
            selectedYear = date.substr(0, 4);
            selectedMonth = date.substr(5, 2);
            selectedDay = date.substr(8, 2);
            rerenderCalendar();
            $this.removeClass('shown');
            $input.trigger('change');
        }
    });

    $remove.click(function () {
        selectedYear = null;
        selectedMonth = null;
        selectedDay = null;
        $input.val('');
        rerenderCalendar();
        $this.removeClass('shown');
        $input.trigger('change');
    });

    $(document).click(function () {
        $this.removeClass('shown');
    });

    $input.change(function () {
        rerenderCalendar();
    });

    rerenderCalendar(); // init
});

(function () {

    var html = `
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
               
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" data-bg></div>
        
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
                
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    
                          <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button data-close type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                              <span class="sr-only">Close</span>
                              <!-- Heroicon name: outline/x -->
                              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                              </svg>
                            </button>
                          </div>
      
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                <span data-title></span>
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    <span data-description></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button data-yes type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            
                        </button>
                        <button data-no type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                            Mégse
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    var eventHandlers = {};

    window.CONFIRM = {
        show: function (title, description, yes, callback) {
            var $dialog = $(html);
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-description]').html(description);
            $dialog.find('[data-yes]').html(yes);
            $dialog.find('[data-no], [data-close], [data-bg]').click(function () {
                $dialog.remove();
            });
            $dialog.find('[data-yes]').click(function () {
                callback();
                if (typeof eventHandlers[$dialog.data('confirm-id')] === 'function') {
                    eventHandlers[$dialog.data('confirm-id')]();
                }
                $dialog.remove();
            });
            $("body").append($dialog);
        },
        onConfirm: function (id, callback) {
            eventHandlers[id] = callback;
        }
    };

}());

(function () {

    var html = `
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
          <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" data-bg></div>
        
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        

            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full sm:p-6">
              <div>
              
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100" data-icon>
                  
                </div>
                <div class="mt-3 text-center sm:mt-5">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title" data-title>
                    
                  </h3>
                  <div class="mt-2">
                    <p class="text-sm text-gray-500" data-description>
                      
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-5 sm:mt-6" data-button-row>
                <button data-button type="button" class="inline-flex justify-center w-full rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">
                  
                </button>
              </div>
            </div>
          </div>
        </div>
    `;

    window.POPUP = {
        success: function (icon, title, description, button, callback) {
            var $dialog = $(html);
            $dialog.find('[data-icon]').html(icon);
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-description]').html(description);
            $dialog.find('[data-button]').html(button);
            $dialog.find('[data-button], [data-bg]').click(function () {
                $dialog.remove();
                if (callback) {
                    callback();
                }
            });
            if (!button) {
                $dialog.find('[data-button-row]').remove();
            }
            $("body").append($dialog);
        },
        failure: function (icon, title, description, button, callback) {
            var $dialog = $(html);
            $dialog.find('[data-icon]').html(icon);
            $dialog.find('[data-icon]').removeClass('bg-green-100');
            $dialog.find('[data-icon]').addClass('bg-red-100');
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-description]').html(description);
            $dialog.find('[data-button]').html(button);
            $dialog.find('[data-button], [data-bg]').click(function () {
                $dialog.remove();
                if (callback) {
                    callback();
                }
            });
            if (!button) {
                $dialog.find('[data-button-row]').remove();
            }
            $("body").append($dialog);
        },
        loading: function (title, description) {
            var $dialog = $(html);
            $dialog.find('[data-icon]').html('<i class="fa-regular fa-spinner-third fa-spin"></i>');
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-description]').html(description);
            $dialog.find('[data-button-row]').remove();
            $("body").append($dialog);
            return {
                close: function () {
                    $dialog.remove();
                },
            };
        }
    };

}());


(function () {

    var html = `
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" data-modal-window>
          <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" data-bg aria-hidden="true"></div>
        
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
             
              <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                <button data-close type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <span class="sr-only">Close</span>
                  <!-- Heroicon name: outline/x -->
                  <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>
              
              <div class="sm:items-start">

                <div class="text-center sm:mt-0 sm:text-left">
                  <h3 class="text-lg leading-6 font-medium text-gray-900" data-title>
                    Deactivate account
                  </h3>
                  <div class="mt-5" data-content>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

    `;

    window.MODAL = {
        show: function (title, contentHtml) {
            var $dialog = $(html);
            $dialog.find('[data-title]').html(title);
            $dialog.find('[data-content]').html(contentHtml);
            $dialog.find('[data-close], [data-bg]').click(function () {
                $dialog.remove();
            });
            $("body").append($dialog);
            return $dialog;
        },
        ajax: function (title, view, data, modalId) {
            var loadingPopup = POPUP.loading('Betöltés');
            setTimeout(function () {
                $.post('/admin-api/render', {view: view, data: data || {}}, function (response) {
                    var dialog = MODAL.show(title, response.html);
                    var $form = dialog.find("form");
                    if ($form[0] && modalId) {
                        $form.attr('data-form-id', modalId + '-form');
                        $form.data('form-id', modalId + '-form');
                    }
                    LIVE_HTML.update(dialog);
                    loadingPopup.close();
                });
            }, 0);
        }
    };

}());

$("[data-navbar-profile-pic]").click(function (e) {
   e.stopPropagation();
   $("[data-profile-context-menu]").toggleClass("invisible");
});

$("body").click(function () {
    $("[data-profile-context-menu]").addClass("invisible");
    $("[data-custom-select] [data-dropdown]").addClass('hidden');
    $("[data-multiselect] [data-dropdown]").addClass('hidden');
    $("[data-lookup] [data-dropdown]").hide();
});

$("[data-hamburger-icon]").click(function (e) {
    $("[data-mobile-menu]").removeClass("invisible");
});

$("[data-close-mobile-menu]").click(function (e) {
    $("[data-mobile-menu]").addClass("invisible");
});

$("[data-logout]").click(function () {
    POPUP.loading('Kijelentkezés', 'Kérjük várjon...');
    setTimeout(function () {
        $.post("/admin-api/logout", {}, function (response) {
            window.location.href = response.redirect_url;
        });
    }, 1000);
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
            $form.find("button[type=submit]").prop("disabled", true).html('&nbsp;<i style="position: relative; top: 2px;" class="fa-regular fa-spinner-third fa-spin"></i>&nbsp;'); // spinner
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
                                        /*
                                        if (!$first_wrong_input || $input_row.offset().top < $input_row.offset().top) {
                                            $first_wrong_input = $input_row;
                                        }

                                         */
                                    }
                                });
                                // console.log($first_wrong_input.offset())
                                /*
                                if ($first_wrong_input && scroll_to_error) {
                                    $("html, body").animate({
                                        scrollTop: Math.max(0, $first_wrong_input.offset().top - 50)
                                    }, 1000);
                                }

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
                                    POPUP.success('<i class="fa-regular fa-check"></i>', 'Sikeres művelet', response.success_message, 'Rendben', function () {
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
                                POPUP.success('<i class="fa-regular fa-check"></i>', 'Sikeresen elmentve', 'A módosításokat elmentette a rendszer.');
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
                            }
                        }
                    }).fail(function () {
                        enable_form();
                        POPUP.failure('<i class="fa-regular fa-hexagon-exclamation"></i>', 'Kapcsolódási hiba', 'Nem sikerült kapcsolódni a kiszolgálóhoz. Próbáld újra vagy vedd fel a kapcsolatot a rendszer üzemeltetőivel', 'Rendben')
                    });
                }, DEV_MODE ? 1500 : 0);
            }
        });
    });
}());

// Select
LIVE_HTML.add('[data-custom-select]', function () {
    // Init
    $(this).click(function (e) {
        e.stopPropagation();
        $(this).find('[data-dropdown]').toggleClass('hidden');
    });

    $(this).find('[data-dropdown]').click(function (e) {
        e.stopPropagation();
    });

    $(this).find('[data-dropdown] li').click(function (e) {
        e.stopPropagation();
        var $root = $(this).closest('[data-custom-select]');
        var newKey = $(this).data('key');
        $root.find('[data-checkmark]').hide();
        $root.find('li[data-key="'+newKey+'"] [data-checkmark]').show();
        $root.find('input[type="hidden"]').val(newKey);
        $root.find('[data-text]').html($(this).find('[data-item-text]').html());
        $root.find('[data-dropdown').addClass('hidden');
    });

});


// Multiselect
LIVE_HTML.add('[data-multiselect]', function () {
    var $this = $(this);
    var value = JSON.parse($this.find('input[type="hidden"]').val());

    function isSelected(val) {
        for (const v of value) {
            if (val == v) {
                return true;
            }
        }
        return false;
    }

    function rerender() {
        $this.find('[data-checkmark]').hide();
        var badges = '';
        value.forEach(function (key) {
            badges += '<span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-100 text-gray-800">';
            var captionHtml = $this.find('li[data-key="' + key + '"] [data-item-text]').html();
            $this.find('li[data-key="' + key + '"] [data-checkmark]').show();
            badges += captionHtml;
            badges += '</span>&nbsp;'
        });
        $this.find('[data-text]').html(badges || 'Válasszon...');
        $this.find('input[type="hidden"]').val(JSON.stringify(value));
    }

    // Init
    $(this).click(function (e) {
        e.stopPropagation();
        $(this).find('[data-dropdown]').toggleClass('hidden');
    });

    $(this).find('[data-dropdown]').click(function (e) {
        e.stopPropagation();
    });

    $(this).find('[data-dropdown] li').click(function (e) {
        e.stopPropagation();
        var newKey = $(this).data('key');
        if (isSelected(newKey)) {
            // Remove
            value.splice(value.indexOf(newKey), 1);
        } else {
            // Add
            value.push(newKey);
        }

        rerender();
    });

});


// Toggle input
LIVE_HTML.add('[data-toggle]', function () {

    $(this).click(function () {
        var currentValue = $(this).find('input[type="hidden"]').val();
        if (String(currentValue) === '0') {
            currentValue = '1';
        } else {
            currentValue = '0';
        }
        $(this).find('input[type="hidden"]').val(currentValue);
        $(this).find('input[type="hidden"]').trigger('change');
        if (currentValue === '0') {
            $(this).find('button').removeClass('bg-indigo-500');
            $(this).find('button').addClass('bg-gray-200');
            $(this).find('[data-handle]').removeClass('translate-x-5');
        } else {
            $(this).find('button').addClass('bg-indigo-500');
            $(this).find('button').removeClass('bg-gray-200');
            $(this).find('[data-handle]').addClass('translate-x-5');
        }
    });

});

LIVE_HTML.add('[data-show-modal]', function () {

    $(this).click(function () {
        var view = $(this).data('view');
        var title = $(this).data('title');
        var params = $(this).data('params');

        MODAL.ajax(title, view, params, $(this).data('modal-id'));
    });

});

(function () {
    var eventHandlers = {};

    window.AJAX_CONFIRM = {
        onSuccess: function (id, callback) {
            eventHandlers[id] = callback;
        }
    };

    LIVE_HTML.add('[data-confirm]', function () {
        $(this).click(function () {
            var $this = $(this);
            var confirmId = $(this).data("confirm-id");
            var url = $(this).data('url');
            var title = $(this).data('title');
            var description = $(this).data('description');
            var yes = $(this).data('yes');

            CONFIRM.show(title, description, yes, function () {

                var loadingPopup = POPUP.loading('Folyamatban...');
                setTimeout(function () {
                    $.post(url, $this.data('params'), function (response) {
                        loadingPopup.close();
                        if (response.error) {
                            POPUP.failure('<i class="fa-regular fa-hexagon-exclamation"></i>', 'Hiba történt', response.error);
                        } else {
                            if (typeof eventHandlers[confirmId] === "function") {
                                eventHandlers[confirmId](response);
                            } else {
                                if (response.redirect_url) {
                                    if (response.redirect_url === '(current)') {
                                        window.location.reload();
                                    } else {
                                        window.location.href = response.redirect_url;
                                    }
                                } else if (response.success_message) {
                                    POPUP.success('<i class="fa-regular fa-check"></i>', 'Sikeres művelet', response.success_message, 'Rendben', function () {
                                        if (response.redirect_after_success) {
                                            if (response.redirect_after_success === '(current)') {
                                                window.location.reload();
                                            } else {
                                                window.location.href = response.redirect_after_success;
                                            }
                                        }
                                    });
                                }
                            }
                        }
                    });
                }, 0);
            });
        });
    });
}());

LIVE_HTML.add('input[name="enable_2fa"]', function () {
    $(this).change(function () {
        var val = $(this).val();
        if (String(val) === "1") {
            $.post('/admin-api/enable-2fa', function (response) {
                $('[data-2fa-info]').show();
                $('[data-2fa-info] img').attr('src', response.qr);
                $('[data-2fa-info]').closest('form').find('input[name="secret"]').val(response.secret);
            });
        } else {
            $.post('/admin-api/disable-2fa', function (response) {
                $('[data-2fa-info]').hide();
            });
        }
    });
});

// Entities

LIVE_HTML.add('[data-entities]', function () {
    var $entities = $(this);
    var entitiesId = $entities.data('entities-id');
    var $addButton = $entities.find('[data-add-entity]');
    var columns = $entities.data('columns');
    var actions = $entities.data('actions');
    var className = $entities.data('class');
    var forceReload = $entities.data('force-reload');
    var max = $entities.data('max');

    var value = JSON.parse($entities.find('input[type="hidden"]').val());

    function updateCountChange() {
        $entities.find('[data-empty-state]').hide();
        $entities.find('[data-add-entity]').hide();
        $entities.find('.custom-table').hide();

        if (value.length === 0) {
            $entities.find('[data-empty-state]').show();
        } else {
            $entities.find('.custom-table').show();
            $entities.find('[data-add-entity]').show();
            $entities.find('[data-empty-state]').hide();
        }

        if (Number(max) && value.length >= Number(max)) {
            $entities.find('[data-add-entity]').hide();
        }
    }

    function insertRow(id) {
        $.post("/admin-api/render-table-row", {
            id: id,
            columns: columns,
            class: className,
            actions: actions,
        }, function (response) {
            var $newRow = $(response.html);
            $newRow.find('[data-show-modal]').data('modal-id', entitiesId + '-edit');
            $newRow.find('[data-show-modal]').attr('data-modal-id', entitiesId + '-edit');
            $newRow.find('[data-confirm]').data('confirm-id', entitiesId + '-delete');
            $newRow.find('[data-confirm]').attr('data-confirm-id', entitiesId + '-delete');
            LIVE_HTML.update($newRow);
            $entities.find('tbody').append($newRow);
        });
    }

    function updateRow(id) {
        $.post("/admin-api/render-table-row", {
            id: id,
            columns: columns,
            class: className,
            actions: actions,
        }, function (response) {
            var $newRow = $(response.html);
            $newRow.find('[data-show-modal]').data('modal-id', entitiesId + '-edit');
            $newRow.find('[data-show-modal]').attr('data-modal-id', entitiesId + '-edit');
            $newRow.find('[data-confirm]').data('confirm-id', entitiesId + '-delete');
            $newRow.find('[data-confirm]').attr('data-confirm-id', entitiesId + '-delete');
            LIVE_HTML.update($newRow);
            $entities.find('tr[data-id="'+id+'"]').replaceWith($newRow);
        });
    }

    AJAX_FORM.onSuccess(entitiesId + '-add-form', function (response) {
        value.push(response.id);
        $entities.find('input[type="hidden"]').val(JSON.stringify(value));
        insertRow(response.id);
        updateCountChange();
        if (forceReload) {
            window.location.reload();
        }
    });

    AJAX_FORM.onSuccess(entitiesId + '-edit-form', function (response) {
        updateRow(response.id);
    });

    AJAX_CONFIRM.onSuccess(entitiesId + '-delete', function (response) {
        $entities.find('tr[data-id="'+response.id+'"]').remove();
        var newValue = [];
        value.forEach(function (item) {
            if (item != response.id) {
                newValue.push(item);
            }
        });
        value = newValue;
        $entities.find('input[type="hidden"]').val(JSON.stringify(value));
        updateCountChange();
        if (forceReload) {
            window.location.reload();
        }
    });

    updateCountChange();
});

LIVE_HTML.add('[data-lookup]', function () {
   var $lookup = $(this);
   var $dropdown = $lookup.find('[data-dropdown]');
   var $hiddenInput = $lookup.find('input[type="hidden"]');
   var className = $lookup.data('class');
   var except = $lookup.data('except');
   var attrs = $lookup.data("attrs");
   var classParts = className.split('\\');
   var classShortName = classParts[classParts.length - 1];
   var columnName = $lookup.data('column');
   var searchUrl = $lookup.data('url') || ('/admin-api/search?class=' + classShortName + '&attrs=' + attrs + '&column=' + columnName + '&except=' + except);

   var lastAjaxId = 0;
   var timeoutId;
   var results = [];

   function createResultsHtml() {
       var html = '<div>';
       results.forEach(function (result) {
           html += '<li data-search-result class="text-gray-900 cursor-default select-none relative py-2 pl-4 pr-4" id="listbox-option-0" data-key="'+result.id+'">';
           html += '<span class="font-normal block" data-item-text>';
           html += result.html;
           html += '</span>';
           html += '</li>';
       });
       return html + '</div>';
   }

   function updateResults() {
       if (results.length === 0) {
           $dropdown.hide();
       } else {
           var $results = $(createResultsHtml());
           $results.find('[data-search-result]').click(function (e) {
               e.stopPropagation();
               // Select new value
               $dropdown.hide();
               $hiddenInput.val($(this).data('key'));
               $hiddenInput.trigger('change');
               $lookup.find('[data-value-html]').html($(this).find('[data-item-text]').html());
               $lookup.find('[data-value-html]').show();
               $lookup.find('[data-search-input]').hide();
               $lookup.find('[data-icon]').hide();
               $lookup.find('[data-remove]').show();
           });
           $dropdown.html($results);
           $dropdown.show();
       }
   }

   function getResults(q) {
       if (timeoutId) {
           clearInterval(timeoutId);
       }
       timeoutId = setTimeout(function () {
           lastAjaxId += 1;
           var currentAjaxId = lastAjaxId;

           $.post(searchUrl, {
               q: q,
           }, function (response) {
               if (lastAjaxId === currentAjaxId) {
                   results = response.results;
                   updateResults();
               }
           });
       }, 500);
   }

   var lastInputTime = 0;
   $lookup.find('[data-search-input]').on('input', function () {
       var q = $(this).val().trim();
       if (!q) {
           getResults('--&&--@@--&&--');
       } else {
           getResults(q);
       }
   });

    $lookup.find('[data-search-input]').click(function (e) {
        e.stopPropagation();
    });

    $lookup.find('[data-remove]').click(function (e) {
        $hiddenInput.val('');
        $lookup.find('[data-value-html]').html('');
        $lookup.find('[data-value-html]').hide();
        $lookup.find('[data-search-input]').val('');
        $lookup.find('[data-search-input]').show();
        $lookup.find('[data-icon]').show();
        $lookup.find('[data-remove]').hide();
        setTimeout(function () {
            $lookup.find('[data-search-input]').focus();
        }, 100);
    });
});

// UPLOAD
(function () {
    function getBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = () => resolve(reader.result.toString().replace(/^data:(.*,)?/, ''));
            reader.onerror = error => reject(error);
        });
    }

    function uploadFile(file, callback) {
        getBase64(file).then(function (data) {
            setTimeout(function () {
                $.post('/admin-api/upload', {
                    data: data,
                    filename: file.name,
                }, callback);
            }, 1000);
        });
    }

    LIVE_HTML.add('[data-file-input]', function () {
        var $this = $(this);
        var confirmId = $(this).find('[data-confirm]').data('confirm-id');
        var $fileInput = $(this).find('input[type="file"]');
        var $hiddenInput = $(this).find('input[type="hidden"]');

        $(this).find('[data-reupload]').click(function () {
            $fileInput.trigger('click');
        });

        function changeUploadedFile(fileInfo) {
            $this.find('[data-uploaded-file]').show();
            $this.find('[data-file-empty-state]').hide();
            $this.find('[data-confirm]').data('params', { id: fileInfo.id });
            $this.find('[data-uploaded-file] [data-photo-url]').attr('src', fileInfo.photoUrl);
            $this.find('[data-uploaded-file] [data-filename]').html(fileInfo.filename);
            $this.find('[data-uploaded-file] [data-filesize]').html(fileInfo.size);
            $hiddenInput.val(fileInfo.id);
        }

        $fileInput.change(function () {
            if ($(this)[0].files.length > 0) {
                var loadingPopup = POPUP.loading('Feltöltés folyamatban', 'Kérjük, várjon...');
                uploadFile($(this)[0].files[0], function (response) {
                    loadingPopup.close();
                    changeUploadedFile(response);
                });
                setTimeout(function () {
                    $fileInput.val('');
                }, 100);
            }
        });

        AJAX_CONFIRM.onSuccess(confirmId, function () {
            $this.find('[data-uploaded-file]').hide();
            $this.find('[data-file-empty-state]').show();
            $hiddenInput.val('');
        });
    });
}());



LIVE_HTML.add('[data-faq]', function () {
    var $this = $(this);

    $this.find('[data-question]').click(function () {
        if ($this.hasClass('active')) {
            $this.find('[data-answer]').slideUp();
        } else {
            $this.find('[data-answer]').slideDown();
        }
        $this.toggleClass('active');
    });
});

LIVE_HTML.add('[data-tooltip]', function () {
    var $this = $(this);

    tippy($this[0], {
        content: $(this).data('tooltip'),
    });
});


LIVE_HTML.add('[data-visible-if]', function () {
    var $this = $(this);
    var $form = $(this).closest('form');
    var orParts = $(this).data('visible-if').split('|');

    var ors = [];

    orParts.forEach(function (part) {
        var parts = part.split(':');
        var fieldName = parts[0].trim();
        var fieldOptions = parts[1].trim().split(',').map(function (i) {
            return i.trim()
        });
        var $field = $form.find('input[name="' + fieldName + '"], select[name="' + fieldName + '"], textarea[name="' + fieldName + '"]');

        ors.push({
            '$field': $field,
            'options': fieldOptions,
        });
    });

    setInterval(function () {
        var found = false;
        ors.forEach(function (o) {
            if (o.$field[0]) {
                if (o.$field[0].tagName.toLowerCase() === 'input' && o.$field.attr('type') === "checkbox") {
                    if (o.options.indexOf(o.$field.prop('checked') ? '1' : '0') >= 0) {
                        found = true;
                    }
                } else {
                    var val = o.$field.val();

                    if (o.options.indexOf(val) >= 0) {
                        found = true;
                    }
                }
            }
        });
        if (found) {
            $this.show();
        } else {
            $this.hide();
        }
    }, 1000);
});

LIVE_HTML.add('[data-clone-input]', function () {
    var $this = $(this);
    var inputName = $(this).data('clone-input');
    $('input[name="'+inputName+'"]').on("input", function () {
        $this.text($(this).val());
    });
});

LIVE_HTML.add('[data-global-search]', function () {
    var $input = $(this).find('input[type="hidden"]');

    $input.change(function () {
        var id = $(this).val();
        window.location.href = id;
    });
});

LIVE_HTML.add('[data-subaction]', function () {
    $(this).click(function (e) {
        e.stopPropagation();
        $(this).toggleClass('opened');
    });

    $(document).click(function () {
        $('[data-subaction]').removeClass('opened');
    });
});

LIVE_HTML.add('[data-master-data]', function () {
    $(this).find('button').trigger('click');
});

LIVE_HTML.add('[data-lang-tab]', function () {
    var selectedLang = 'hu';

    function refresh() {
        $('[data-visible-if-lang]').hide();
        $('[data-visible-if-lang][data-lang="'+selectedLang+'"]').show();
    }

    $(this).click(function () {
        $("[data-lang-tab]").removeClass('active');
        $(this).addClass('active');
        selectedLang = $(this).data('lang');
        refresh();
    });

    refresh();
});

LIVE_HTML.add('[data-summernote]', function () {
    var $this = $(this);

    var quill = new Quill($(this).find('.summernote-container')[0], {
        theme: 'snow',
        modules: {
            table: true,
            toolbar: [
                [{ header: [1, 2, 3, 4, 5, 6,  false] }],
                ['bold', 'italic', 'underline','strike'],
                ['image', 'code-block'],
                ['link'],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['table'],
                ['clean'],
                [{ 'indent': '-1' }, { 'indent': '+1' }],
            ]
        },
        placeholder: 'Kezdjen el gépelni...',
    });

    setInterval(function () {
        var html = quill.root.innerHTML;
        $this.find('input[type="hidden"]').val(html);
    }, 1500);

    // Init
    var html = quill.root.innerHTML;
    $this.find('input[type="hidden"]').val(html);
});

LIVE_HTML.update('body');

