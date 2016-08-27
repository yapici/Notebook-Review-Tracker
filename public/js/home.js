var resizeTimer;
var windowHeight;
$(window).load(function () {
    windowHeight = $(window).height();
    AddNewItem.selectChangeListener();
    CommentsBubble.clickListeners();
    CollapsableTables.resizeCollapsibleTables();
    NotebooksTables.adjustTableCellWidths();
});

$(window).on('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function () {
        if (windowHeight !== $(window).height()) {
            windowHeight = $(window).height();
            CollapsableTables.resizeCollapsibleTables();
        }
        NotebooksTables.adjustTableCellWidths();
        CommentsBubble.reposition();
    }, 400);
});

var CommentsBubble = {
    bubbleHeight: "",
    tr: "",
    isVisible: false,
    wrapper: "#notebook-table-element-holder",
    clickListeners: function () {
        var that = this;

        $(that.wrapper).on("click", ".comment-bubble", function (e) {
            e.stopPropagation();
        });

        $(that.wrapper).on("click", "select", function (e) {
            e.stopPropagation();
        });

        $(".notebooks-table").on("click", "select", function (e) {
            e.stopPropagation();
            e.preventDefault();
            e.cancelBubble = true;
            return false;
        });

        $(document).on("click", "#gray-out-div", function () {
            if (that.isVisible) {
                that.hide();
            }
        });

        $(".notebooks-table tbody").on("click", "tr", function (e) {
            if (e.target.nodeName === "SELECT") {
                return;
            }
            that.tr = $(this);

            if (!that.isVisible) {
                that.show();
            } else {
                that.hide();
            }
        });
    },
    show: function () {
        var that = this;
        var tr = that.tr;
        var radius = tr.closest("table").css("border-bottom-right-radius");
        var wrapper = $(that.wrapper);
        wrapper.show();

        that.isVisible = true;
        $("#gray-out-div").fadeIn();
        wrapper.html("");
        wrapper.html("<span class='close-popup-button' style='top: -1.6em; right: 0;' onclick='CommentsBubble.hide()'></span><table><tr>" + tr.html() + "</tr></table>");
        var bubble = wrapper.find(".comment-bubble");

        wrapper.css({
            height: "auto",
            width: tr.outerWidth()
        });

        var position = tr.position();
        wrapper.css(position);

        wrapper.animate({
            top: $(window).height() / 2 - wrapper.outerHeight() - bubble.outerHeight() / 2,
            left: $(window).width() / 2 - wrapper.outerWidth() / 2
        });

        wrapper.find("td:first-child").css("width", tr.find("td:first-child").outerWidth());
        wrapper.find("td:nth-child(2)").css("width", tr.find("td:nth-child(2)").outerWidth());
        wrapper.find("td:nth-child(3)").css("width", tr.find("td:nth-child(3)").outerWidth());
        wrapper.find("td:last-child").css("width", tr.find("td:last-child").outerWidth());

        // Do not delete this second css assignment code. Double assignment is intentional due to a bug.
        wrapper.css({
            height: "auto",
            width: tr.outerWidth()
        });

        that.bubbleHeight = bubble.height();
        bubble.css("height", "0");
        bubble.css("width", tr.width());
        bubble.animate({
            height: that.bubbleHeight,
            opacity: "1"
        }, 500);

        wrapper.find("td:first-child").animate({
            borderTopLeftRadius: radius,
            borderBottomLeftRadius: radius
        });

        wrapper.find("td:last-child").animate({
            borderTopRightRadius: radius,
            borderBottomRightRadius: radius
        });
        
        wrapper.find(".comment-elements-outer-wrappper").animate({
            scrollTop: wrapper.find(".comment-elements-outer-wrappper").height()
        });

        Core.ajaxKeepGrayOut = true;
    },
    hide: function () {
        var that = this;
        that.isVisible = false;
        var tr = that.tr;
        var wrapper = $(that.wrapper);
        var bubble = wrapper.find(".comment-bubble");
        $("#gray-out-div").fadeOut();

        var position = tr.position();

        wrapper.animate({
            top: position.top,
            left: position.left
        });

        bubble.animate({
            height: "0",
            opacity: "0",
            minHeight: "0px"
        }, 500).promise().done(function () {
            bubble.hide().css({
                height: that.bubbleHeight
            });
            wrapper.html("");
            wrapper.hide();
        });

        Core.ajaxKeepGrayOut = false;
    },
    reposition: function () {
        var that = this;
        if (that.isVisible) {
            var wrapper = $(that.wrapper);
            var bubble = wrapper.find(".comment-bubble");
            var tr = that.tr;

            wrapper.animate({
                top: $(window).height() / 2 - wrapper.outerHeight() - bubble.outerHeight() / 2,
                left: $(window).width() / 2 - tr.outerWidth() / 2,
                width: tr.outerWidth()
            }).css("overflow", "visible");

            bubble.animate({
                width: tr.outerWidth()
            });
        }
    },
    addComment: function (element) {
        var innerWrapper = $(element).closest('.comment-bubble-inner-wrapper');
        var id = innerWrapper.find("textarea").attr("class").split('-').pop().trim();
        var comment = innerWrapper.find("textarea").val().trim();
        var errorDiv = innerWrapper.find(".error-div");
        Core.resetErrorDiv(errorDiv);

        if (comment !== "") {
            var params = {
                url: "ajax/add-comment.php",
                method: "POST",
                data: {
                    id: id,
                    comment: comment
                },
                errorDiv: errorDiv
            };

            Core.ajax(params,
                    function (json) {
                        console.log(json);
                        if (json.status === "success") {
                        } else {
                        }
                    });
        } else {
            errorDiv.html("Please add a message first");
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
                errorDiv: $("#add-new-item-error-div")
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

var CollapsableTables = {
    collapsableTable1Visible: true,
    collapsableTable2Visible: true,
    resizeCollapsibleTables: function () {
        var viewportHeight = $(window).height();
        var headerHeight = $(".header").outerHeight();

        var tableHeadingHeights =
                (
                        (
                                $(".collapsable-table").siblings('.heading').outerHeight() +
                                parseInt($(".collapsable-table").siblings('.heading').css("margin-top"))
                                )
                        * 2) || 84;
        var tablesWrapperMargin = (parseInt($(".table-wrapper").css("margin-bottom")) + parseInt($(".table-wrapper").css("margin-top")) * 2) || 60;
        var mainWrapperPaddings = (parseInt($("#home-main-body-wrapper").css("padding-bottom")) + parseInt($("#home-main-body-wrapper").css("padding-top")) * 2) || 40;

        var availableHeight =
                viewportHeight - (
                        headerHeight +
                        tableHeadingHeights +
                        tablesWrapperMargin +
                        mainWrapperPaddings
                        ) + 30;
        $("#recently-added-notebooks-table-wrapper").css("max-height", availableHeight + tablesWrapperMargin / 2 + tableHeadingHeights / 2);
        $("#home-main-body-wrapper").css("height", availableHeight);

        var collapsableTable1MaxHeight;
        var collapsableTable2MaxHeight;

        var collapsableTable1 = $(".collapsable-table-1");
        var collapsableTable2 = $(".collapsable-table-2");

        var invisibleHolder = $("#invisible-element");
        invisibleHolder.html("<table class='notebooks-table'>" + collapsableTable1.html() + "</table>");
        collapsableTable1MaxHeight = invisibleHolder.height();

        if (collapsableTable1MaxHeight < 100) {
            collapsableTable1.css("min-height", collapsableTable1MaxHeight);
        }

        invisibleHolder.html("<table class='notebooks-table'>" + collapsableTable2.html() + "</table>");
        collapsableTable2MaxHeight = invisibleHolder.height();
        invisibleHolder.html("");

        if (collapsableTable2MaxHeight < 100) {
            collapsableTable2.css("min-height", collapsableTable2MaxHeight);
        }

        var halfOfAvailableHeight = availableHeight / 2;

        if (this.collapsableTable1Visible
                && !this.collapsableTable2Visible) {
            collapsableTable1.css("max-height", availableHeight);
        } else if (!this.collapsableTable1Visible
                && this.collapsableTable2Visible) {
            collapsableTable2.css("max-height", availableHeight);
        } else if (this.collapsableTable1Visible
                && this.collapsableTable2Visible) {
            halfOfAvailableHeight = availableHeight / 2;

            if (collapsableTable1MaxHeight < halfOfAvailableHeight) {
                if (collapsableTable2MaxHeight > halfOfAvailableHeight) {
                    collapsableTable1.css("max-height", collapsableTable1MaxHeight);
                    collapsableTable2.css("max-height", availableHeight - collapsableTable1MaxHeight);
                } else {
                    collapsableTable1.css("max-height", collapsableTable1MaxHeight);
                    collapsableTable2.css("max-height", collapsableTable2MaxHeight);
                }
            } else if (collapsableTable1MaxHeight > halfOfAvailableHeight) {
                if (collapsableTable2MaxHeight < halfOfAvailableHeight) {
                    collapsableTable1.css("max-height", availableHeight - collapsableTable2MaxHeight);
                    collapsableTable2.css("max-height", collapsableTable2MaxHeight);
                } else {
                    collapsableTable1.css("max-height", halfOfAvailableHeight);
                    collapsableTable2.css("max-height", halfOfAvailableHeight);
                }
            }
        }
    }
};

var NotebooksTables = {
    adjustTableCellWidths: function () {
        $(".notebooks-table").each(function () {
            var firstCell = $(this).find("tr td:first-child");

            var invisibleEl = $("#invisible-element");
            invisibleEl.html(firstCell.html().substring(0, firstCell.html().indexOf("<span")));
            var width = invisibleEl.outerWidth() + parseInt(firstCell.css('padding-right')) * 3;
            invisibleEl.html("");

            var numOfColumns = $(this).find("tbody tr").children().size() / $(this).find("tbody tr").size();

            if ($(this).width() / numOfColumns < width) {
                firstCell.animate({width: width});
                $(this).find("tr:first-child th:first-child").animate({width: width});
            } else {
                firstCell.css('width', "auto");
                $(this).find("tr:first-child th:first-child").css('width', "auto");
            }
        });
    }
};