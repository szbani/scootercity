function format(d) {
  // `d` is the original data object for the row
  for()
  return (
    '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    "<tr>" +
    "<td>További képek:</td>" +
    "<td>" +
    '<img src="../media/products/'+
    d.kepek +
    '" class="img-fluid img-table" alt=""> '+
    "</td>" +
    "</tr>" +
    "<tr>" +
    "<td>leírás:</td>" +
    "<td>" +
    d.leiras +
    "</td>" +
    "</tr>" +
    "<tr>" +
    "<td>Tulajdonságok:</td>" +
    "<td>"+
    d.tulajdonsagok+
    "</td>" +
    "</tr>" +
    "</table>"
  );
}

function createTable() {
  var table = $("#table").DataTable({
    ajax: {
      url: "query/test.php",
      dataSrc: "",
    },
    columns: [
      {
        className: "dt-control",
        orderable: false,
        data: null,
        defaultContent: "",
      },
      { data: "id" },
      { data: "nev" },
      {
        data: "indexkep",
        render: function (data, type) {
          if( type === 'display'){
            return '<img src="../media/products/' +data + '" class="img-fluid img-table" alt=""> ';
          }
          return data;
          }
      },
      { data: "ar" },
      { data: "kat_nev" },
    ],
    dom: "Blfrtip",
    buttons: [
      {
        text: "My button",
        action: function (e, dt, node, config) {
          console.log(table.row(".selected").data());
        },
      },
    ],
  });
  $("#table tbody").on("click", "tr", function () {
    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
    } else {
      table.$("tr.selected").removeClass("selected");
      $(this).addClass("selected");
    }
  });
  $("#table tbody").on("click", "td.dt-control", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    console.log(row.data());
    if (row.child.isShown()) {
      // This row is already open - close it
      row.child.hide();
      tr.removeClass("shown");
    } else {
      // Open this row
      row.child(format(row.data())).show();
      tr.addClass("shown");
    }
  });
}
function loadTables() {
  var table = $("#table").DataTable({
    ordering: false,
    fixedHeader: true,
  });
}
function loadTablesSortable() {
  $("#table").DataTable({
    ordering: true,
    fixedHeader: true,
    footer: false,
  });
}
