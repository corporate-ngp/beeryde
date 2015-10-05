siteObjJs.admin.linkCategory = function () {
    var grid;

    var handleTable = function () {
        grid = new Datatable();

        grid.init({
            src: $('#linkcategory-table'),
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
                "bStateSave": false,
                "lengthMenu": siteObjJs.admin.commonJs.constants.gridLengthMenu,
                "pageLength": siteObjJs.admin.commonJs.constants.recordsPerPage,
                "columns": [
                    {data: 'ids', name: 'ids', orderable: false, searchable: false},
                    {data: 'category', name: 'category'},
                    {data: 'position', name: 'position'},
                    {data: 'header_text', name: 'header_text'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "ajax": {
                    "url": "link-category/data",
                    "type": "GET"
                }
            }
        });

        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });

        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $(".table-group-action-input", grid.getTableWrapper());
            var actionType = action.attr('data-actionType');
            var actionField = action.attr('data-actionField');
            var actionValue = action.val();
            if (action.val() !== "" && grid.getSelectedRowsCount() > 0) {

                var formdata = {
                    action: 'update',
                    actionField: actionField,
                    actionType: actionType,
                    actionValue: actionValue,
                    ids: grid.getSelectedRows()
                };

                handleGroupAction(grid, formdata);

            } else if (action.val() === "") {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'Please select an action',
                    container: grid.getTableWrapper(),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
            } else if (grid.getSelectedRowsCount() === 0) {
                Metronic.alert({
                    type: 'danger',
                    icon: 'warning',
                    message: 'No record selected',
                    container: grid.getTableWrapper(),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
            }
        });

        var table = grid.getTable();
        var oTable = table.dataTable();

        table.on('click', '.delete', function (e) {
            e.preventDefault();
            var userId = $(this).attr('data-id');
            bootbox.confirm("Are you sure?", function (result) {
                if (result === false) {
                    return;
                }

                var nRow = $(this).parents('tr')[0];

                var formdata = {
                    action: 'delete',
                    actionField: 'id',
                    actionType: 'group',
                    actionValue: userId,
                    ids: userId
                };
                handleGroupAction(grid, formdata);
            });
        });

        table.on('click', '.view', function (e) {
            e.preventDefault();
            var userId = $(this).attr('data-id');

            var nTr = $(this).parents('tr')[0];
            if (oTable.fnIsOpen(nTr)) {
                /* This row is already open - close it */
                $(this).addClass("row-details-close").removeClass("row-details-open");
                oTable.fnClose(nTr);
            } else {
                /* Open this row */
                $(this).addClass("row-details-open").removeClass("row-details-close");
                oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
            }

        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            var userId = $(this).attr('data-id');
            var redirectUrl = 'linkcategory/' + userId + '/edit';
            window.location.href = redirectUrl;
        });

        /* Formatting function for row details */
        function fnFormatDetails(oTable, nTr) {
            //var aData = oTable.row(nTr).data();
            var aData = oTable.fnGetData(nTr);
            var sOut = '<table>';
            sOut += '<tr><td>Id:</td><td>' + aData.id + '</td></tr>';
            sOut += '<tr><td>Category:</td><td>' + aData.category + '</td></tr>';
            sOut += '<tr><td>Description:</td><td>' + aData.header_text + '</td></tr>';
            sOut += '<tr><td>Status:</td><td>' + aData.status + '</td></tr>';
            sOut += '<tr><td>Other:</td><td>Could provide a link here</td></tr>';
            sOut += '</table>';

            return sOut;
        }


        function handleGroupAction(grid, data) {

            var token = $('meta[name="csrf-token"]').attr('content');
            var form = new FormData();
            form.append("action", data.action);
            form.append("actionType", data.actionType);
            form.append("field", data.actionField);
            form.append("value", data.actionValue);
            form.append("ids", data.ids);
            form.append("_token", token);
            var actionUrl = 'link-category/group-action';

            jQuery.ajax({
                url: actionUrl,
                cache: false,
                data: form,
                dataType: "json",
                type: "POST",
                processData: false,
                contentType: false,
                success: function (data)
                {
                    grid.getDataTable().ajax.reload();
                    if (data.status === 'success') {
                        Metronic.alert({
                            type: 'success',
                            icon: 'success',
                            message: data.message,
                            container: grid.getTableWrapper(),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });

                    }
                    else if (data.status === 'fail') {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: data.message,
                            container: grid.getTableWrapper(),
                            place: 'prepend',
                            closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                }
            });
        }
    };

    var handleInputMasks = function () {
        $.extend($.inputmask.defaults, {
            'autounmask': true
        });

        $("#position").inputmask({
            "mask": "9",
            "repeat": 10,
            "greedy": false
        });

    };

    var handleBootstrapMaxlength = function () {
        $('#header_text').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left',
            threshold: 10
        });
        $('#category').maxlength({
            limitReachedClass: "label label-danger",
            alwaysShow: false,
            placement: 'bottom-left',
            threshold: 10
        });
    };

    //common method for create and update of category
    var ajaxSubmitForm = function () {
        var formElement = $(this.currentForm);
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var formData = formElement.serialize();

        $.ajax({
            url: actionUrl,
            cache: false,
            data: formData,
            dataType: "json",
            type: actionType,
            success: function (data)
            {
                if (data.status === 'success') {
                    $('#sidebar-menu').html(data.sidebar);
                    grid.getDataTable().ajax.reload();
                    formElement[0].reset();
                    Metronic.alert({
                        type: 'success',
                        message: data.message,
                        container: $('#errorMessage'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                    $('.btn-collapse').trigger('click');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                var errors = jqXHR.responseJSON;
                var errorsHtml = '';
                $.each(errors, function (key, value) {
                    errorsHtml += value[0] + '<br />';
                });

                Metronic.alert({
                    type: 'danger',
                    message: errorsHtml,
                    container: $('#errorMessage'),
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
            }
        });

    };

    $('#showCategoryIcons').on('shown.bs.modal', function () {
        $('span[id^="item-box_"]').on('click', function () {
            $('.link-category-form input[id="category_icon"]').val($.trim($(this).text()));
            $('.link-category-form .category-icon').html('<i class="' + $.trim($(this).text()) + '"></i>');
            $('#showCategoryIcons').modal('hide');
            $('#edit_form #showCategoryIcons').modal('hide');
        });
    });

    var showPopup = function (selector) {
        $('.portlet-body').on('click', '#showCategoryIconsPopup', function () {
            $(selector + ' #showCategoryIcons').modal('show');
        });
    };

    $('.portlet-body').on('click', '.edit-form-link', function () {
        var category_id = $(this).attr("id");
        var actionUrl = 'link-category/' + category_id + '/edit';
        $.ajax({
            url: actionUrl,
            cache: false,
            dataType: "json",
            type: "GET",
            success: function (data)
            {
                showPopup('#edit_form');
                $("#edit_form").html(data.form);
                siteObjJs.validation.formValidateInit('#category-form-update', ajaxSubmitForm);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        });
    });

    return {
        //main function to initiate the module
        init: function () {
            handleTable();
            //handleInputMasks();
            //handleBootstrapMaxlength();
            showPopup('.add-form-main');
            //create form - client side validation
            siteObjJs.validation.formValidateInit('.link-category-form', ajaxSubmitForm);
        }

    };

}();