siteObjJs.admin.links = function () {
    var grid;

    var handleTable = function () {
        grid = new Datatable();

        grid.init({
            src: $('#linkmanagement-table'),
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
                    {data: 'cat', name: 'link_category_id'},
                    {data: 'link_category_id', name: 'link_category_id', visible: false, orderable: false},
                    {data: 'link_name', name: 'link_name'},
                    {data: 'link_url', name: 'link_url'},
                    {data: 'pagination', name: 'pagination'},
                    {data: 'position', name: 'position'},
                    {data: 'status', name: 'status'},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                ],
                "ajax": {
                    "url": "links/data",
                    "type": "GET"
                },
            }
        });

        $('#data-search').keyup(function () {
            grid.getDataTable().search($(this).val()).draw();
        });

        $('#search_link_category').on('change', function () {
            grid.getDataTable().column($(this).attr('column-index')).search($(this).val()).draw();
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
        var oTable = table.dataTable();

        table.on('click', '.edit', function (e) {
            e.preventDefault();
            var userId = $(this).attr('data-id');
            var redirectUrl = 'linkcategory/' + userId + '/edit';
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
            var actionUrl = 'links/group-action';

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
                            place: 'prepend'
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {

                }
            });
        }
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
                    grid.getDataTable().ajax.reload();
                    formElement[0].reset();
                    $('#link_category_id').select2('val', '');
                    $('#links_assign').select2('val', '');
                    $('#pagination').select2('val', '');
                    $('.link-icon').val('');
                    $('#sidebar-menu').html(data.sidebar);
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
    $('#showLinkIcons').on('shown.bs.modal', function () {
        $('span[id^="item-box_"]').on('click', function () {
            $('.link-management-form input[id="link_icon"]').val($.trim($(this).text()));
            $('.link-management-form .link-icon').html('<i class="' + $.trim($(this).text()) + '"></i>');
            $('#showLinkIcons').modal('hide');
            $('#edit_form #showLinkIcons').modal('hide');
        });
    });


    var showPopup = function (selector) {
        $('.portlet-body').on('click', '#showLinkIconsPopup', function () {
            $(selector + ' #showLinkIcons').modal('show');
        });
    };

    $('.portlet-body').on('click', '.edit-form-link', function () {
        var category_id = $(this).attr("id");
        var actionUrl = 'links/' + category_id + '/edit';
        $.ajax({
            url: actionUrl,
            cache: false,
            dataType: "json",
            type: "GET",
            success: function (data)
            {
                showPopup('#edit_form');
                $("#edit_form").html(data.form);
                siteObjJs.validation.formValidateInit('#linkmanagement-form-update', ajaxSubmitForm);
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
            showPopup('.add-form-main');
            //create form - client side validation
            siteObjJs.validation.formValidateInit('.link-management-form', ajaxSubmitForm);
        }

    };

}();