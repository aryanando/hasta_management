// Default Laravel bootstrapper, installs axios
import "./bootstrap";

// Added: Actual Bootstrap JavaScript dependency
import "bootstrap";

// Added: Popper.js dependency for popover support in Bootstrap
import "@popperjs/core";

import jQuery from "jquery";
window.$ = jQuery;

import DataTables from "datatables.net";
import 'datatables.net-plugins/dataRender/datetime.mjs';
window.DataTables = DataTables;

// window.$(document).ready(function () {
//     setInterval(function () {
//         cache_clear();
//     }, 3000);
// });

// function cache_clear() {
//     window.location.reload(true);
//     // window.location.reload(); use this if you do not remove cache
// }
import QRCode from "qrcode";
window.QRCode = QRCode;


