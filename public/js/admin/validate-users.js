siteObjJs.admin.validateUserJs = function () {
    var whatIsIpTitle, whatIsIpDesc;
    var handleInputMasks = function () {
        $.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#mask_phone").inputmask("mask", {
            "mask": "(999) 999-9999"
        }); //specifying fn & options
        $("#mask_number").inputmask({
            "mask": "9",
            "repeat": 10,
            "greedy": false
        });
        $("#mask_number_pagination").inputmask({
            "mask": "9",
            "repeat": 10,
            "greedy": false
        });

    };

    var handlePasswordStrengthChecker = function () {
        var initialized = false;
        var input = $("#password_strength");

        input.keydown(function () {
            if (initialized === false) {
                // set base options
                input.pwstrength({
                    raisePower: 1.4,
                    minChar: 8,
                    verdicts: ["Weak", "Normal", "Medium", "Strong", "Very Strong"],
                    scores: [17, 26, 40, 50, 60]
                });

                // add your own rule to calculate the password strength
                input.pwstrength("addRule", "demoRule", function (options, word, score) {
                    return word.match(/[a-z].[0-9]/) && score;
                }, 10, true);

                // set as initialized 
                initialized = true;
            }
        });
    };

    var handleBootstrapMaxlength = function () {
        $('#first_name').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left',
            threshold: 10
        });
        $('#last_name').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left',
            threshold: 10
        });
        $('#user_name').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left',
            threshold: 10
        });
    };

    var handleCheckboxValidation = function () {
        $('.caption input[type="checkbox"]').change(function () {
            var portlet = $(this).closest("div.portlet");
            if (this.checked) {
                portlet.find('.checker span').addClass('checked');
                portlet.find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                portlet.find('.checker span').removeClass('checked');
                portlet.find('input[type="checkbox"]').removeAttr('checked');
            }
        });
        $('#selectall').change(function () {
            if (this.checked) {
                $('div.portlet').find('.assignLinks-block .checker span').addClass('checked');
                $('div.portlet').find('.assignLinks-block input[type="checkbox"]').attr('checked', 'checked');
            } else {
                $('div.portlet').find('.assignLinks-block .checker span').removeClass('checked');
                $('div.portlet').find('.assignLinks-block input[type="checkbox"]').removeAttr('checked');
            }
        });

        $('.user-link-box input[name="links[]"]').change(function () {
            var portlet = $(this).closest("div.user-link-box");
            if (this.checked) {
                portlet.find('.checker span').addClass('checked');
                portlet.find('input[type="checkbox"]').attr('checked', 'checked');
            } else {
                portlet.find('.checker span').removeClass('checked');
                portlet.find('input[type="checkbox"]').removeAttr('checked');
            }
        });
    };

    var handleDialog = function () {

        $('.form-body').on('click', '#what_is_this', function (e) {
            e.preventDefault();
            bootbox.dialog({
                title: siteObjJs.admin.validateUserJs.whatIsIpTitle,
                message: siteObjJs.admin.validateUserJs.whatIsIpDesc
            });
        });
    };

    var handleSelectUserType = function () {

        $('.portlet-body').on('change', '#select-user-type', function (e) {
            e.preventDefault();
            var userTypeId = $("#select-user-type option:selected").val();
            var user_id = $("#admin-user-form").attr('data-user-id');
            var actionUrl = adminUrl + '/user/links';
            $.ajax({
                url: actionUrl,
                data: {user_type: userTypeId, user_id: user_id},
                cache: false,
                dataType: "json",
                type: "GET",
                success: function (data)
                {
                    $(".assignLinks-block").html(data.form);
                    handleCheckboxValidation();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                }
            });
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handleInputMasks();
            handleBootstrapMaxlength();
            handlePasswordStrengthChecker();
            handleCheckboxValidation();
            handleDialog();
            handleSelectUserType();
        }

    };

}();