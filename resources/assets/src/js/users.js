;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
    var userTable = null;
    var requestType = null;

    function resetModal() {
        $('#user-id').val('');
        $('#user-name').val('');
        $('#user-email').val('');
    }

    function onAddUser(e) {
        e.preventDefault();
        resetModal();

        requestType = 'POST';
        modalActionName = 'Add User';

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onEditUser(e) {
        e.preventDefault();
        resetModal();

        modalActionName = 'Update User';
        requestType = 'PUT';

        var row = $(e.currentTarget).closest('tr');

        modal.find('#user-id').val(row.attr('data-entry-id').trim());
        modal.find('#user-display-name').val(row.find('.title').text().trim());
        modal.find('#user-description').val(row.find('.description').text().trim());

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }


    function onSaveUser(e) {
        e.preventDefault();
        var data = {
            id: modal.find('#user-id').val(),
            title: modal.find('#user-display-name').val(),
            description: modal.find('#user-description').val(),
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
                        userTable.find('tbody').append(
                            '<tr data-entry-id=' + response.data.id + '>' +
                            ' <td field-key="title">' +
                            '<a href="" class="edit-user">' + response.data.title + '</a>' +
                            '</td>' +
                            '<td field-key="description">' + response.data.description + '</td>' +
                            '<td field-key="created-at">' + response.data.created_at + '</td>'
                        );
                    } else {
                        console.log('here');
                        var row = userTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
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
        if (page != 'users') return;

        /** initialized variables **/
        modal = $('#users-modal');
        addButton = $('#add-user');
        saveButton = $('#save-user');
        userTable = $('#users-table');

        /** Bind events to elements **/
        addButton.on('click', onAddUser);
        saveButton.on('click', onSaveUser);
        $('.edit-user').on('click', onEditUser);

        displayModalActionName();
    }

    $(document).ready(init);
}(jQuery));