// APP CSS
import '../css/app.scss';

// JQuery
import $ from 'jquery'
window.$ = $
window.jQuery = $

// Select2
require("select2");

// Datatable
import 'datatables.net'
import 'datatables.net-rowreorder'
import 'datatables.net-responsive'
import "../css/vendor/datatable.scss"

$.extend(true, $.fn.dataTable.defaults, {
  dom: '<"dataTables_top" <l> <f>>t<"dataTables_bottom"<i> <p>>',
  lengthMenu: [5, 10, 25, 50, 100],
  pageLength: 10,
  language: {
    emptyTable: "Tidak ada data yang dapat ditampilkan",
    sProcessing: "Sedang memproses...",
    sLengthMenu: "Tampilkan _MENU_ entri",
    sZeroRecords: "Tidak ditemukan data yang sesuai",
    sInfo: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
    sInfoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
    sInfoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
    sInfoPostFix: "",
    sSearch: "Cari:",
    searchPlaceholder: "masukkan kata kunci",
    sUrl: "",
    oPaginate: {
      sFirst: "Pertama",
      sPrevious: "Sebelumnya",
      sNext: "Selanjutnya",
      sLast: "Terakhir",
    },
  }
})

// TippyJS
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css';
window.tippy = tippy

// Helper
import {
  initFormAjax
} from './helpers'

window.initFormAjax = initFormAjax
