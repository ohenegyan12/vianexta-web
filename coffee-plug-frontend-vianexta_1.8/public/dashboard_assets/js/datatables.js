$(document).ready(function () {
  var table = $("#dt_trans").DataTable({
    lengthChange: false,
    buttons: ["copy", "excel", "csv", "pdf", "colvis"],
  });

  table.buttons().container().appendTo("#dt_trans_wrapper .col-md-6:eq(0)");
});