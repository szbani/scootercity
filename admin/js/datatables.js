function format(d) {
  var kepek = "";
  try {
    if (d.szkepek > 0) {
      for (i = 0; i < d.szkepek; i++) {
        kepek +=
          '<img src="../media/products/' +
          d.id +
          "-" +
          i +
          ".jpg" +
          '" class="img-fluid img-table" alt="">';
      }
    } else {
      kepek = "product-placeholder.png";
    }
  } catch {
    $kepek =
      '<img src="../media/products/product-placeholder.png" class="img-fluid img-table" alt="">';
  }
  var tul = "";
  try {
    var json = JSON.parse(d.tulajdonsagok);
    console.log(json);
    $.each(json, function (id, value) {
      $.each(value, function (id, value) {
        tul += id + ": " + value + ",&ensp;";
      });
    });
    tul = tul.slice(0, -7);
  } catch {
    tul = "nincs megadva tulajdonság.";
  }
  return (
    '<div class="slider">' +
    '<table class="table" cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
    "<tr>" +
    "<td class='child-row'>További képek:</td>" +
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
    "</div>"
  );
}

var childRows = null;
function createTableTermekek() {
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
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/hu.json",
    },
    responsive: true,
    ajax: {
      url: "query/jsonQuery.php",
      dataSrc: "",
      data: { table: "termekek" },
      type: "POST",
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
        data: "szkepek",
        render: function (data, type, row) {
          if (type === "display") {
            var img = "product-placeholder.png";
            if (data > 0) img = row.id + "-" + 0 + ".jpg";
            return (
              '<img src="../media/products/' +
              img +
              '" class="img-fluid img-table" alt=""> '
            );
          }
          return data;
        },
      },
      { data: "ar" },
      { data: "knev" },
      { data: "mennyiseg" },
      {
        data: null,
        className: "dt-center edit",
        defaultContent: '<i class="fa fa-pencil"/>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center delete",
        defaultContent: '<i class="fa fa-trash"/>',
        orderable: false,
      },
    ],
    buttons: [
      {
        text: "Új termék",
        action: function (e, dt, node, config) {
          $("#modal").modal("show");
          if ($("#modalSubmit").attr("name") != "upload") {
            $("#form").trigger("reset");
            console.log("if statement");
            $("#modalSubmit").attr("name", "upload");
            $("#modalSubmit").text("Feltöltés");
            $("#modalTitle").text("Termék felvétele");
            resetPics();
          }
        },
      },
    ],
  });
  //edit data
  editTermekek(table);
  //delete data
  del(table);
  //child row
  $("#table tbody").on("click", "td.dt-control", function () {
    var tr = $(this).closest("tr");
    var row = table.row(tr);
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

  setInterval(function () {
    childRows = table.rows($(".shown"));
    table.ajax.reload(null, false);
  }, 30000);
  table.on("draw", function () {
    // If reloading table then show previously shown rows
    if (childRows) {
      childRows.every(function (rowIdx, tableLoop, rowLoop) {
        d = this.data();
        this.child($(format(d))).show();
        this.nodes().to$().addClass("shown");
        $("div.slider", this.child()).slideDown();
      });

      // Reset childRows so loop is not executed each draw
      childRows = null;
    }
  });
}

function del(table) {
  table.on("click", "td.delete", function (e) {
    e.preventDefault();
    if ($(this).children().length > 0) {
      var tr = $(this).closest("tr");
      var row = table.row(tr);
      $("#deleteModal").modal("show");
      $("#delId").text(row.data().id);
      $("#delNev").text(row.data().nev);
      $("#delHidden").attr("value", row.data().id);
    }
  });
}
function editTermekek(table) {
  table.on("click", "td.edit", function (e) {
    e.preventDefault();
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    $("#modalSubmit").attr("name", "edit");
    $("#modalSubmit").text("Szerkesztés");
    $("#modalTitle").text("Termék szerkesztése");
    $("#modal").modal("show");
    $("#form").trigger("reset");
    resetPics();
    $("#inputId").val(table.cell(row, 1).data());
    $("#inputNev").val(table.cell(row, 2).data());
    $("#inputAr").val(table.cell(row, 4).data());
    $("#inputMennyiseg").val(table.cell(row, 6).data());
    $("#inputLeiras").val(row.data().leiras);
    $("#inputKategoria").val(row.data().kategoria);
    if (row.data().szkepek > 0) {
      var output = $(".preview-images-zone");
      var html = "";
      for (i = 0; i < row.data().szkepek; i++) {
        html =
          '<div id="' +
          i +
          '"class="preview-image preview-show-' +
          i +
          '">' +
          '<div class="image-cancel" data-no="' +
          i +
          '">x</div>' +
          '<div class="image-zone"><img id="pro-img-' +
          i +
          '"src="../media/products/' +
          row.data().id +
          "-" +
          i +
          ".jpg" +
          '"></div>';

        output.append(html);

        var url = getBase64Image(
          "../media/products/" + row.data().id + "-" + i + ".jpg"
        );
        var blob = dataURItoBlob(url);
        var fd = new FormData();
        fd.append("file", blob, "tempFile-" + i);
        var temp = new DataTransfer();
        temp.items.add(fd.get("file"));
        num = i;
        var input = document.createElement("input");
        input.type = "file";
        input.name = "images[]";
        input.hidden = true;
        input.files = temp.files;
        $(".preview-show-" + i).append(input);
      }
    }
    try {
      var json = JSON.parse(row.data().tulajdonsagok);
      var tulnevek = $('input[name="tul-nev[]"]');
      var tulertekek = $('input[name="tul-ertek[]"]');
      for (i = tulnevek.length; i < json.length; i++) {
        $(".add-row").trigger("click");
      }
      $.each(json, function (jsonid, value) {
        $.each(value, function (id, value) {
          $(tulnevek[jsonid]).val(id);
          $(tulertekek[jsonid]).val(value);
        });
      });
    } catch {}
  });
}

function createTableLogs() {
  var table = $("#table").DataTable({
    order: [[0, "desc"]],
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
    responsive: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/hu.json",
    },
    ajax: {
      url: "query/jsonQuery.php",
      dataSrc: "",
      data: { table: "logs" },
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "user" },
      { data: "action" },
      { data: "time" },
      { data: "ip" },
    ],
  });
  setInterval(function () {
    table.ajax.reload(null, false);
  }, 30000);
}

function createTableFiokok() {
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
    order: [[1, "asc"]],
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/hu.json",
    },
    responsive: true,
    ajax: {
      url: "query/jsonQuery.php",
      dataSrc: "",
      data: { table: "fiokok" },
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "email" },
      { data: "action" },
      {
        data: "edit",
        className: "dt-center edit",
        orderable: false,
      },
      {
        data: "delete",
        className: "dt-center delete",
        orderable: false,
      },
    ],
    buttons: [
      {
        text: "Új fiók",
        action: function (e, dt, node, config) {
          $("#modal").modal("show");
          if ($("#modalSubmit").attr("name") != "upload") {
            $("#form").trigger("reset");
            console.log("if statement");
            $("#modalSubmit").attr("name", "upload");
            $("#modalTitle").text("Fiók hozzáadása");
            $("#inputEmail").attr("readonly", false);
          }
        },
      },
    ],
  });
  del(table);
  editFiokok(table);
  setInterval(function () {
    table.ajax.reload(null, false);
  }, 30000);
}

function editFiokok(table) {
  table.on("click", "td.edit", function (e) {
    e.preventDefault();
    if ($(this).children().length > 0) {
      var tr = $(this).closest("tr");
      var row = table.row(tr);
      $("#modalSubmit").attr("name", "edit");
      $("#modalSubmit").text("Szerkesztés");
      $("#modalTitle").text("Fiók szerkesztése");
      $("#modal").modal("show");
      $("#form").trigger("reset");
      $("#inputId").val(row.data().id);
      $("#inputEmail").val(row.data().email);
      $("#inputEmail").attr("readonly", true);
    }
  });
}

function createTableKategoriak() {
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
    order: [[1, "asc"]],
    fixedHeader: {
      header: true,
      headerOffset: $("#navbar").outerHeight(true),
    },
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.1/i18n/hu.json",
    },
    responsive: true,
    ajax: {
      url: "query/jsonQuery.php",
      dataSrc: "",
      data: { table: "kategoriak" },
      type: "POST",
    },
    columns: [
      { data: "id" },
      { data: "nev" },
      { data: "hasznalva" },
      {
        data: null,
        className: "dt-center edit",
        defaultContent: '<i class="fa fa-pencil"/>',
        orderable: false,
      },
      {
        data: null,
        className: "dt-center delete",
        defaultContent: '<i class="fa fa-trash"/>',
        orderable: false,
      },
    ],
    buttons: [
      {
        text: "Új kategória",
        action: function (e, dt, node, config) {
          $("#modal").modal("show");
          if ($("#modalSubmit").attr("name") != "upload") {
            $("#form").trigger("reset");
            $("#modalSubmit").attr("name", "upload");
            $("#modalSubmit").text("Feltöltés");
            $("#modalTitle").text("Kategória hozzáadása");
          }
        },
      },
    ],
  });
  editKategoriak(table);
  del(table);
  setInterval(function () {
    table.ajax.reload(null, false);
  }, 30000);
}

function editKategoriak(table) {
  table.on("click", "td.edit", function (e) {
    e.preventDefault();
    var tr = $(this).closest("tr");
    var row = table.row(tr);
    $("#modalSubmit").attr("name", "edit");
    $("#modalSubmit").text("Szerkesztés");
    $("#modalTitle").text("Kategória szerkesztése");
    $("#modal").modal("show");
    $("#form").trigger("reset");
    $("#inputId").val(row.data().id);
    $("#inputNev").val(row.data().nev);
  });
}
