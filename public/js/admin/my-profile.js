siteObjJs.admin.myProfileJs = function () {
    var confirmRemoveImage, maxFileSize, mimes;
    var token = $('meta[name="csrf-token"]').attr('content');
    // Initialize all the page-specific event listeners here.

    var initializeListener = function () {

        //Reset everything when clicked on cancel
        $('body').on("click", ".btn-collapse", function () {
            $("#ajax-response-text").html("");
            //retrieve id of form element and create new instance of validator to clear the error messages if any
            var formElement = $(this).closest("form");
            var formId = formElement.attr("id");
            var validator = $('#' + formId).validate();
            validator.resetForm();
            //remove any success or error classes on any form, to reset the label and helper colors
            $('.form-group').removeClass('has-error');
            $('.form-group').removeClass('has-success');
        });

        //Reset everything when clicked on cancel
        $('body').on("click", ".remove-image", function () {
            var formElement = $(this.closest('form'));
            bootbox.confirm({
                buttons: {confirm: {label: 'CONFIRM'}},
                message: siteObjJs.admin.myProfileJs.confirmRemoveImage,
                callback: function (result) {
                    if (result === false) {
                        return;
                    }
                    $('#avatar')[0].files[0] = "";
                    $('#remove').val('remove');
                    formElement.submit();
                }
            });
        });

        //bind to onchange event of avatar input field
        $('#avatar').bind('change', function (e) {
            var elet = $(this);
            //this.files[0].size gets the size of your file.
            if (this.files[0]) {
                if (this.files[0].size > 2097152) {
                    var error = siteObjJs.admin.myProfileJs.maxFileSize;
                    $('#file-error').text(error);
                    return false;
                }

                var ext = $('#avatar').val().split('.').pop().toLowerCase();
                if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                    var error = siteObjJs.admin.myProfileJs.mimes;
                    $('#file-error').text(error);
                    return false;
                }
                else
                {
                    $('#file-error').text('');
                }

            }

        });

        //if "remove" button is clicked from input, clear error messages
        $('body').on('click', 'a.fileinput-exists', function () {
            $('#file-error').text('');
        });

        $(window).on('keydown', function (e) {
            e = e || window.event;
            if (e.keyCode == 116) {
                e.preventDefault();
                window.location.reload(true);
            }
        });
    };
    // Common method to handle add and edit ajax request and reponse

    var handleAjaxRequest = function () {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serializeArray();
        var icon = "check";
        var messageType = "success";
        //alert(formData);

        var form = new FormData();
        formData.reduce(function (obj, item) {
            form.append(item.name, item.value);
        });
        var image = $('#avatar')[0].files[0];
        if (image) {
            if (image.size > 2097152) {
                var error = siteObjJs.admin.myProfileJs.maxFileSize;
                $('#file-error').text(error);
                return false;
            }
            var ext = $('#avatar').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                var error = siteObjJs.admin.myProfileJs.mimes;
                $('#file-error').text(error);
                return false;
            }
            form.append('avatar', image);
        }

        form.append('_token', token);
        if ($('input[name=_method]').val()) {
            form.append('_method', $('input[name=_method]').val());
        }

        $.ajax(
                {
                    url: actionUrl,
                    type: actionType,
                    data: form,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (data)
                    {
                        //console.log(data);
                        //data: return data from server
                        if (data.status === "error")
                        {
                            icon = "times";
                            messageType = "danger";
                        }

                        //Empty the form fields
                        formElement.find("input[type=text], textarea").val("");
                        //trigger cancel button click event to collapse form and show title of add page
                        //$('.btn-collapse').trigger('click');

                        var formPlace = (data.formPlace);
                        $('#' + formPlace).addClass('active');
                        $('.' + formPlace).addClass('active');
                        $('#' + formPlace).html(data.form);
                        $('#username-avatar').html(data.userNameAvatar);
                        $('#user-login-info').html(data.userLoginInfo);

                        siteObjJs.validation.formValidateInit('#edit-info-form', handleAjaxRequest);
                        siteObjJs.validation.formValidateInit('#change-avatar-form', handleAjaxRequest);
                        siteObjJs.validation.formValidateInit('#change-password-form', handleAjaxRequest);

                        Metronic.alert({
                            type: messageType,
                            icon: icon,
                            message: data.message,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    },
                    error: function (jqXhr, json, errorThrown)
                    {
                        var errors = jqXhr.responseJSON;
                        var errorsHtml = '';
                        $.each(errors, function (key, value) {
                            errorsHtml += value[0] + '<br />';
                        });
                        // alert(errorsHtml, "Error " + jqXhr.status + ': ' + errorThrown);
                        Metronic.alert({
                            type: 'danger',
                            message: errorsHtml,
                            container: $('#ajax-response-text'),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }
                }
        );
    }

    return {
        //main function to initiate the module
        init: function () {
            initializeListener();
            //bind the validation method to 'add' form on load
            siteObjJs.validation.formValidateInit('#edit-info-form', handleAjaxRequest);
            siteObjJs.validation.formValidateInit('#change-avatar-form', handleAjaxRequest);
            siteObjJs.validation.formValidateInit('#change-password-form', handleAjaxRequest);
        }
    };
}();
