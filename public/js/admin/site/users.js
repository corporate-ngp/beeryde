siteObjJs.admin.siteUsersJs = function () {
    var confirmRemoveImage, maxFileSize, mimes;
    var grid;

    //Identifiers 
    var tableIdentifier = '#users_datatable_ajax';
    var formIdentifier = '#admin-user-form';
    var ajaxMessageIdentifier = $('#ajax-response-text');

    //urls
    var gridDataUrl = adminUrl + '/site-user/data';
    var groupActionUrl = adminUrl + '/site-user/group-action';
    var fieldCheckUrl = adminUrl + '/site-user/check-avalability';

    //other
    var token = $('meta[name="csrf-token"]').attr('content');
    var passUsername = false;
    var deleteMessage, restoreMessage;

    var initPickers = function () {
//init date pickers
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    };

    var handleTable = function () {
        grid = new Datatable();
        grid.init({
            src: $(tableIdentifier),
            loadingMessage: 'Loading...',
            dataTable: {
                'language': {
                    'info': '<span class="seperator">|</span><b>Total _TOTAL_ record(s) found</b>',
                    'infoEmpty': '',
                },
                'bStateSave': true,
                'lengthMenu': siteObjJs.admin.commonJs.constants.gridLengthMenu,
                'pageLength': siteObjJs.admin.commonJs.constants.recordsPerPage,
                'columns': [
                    {data: 'ids', name: 'ids', orderable: false, searchable: false},
                    {data: 'id', name: 'id'},
                    {data: 'avatar', name: 'avatar', orderable: false, searchable: false},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                'drawCallback': function (settings) {
                    var api = this.api();
                    var rows = api.rows({page: 'current'}).nodes();
                    var last = null;
                    var page = api.page();
                    var recNum = null;
                    var displayLength = settings._iDisplayLength;
                    api.column(1, {page: 'current'}).data().each(function (group, i) {
                        recNum = ((page * displayLength) + i + 1);
                        $(rows).eq(i).children('td:nth-child(2)').html(recNum);
                    });
                },
                'ajax': {
                    'url': gridDataUrl,
                    'type': 'GET'
                },
                'order': [
                    [1, 'desc']
                ]
            }
        });
        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });
        // handle group actionsubmit button click
        grid.getTableWrapper().on('click', '.table-group-action-submit', function (e) {
            e.preventDefault();
            var action = $('.table-group-action-input', grid.getTableWrapper());
            var actionType = action.attr('data-actionType');
            var actionField = action.attr('data-actionField');
            var actionValue = action.val();
            var formAction = 'update';
            var message = siteObjJs.admin.usersJs.deleteMessage;
            if (actionValue == 'restore') {
                message = siteObjJs.admin.usersJs.restoreMessage;
            }

            if (actionValue !== '' && grid.getSelectedRowsCount() > 0) {

                var formdata = {
                    action: formAction,
                    actionField: actionField,
                    actionType: actionType,
                    actionValue: actionValue,
                    ids: grid.getSelectedRows()
                };

                if ((actionValue == 'delete' || actionValue == 'delete-hard') || actionValue == 'restore') {
                    formdata['action'] = actionValue;

                    bootbox.confirm({buttons: {confirm: {label: 'CONFIRM'}}, message: message, callback: function (result) {
                            if (result === false) {
                                return;
                            }
                            handleGroupAction(grid, formdata);
                        }});
                } else {
                    handleGroupAction(grid, formdata);
                }

            } else if (action.val() === '') {
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
            window.location.href = adminUrl + '/site-user/' + $(this).attr('data-id') + '/edit';
        });

        function handleGroupAction(grid, data) {
            var form = new FormData();
            form.append('action', data.action);
            form.append('actionType', data.actionType);
            form.append('field', data.actionField);
            form.append('value', data.actionValue);
            form.append('ids', data.ids);
            form.append('_token', token);
            jQuery.ajax({
                url: groupActionUrl,
                cache: false,
                data: form,
                dataType: 'json',
                type: 'POST',
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


    var validateSubmit = function () {
        handleAjaxRequest();
        return false;
    };

    var handleAjaxRequest = function () {

        var formElement = $(formIdentifier);
        var icon = 'check';
        var messageType = 'success';
        var formData = formElement.serializeArray();
        var actionUrl = formElement.attr('action');
        var actionType = formElement.attr('method');

        var form = new FormData();
        formData.reduce(function (obj, item) {
            form.append(item.name, item.value);
        });

        var image = $('#avatar')[0].files[0];
        if (image) {
            form.append('avatar', image);
        }
        form.append('_token', token);
        if ($('input[name=_method]').val()) {
            form.append('_method', $('input[name=_method]').val());
        }

        $.ajax({
            url: actionUrl,
            type: actionType,
            data: form,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data)
            {
                if (data.status === 'error')
                {
                    icon = 'times';
                    messageType = 'danger';

                }

                Metronic.alert({
                    type: messageType,
                    icon: icon,
                    message: data.message,
                    container: ajaxMessageIdentifier,
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });

                if (data.status === 'success')
                {
                    setTimeout(function () {
                        window.location.href = data.redirect
                    }, 3000);
                }

            },
            error: function (jqXhr, json, errorThrown)
            {
                var errors = jqXhr.responseJSON;
                var errorsHtml = '';
                $.each(errors, function (key, value) {
                    errorsHtml += value[0] + '<br />';
                });

                Metronic.alert({
                    type: 'danger',
                    message: errorsHtml,
                    container: ajaxMessageIdentifier,
                    place: 'prepend',
                    closeInSeconds: siteObjJs.admin.commonJs.constants.alertCloseSec
                });
            }
        }
        );
    };
    
    return {
        init: function (identifier, url) {
            initPickers();
            gridDataUrl = url || gridDataUrl;
            tableIdentifier = identifier || tableIdentifier;
            handleTable();
        },
        initCreate: function () {
            siteObjJs.validation.formValidateInit(formIdentifier, validateSubmit);
        },
        initEdit: function () {
            siteObjJs.validation.formValidateInit(formIdentifier, handleAjaxRequest);
        }

    };
}();