siteObjJs.admin.pages = function () {
    var token = $('meta[name="csrf-token"]').attr('content');

    // Initialize all the page-specific event listeners here.

    var initializeListener = function () {
        $('.slug').slugify('#page_name');
        $('#page_url').slugify('#page_name');
    };

    var handleRecords = function () {

        grid = new Datatable();

        grid.init({
            src: $('#pages_datatable_ajax'),
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
                    {data: 'id', name: 'id', visible: false},
                    {data: 'page_name', name: 'page_name', visible: false},
                    {data: 'page_url', name: 'page_url', visible: false},
                    {data: 'page_desc', name: 'page_desc', visible: false},
                    {data: 'display_page_name', name: 'page_name'},
                    {data: 'display_page_url', name: 'page_url'},
                    {data: 'display_page_desc', name: 'page_desc'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "ajax": {
                    "url": "manage-pages/data",
                    "type": "GET"
                },
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

        var table = grid.getTable();

        table.on('click', '.delete', function (e) {
            e.preventDefault();
            var userId = $(this).attr('data-id');
            var action = $(this).attr('data-action');
            var message = $(this).attr('data-message');
            bootbox.confirm(
                    {
                        buttons: {confirm: {label: 'CONFIRM'}},
                        message: message,
                        callback: function (result) {
                            if (result === false) {
                                return;
                            }
                            var formdata = {
                                action: action,
                                actionField: 'id',
                                actionType: 'group',
                                actionValue: userId,
                                ids: userId
                            };
                            handleGroupAction(grid, formdata);
                        }

                    });
        });

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            var pageId = $(this).attr('data-id');
            var redirectUrl = 'manage-pages/' + pageId + '/edit';
            window.location.href = redirectUrl;
        });

        function handleGroupAction(grid, data) {

            var token = $('meta[name="csrf-token"]').attr('content');
            var form = new FormData();
            form.append("action", data.action);
            form.append("actionType", data.actionType);
            form.append("field", data.actionField);
            form.append("value", data.actionValue);
            form.append("ids", data.ids);
            form.append("_token", token);
            var actionUrl = 'manage-pages/group-action';

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
                            place: 'prepend'
                        });

                    }
                    else if (data.status === 'fail') {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: data.message,
                            container: grid.getTableWrapper(),
                            place: 'prepend'
                        });
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
                        place: 'prepend'
                    });
                }
            });
        }

    };

    //common method for create and update of category
    var ajaxSubmitForm = function () {
        var formElement = $(this.currentForm); // Retrive form from DOM and convert it to jquery object
        var formID = formElement.attr("id");
        var formData = formElement.serializeArray();
        var actionUrl = formElement.attr("action");
        var actionType = formElement.attr("method");
        var count = tinymce.editors.length;

        var form = new FormData();
        formData.reduce(function (obj, item) {
            form.append(item.name, item.value);
        });

        if (formID === 'pages-form-update')
        {
            if (count == 2)
            {
                var content = [];
                form.append('page_desc', tinymce.editors[0].getContent());
                form.append('page_content', tinymce.editors[1].getContent());
            }
            else if (count == 4)
            {
                var content = [];
                form.append('page_desc', tinymce.editors[2].getContent());
                form.append('page_content', tinymce.editors[3].getContent());
            }
        }
        else
        {
            var content = [];
            form.append('page_desc', tinymce.editors[0].getContent());
            form.append('page_content', tinymce.editors[1].getContent());
        }
        form.append('_token', token);
        if ($('input[name=_method]').val()) {
            form.append('_method', $('input[name=_method]').val());
        }

        $.ajax({
            url: actionUrl,
            type: actionType,
            data: form,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if (data.status === 'success') {
                    grid.getDataTable().ajax.reload();
                    formElement[0].reset();
                    Metronic.alert({
                        type: 'success',
                        message: data.message,
                        container: $('#errorMessage'),
                        place: 'prepend',
                        closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                    });
                }
                $('.btn-collapse').trigger('click');
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
    var fetchDataForEdit = function () {

        $('.portlet-body').on('click', '.edit-form-link', function () {
            var page_id = $(this).attr("id");
            var actionUrl = 'manage-pages/' + page_id + '/edit';

            $.ajax({
                url: actionUrl,
                cache: false,
                dataType: "json",
                type: "GET",
                success: function (data)
                {
                    $("#edit_form").html(data.form);
                    siteObjJs.validation.formValidateInit('#pages-form-update', ajaxSubmitForm);
                    if (typeof (tinymce) !== 'undefined') {
                        var length = tinymce.editors.length;
                        for (var i = length; i > 0; i--) {
                            tinymce.editors[i - 1].remove();
                        }
                        ;
                    }

                    tinymce.init(editor_config);
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
            handleRecords();
            fetchDataForEdit();
            initializeListener();
            //create form - client side validation
            siteObjJs.validation.formValidateInit('.pages-create-form', ajaxSubmitForm);
            tinymce.init(editor_config);
        }

    };

}();