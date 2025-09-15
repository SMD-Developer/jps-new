$(function(){
    $('form').validator();
    $('[type="password"]').togglepassword('btn btn-outline-light p-1');
    $.fn.button = function(action) {
        if (action === 'loading') {
            let spinner = "<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span> Processing ...";
            this.data('original-text', this.html()).html(spinner).addClass('disabled').prop('disabled',true);
        }
        if (action === 'reset' && this.data('original-text')) {
            this.html(this.data('original-text')).removeClass('disabled').prop('disabled',false);
        }
    };
    $(document).on('submit','.loginFrm',function (e){
        e.preventDefault();
        var form = $(this);
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                form.addClass('spinner');
                $('#error_div').remove();
                form.find('.form-group').removeClass('has-error');
                form.find('button[type="submit"]').button('loading');
            },
            success: function(data, textStatus, jqXHR) {
                if (jqXHR.responseJSON) {
                    result = data;
                } else {
                    result = JSON.parse(data);
                }
                if (result.action === 'redirect') {
                    window.location.href = result.redirect_url;
                }else{
                    errorMessage(result.message)
                }
            },
            error: function(jqXHR, json, errorThrown) {
                var response = jqXHR.responseJSON;
                var errors = response.errors;
                var errorStr = '<h6 class="text-white">' + response.message + '</h6>';
                form.find('.form-control').removeClass('is-invalid');
                var errorsHtml = errorMessage(errorStr);
                form.prepend(errorsHtml);
            },
            complete: function() {
                form.removeClass('spinner');
                form.find('button[type="submit"]').button('reset');
            }
        });
    });
});
function errorMessage(errorStr) {
    return '<div class="col-sm-12 alert alert-danger bg-danger text-white text-xs" id="error_div"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + errorStr + '</div>';
}