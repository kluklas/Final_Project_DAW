import "./bootstrap";

// Metronic
import "../metronic/core/index";
import "../metronic/app/layouts/demo1";

// jQuery
import $ from "jquery";

window.$ = window.jQuery = $;

// DataTables
import DataTable from "datatables.net-dt";

// Vincular DataTables con jQuery
DataTable.use($);

// Extensiones DataTables
import "datatables.net-autofill-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.colVis.mjs";
import "datatables.net-buttons/js/buttons.html5.mjs";
import "datatables.net-buttons/js/buttons.print.mjs";
import "datatables.net-colreorder-dt";
import "datatables.net-datetime";
import "datatables.net-fixedcolumns-dt";
import "datatables.net-fixedheader-dt";
import "datatables.net-keytable-dt";
import "datatables.net-responsive-dt";
import "datatables.net-rowgroup-dt";
import "datatables.net-rowreorder-dt";
import "datatables.net-scroller-dt";
import "datatables.net-searchbuilder-dt";
import "datatables.net-searchpanes-dt";
import "datatables.net-select-dt";
import "datatables.net-staterestore-dt";

// Configuración Tailwind
import "../js/config/dataTables.tailwindcss.js";

export { $, DataTable };