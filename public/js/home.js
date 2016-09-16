var PageCore;
var CommentsBubble;
var AddNewItem;
var DynamicTables;
var NotebooksTables;
var AssignedNotebooks;
var MyNotebooks;

$(window).load(function () {
    PageCore.init();
    CommentsBubble.init(Core);
    AddNewItem.init(Core, Constants, DynamicTables, NotebooksTables);
    DynamicTables.init();
    NotebooksTables.init(Core);
    AssignedNotebooks.init(NotebooksTables);
    MyNotebooks.init(NotebooksTables);
});

$(window).on('resize', function () {
    clearTimeout(PageCore.settings.resizeTimer);
    PageCore.settings.resizeTimer = setTimeout(function () {
        if (PageCore.settings.windowHeight !== $(window).height()) {
            PageCore.settings.windowHeight = $(window).height();
            DynamicTables.resizeCollapsibleTables();
        }
        NotebooksTables.adjustTableCellWidths();
        CommentsBubble.reposition();
    }, 400);
});

PageCore = {
    settings: {
        resizeTimer: "",
        windowHeigth: ""
    },
    init: function () {
        this.settings.windowHeight = $(window).height();
    }
};

CommentsBubble = {
    settings: {
        core: "",
        bubbleHeight: "",
        tr: "",
        isVisible: false,
        wrapper: "#notebook-table-element-holder",
        parentId: "",
        commentsHtml: ""
    },
    /**
     * @param {Core} core
     */
    init: function (core) {
        this.settings.core = core;

        this.clickListeners();
    },
    clickListeners: function () {
        var self = this;

        $(self.settings.wrapper).on("click", ".comment-bubble", function (e) {
            e.stopPropagation();
        });

        $(self.settings.wrapper).on("click", "select", function (e) {
            e.stopPropagation();
        });

        $(".notebooks-table").on("click", "select", function (e) {
            e.stopPropagation();
            e.preventDefault();
            e.cancelBubble = true;
            return false;
        });

        $(document).on("click", "#gray-out-div", function () {
            if (self.settings.isVisible) {
                self.hide();
            }
        });

        $(".notebooks-table tbody").on("click", "tr", function (e) {
            if (e.target.nodeName === "SELECT") {
                return;
            }
            self.settings.tr = $(this);

            if (!self.settings.isVisible) {
                self.show();
            } else {
                self.hide();
            }
        });
    },
    show: function () {
        var self = this;
        var tr = self.settings.tr;
        var trId = tr.attr("id");
        var radius = tr.closest("table").css("border-bottom-right-radius");
        var wrapper = $(self.settings.wrapper);
        wrapper.show();

        self.settings.isVisible = true;
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

        self.settings.bubbleHeight = bubble.height();
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

        self.scrollToBottom(wrapper.find(".comment-elements-outer-wrappper"));

        self.settings.core.ajaxKeepGrayOut = true;
    },
    hide: function () {
        var self = this;
        self.settings.isVisible = false;
        var tr = self.settings.tr;
        var wrapper = $(self.settings.wrapper);
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
                height: self.settings.bubbleHeight
            });
            wrapper.html("");
            wrapper.hide();
            $(self.settings.parentId).html(self.settings.commentsHtml);
        });

        self.settings.core.ajaxKeepGrayOut = false;
    },
    reposition: function () {
        var self = this;
        if (self.settings.isVisible) {
            var wrapper = $(self.settings.wrapper);
            var bubble = wrapper.find(".comment-bubble");
            var tr = self.settings.tr;

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
        var self = this;
        var innerWrapper = $(element).closest('.comment-bubble-inner-wrapper');
        var id = innerWrapper.find("textarea").attr("class").split('-').pop().trim();
        var textarea = innerWrapper.find("textarea");
        var comment = textarea.val().trim();
        var errorDiv = innerWrapper.find(".error-div");
        self.settings.core.resetErrorDiv(errorDiv);

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

            self.settings.core.ajax(params,
                    function (json) {
                        if (json.status === "success") {
                            self.settings.parentId = "." + innerWrapper.find(".comment-elements-outer-wrappper").attr('class').split(' ')[0];
                            self.settings.commentsHtml = json.comments;

                            innerWrapper.find(".comment-elements-outer-wrappper").html(json.comments);
                            self.scrollToBottom(innerWrapper.find(".comment-elements-outer-wrappper"));

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

AddNewItem = {
    settings: {
        core: "",
        constants: "",
        dynamicTables: "",
        notebooksTables: ""
    },
    /**
     * @param {Core} core
     * @param {Constants} constants
     * @param {DynamicTables} dynamicTables
     * @param {NotebooksTables} notebooksTables
     */
    init: function (core, constants, dynamicTables, notebooksTables) {
        this.settings.core = core;
        this.settings.constants = constants;
        this.settings.dynamicTables = dynamicTables;
        this.settings.notebooksTables = notebooksTables;

        this.selectChangeListener();
    },
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
        var self = this;
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

            self.settings.core.ajax(params,
                    function (json) {
                        if (json.status === "success") {
                            self.closePopup();
                            self.settings.core.resetSelect($("#add-new-notebook-items-wrapper select"));
                            $("#add-new-item-author option").prop("disabled", false);
                            self.settings.core.resetErrorDiv($("#add-new-item-error-div"));
                            $("#add-new-item-number").val("");
                            $("#add-new-item-comments").val("");

                            self.closePopup();
                            self.settings.core.showToast("New item is added successfully");

                            $("#assigned-notebooks-for-review-table-wrapper tbody").html(json.assigned_notebooks_tbody);
                            $("#my-notebooks-table-wrapper tbody").html(json.my_notebooks_tbody);
                            $("#recently-added-notebooks-table-wrapper tbody").html(json.recent_notebooks_tbody);
                            self.settings.dynamicTables.resizeCollapsibleTables();
                            self.settings.notebooksTables.adjustTableCellWidths();
                        } else {
                            errorDiv.html(self.settings.constants.SERVER_FAIL_RESPONSE);
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
        var self = this;

        $("#add-new-notebook-items-wrapper select").css('color', '#999999');

        $(document).on('change', '#add-new-notebook-items-wrapper select', function () {
            if (!$(this).is(':disabled')) {
                $(this).css('color', self.settings.constants.MAIN_TEXT_COLOR);
            }
        });
    }
};

DynamicTables = {
    settings: {
        dynamicTable1Visible: true,
        dynamicTable2Visible: true
    },
    init: function () {
        this.resizeCollapsibleTables();
    },
    resizeCollapsibleTables: function () {
        var viewportHeight = $(window).height();
        var headerHeight = $(".header").outerHeight();

        var tableHeadingHeights = ($(".dynamic-table").siblings('.heading').outerHeight() + parseInt($(".dynamic-table").siblings('.heading').css("margin-top"))) * 2 || 84;
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

        var dynamicTable1MaxHeight;
        var dynamicTable2MaxHeight;

        var dynamicTable1 = $(".dynamic-table-1");
        var dynamicTable2 = $(".dynamic-table-2");

        var invisibleHolder = $("#invisible-element");
        invisibleHolder.html("<table class='notebooks-table'>" + dynamicTable1.html() + "</table>");
        dynamicTable1MaxHeight = invisibleHolder.height();

        if (dynamicTable1MaxHeight < 100) {
            dynamicTable1.css("min-height", dynamicTable1MaxHeight);
        }

        invisibleHolder.html("<table class='notebooks-table'>" + dynamicTable2.html() + "</table>");
        dynamicTable2MaxHeight = invisibleHolder.height();
        invisibleHolder.html("");

        if (dynamicTable2MaxHeight < 100) {
            dynamicTable2.css("min-height", dynamicTable2MaxHeight);
        }

        var halfOfAvailableHeight = availableHeight / 2;

        if (this.settings.dynamicTable1Visible
                && !this.settings.dynamicTable2Visible) {
            dynamicTable1.css("max-height", availableHeight);
        } else if (!this.settings.dynamicTable1Visible
                && this.settings.dynamicTable2Visible) {
            dynamicTable2.css("max-height", availableHeight);
        } else if (this.settings.dynamicTable1Visible
                && this.settings.dynamicTable2Visible) {
            halfOfAvailableHeight = availableHeight / 2;

            if (dynamicTable1MaxHeight < halfOfAvailableHeight) {
                if (dynamicTable2MaxHeight > halfOfAvailableHeight) {
                    dynamicTable1.css("max-height", dynamicTable1MaxHeight);
                    dynamicTable2.css("max-height", availableHeight - dynamicTable1MaxHeight);
                } else {
                    dynamicTable1.css("max-height", dynamicTable1MaxHeight);
                    dynamicTable2.css("max-height", dynamicTable2MaxHeight);
                }
            } else if (dynamicTable1MaxHeight > halfOfAvailableHeight) {
                if (dynamicTable2MaxHeight < halfOfAvailableHeight) {
                    dynamicTable1.css("max-height", availableHeight - dynamicTable2MaxHeight);
                    dynamicTable2.css("max-height", dynamicTable2MaxHeight);
                } else {
                    dynamicTable1.css("max-height", halfOfAvailableHeight);
                    dynamicTable2.css("max-height", halfOfAvailableHeight);
                }
            }
        }
    }
};

NotebooksTables = {
    settings: {
        core: "",
        cellWidthAdjustTimeout: "",
        currentStatus: ""
    },
    /**
     * @param {Core} core
     */
    init: function (core) {
        this.settings.core = core;

        this.adjustTableCellWidths();

        this.statusChangeListener();
    },
    adjustTableCellWidths: function () {
        var self = this;
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
            clearTimeout(self.settings.cellWidthAdjustTimeout);
            self.settings.cellWidthAdjustTimeout = setTimeout(function () {
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
    },
    updateStatus: function (notebookId, statusId) {
        var self = this;

        var params = {
            url: "ajax/update-status.php",
            method: "POST",
            data: {
                notebook_id: notebookId,
                status_id: statusId
            },
            errorDiv: $("#main-error-div")
        };

        self.settings.core.ajax(
                params,
                function (json) {
                    if (json.status === "success") {
                        self.settings.currentStatus = "";
                        self.settings.core.showToast("Status was successfully updated");
                    }
                });
    },
    statusChangeListener: function () {
        var self = this;

        $("#notebook-table-element-holder").on("focus", ".statuses-dropdown", function () {
            self.settings.currentStatus = $(this).val();
        }).on("change", ".statuses-dropdown", function () {
            if (self.settings.currentStatus !== $(this).val()) {
                var notebookId = $(this).closest('tr').attr("class").split(' ')[0].split('-').pop().trim();
                self.settings.updateStatus(notebookId, $(this).val());
            }
        });
    }
};

AssignedNotebooks = {
    settings: {
        notebooksTables: ""
    },
    /**
     * @param {NotebooksTables} notebooksTables
     */
    init: function (notebooksTables) {
        this.settings.notebooksTables = notebooksTables;

        this.statusChangeListener();
    },
    statusChangeListener: function () {
        var self = this;

        $("#assigned-notebooks-for-review-table-wrapper").on("focus", ".statuses-dropdown", function () {
            self.settings.notebooksTables.currentStatus = $(this).val();
        }).on("change", ".statuses-dropdown", function () {
            if (self.settings.notebooksTables.currentStatus !== $(this).val()) {
                var notebookId = $(this).closest('tr').attr("id").split('-').pop().trim();
                self.settings.notebooksTables.updateStatus(notebookId, $(this).val());
            }
        });
    }
};

MyNotebooks = {
    settings: {
        notebooksTables: ""
    },
    /**
     * @param {NotebooksTables} notebooksTables
     */
    init: function (notebooksTables) {
        this.settings.notebooksTables = notebooksTables;

        this.statusChangeListener();
    },
    statusChangeListener: function () {
        var self = this;

        $("#my-notebooks-table-wrapper").on("focus", ".statuses-dropdown", function () {
            self.settings.notebooksTables.currentStatus = $(this).val();
        }).on("change", ".statuses-dropdown", function () {
            if (self.settings.notebooksTables.currentStatus !== $(this).val()) {
                var notebookId = $(this).closest('tr').attr("id").split('-').pop().trim();
                self.settings.notebooksTables.updateStatus(notebookId, $(this).val());
            }
        });
    }
};