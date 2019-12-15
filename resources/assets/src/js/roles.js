;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
    var delXhr = null;
    var roleTable = null;
    var requestType = null;

    function resetModal() {
        $('#role-id').val('');
        $('#role-display-name').val('');
        $('#role-description').val('');
    }

    function onAddRole(e) {
        e.preventDefault();
        resetModal();

        requestType = 'POST';
        modalActionName = 'Add Role';

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onEditRole(e) {
        e.preventDefault();
        resetModal();

        modalActionName = 'Update Role';
        requestType = 'PUT';

        modal.find('#role-id').val($(e.currentTarget).attr('data-entry-id').trim());
        modal.find('#role-display-name').val($(e.currentTarget).find('.title').text().trim());
        modal.find('#role-description').val($(e.currentTarget).find('.description').text().trim());

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }


    function onSaveRole(e) {
        e.preventDefault();
        var data = {
            id: modal.find('#role-id').val(),
            title: modal.find('#role-display-name').val(),
            description: modal.find('#role-description').val(),
            _token: modal.find('input[name="_token"]').val(),
        };

        if (requestType == 'PUT') ajax_url = ajax_url + '/' + data.id;

        if (saveXhr && saveXhr.readyState != 4) abort();
        saveXhr = $.ajax({
            url: ajax_url,
            type: requestType,
            data: data,
            dataType: 'json',
            beforeSend: function () {

            },
            error: function (a, b, c) {
                console.log(a, b, c)
            },
            success: function (response) {
                if (response.status == 1) {

                    if (requestType == 'POST') {
                        var createdAt = response.data.created_at.split(' ');
                        roleTable.find('tbody').append(
                            '<tr class="edit-role edit-row" data-entry-id="' + response.data.id + '">' +
                            '<td field-key="title" class="title text-info">' + response.data.title + '</td>' +
                            '<td field-key="description" class="description">' + response.data.description + '</td>' +
                            '<td field-key="created-at">' +  createdAt[0] + '</td>'
                        );

                        // rebind edit event
                        roleTable.find('.edit-row').on('click', onEditRole);
                    } else {
                        var row = roleTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
                        row.find('.title a').text(data.title);
                        row.find('.description').text(data.description);
                    }

                    notify({msg: response.message});
                    modal.modal('hide');
                } else {
                    notify({type: 'danger', msg: response.message})
                }
            },
            complete: function () {
            },
        });
    }

    function onDeleteRole() {

        var id = modal.find('#role-id').val().trim();
        requestType = 'DELETE';

        if (delXhr && delXhr.readyState != 4) abort();
        delXhr = $.ajax({
            url: ajax_url + '/' + id,
            type: requestType,
            data: {id: id, _token: modal.find('input[name="_token"]').val()},
            dataType: 'json',
            beforeSend: function () {

            },
            error: function (a, b, c) {
                console.log(a, b, c)
            },
            success: function (response) {
                if (response.status == 1) {
                    roleTable.find('tbody').find('tr[data-entry-id="' + id + '"]').remove();
                    notify({msg: response.message});
                    modal.modal('hide');
                } else {
                    notify({type: 'danger', msg: response.message})
                }
            },
            complete: function () {
            },
        });
    }

    function init() {
        if (page != 'roles') return;

        /** initialized variables **/
        modal = $('#role-modal');
        addButton = $('#add-role');
        saveButton = $('#save-role');
        roleTable = $('#role-table');

        /** Bind events to elements **/
        addButton.on('click', onAddRole);
        saveButton.on('click', onSaveRole);
        $('.edit-role').on('click', onEditRole);
        $('#delete-role').on('click', onDeleteRole);

    }

    $(document).ready(init);
}(jQuery));