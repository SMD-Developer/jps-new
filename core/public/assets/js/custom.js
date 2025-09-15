﻿'use strict';
$(document).ajaxStart(function() { Pace.restart(); });
window.addEventListener('load', function() {
    var forms = document.getElementsByClassName('needs-validation');
    var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }else{
                $(form).find('.btn_submit').button('loading');
            }
            form.classList.add('was-validated');
        }, false);
    });
}, false);
$.fn.button = function(action) {
    if (action === 'loading') {
        let spinner = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Processing ...";
        this.data('original-text', this.html()).html(spinner).addClass('disabled').prop('disabled',true);
    }
    if (action === 'reset' && this.data('original-text')) {
        this.html(this.data('original-text')).removeClass('disabled').prop('disabled',false);
    }
};
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.fn.dataTable.ext.errMode = 'console';
    $('form').validator();

    var t = $('.datatable').DataTable({
        "columnDefs": [{
            "searchable": false,
            "orderable": false,
            "targets": 0
        }],
        "order": [
            [1, 'asc']
        ],
        "bLengthChange": true,
        "bInfo": false,
        "filter": true,
        "oLanguage": {
            "sSearch": "Search",
            "processing": "Loading. Please wait..."
        }
    });
    $('div.dataTables_filter input').addClass('form-control input-sm');
    $('div.dataTables_length select').addClass('form-control input-sm');
    t.on('order.dt search.dt', function() {
        t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });
    }).draw();
    $('.datepicker').pikaday({ firstDay: 1, format: 'YYYY-MM-DD', autoclose: true });
    $(".chosen").chosen({ width: '100%' });
    if (isTouchDevice() === false) {
        $('[data-rel="tooltip"]').tooltip().click(function(e) {
            $(this).tooltip('toggle');
        });
    }

    //Add text editors
    $('.text_editor').trumbowyg({height: 50});
    /*======================================
       CUSTOM SCRIPTS
    ========================================*/
    var $modal = $('#ajax-modal');
    $(document).on('click', '[data-toggle="ajax-modal"]', function(e) {
        e.preventDefault();
        var element = $(this);
        var url = $(this).attr('href');
        if (url.indexOf('#') === 0) {
            $('#mainModal').modal('open');
        } else {
            element.button('loading');
            $modal.load(url, function(response, status, xhr) {
                if (status !== "error") {
                    $modal.modal();
                    new PerfectScrollbar('.modal-body');
                    $('.datepicker').pikaday({ firstDay: 1, format: 'YYYY-MM-DD', autoclose: true });
                    $('form').validator().on('submit', function(e) {
                        if (e.isDefaultPrevented()) {
                            return false;
                        }
                    });
                    $(".chosen").chosen({ width: '100%' });
                    if ($.isFunction($.fn.togglepassword)) {
                        $('[type="password"]').togglepassword('btn btn-light');
                    }
                    if (element.hasClass('ajaxNonReload')) {
                        $modal.find('form').addClass('ajaxNonReload');
                    }
                    if (element.attr("data-element")) {
                        $modal.find('form').attr('data-element', element.attr("data-element"));
                    }
                    if ($modal.find('#payment_form').length > 0) {
                        $('.ajaxChosen').ajaxChosen({
                            dataType: 'json',
                            type: 'POST',
                            url: '/search',
                            success: function(data, textStatus, jqXHR) {}
                        }, {
                            processItems: function(data) { return data; },
                            generateUrl: function(q) { return '/invoices/ajaxSearch' },
                            loadingImg: '/assets/plugins/chosen/loading.gif',
                            minLength: 1
                        });
                    }
                    //Add text editors
                    if ($modal.find('.text_editor').length > 0) {
                        $('.text_editor').summernote({
                            height: 200
                        });
                    }
                }else{
                    if (xhr.responseJSON) {
                        var result = response;
                    } else {
                        var result = JSON.parse(response);
                    }
                    showNotification(result.message, 'error');
                }
                element.button('reset');
            });
        }
    });
    $(document).on('submit', '.ajax-submit', function(e) {
        e.preventDefault();
        var $form = $(this),
        $modal = $form.closest('.modal-dialog'),
        $modalBody = $form.find('.modal-body');
        $modalBody.find('.alert-danger').remove();
        var formData = new FormData(this);
        var ajaxNonReload = false;
        if ($form.hasClass('ajaxNonReload')) {
            ajaxNonReload = true;
            formData.append('ajaxNonReload', 'true');
            $form.find('button[type=submit]').button('loading');
        }
        $.ajax({
            type: "POST",
            url: $form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                $modal.addClass('spinner');
                $('#error_div').remove();
                $modalBody.find('.form-group').removeClass('has-error');
                $form.find('button[type="submit"]').button('loading');
            },
            success: function(data) {
                if (ajaxNonReload) {
                    if ($form.attr("data-element")) {
                        var element = $form.attr("data-element");
                        $('#' + element).append('<option value="' + data.value + '">' + data.text + '</option>');
                        $('#' + element).val(data.value).trigger('chosen:updated');
                    }
                    $('#ajax-modal').modal('hide');
                } else {
                    window.location.reload();
                }
            },
            error: function(jqXHR, json, errorThrown) {
                var response = jqXHR.responseJSON;
                var errors = response.errors;
                var errorStr = '<h6 class="text-white">' + response.message + '</h6>';
                $form.find('.form-control').removeClass('is-invalid');
                if (response.errors) {
                    $.each(errors, function(key, value) {
                        $(':input[name="' + key + '"]').addClass("is-invalid");
                        errorStr += '- ' + value[0] + '<br/>';
                    });
                }
                var errorsHtml = errorMessage(errorStr);
                $form.prepend(errorsHtml);
                $('#ajax-modal').animate({ scrollTop: 0 }, 'slow');
            },
            complete: function() {
                $modal.removeClass('spinner');
                $form.find('button[type="submit"]').button('reset');
            }
        });
    });
    if ($('#activation-modal').length == 1) {
        $('#activation-modal').modal();
    }
    if ($.isFunction($.fn.togglepassword)) {
        $('[type="password"]').togglepassword('btn btn-light');
    }
});
$(document).on('change','input.select-all-permissions', function(){
    $(this).parents('table').find('input:checkbox').not(this).prop('checked', this.checked);
});
$(document).on('change','input.chkbx-permission', function(){
    if ($('input.chkbx-permission:checked').length === $('.chkbx-permission').length) {
        $('input.select-all-permissions').prop('checked', true);
    }else{
        $('input.select-all-permissions').prop('checked', false);
    }
});
function showNotification(text, icon) {
    Swal.fire({
        icon: icon,
        title: text,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 5000
    });
}
function isTouchDevice() {
    return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
}

function checkLicense() {
    var usernameInput = $('#envato_username');
    var purchaseCodeInput = $('#purchase_code');
    $("#activation-modal .form-group").each(function(index) {
        $(this).removeClass("has-error");
    });
    if (usernameInput.val() == '') {
        usernameInput.parent().addClass("has-error");
    } else if (purchaseCodeInput.val().length < 9) {
        purchaseCodeInput.parent().addClass("has-error");
    } else {
        var form = $('#verify_form');
        var formData = form.serialize();
        var modalBody = $('#activation-modal').find('.modal-body');
        $.ajax({
            url: form.attr('action'),
            type: "post",
            data: formData,
            beforeSend: function() {
                $('#activation-modal').find('.modal-dialog').addClass('spinner');
                $('#activation_error').remove();
            },
            success: function(response) {
                window.location.reload(true);
            },
            error: function(jqXhr, json, errorThrown) {
                var response = jqXhr.responseJSON;
                var errorsHtml = '<div class="alert alert-danger" id="activation_error"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + response.error + '</div>';
                modalBody.prepend(errorsHtml);
            },
            complete: function() {
                $('#activation-modal').find('.modal-dialog').removeClass('spinner');
            }
        })
    }
}
/*--------------------------------------------------------------
 Template select navigation
 --------------------------------------------------------------*/
$(document).on('change', '#template_select', function() {
    window.location.href = this.value;
});
$(document).on('click', '#btn_add_row', function() {
    cloneRow('item_table');
});
$(document).on('change', '#currency', function() {
    if ($(this).val() !== '') {
        $('.currencySymbol').text($("[name='currency']").val());
    }
});
$(document).on('change', 'input[name="selected_method"]', function() {
    if (this.checked) {
        $('#method_btn').prop('disabled', false);
    } else {
        $('#method_btn').prop('disabled', true);
    }
});

function errorMessage(errorStr) {
    return '<div class="col-sm-12 alert alert-danger bg-danger text-white" id="error_div"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorStr + '</div>';
}

function scrollToElement(element) {
    $('html, body').animate({
        scrollTop: element.offset().top - 200
    }, 1000);
}
function searchPermissions() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("permissionTable");
    tr = table.getElementsByTagName("tr");
    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}