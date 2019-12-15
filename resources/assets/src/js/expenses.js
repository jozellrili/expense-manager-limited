;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;
    var delXhr = null;
    var expenseTable = null;
    var requestType = null;

    function resetModal() {
        $('#expense-id').val('');
        $('#expense-category-select').val('');
        $('#expense-amount').val('');
        $('#expense-entry-date').val('');
    }

    function onAddExpense(e) {
        e.preventDefault();
        resetModal();

        requestType = 'POST';
        modalActionName = 'Add Expense';

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onEditExpense(e) {
        e.preventDefault();
        resetModal();

        modalActionName = 'Update Expense';
        requestType = 'PUT';

        var amount = $(e.currentTarget).find('.amount').text().trim();
        amount = amount.replace('₱', '').replace(',', '');

        modal.find('#expense-id').val($(e.currentTarget).attr('data-entry-id').trim());
        modal.find('#expense-category-select').val($(e.currentTarget).find('.expense-category').attr('data-expense-category-id').trim());
        modal.find('#expense-amount').val(amount);
        modal.find('#expense-entry-date').val($(e.currentTarget).find('.entry-date').text().trim());

        modal.find('.action-name').text(modalActionName);
        modal.modal();
    }

    function onSaveExpense(e) {
        e.preventDefault();
        var url = null;
        var data = {
            id: modal.find('#expense-id').val(),
            expense_category_id: modal.find('#expense-category-select').val(),
            amount: modal.find('#expense-amount').val(),
            entry_date: modal.find('#expense-entry-date').val(),
            _token: modal.find('input[name="_token"]').val(),
        };

        if (requestType == 'PUT') url = ajax_url + '/' + data.id;
        else url = ajax_url;

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

                    var expenseCategory = modal.find('#expense-category-select option:selected').text().trim();

                    if (requestType == 'POST') {
                        var createdAt = response.data.created_at.split(' ');
                        expenseTable.find('tbody').append(
                            '<tr class="edit-expense edit-row" data-entry-id="' + response.data.id + '">' +
                            '<td field-key="expense_category" class="expense-category" data-expense-category-id="' + response.data.expense_category_id + '">' + expenseCategory + '</td>' +
                            '<td field-key="amount" class="amount">₱' + response.data.amount + '</td>' +
                            '<td field-key="entry_date" class="entry-date">' + response.data.entry_date + '</td>' +
                            '<td field-key="created-at">' + createdAt[0] + '</td>'
                        );

                        // rebind edit event
                        expenseTable.find('.edit-row').on('click', onEditExpense);
                    } else {
                        var row = expenseTable.find('tbody tr[data-entry-id="' + response.data.id + '"]');
                        row.find('.expense-category').text(expenseCategory);
                        row.find('.amount').text(data.amount);
                        row.find('.entry-date').text(data.entry_date);
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

    function onDeleteExpense() {

        var id = modal.find('#expense-id').val().trim();
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
                    expenseTable.find('tbody').find('tr[data-entry-id="' + id + '"]').remove();
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
        if (page != 'expenses') return;

        /** initialized variables **/
        modal = $('#expense-modal');
        addButton = $('#add-expense-btn');
        saveButton = $('#save-expense');
        expenseTable = $('#expense-table');

        /** Bind events to elements **/
        addButton.on('click', onAddExpense);
        saveButton.on('click', onSaveExpense);
        $('.edit-expense').on('click', onEditExpense);
        $('#delete-expense').on('click', onDeleteExpense);

    }

    $(document).ready(init);
}(jQuery));