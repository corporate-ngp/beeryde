siteObjJs.admin.ipLocationsJs = function () {

    // basic validation
    var formValidation = function () {
        var formIdentity = $('.locations-form');
        var errorMsg = $('.alert-danger', formIdentity);
        var successMsg = $('.alert-success', formIdentity);
        formIdentity.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: '', // validate all fields including form hidden input
            rules: {
                country_id: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                location: {
                    required: true,
                    maxlength: 100
                },
                address: {
                    required: true,
                    maxlength: 255
                },
                address1: {
                    maxlength: 255
                },
                landmark: {
                    maxlength: 100
                },
                zipcode: {
                    required: true,
                    maxlength: 20
                },
                status: {
                    required: true
                }
            },
            submitHandler: function (form) {
                form.submit(); // submit the form
            },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                successMsg.hide();
                errorMsg.show();
                Metronic.scrollTo(errorMsg, -200);
            },
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.parent('.input-group').size() > 0) {
                    error.insertAfter(element.parent('.input-group'));
                } else if (element.attr('data-error-container')) {
                    error.appendTo(element.attr('data-error-container'));
                } else if (element.parents('.radio-list').size() > 0) {
                    error.appendTo(element.parents('.radio-list').attr('data-error-container'));
                } else if (element.parents('.radio-inline').size() > 0) {
                    error.appendTo(element.parents('.radio-inline').attr('data-error-container'));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr('data-error-container'));
                } else if (element.parents('.checkbox-inline').size() > 0) {
                    error.appendTo(element.parents('.checkbox-inline').attr('data-error-container'));
                } else {
                    error.insertAfter(element); // for other inputs, just perform default behavior
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group   
            },
            unhighlight: function (element) { // revert the change done by hightlight

            },
            success: function (label, element) {
                var icon = $(element).parent('.input-icon').children('i');
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                icon.removeClass('fa-warning').addClass('fa-check');
            },
            submitHandler: function (form) {
                successMsg.show();
                errorMsg.hide();
                form.submit(); // submit the form
            }
        });

        $('.select2me', formIdentity).change(function () {
            formIdentity.validate().element($(this));
        });

        $('input[name="location"]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: 'bottom-left'
        });
        $('input[name="address"]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left'
        });
        $('input[name="address1"]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: 'bottom-left'
        });
        $('input[name="landmark"]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: true,
            placement: 'bottom-left'
        });
        $('input[name="zipcode"]').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left'
        });
    }
    var handleRecords = function () {
        var grid = new Datatable();

        grid.init({
            src: $('#ipLocationsList'),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            onDataLoad: function (grid) {
                // execute some code on ajax data load
            },
            loadingMessage: 'Loading...',
            dataTable: {
                'language': {
                    'info': '<span class="seperator">|</span><b>Total _TOTAL_ record(s) found</b>',
                    'infoEmpty': '',
                },
                'bStateSave': true,
                "lengthMenu": siteObjJs.admin.commonJs.constants.gridLengthMenu,
                "pageLength": siteObjJs.admin.commonJs.constants.recordsPerPage,
                'ajax': {
                    'url': adminUrl + '/locations/list',
                },
                'order': [
                    [1, 'asc']
                ]// set first column as a default sort by asc
            }
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $('.table-group-action-input', grid.getTableWrapper());
            if (action.val() != '' && grid.getSelectedRowsCount() > 0) {
                grid.setAjaxParam('customActionType', 'group_action');
                grid.setAjaxParam('customActionName', action.val());
                grid.setAjaxParam('id', grid.getSelectedRows());
                grid.getDataTable().ajax.reload();
                grid.clearAjaxParams();
            } else if (action.val() == '') {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend'
                });
            }
        });
    }

    var mapBasic = function () {
        new GMaps({
            div: '#gmap_basic',
            lat: -12.043333,
            lng: -77.028333
        });
    }

    var mapGeolocation = function () {

        var map = new GMaps({
            div: '#gmap_geo',
            lat: -12.043333,
            lng: -77.028333
        });

        GMaps.geolocate({
            success: function (position) {
                map.setCenter(position.coords.latitude, position.coords.longitude);
            },
            error: function (error) {
                alert('Geolocation failed: ' + error.message);
            },
            not_supported: function () {
                alert("Your browser does not support geolocation");
            },
            always: function () {
                //alert("Geolocation Done!");
            }
        });
    }

    var mapGeocoding = function () {

        var map = new GMaps({
            div: '#gmap_geocoding',
            lat: -12.043333,
            lng: -77.028333
        });

        var handleAction = function () {
            var text = $.trim($('#gmap_geocoding_address').val());
            GMaps.geocode({
                address: text,
                callback: function (results, status) {
                    if (status == 'OK') {
                        var latlng = results[0].geometry.location;
                        map.setCenter(latlng.lat(), latlng.lng());
                        map.addMarker({
                            lat: latlng.lat(),
                            lng: latlng.lng()
                        });
                        Metronic.scrollTo($('#gmap_geocoding'));
                    }
                }
            });
        }

        $('#gmap_geocoding_btn').click(function (e) {
            e.preventDefault();
            handleAction();
        });

        $("#gmap_geocoding_address").keypress(function (e) {
            var keycode = (e.keyCode ? e.keyCode : e.which);
            if (keycode == '13') {
                e.preventDefault();
                handleAction();
            }
        });
    }

    return {
        //main function to initiate the module
        init: function () {
            formValidation();
            handleRecords();
            //mapBasic();
            //mapGeolocation();
            //mapGeocoding();
        }

    };

}();