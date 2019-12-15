;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
    var delXhr = null;
    var expenseCategoryTable = null;
    var requestType = null;

    function resetModal() {
        $('#expense-category-id').val('');
        $('#expense-category-name').val('');
        $('#expense-category-description').val('');
    }

    function onAddExpenseCategory(e) {
        e.preventDefault();
        resetModal();

        requestType = 'POST';
        modalActionName = 'Add Category';

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onEditExpenseCategory(e) {
        e.preventDefault();
        resetModal();

        modalActionName = 'Update Role';
        requestType = 'PUT';

        modal.find('#expense-category-id').val($(e.currentTarget).attr('data-entry-id').trim());
        modal.find('#expense-category-name').val($(e.currentTarget).find('.name').text().trim());
        modal.find('#expense-category-description').val($(e.currentTarget).find('.description').text().trim());

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onSaveExpenseCategory(e) {
        e.preventDefault();
        var data = {
            id: modal.find('#expense-category-id').val(),
            name: modal.find('#expense-category-name').val(),
            description: modal.find('#expense-category-description').val(),
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
                        expenseCategoryTable.find('tbody').append(
                            '<tr class="edit-expense-category edit-row" data-entry-id="' + response.data.id + '">' +
                            '<td field-key="name" class="name text-info">' + response.data.name + '</td>' +
                            '<td field-key="description" class="description">' + response.data.description + '</td>' +
                            '<td field-key="created-at">' +  createdAt[0] + '</td>'
                        );

                        // rebind edit event
                        expenseCategoryTable.find('.edit-row').on('click', onEditExpenseCategory);
                    } else {
                        var row = expenseCategoryTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
                        row.find('.name').text(data.title);
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

    function onDeleteExpenseCategory() {

        var id = modal.find('#expense-category-id').val().trim();
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
                    expenseCategoryTable.find('tbody').find('tr[data-entry-id="'+ id + '"]').remove();
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
        if (page != 'expense_categories') return;

        /** initialized variables **/
        modal = $('#expense-category-modal');
        addButton = $('#add-expense-category-btn');
        saveButton = $('#save-expense-category');
        expenseCategoryTable = $('#expense-category-table');

        /** Bind events to elements **/
        addButton.on('click', onAddExpenseCategory);
        saveButton.on('click', onSaveExpenseCategory);
        $('.edit-expense-category').on('click', onEditExpenseCategory);
        $('#delete-expense-category').on('click', onDeleteExpenseCategory);

    }

    $(document).ready(init);
}(jQuery));