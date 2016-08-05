function toggleAddNewItemView() {
    var view = $("#add-new-notebook-items-inner-wrapper");
    
    if (view.is(":visible")) {
        view.slideUp();
    } else {
        view.slideDown();
    }
}