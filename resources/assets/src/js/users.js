;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
    var delXhr = null;
    var userTable = null;
    var requestType = null;

    function resetModal() {
        $('#user-id').val('');
        $('#user-name').val('');
        $('#user-email').val('');
        $('#user-role').val('');
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

        modal.find('#user-id').val($(e.currentTarget).attr('data-entry-id').trim());
        modal.find('#user-name').val($(e.currentTarget).find('.name').text().trim());
        modal.find('#user-email').val($(e.currentTarget).find('.email').text().trim());
        modal.find('#user-role').val($(e.currentTarget).find('.role').attr('data-role-id').trim());

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }


    function onSaveUser(e) {
        e.preventDefault();
        var url = null;
        var data = {
            id: modal.find('#user-id').val(),
            name: modal.find('#user-name').val(),
            email: modal.find('#user-email').val(),
            password: 'password',
            role_id: modal.find('#user-role').val(),
            _token: modal.find('input[name="_token"]').val(),
        };

        console.log(data);

        if (requestType == 'PUT') url = ajax_url + '/' + data.id;
        else url =  ajax_url;

        console.log(requestType);

        if (saveXhr && saveXhr.readyState != 4) abort();
        saveXhr = $.ajax({
            url: url,
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

                        var role = modal.find('#user-role option:selected').text();
                        var createdAt = response.data.created_at.split(' ');

                        userTable.find('tbody').append(
                            '<tr data-entry-id=""' + response.data.id + '" class="edit-user edit-row">' +
                            '<td field-key="name" class="name text-info">' + response.data.name + '</td>' +
                            '<td field-key="email">' + response.data.email + '</td>' +
                            '<td field-key="role" data-role-id="'+ response.data.role_id +'">' + role + '</td>' +
                            '<td field-key="created-at">' + createdAt[0] + '</td>'
                        );

                        // rebind edit event
                        userTable.find('.edit-row').on('click', onEditUser);

                    } else {
                        var row = userTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
                        row.find('.name').text(data.name);
                        row.find('.email').text(data.email);
                        row.find('.email').text(data.role);
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

    function onDeleteUser() {

        var id = modal.find('#user-id').val().trim();
        requestType = 'DELETE';

        if (delXhr && delXhr.readyState != 4) abort();
        delXhr = $.ajax({
            url: ajax_url + '/' + id,
            type: requestType,
            data: {id: id, _token: modal.find('input[name="_token"]').val()},
            dataType: 'json',
            beforeSend: function () {},
            error: function (a, b, c) {
                console.log(a, b, c)
            },
            success: function (response) {
                if (response.status == 1) {
                    userTable.find('tbody').find('tr[data-entry-id="'+ id + '"]').remove();
                    notify({msg: response.message});
                    modal.modal('hide');
                } else {
                    notify({type: 'danger', msg: response.message})
                }
            },
            complete: function () {},
        });
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
        $('#delete-user').on('click', onDeleteUser);
    }

    $(document).ready(init);
}(jQuery));