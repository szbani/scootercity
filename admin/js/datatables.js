function format(d) {
  // `d` is the original data object for the row
  var kepek = "";
  try {
    $.each(JSON.parse(d.kepek), function (id, value) {
      kepek +=
        '<img src="../media/products/' +
        value +
        '" class="img-fluid img-table" alt="">';
    });
  } catch {
    $kepek =
      '<img src="../media/products/product-placeholder.png" class="img-fluid img-table" alt="">';
  }
  var tul = "<label>";
  try {
    var json = JSON.parse(d.tulajdonsagok);
    $.each(json, function (id, value) {
      tul += id + ": " + value + ",&ensp;";
    });
    tul = tul.slice(0, -7);
    tul += "</label>";
  } catch {
    tul = "nincs megadva tulajdonság.";
  }
  return ('<div class="slider">' +
    '<table class="table" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    "<tr>" +
    "<td>További képek:</td>" +
    "<td>" +
    kepek +
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
    "<td>" +
    tul +
    "</td>" +
    "</tr>" +
    "</table>" +
    '</div>'
  );
}

function createTable() {
  var table = $("#table").DataTable({
    dom:
      '<"row"' +
      '<"col-sm-12 col-md-2"B>' +
      '<"col-sm-12 col-md-6"l>' +
      '<"col-sm-12 col-md-4"f>>' +
      "t" +
      '<"row"' +
      '<"col-sm-12 col-md-6"i>' +
      '<"col-sm-12 col-md-6"p>>',
    order: [[1, "desc"]],
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
    responsive: true,
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
          if (type === "display") {
            return (
              '<img src="../media/products/' +
              data +
              '" class="img-fluid img-table" alt=""> '
            );
          }
          return data;
        },
      },
      { data: "ar" },
      { data: "kat_nev" },
      {
        data: null,
        className: "dt-center editor-edit",
        defaultContent: '<i class="fa fa-pencil"/>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center editor-delete",
        defaultContent: '<i class="fa fa-trash"/>',
        orderable: false,
      },
    ],
    buttons: [
      {
        text: "Új termék",
        action: function (e, dt, node, config) {
          $('#modal').modal("show");
          $('#modalSubmit').attr('name', 'upload');
        },
      },
    ],
  });
  //edit data
  edit(table);
  //delete data
  del(table);
  //child row
  $("#table tbody").on("click", "td.dt-control", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    console.log(row.data());
    if (row.child.isShown()) {
      // This row is already open - close it
      $("div.slider", row.child()).slideUp(function () {
        row.child.hide();
        tr.removeClass("shown");
      });
    } else {
      // Open this row
      row.child(format(row.data()), "no-padding").show();
      tr.addClass("shown");
      $("div.slider", row.child()).slideDown();
    }
  });
}

//regi
function loadTables() {
  var table = $("#table").DataTable({
    ordering: false,
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
  });
}
function loadTablesSortable() {
  $("#table").DataTable({
    ordering: true,
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
  });
}
//regi vege

function del(table) {
  table.on("click", "td.editor-delete", function (e) {
    e.preventDefault();
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    $("#deleteModal").modal("show");
    $("#delId").text(table.cell(row, 1).data());
    $("#delNev").text(table.cell(row, 2).data());
    $("#delHidden").attr('value', table.cell(row, 1).data());
  });
}
function edit(table) {
  $(table).on("click", "td.editor-edit", function (e) {
    e.preventDefault();
    $('#modal').modal("show");
    $('#modalSubmit').attr('name', 'edit');
  });
}


// frissites idokozonkent
// setInterval(function () {
//       $('#example').DataTable().ajax.reload();
//   }, 10000);
//
//   setInterval( function () {
//
//       $.ajax ({
//               "url": "http://85.192.41.18:5000/getsixvar",
//               "type": "GET",
//               "dataType": "json",
//               "dataSrc": "data",
//               "csrfmiddlewaretoken": "{{ csrf_token }}",
//           success: function(result) {
//               document.getElementById('p1').innerHTML = result['p1'];
//               document.getElementById('p2').innerHTML = result['p2'];
//               console.log(result);
//               },
//           })
//       }, 5000);
