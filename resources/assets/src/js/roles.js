;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
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

        var row = $(e.currentTarget).closest('tr');

        modal.find('#role-id').val(row.attr('data-entry-id').trim());
        modal.find('#role-display-name').val(row.find('.title').text().trim());
        modal.find('#role-description').val(row.find('.description').text().trim());

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
                console.log(response);
                if (response.status == 1) {

                    if (requestType == 'POST') {
                        roleTable.find('tbody').append(
                            '<tr data-entry-id=' + response.data.id + '>' +
                            ' <td field-key="title">' +
                            '<a href="" class="edit-role">' + response.data.title + '</a>' +
                            '</td>' +
                            '<td field-key="description">' + response.data.description + '</td>' +
                            '<td field-key="created-at">' + response.data.created_at + '</td>'
                        );
                    } else {
                        console.log('here');
                        var row = roleTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
                        console.log(row);

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

    function displayModalActionName() {
        modal.find('.action-name').text(modalActionName);
    }

    function init() {
        if (page != 'roles') return;

        /** initialized variables **/
        modal = $('#role-modal');
        addButton = $('#add-role');
        saveButton = $('#save-role');
        roleTable = $('#role-table');
        modalActionName = 'Add Role';

        /** Bind events to elements **/
        addButton.on('click', onAddRole);
        saveButton.on('click', onSaveRole);
        $('.edit-role').on('click', onEditRole);

        displayModalActionName();
    }

    $(document).ready(init);
}(jQuery));