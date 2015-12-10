siteObjJs.admin.rideJs = function () {

    // Initialize all the page-specific event listeners here.

    var initializeListener = function () {
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

        $('#create-city').on('change', '.country_id1', function (e) {
            fetchCarList(this);
        });

        $('#edit_form').on('change', '.country_id1', function (e) {
            fetchCarList(this);
        });

        $('#CarList').on('change', '#country-drop-down-search', function (e) {
            fetchCarList(this, 'search');
        });

        $('#CarList').on('click', '.filter-cancel', function (e) {
            $("#country-drop-down-search").val('');
            $("#CarList #state-drop-down-search #state_id").val('');
            $("#status-drop-down-search").val('');
        });

    };

    // Method to fetch States list on country dropdown value changed

    var fetchCarList = function (elet, content) {
        content = content || '';
        var currentForm = $(elet).closest("form");
        var userID = $(elet).val();

        var actionUrl = 'cars/userCars/' + userID;
        $.ajax({
            url: actionUrl,
            cache: false,
            type: "GET",
            processData: false,
            contentType: false,
            success: function (data)
            {
                if (content === 'search') {
                    htm = $($.parseHTML(data.list)).filter('div#state-listing-content');
                    $('#CarList').find("#state-drop-down-search").html(htm.html());
                } else {
                    $(currentForm).find("#state-drop-down").html(data.list);
                }

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
        });
    };

    // Method to fetch and place edit form with data using ajax call

    var fetchDataForEdit = function () {
        $('.portlet-body').on('click', '.edit-form-link', function () {
            var car_id = $(this).attr("id");
            var actionUrl = 'rides/' + car_id + '/edit';
            $.ajax({
                url: actionUrl,
                cache: false,
                dataType: "json",
                type: "GET",
                success: function (data)
                {
                    $("#edit_form").html(data.form);
                    siteObjJs.validation.formValidateInit('#edit-city', handleAjaxRequest);
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
            });
        });
    };

    // Common method to handle add and edit ajax request and reponse

    var handleAjaxRequest = function () {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serialize();
        var icon = "check";
        var messageType = "success";
        $.ajax(
                {
                    url: actionUrl,
                    cache: false,
                    type: actionType,
                    data: formData,
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
                        $("#country_id").select2('val', '');
                        $("#states_id").select2('val', '');

                        //trigger cancel button click event to collapse form and show title of add page
                        $('.btn-collapse').trigger('click');

                        //reload the data in the datatable
                        grid.getDataTable().ajax.reload();

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

    var handleTable = function () {

        grid = new Datatable();
        grid.init({
            src: $('#CarList'),
            loadingMessage: 'Loading...',
            dataTable: {
                'language': {
                    'info': '<span class="seperator">|</span><b>Total _TOTAL_ record(s) found</b>',
                    'infoEmpty': '',
                },
                "bStateSave": false,
                "lengthMenu": siteObjJs.admin.commonJs.constants.gridLengthMenu,
                "pageLength": siteObjJs.admin.commonJs.constants.recordsPerPage,
                "columns": [
                    {data: null, name: 'rownum', searchable: false},
                    {data: 'id', name: 'id', visible: false},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'ride_from', name: 'ride_from'},
                    {data: 'ride_to', name: 'ride_to'},
                    {data: 'price', name: 'price'},
                    {data: 'ride_date', name: 'ride_date'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    var page = api.page();
                    var recNum = null;
                    var displayLength = settings._iDisplayLength;
                    api.column(0, {page: 'current'}).data().each(function (group, i) {
                        recNum = ((page * displayLength) + i + 1);
                        $(rows).eq(i).children('td:first-child').html(recNum);
                    });
                },
                "ajax": {
                    "url": "rides/data",
                    "type": "GET"
                },
                "order": [
                    [1, "asc"]
                ]// set first column as a default sort by asc
            }
        });
        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });
        $('#search_country').on('change', function () {
            grid.getDataTable().column($(this).attr('column-index')).search($(this).val()).draw();
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initializeListener();
            handleTable();
            fetchDataForEdit();

            //bind the validation method to 'add' form on load
            siteObjJs.validation.formValidateInit('#create-city', handleAjaxRequest);
        }
    };
}();
