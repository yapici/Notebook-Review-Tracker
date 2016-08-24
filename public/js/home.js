$(document).ready(function () {
    AddNewItem.selectChangeListener();
    CommentsBubble.clickListeners();
});

var CommentsBubble = {
    originalTdZ: "1",
    bubbleHeight: "",
    td: "",
    clickListeners: function () {
        var that = this;

        $(".notebooks-table").on("click", ".comment-bubble", function (e) {
            e.stopPropagation();
        });

        $(".notebooks-table").on("click", "select", function (e) {
            e.stopPropagation();
        });

        $(document).on("click", "#gray-out-div", function () {
            that.hide();
        });

        $(".notebooks-table").on("click", "tr", function () {
            that.td = $(this);
            var td = that.td;
            var currentZ = td.find("td").css("z-index");
            var bubble = td.find(".comment-bubble");
            var radius = td.closest("table").css("border-radius");

            if (currentZ !== "9999") {
                that.originalTdZ = currentZ;
                td.find("td").css("z-index", "9999");
                $("#gray-out-div").fadeIn();
                bubble.show().css("z-index", "9999");

                that.bubbleHeight = bubble.height();
                bubble.css("height", "0");
                bubble.animate({
                    width: td.width(),
                    height: that.bubbleHeight,
                    opacity: "1"
                }, 500);

                td.find("td:first-child").animate({
                    borderTopLeftRadius: radius,
                    borderBottomLeftRadius: radius
                });

                td.find("td:last-child").animate({
                    borderTopRightRadius: radius,
                    borderBottomRightRadius: radius
                });
            } else {
                that.hide();
            }
        });
    },
    hide: function () {
        var that = this;
        var td = that.td;
        var bubble = td.find(".comment-bubble");
        $("#gray-out-div").fadeOut();

        bubble.animate({
            width: "0",
            height: "0",
            opacity: "0",
            minHeight: "0px"
        }, 500).promise().done(function () {
            bubble.hide().css({
                zIndex: that.originalTdZ,
                height: that.bubbleHeight
            });
            td.find("td").css("z-index", that.originalTdZ);
        });

        if (td.is(':last-child')) {
            td.find("td:first-child").animate({
                borderTopLeftRadius: 0
            });

            td.find("td:last-child").animate({
                borderTopRightRadius: 0
            });
        } else {
            td.find("td:first-child").animate({
                borderTopLeftRadius: 0,
                borderBottomLeftRadius: 0
            });

            td.find("td:last-child").animate({
                borderTopRightRadius: 0,
                borderBottomRightRadius: 0
            });
        }
    }
};

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
        $("#add-new-item-error-div").html("");
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