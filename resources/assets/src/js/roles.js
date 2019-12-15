;(function ($) {
    var modal = null;
    var addButton, saveButton = null;
    var modalActionName = null;
    var saveXhr = null;

    function onAddRole(e) {
        e.preventDefault();
        modal.modal();
    }

    function collectData() {
        return {
            id: modal.find('#role-id').val(),
            title: modal.find('#role-display-name').val(),
            description: modal.find('#role-description').val(),
            _token: modal.find('input[name="_token"]').val(),
        };
    }

    function onSaveRole(e) {
        e.preventDefault();
        var data = collectData();

        console.log(data);

        if (saveXhr && saveXhr.readyState != 4) abort();
        saveXhr = $.ajax({
            type: 'POST',
            data: data,
            dataType: 'json',
            beforeSend: function () {

            },
            error: function (a, b, c) {
                console.log(a, b, c)
            },
            success: function (response) {

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
        modalActionName = 'Add Role';

        /** Bind events to elements **/
        addButton.on('click', onAddRole);
        saveButton.on('click', onSaveRole);

        displayModalActionName();
    }

    $(document).ready(init);
}(jQuery));