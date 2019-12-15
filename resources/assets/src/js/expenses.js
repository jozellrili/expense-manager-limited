;(function () {
    var modal, addButton;

    function onAddCategory(e) {
        e.preventDefault();

        modal.show();

    }

    function init() {
        console.log(page);
        if (page != 'expenses' || page != 'expense_categories') return;

        modal = $('#expense-category-modal');
        addButton = $('#add-expense-category-btn');

        /** Bind Events **/
        addButton.on('click', onAddCategory);
    }

    $(document).ready(init);
}(jQuery));