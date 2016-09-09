var resizeTimer;
var windowHeight;
$(window).load(function () {
    windowHeight = $(window).height();
    AddNewItem.selectChangeListener();
    CommentsBubble.clickListeners();
    CollapsableTables.resizeCollapsibleTables();
    NotebooksTables.adjustTableCellWidths();
    AssignedNotebooks.statusChangeListener();
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
    parentId: "",
    commentsHtml: "",
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
        var trId = tr.attr("id");
        var radius = tr.closest("table").css("border-bottom-right-radius");
        var wrapper = $(that.wrapper);
        wrapper.show();

        that.isVisible = true;
        $("#gray-out-div").fadeIn();
        wrapper.html("");
        wrapper.html("<span class='close-popup-button' style='top: -1.6em; right: 0;' onclick='CommentsBubble.hide()'></span><table><tr class='" + trId + "'>" + tr.html() + "</tr></table>");
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
        bubble.css("width", tr.width());
        bubble.animate({
            height: "auto",
            opacity: "1"
        }, 500).css("display", "inline-block");

        wrapper.find("td:first-child").animate({
            borderTopLeftRadius: radius,
            borderBottomLeftRadius: radius
        });

        wrapper.find("td:last-child").animate({
            borderTopRightRadius: radius,
            borderBottomRightRadius: radius
        });

        that.scrollToBottom(wrapper.find(".comment-elements-outer-wrappper"));

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
            $(that.parentId).html(that.commentsHtml);
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
        var that = this;
        var innerWrapper = $(element).closest('.comment-bubble-inner-wrapper');
        var id = innerWrapper.find("textarea").attr("class").split('-').pop().trim();
        var textarea = innerWrapper.find("textarea");
        var comment = textarea.val().trim();
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
                        if (json.status === "success") {
                            that.parentId = "." + innerWrapper.find(".comment-elements-outer-wrappper").attr('class').split(' ')[0];
                            that.commentsHtml = json.comments;

                            innerWrapper.find(".comment-elements-outer-wrappper").html(json.comments);
                            that.scrollToBottom(innerWrapper.find(".comment-elements-outer-wrappper"));

                            textarea.val("");
                        } else {
                        }
                    });
        } else {
            errorDiv.html("Please add a message first");
        }
    },
    scrollToBottom: function (element) {
        var height = 0;
        element.find(".comment-elements-inner-wrapper").each(function () {
            height += $(this).outerHeight();
        });
        element.animate({
            scrollTop: height
        });
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
        var author = $("#add-new-item-author").val();
        var comments = $("#add-new-item-comments").val();
        var errorDiv = $("#add-new-item-error-div");

        if (comments === "Comments") {
            comments = "";
        }

        if (division === "" ||
                project === "" ||
                number === "" ||
                reviewer === "" ||
                author === "") {
            errorDiv.html("Please fill all the required fields");
        } else {
            var params = {
                url: "ajax/add-new-item.php",
                method: "POST",
                data: {
                    notebook_no: notebookNo,
                    reviewer: reviewer,
                    comments: comments,
                    author: author
                },
                errorDiv: $("#add-new-item-error-div")
            };

            Core.ajax(params,
                    function (json) {
                        if (json.status === "success") {
                            that.closePopup();
                            Core.resetSelect($("#add-new-notebook-items-wrapper select"));
                            $("#add-new-item-author option").prop("disabled", false);
                            Core.resetErrorDiv($("#add-new-item-error-div"));
                            $("#add-new-item-number").val("");
                            $("#add-new-item-comments").val("");

                            that.closePopup();
                            Core.showToast("New item is added successfully");

                            $("#assigned-notebooks-for-review-table-wrapper tbody").html(json.assigned_notebooks_tbody);
                            $("#my-notebooks-table-wrapper tbody").html(json.my_notebooks_tbody);
                            $("#recently-added-notebooks-table-wrapper tbody").html(json.recent_notebooks_tbody);
                            CollapsableTables.resizeCollapsibleTables();
                            NotebooksTables.adjustTableCellWidths();
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
    cellWidthAdjustTimeout: "",
    adjustTableCellWidths: function () {
        var that = this;
        $(".notebooks-table").each(function () {
            var width = 0;
            var firstCells = $(this).find("tr td:first-child");

            $(this).find('tr').each(function () {
                var firstCell = $(this).find("td:first-child");
                try {
                    var invisibleEl = $("#invisible-element");
                    invisibleEl.html(firstCell.html().substring(0, firstCell.html().indexOf("<span")));
                    var cellWidth = invisibleEl.outerWidth() + parseInt(firstCell.css('padding-right')) * 3;
                    invisibleEl.html("");
                    if (cellWidth > width) {
                        width = cellWidth;
                    }
                } catch (e) {

                }
            });

            var numOfColumns = $(this).find("tbody tr").children().size() / $(this).find("tbody tr").size();

            if ($(this).width() / numOfColumns < width) {
                firstCells.animate({width: width});
                $(this).find("tr:first-child th:first-child").animate({width: width}).promise().done(prepareTooltip);
            } else {
                firstCells.css('width', "auto");
                $(this).find("tr:first-child th:first-child").css('width', "auto");
                prepareTooltip();
            }
        });

        function prepareTooltip() {
            clearTimeout(that.cellWidthAdjustTimeout);
            that.cellWidthAdjustTimeout = setTimeout(function () {
                $('.notebooks-table td+td').each(function (i) {
                    prep($(this));
                });
                $('.notebooks-table th+th').each(function (i) {
                    prep($(this));
                });

                function prep(el) {
                    el.attr("title", el.attr("tmp_title"));
                    var element = el
                            .clone()
                            .css({display: 'inline', width: 'auto', visibility: 'hidden'})
                            .appendTo('body');

                    if (element.width() > el.width()) {
                        el.tooltip({
                            position: {
                                my: "center bottom",
                                at: "center top",
                                collision: "flipfit",
                                using: function (position, feedback) {
                                    $(this).css(position);
                                    $("<div>")
                                            .addClass("arrow")
                                            .addClass(feedback.vertical)
                                            .addClass(feedback.horizontal)
                                            .appendTo(this);
                                }
                            },
                            show: {
                                effect: "drop",
                                direction: 'up',
                                duration: 300,
                                delay: 500,
                                easing: "swing"
                            }
                        });
                    } else {
                        el.attr("tmp_title", el.attr("title"));
                        el.attr("title", "");
                    }

                    element.remove();
                }
            }, 610);
        }
    }
};

var AssignedNotebooks = {
    currentStatus: "",
    statusChangeListener: function () {
        var that = this;

        $("#assigned-notebooks-for-review-table-wrapper").on("focus", ".statuses-dropdown", function () {
            that.currentStatus = $(this).val();
        }).on("change", ".statuses-dropdown", function () {
            if (that.currentStatus !== $(this).val()) {
                var notebookId = $(this).closest('tr').attr("id").split('-').pop().trim();
                that.updateStatus(notebookId, $(this).val());
            }
        });

        $("#notebook-table-element-holder").on("focus", ".statuses-dropdown", function () {
            that.currentStatus = $(this).val();
        }).on("change", ".statuses-dropdown", function () {
            if (that.currentStatus !== $(this).val()) {
                var notebookId = $(this).closest('tr').attr("class").split(' ')[0].split('-').pop().trim();
                that.updateStatus(notebookId, $(this).val());
            }
        });
    },
    updateStatus: function (notebookId, statusId) {
        var that = this;

        var params = {
            url: "ajax/update-status.php",
            method: "POST",
            data: {
                notebook_id: notebookId,
                status_id: statusId
            },
            errorDiv: $("#main-error-div")
        };

        Core.ajax(
                params,
                function (json) {
                    if (json.status === "success") {
                        that.currentStatus = "";
                        Core.showToast("Status was successfully updated");
                    }
                });
    }
};