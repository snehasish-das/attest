<?php
session_start();
require_once 'api/src/config/init.php';
$_SESSION['site-url']=BASE_URL;
@$currUrl = end(explode('/',$_SERVER['REQUEST_URI']));

$redirect = $currUrl == '' ? 'index' : $currUrl; 
if (!isset($_SESSION['user-details'])) {
	header("Location: login?redirect=".$redirect);
	exit();
}
require_once 'api/src/functions.php';

$cta = new CallToAction();
$site_name_url = $_SESSION['site-url'] . '/api/site_options/site_name';
$data = json_decode($cta->httpGet($site_name_url), true);
$site_name = $data[0]['option_value'];

$report_name = $_REQUEST['node'];
// $isRootNode = $_REQUEST['parent_node']==''?true:false;
// $tests_url = $_SESSION['site-url'] . '/api/tests?parent_node='.$parent_node;
// $tests = json_decode($cta->httpGetWithAuth($tests_url,$_SESSION['auth-phrase']), true);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name.' - '.ucfirst(str_replace('-',' ',$report_name)); ?></title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/structure.css" rel="stylesheet" type="text/css" class="structure" />

    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!--  BEGIN CUSTOM STYLE FILE  -->
    <link href="assets/css/elements/custom-tree_view.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="plugins/editors/quill/quill.snow.css">
    <link href="assets/css/apps/todolist.css" rel="stylesheet" type="text/css" />
    <!--  END CUSTOM STYLE FILE  -->

    <!-- BEGIN PAGE LEVEL CUSTOM STYLES -->
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/custom_dt_html5.css">
    <link rel="stylesheet" type="text/css" href="plugins/table/datatable/dt-global_style.css">
    <!-- END PAGE LEVEL CUSTOM STYLES -->

</head>

<body class="dashboard-analytics admin-header">

    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        <div class="sidebar-wrapper sidebar-theme">

            <div class="theme-logo">
                <a href="index">
                    <img src="assets/img/247-logo.svg" class="navbar-logo" alt="logo">
                    <span class="admin-logo"><?php echo $site_name; ?><span></span></span>
                </a>
            </div>

            <div class="sidebarCollapseFixed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="feather feather-arrow-left">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
            </div>

            <?php require_once './partials/menu.php'; ?>

        </div>
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">

                <div class="content-container">

                    <div class="col-left layout-top-spacing">
                        <div class="col-left-content">

                            <div class="header-container">
                                <?php require_once './partials/header.php'; ?>
                            </div>

                            <div class="admin-data-content layout-top-spacing">

                                <div class="row layout-top-spacing" id="cancel-row">

                                    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                                        <div class="widget-content widget-content-area br-6">
                                            <?php require_once './report-partials/'.$report_name.'.php'; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="footer-wrapper col-xl-12">
                                <?php require './partials/footer.php'; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-right">
                        <?php //require_once './partials/notifications.php'; ?>
                    </div>

                </div>
            </div>

        </div>
        <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->
    <?php require_once './partials/modals.php'; ?>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="bootstrap/js/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
    $(document).ready(function() {
        App.init();
    });
    </script>
    <script src="assets/js/custom.js"></script>
    <script src="plugins/treeview/custom-jstree.js"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN MODAL FORM -->
    <script src="plugins/select2/select2.min.js"></script>
    <script src="plugins/select2/custom-select2.js"></script>
    <script src="assets/js/forms/bootstrap_validation/bs_validation_script.js"></script>
    <!-- BEGIN MODAL FORM -->



    <!-- BEGIN PAGE LEVEL CUSTOM SCRIPTS -->
    <script src="plugins/table/datatable/datatables.js"></script>
    <!-- NOTE TO Use Copy CSV Excel PDF Print Options You Must Include These Files  -->
    <script src="plugins/table/datatable/button-ext/dataTables.buttons.min.js"></script>
    <script src="plugins/table/datatable/button-ext/jszip.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.html5.min.js"></script>
    <script src="plugins/table/datatable/button-ext/buttons.print.min.js"></script>
    <script>
    $('#html5-extension').DataTable({
        "dom": "<'dt--top-section'<'row'<'col-sm-12 col-md-6 d-flex justify-content-md-start justify-content-center'B><'col-sm-12 col-md-6 d-flex justify-content-md-end justify-content-center mt-md-0 mt-3'f>>>" +
            "<'table-responsive'tr>" +
            "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
        buttons: {
            buttons: [{
                    extend: 'copy',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'csv',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'excel',
                    className: 'btn btn-sm'
                },
                {
                    extend: 'print',
                    className: 'btn btn-sm'
                }
            ]
        },
        "oLanguage": {
            "oPaginate": {
                "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
            },
            "sInfo": "Showing page _PAGE_ of _PAGES_",
            "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
            "sSearchPlaceholder": "Search...",
            "sLengthMenu": "Results :  _MENU_",
        },
        "stripeClasses": [],
        "lengthMenu": [7, 10, 20, 50],
        "pageLength": 7
    });
    </script>
    <script src="plugins/sweetalerts/sweetalert2.min.js"></script>
    <!--script src="plugins/sweetalerts/custom-sweetalert.js"></script-->
    <!-- END PAGE LEVEL CUSTOM SCRIPTS -->
</body>
<script>
    (function($) {
  "use strict";

  function _interopDefaultLegacy(e) {
    return e && typeof e === "object" && "default" in e ? e : {
      default: e
    }
  }
  var $__default = _interopDefaultLegacy($);
  var NULL_CELL = new(function() {
    function class_1() {}
    class_1.prototype.columnAddress = function() {
      return 0
    };
    class_1.prototype.width = function() {
      return 0
    };
    class_1.prototype.getCell = function() {
      return null
    };
    class_1.prototype.matches = function(other) {
      return false
    };
    return class_1
  }());
  var RowMerge = function() {
    function RowMerge(tableTarget, args) {
      var t = tableTarget.get(0);
      if (!(t instanceof HTMLTableElement)) {
        throw new Error("JQuery target must be a table element.")
      }
      this.origTable = t;
      var exc = args.zeroIndexed ? args.excludedColumns : args.excludedColumns.map(function(n) {
        return n - 1
      });
      this.mergeTable = RowMerge.merge(t, args.matcher, exc)
    }
    RowMerge.merge = function(table, matcher, excludedColumns) {
      var t = table.cloneNode(true);
      var s = t.tBodies;
      for (var i = 0; i < s.length; i++) {
        var section = s.item(i);
        RowMerge.mergeSection(section, matcher, excludedColumns)
      }
      return t
    };
    RowMerge.mergeSection = function(section, matcher, excludedColumns) {
      var rows = section.rows;
      if (rows.length == 0) {
        return
      }
      var arr = new Array;
      arr.push(NULL_CELL);
      for (var r = 0; r < rows.length; r++) {
        var row = rows.item(r);
        var cells = RowMerge.createCells(row.cells, matcher);
        if (cells.length == 0) {
          continue
        }
        var ia = 0;
        var ib = 0;
        var arrNew = new Array;
        var _loop_1 = function() {
          var cellA = arr[ia];
          var cellB = cells[ib];
          var ca = cellA.columnAddress();
          var cb = cellB.columnAddress();
          if (ca > cb) {
            ib++;
            arrNew.push(cellB)
          } else if (ca < cb) {
            ia++
          } else {
            if (excludedColumns.some(function(n) {
                return ca === n
              })) {
              ia++;
              ib++;
              arrNew.push(cellB)
            } else {
              var wa = cellA.width();
              var wb = cellB.width();
              if (wa != wb) {
                ia++;
                ib++;
                arrNew.push(cellB)
              } else {
                if (cellA.matches(cellB)) {
                  arrNew.push(cellA);
                  cellA.getCell().rowSpan++;
                  row.removeChild(cellB.getCell());
                  ia++;
                  ib++
                } else {
                  ia++;
                  ib++;
                  arrNew.push(cellB)
                }
              }
            }
          }
        };
        while (ia < arr.length && ib < cells.length) {
          _loop_1()
        }
        for (; ib < cells.length; ib++) {
          var cellB = cells[ib];
          arrNew.push(cellB)
        }
        arr = arrNew
      }
    };
    RowMerge.createCells = function(cells, matcher) {
      var a = new Array(cells.length);
      for (var i = 0, col = 0; i < cells.length; i++) {
        var c = cells.item(i);
        var width = c.colSpan;
        a[i] = new RowMerge.SingleCell(col, width, c, matcher);
        col += width
      }
      return a
    };
    RowMerge.prototype.getMerged = function() {
      return this.mergeTable
    };
    RowMerge.prototype.getOriginal = function() {
      return this.origTable
    };
    RowMerge.SingleCell = function() {
      function class_2(column, width, cell, matcher) {
        this.col = column;
        this.w = width;
        this.cell = cell;
        this.matcher = matcher
      }
      class_2.prototype.columnAddress = function() {
        return this.col
      };
      class_2.prototype.width = function() {
        return this.w
      };
      class_2.prototype.getCell = function() {
        return this.cell
      };
      class_2.prototype.matches = function(other) {
        return this.matcher(this.getCell(), other.getCell())
      };
      return class_2
    }();
    return RowMerge
  }();
  $__default["default"].fn.rowMerge = function(args) {
    var MATCH_TEXT_ONLY = function(value, other) {
      return value.textContent == other.textContent
    };
    var target = this;
    args = $__default["default"].extend({}, $__default["default"].fn.rowMerge.args, args);
    if (typeof args.matcher === "undefined") args.matcher = MATCH_TEXT_ONLY;
    if (typeof args.excludedColumns === "undefined") args.excludedColumns = new Array;
    if (typeof args.zeroIndexed === "undefined") args.zeroIndexed = false;
    var rowMerge = new RowMerge(target, args);
    var methods = {
      merge: function() {
        update(rowMerge.getMerged())
      },
      unmerge: function() {
        update(rowMerge.getOriginal())
      }
    };
    methods.merge();
    return methods;

    function update(table) {
      var t = $__default["default"](table);
      target.replaceWith(t);
      target = t
    }
  };
  $__default["default"](function() {
    var selector = typeof $__default["default"].fn.rowMerge.selector === "undefined" ? "table.row-merge" : $__default["default"].fn.rowMerge.selector;
    var s = $__default["default"](selector);
    s.each(function(i, e) {
      $__default["default"](e).rowMerge()
    })
  });
  $__default["default"].fn.rowMerge.selector = undefined;
  $__default["default"].fn.rowMerge.args = {}
})($);

</script>

<script>
      // Use the plugin once the DOM has been loaded.
      $(function () {
        // Apply the plugin 
        var table = $('#html5-extension').rowMerge({
          excludedColumns: [3,4],
        });
      });
    </script>
</html>