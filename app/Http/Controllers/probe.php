
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>http://stackoverflow.com/a/31663268/315935</title>
<meta name="author" content="Oleg Kiriljuk">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.css">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">-->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://rawgit.com/free-jqgrid/jqGrid/master/plugins/ui.multiselect.css">
    <link rel="stylesheet" href="http://rawgit.com/free-jqgrid/jqGrid/master/css/ui.jqgrid.css">
    <style>
    html, body { font-size: 75%; }
.ui-datepicker select.ui-datepicker-year,
.ui-datepicker select.ui-datepicker-month {
    color: black
}
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="http://rawgit.com/free-jqgrid/jqGrid/master/plugins/ui.multiselect.js"></script>
    <!--<script src="http://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.12.1/js/i18n/grid.locale-en.js"></script>-->
<script>
$.jgrid = $.jgrid || {};
$.jgrid.no_legacy_api = true;
$.jgrid.useJSON = true;
</script>
<!--<script src="jqGrid/js/jquery.jqGrid.src.js"></script>-->
    <script src="http://rawgit.com/free-jqgrid/jqGrid/master/js/jquery.jqgrid.src.js"></script>
    <script>
        //<![CDATA[
        /*global $ */
        /*jslint browser: true */
    $(function () {
        "use strict";
        "use strict";
        var myData = [
                {id: "1",  invdate: "2007-10-01", name: "test",   note: "note",   amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                {id: "2",  invdate: "2007-10-02", name: "test2",  note: "note2",  amount: "300.00", tax: "20.00", closed: false, ship_via: "FE", total: "320.00"},
                {id: "3",  invdate: "2011-07-30", name: "test3",  note: "note3",  amount: "400.00", tax: "30.00", closed: true,  ship_via: "FE", total: "430.00"},
                {id: "4",  invdate: "2007-10-04", name: "test4",  note: "note4",  amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                {id: "5",  invdate: "2007-10-31", name: "test5",  note: "note5",  amount: "300.00", tax: "20.00", closed: false, ship_via: "FE", total: "320.00"},
                {id: "6",  invdate: "2007-09-06", name: "test6",  note: "note6",  amount: "400.00", tax: "30.00", closed: false, ship_via: "FE", total: "430.00"},
                {id: "7",  invdate: "2011-07-30", name: "test7",  note: "note7",  amount: "200.00", tax: "10.00", closed: true,  ship_via: "TN", total: "210.00"},
                {id: "8",  invdate: "2007-10-03", name: "test8",  note: "note8",  amount: "300.00", tax: "20.00", closed: true,  ship_via: "FE", total: "320.00"},
                {id: "9",  invdate: "2007-09-01", name: "test9",  note: "note9",  amount: "400.00", tax: "30.00", closed: false, ship_via: "TN", total: "430.00"},
                {id: "10", invdate: "2007-09-08", name: "test10", note: "note10", amount: "500.00", tax: "30.00", closed: true,  ship_via: "TN", total: "530.00"},
                {id: "11", invdate: "2007-09-08", name: "test11", note: "note11", amount: "500.00", tax: "30.00", closed: false, ship_via: "FE", total: "530.00"},
                {id: "12", invdate: "2007-09-10", name: "test12", note: "note12", amount: "500.00", tax: "30.00", closed: false, ship_via: "FE", total: "530.00"}
            ],
            $grid = $("#list"),
            initDateSearch = function (elem) {
                $(elem).datepicker({
                    dateFormat: "dd-M-yy",
                    autoSize: true,
                    changeYear: true,
                    changeMonth: true,
                    showButtonPanel: true,
                    showWeek: true,
                    onSelect: function () {
                        if (this.id.substr(0, 3) === "gs_") {
                            setTimeout(function () {
                                $(elem).closest("div.ui-jqgrid-hdiv").next("div.ui-jqgrid-bdiv").find("table.ui-jqgrid-btable").first()[0].triggerToolbar();
                            }, 50);
                        } else {
                            // to refresh the filter
                            $(this).trigger("change");
                        }
                    }
                });
            },
            numberSearchOptions = ["eq", "ne", "lt", "le", "gt", "ge", "nu", "nn", "in", "ni"],
            numberTemplate = {formatter: "number", align: "right", sorttype: "number",
                searchoptions: { sopt: numberSearchOptions }},
            myDefaultSearch = "cn",
            refreshSerchingToolbar = function ($grid, myDefaultSearch) {
                var p = $grid.jqGrid("getGridParam"), postData = p.postData, filters, i, l,
                    rules, rule, iCol, cm = p.colModel,
                    cmi, control, tagName;

                for (i = 0, l = cm.length; i < l; i++) {
                    control = $("#gs_" + $.jgrid.jqID(cm[i].name));
                    if (control.length > 0) {
                        tagName = control[0].tagName.toUpperCase();
                        if (tagName === "SELECT") { // && cmi.stype === "select"
                            control.find("option[value='']")
                                .attr("selected", "selected");
                        } else if (tagName === "INPUT") {
                            control.val("");
                        }
                    }
                }

                if (typeof (postData.filters) === "string" &&
                    typeof ($grid[0].ftoolbar) === "boolean" && $grid[0].ftoolbar) {

                    filters = $.parseJSON(postData.filters);
                    if (filters && filters.groupOp === "AND" && filters.groups === undefined) {
                        // only in case of advance searching without grouping we import filters in the
                        // searching toolbar
                        rules = filters.rules;
                        for (i = 0, l = rules.length; i < l; i++) {
                            rule = rules[i];
                            iCol = p.iColByName[rule.field];
                            if (iCol >= 0) {
                                cmi = cm[iCol];
                                control = $("#gs_" + $.jgrid.jqID(cmi.name));
                                if (control.length > 0 &&
                                    (((cmi.searchoptions === undefined ||
                                    cmi.searchoptions.sopt === undefined)
                                    && rule.op === myDefaultSearch) ||
                                    (typeof (cmi.searchoptions) === "object" &&
                                    $.isArray(cmi.searchoptions.sopt) &&
                                    cmi.searchoptions.sopt.length > 0 &&
                                    cmi.searchoptions.sopt[0] === rule.op))) {
                                    tagName = control[0].tagName.toUpperCase();
                                    if (tagName === "SELECT") { // && cmi.stype === "select"
                                        control.find("option[value='" + $.jgrid.jqID(rule.data) + "']")
                                            .attr("selected", "selected");
                                    } else if (tagName === "INPUT") {
                                        control.val(rule.data);
                                    }
                                }
                            }
                        }
                    }
                }
            },
            cm = [
                //{name: "id", width: 70, align: "center", sorttype: "int", formatter: "int"},
                {name: "invdate", width: 75, align: "center", sorttype: "date",
                    formatter: "date", formatoptions: {newformat: "d-M-Y"}, datefmt: "d-M-Y",
                    searchoptions: {
                        sopt: ["eq", "ne"],
                        dataInit: initDateSearch
                    }},
                {name: "name", width: 65},
                {name: "amount", width: 75, template: numberTemplate},
                {name: "tax", width: 52, template: numberTemplate},
                {name: "total", width: 60, search: false, template: numberTemplate},
                {name: "closed", width: 67, align: "center", formatter: "checkbox",
                    edittype: "checkbox", editoptions: {value: "Yes:No", defaultValue: "Yes"},
                    stype: "select", searchoptions: { sopt: ["eq", "ne"], value: ":Any;true:Yes;false:No" }},
                {name: "ship_via", width: 95, align: "center", formatter: "select",
                    edittype: "select", editoptions: {value: "FE:FedEx;TN:TNT;IN:Intim", defaultValue: "IN"},
                    stype: "select", searchoptions: { sopt: ["eq", "ne"], value: ":Any;FE:FedEx;TN:TNT;IN:Intim"}},
                {name: "note", width: 60, sortable: false}
            ],
            saveObjectInLocalStorage = function (storageItemName, object) {
                if (window.localStorage !== undefined) {
                    window.localStorage.setItem(storageItemName, JSON.stringify(object));
                }
            },
            removeObjectFromLocalStorage = function (storageItemName) {
                if (window.localStorage !== undefined) {
                    window.localStorage.removeItem(storageItemName);
                }
            },
            getObjectFromLocalStorage = function (storageItemName) {
                if (window.localStorage !== undefined) {
                    return $.parseJSON(window.localStorage.getItem(storageItemName));
                }
            },
            myColumnStateName = function (grid) {
                return window.location.pathname + "#" + grid[0].id;
            },
            idsOfSelectedRows = [],
            getColumnNamesFromColModel = function () {
                var colModel = this.jqGrid("getGridParam", "colModel");
                return $.map(colModel, function (cm, iCol) {
                    // we remove "rn", "cb", "subgrid" columns to hold the column information
                    // independent from other jqGrid parameters
                    return $.inArray(cm.name, ["rn", "cb", "subgrid"]) >= 0 ? null : cm.name;
                });
            },
            saveColumnState = function () {
                var p = this.jqGrid("getGridParam"), colModel = p.colModel, i, l = colModel.length, colItem, cmName,
                    postData = p.postData,
                    columnsState = {
                        search: p.search,
                        page: p.page,
                        rowNum: p.rowNum,
                        sortname: p.sortname,
                        sortorder: p.sortorder,
                        cmOrder: getColumnNamesFromColModel.call(this),
                        selectedRows: idsOfSelectedRows,
                        colStates: {}
                    },
                    colStates = columnsState.colStates;

                if (postData.filters !== undefined) {
                    columnsState.filters = postData.filters;
                }

                for (i = 0; i < l; i++) {
                    colItem = colModel[i];
                    cmName = colItem.name;
                    if (cmName !== "rn" && cmName !== "cb" && cmName !== "subgrid") {
                        colStates[cmName] = {
                            width: colItem.width,
                            hidden: colItem.hidden
                        };
                    }
                }
                saveObjectInLocalStorage(myColumnStateName(this), columnsState);
            },
            myColumnsState,
            isColState,
            restoreColumnState = function (colModel) {
                var colItem, i, l = colModel.length, colStates, cmName,
                    columnsState = getObjectFromLocalStorage(myColumnStateName(this));

                if (columnsState) {
                    colStates = columnsState.colStates;
                    for (i = 0; i < l; i++) {
                        colItem = colModel[i];
                        cmName = colItem.name;
                        if (cmName !== "rn" && cmName !== "cb" && cmName !== "subgrid") {
                            colModel[i] = $.extend(true, {}, colModel[i], colStates[cmName]);
                        }
                    }
                }
                return columnsState;
            },
            updateIdsOfSelectedRows = function (id, isSelected) {
                var index = $.inArray(id, idsOfSelectedRows);
                if (!isSelected && index >= 0) {
                    idsOfSelectedRows.splice(index, 1); // remove id from the list
                } else if (index < 0) {
                    idsOfSelectedRows.push(id);
                }
            },
            firstLoad = true;

        myColumnsState = restoreColumnState.call($grid, cm);
        isColState = myColumnsState !== undefined && myColumnsState !== null;
        idsOfSelectedRows = isColState && myColumnsState.selectedRows !== undefined ? myColumnsState.selectedRows : [];

        $grid.jqGrid({
            datatype: "local",
            data: myData,
            colNames: [/*"Inv No",*/"Date", "Client", "Amount", "Tax", "Total", "Closed", "Shipped via", "Notes"],
            colModel: cm,
            rowNum: isColState ? myColumnsState.rowNum : 10,
            rowList: [5, 10, 20],
            pager: true,
            gridview: true,
            page: isColState ? myColumnsState.page : 1,
            search: isColState ? myColumnsState.search : false,
            postData: isColState ? { filters: myColumnsState.filters } : {},
            sortname: isColState ? myColumnsState.sortname : "invdate",
            sortorder: isColState ? myColumnsState.sortorder : "desc",
            rownumbers: true,
            ignoreCase: true,
            iconSet: "fontAwesome",
            shrinkToFit: false,
            autoResizing: { compact: true },
            //multiselect: true,
            //shrinkToFit: false,
            //viewrecords: true,
            caption: "The usage of localStorage to save jqGrid preferences",
            height: "auto",
            onSelectRow: function (id, isSelected) {
                updateIdsOfSelectedRows(id, isSelected);
                saveColumnState.call($grid, $grid[0].p.remapColumns);
            },
            sortable: {
                update: function () {
                    saveColumnState.call($grid);
                },
                options: {
                    opacity: 0.8
                }
            },
            onSelectAll: function (aRowids, isSelected) {
                var i, count, id;
                for (i = 0, count = aRowids.length; i < count; i++) {
                    id = aRowids[i];
                    updateIdsOfSelectedRows(id, isSelected);
                }
                saveColumnState.call($grid, $grid[0].p.remapColumns);
            },
            loadComplete: function () {
                var $this = $(this), p = $this.jqGrid("getGridParam"), i, count;

                if (firstLoad) {
                    firstLoad = false;
                    if (isColState && myColumnsState.cmOrder != null && myColumnsState.cmOrder.length > 0) {
                        // We compares the values from myColumnsState.cmOrder array
                        // with the current names of colModel and remove wrong names. It could be
                        // required if the column model are changed and the values from the saved stated
                        // not corresponds to the
                        var fixedOrder = $.map(myColumnsState.cmOrder, function (name) {
                            return p.iColByName[name] === undefined ? null : name;
                        });
                        $this.jqGrid("remapColumnsByName", fixedOrder, true);
                    }
                    if (typeof (this.ftoolbar) !== "boolean" || !this.ftoolbar) {
                        // create toolbar if needed
                        $this.jqGrid("filterToolbar",
                            {stringResult: true, searchOnEnter: true, defaultSearch: myDefaultSearch});
                    }
                }
                refreshSerchingToolbar($this, myDefaultSearch);
                for (i = 0, count = idsOfSelectedRows.length; i < count; i++) {
                    $this.jqGrid("setSelection", idsOfSelectedRows[i], false);
                }
                saveColumnState.call($this, this.p.remapColumns);
            },
            resizeStop: function () {
                saveColumnState.call($grid, $grid[0].p.remapColumns);
            }
        });
        $.extend($.jgrid.search, {
            multipleSearch: true,
            multipleGroup: true,
            //recreateFilter: true,
            closeOnEscape: true,
            closeAfterSearch: true//,
            //overlay: 0
        });
        $grid.jqGrid("navGrid", {edit: false, add: false, del: false});
        $grid.jqGrid("navButtonAdd", {
            caption: "",
            buttonicon: "fa-table",
            title: "Choose columns",
            onClickButton: function () {
                $(this).jqGrid("columnChooser", {
                    done: function (perm) {
                        if (perm) {
                            this.jqGrid("remapColumns", perm, true);
                            saveColumnState.call(this);
                        }
                    }
                });
            }
        });
        $grid.jqGrid("navButtonAdd", {
            caption: "",
            buttonicon: "fa-times",
            title: "Clear saved grid's settings",
            onClickButton: function () {
                removeObjectFromLocalStorage(myColumnStateName($(this)));
                window.location.reload();
            }
        });
    });
//]]>
</script>
</head>
<body>
<div id="outerDiv" style="margin: 5px;">
    <table id="list"></table>
    </div>
    </body>
    </html>
