$(document).ready(function () {
    AddNewItem.selectChangeListener();
});

var AddNewItem = {
    toggleAddNewItemView: function () {
        var view = $("#add-new-notebook-items-inner-wrapper");
        $("#add-new-item-error-div").html("");

        if (!$(':animated').length) {
            if (view.is(":visible")) {
                var radius = parseInt(view.parent().find(".heading").css("border-top-left-radius"));

                if (isNaN(radius)) {
                    radius = 4;
                }

                view.stop().slideUp();
                view.parent().find(".heading").animate({
                    borderBottomLeftRadius: radius,
                    borderBottomRightRadius: radius
                }, 600);
            } else {
                view.stop().slideDown();
                view.parent().find(".heading").animate({
                    borderBottomLeftRadius: 0,
                    borderBottomRightRadius: 0
                }, 600);
            }
        }
    },
    addNewItem: function () {
        var that = this;
        var division = $("#add-new-item-division").val();
        var project = $("#add-new-item-project").val();
        var number = $("#add-new-item-number").val();

        function pad(str) {
            return str.length < 6 ? pad("0" + str, 6) : str;
        }

        var notebookNo = division + " " + project + "-" + pad(number);

        var reviewer = $("#add-new-item-reviewer").val();
        var comments = $("#add-new-item-comments").val();
        var errorDiv = $("#add-new-item-error-div");

        if (division === "" ||
                project === "" ||
                number === "" ||
                reviewer === "") {
            errorDiv.html("Please fill all the required fields");
        } else {
            var params = {
                url: "ajax/add-new-item.php",
                method: "POST",
                data: {
                    notebook_no: notebookNo,
                    reviewer: reviewer,
                    comments: comments
                },
                errorDiv: "#add-new-item-error-div"
            };

            Core.ajax(params,
                    function (json) {
                        if (json.status === "success") {
                            that.closePopup();
                            Core.resetSelect($("#add-new-notebook-items-wrapper select"));
                            Core.resetErrorDiv($("#add-new-item-error-div"));
                            $("#add-new-item-number").val("");
                            $("#add-new-item-comments").val("");
                        } else {
                            errorDiv.html(Constants.SERVER_FAIL_RESPONSE);
                        }
                    });
        }
    },
    showPopup: function () {
        $("#add-new-notebook-items-wrapper").fadeIn();
        $("#gray-out-div").fadeIn();
    },
    closePopup: function () {
        $("#add-new-notebook-items-wrapper").fadeOut();
        $("#gray-out-div").fadeOut();
    },
    selectChangeListener: function () {
        $("#add-new-notebook-items-wrapper select").css('color', '#999999');

        $(document).on('change', '#add-new-notebook-items-wrapper select', function () {
            if (!$(this).is(':disabled')) {
                $(this).css('color', Constants.MAIN_TEXT_COLOR);
            }
        });
    }
};