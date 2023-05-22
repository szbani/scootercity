function format(d) {
    var kepek = "";
    try {
        if (d.images != null) {
            images = d.images.split(",");
            for (i = 0; i < images.length; i++) {
                kepek +=
                    '<img src="../media/products/' +
                    images[i] +
                    '" class="img-fluid img-table" alt="">';
            }
        } else {
            kepek =
                '<img src="../media/products/product-placeholder.png" class="img-fluid img-table" alt="">';
        }
    } catch {
        kepek =
            '<img src="../media/products/product-placeholder.png" class="img-fluid img-table" alt="">';
    }
    var menny = "";
    if (d.meretek != null) {
        meretek = d.meretek.split(",");
        for (i = 0; i < meretek.length; i++) {
            if (menny != "") menny += ", ";
            menny += meretek[i];
        }
    } else {
        menny = "0";
    }
    var tul = "";
    if (d.tulajdonsagok != null) {
        try {
            var json = JSON.parse(d.tulajdonsagok);
            $.each(json, function (id, value) {
                $.each(value, function (id, value) {
                    tul += id + ": " + value + ",&ensp;";
                });
            });
            tul = tul.slice(0, -7);
        } catch {
            tul = "nincs megadva tulajdonság.";
        }
    } else {
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
        "<td class='child-row'>Mennyiségek:</td>" +
        "<td>" +
        menny +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>leírás:</td>" +
        "<td>" +
        d.leiras +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Specifikációk:</td>" +
        "<td>" +
        tul +
        "</td>" +
        "</tr>" +
        "</table>" +
        "</div>"
    );
}

var childRows = null;
var inputFocus = false;
var table = $("#table").DataTable({});

function createTableTermekek() {
    table = $("#table").DataTable({
        scrollX: true,
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

        ajax: {
            url: "query/jsonQuery.php",
            dataSrc: "",
            data: {table: "termekek"},
            type: "POST",
        },
        columns: [
            {
                width: '2%',
                className: "dt-control",
                orderable: false,
                data: null,
                defaultContent: "",
            },
            {
                data: "id",
                width: "4%",
            },
            {
                data: "nev",
                width: "39%",
            },
            {
                data: "images",
                width: "5%",
                render: function (data, type, row) {
                    if (type === "display") {
                        var img = "product-placeholder.png";
                        if (data != null) img = data.split(",")[0];
                        return (
                            '<img src="../media/products/' +
                            img +
                            '" class="img-fluid img-table" alt=""> '
                        );
                    }
                    return data;
                },
            },
            {
                data: "ar",
                width: '8%',
            },
            {
                data: "learazas",
                width: '8%',
                render: function (data) {
                    if (data == null) return 'Nincs leárazva';
                    return data;
                }
            },
            {
                data: "knev",
                width: '10%',
            },
            {
                data: "markanev",
                width: '10%',
                render: function (data, type, row) {
                    if (data == null) return "Nincs megadva";
                    return data;
                },
            },
            {
                data: "mennyiseg",
                width: "5%",
                render: function (data, type, row) {
                    if (data == null) return 0;
                    return data;
                    // return (
                    //   '<input type="number" class="form-control table-input" id="' +
                    //   row.id +
                    //   '" value="' +
                    //   data +
                    //   '">'
                    // );
                },
            },
            {
                data: null,
                "width": "3%",
                className: "dt-center edit-images",
                defaultContent: '<i class="fa-solid fa-image"></i>',
                orderable: false,
            },
            {
                data: null,
                "width": "3%",
                className: "dt-center edit",
                defaultContent: '<i class="fa fa-pencil"/>',
                orderable: false,
            },
            {
                data: null,
                "width": "3%",
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
                        $("#modalSubmit").attr("name", "upload");
                        $("#modalSubmit").text("Feltöltés");
                        $("#modalTitle").text("Termék felvétele");
                        resetPics();
                    }
                },
            },
        ],
    });
    imageReorder("U_termekek.php");
    //edit data
    editTermekek();
    //delete data
    del("U_termekek.php");
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
    // $("#table tbody").on("focus", ".table-input", function () {
    //   // console.log("focus fired");
    //   var tr = $(this).closest("tr");
    //   var row = table.row(tr);
    //   inputFocus = true;
    // });
    // $("#table tbody").on("keypress", ".table-input", function (e) {
    //   if (e.which == 13) {
    //     var tr = $(this).closest("tr");
    //     var row = table.row(tr);
    //     //ajax
    //     $.ajax({
    //       type: "post",
    //       url: "query/U_termekek.php",
    //       data: { mennyId: row.data().id, mennyiseg: this.value },
    //       success: function (data) {
    //         createToast("Sikeres Módosítás", ["Új mennyiség: " + data], true);
    //       },
    //     });
    //   }
    // });
    // $("#table tbody").on("focusout", ".table-input", function () {
    //   // console.log("focusout fired");
    //   var tr = $(this).closest("tr");
    //   var row = table.row(tr);
    //   inputFocus = false;
    // });
    setInterval(function () {
        if (inputFocus == false) {
            tableReload(false);
        }
    }, 100000);
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

function tableReload(pics) {
    if (childRows == null) childRows = table.rows($(".shown"));
    table.ajax.reload(null, false);
    if (pics) resetPics();
}

function imageReorder(file) {
    var tr;
    var row;
    table.on("click", "td.edit-images", function (e) {
        e.preventDefault();
        tr = $(this).closest("tr");
        row = table.row(tr);
        $("#reorderModal").modal("show");
        $("#orderHidden").val(row.data().id);
        if (row.data().images != null)
            imageZone(row.data().images.split(","), file);
    });
    $("#reorder").on("submit", function (e) {
        e.preventDefault();
        let array = new Array();

        $(".image-zone")
            .children()
            .each(function () {
                array.push($(this).attr("src"));
            });

        if (array.length > 0) {
            $.ajax({
                type: "post",
                url: "query/" + file,
                data: {reorder: "", images: array},
                success: function (data) {
                    createToast(
                        "Sikeres Módosítás",
                        "Módosítottad (" +
                        row.data().id +
                        ")" +
                        row.data().nev +
                        " Terméket",
                        true
                    );
                },
            });
        }
        $("#reorderModal").modal("hide");
    });
    $("#reorderModal").on("hidden.bs.modal", function () {
        tableReload(true);
    });
}

function del(file) {
    var tr;
    var row;
    table.on("click", "td.delete", function (e) {
        e.preventDefault();
        if ($(this).children().length > 0) {
            tr = $(this).closest("tr");
            row = table.row(tr);
            $("#deleteModal").modal("show");
            $("#delId").text(row.data().id);
            $("#delNev").text(row.data().nev);
        }
    });
    $("#delete").on("submit", function (e) {
        e.preventDefault();
        $("#deleteModal").modal("hide");
        $.ajax({
            type: "POST",
            url: "query/" + file,
            dataType: "JSON",
            data: {delete: "", id: row.data().id, nev: row.data().nev},
            success: function (data) {
                var title = "Sikertelen törlés";
                if (data.success) title = "Sikeres törlés";
                createToast(title, data.messages, data.success);
                tableReload(false);
            },
            error: function (data) {
                console.log(data);
                createToast("Sikertelen törlés", [data], false);
            },
        });
    });
}

function editTermekek() {
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
        $("#inputMarka").val(row.data().marka);
        try {
            var json = JSON.parse(row.data().tulajdonsagok);
            var tulnevek = $('input[name="tul-nev[]"]');
            for (i = tulnevek.length; i < json.length; i++) {
                $(".add-row").trigger("click");
            }
            tulnevek = $('input[name="tul-nev[]"]');
            var tulertekek = $('input[name="tul-ertek[]"]');
            $.each(json, function (jsonid, value) {
                $.each(value, function (id, value) {
                    $(tulnevek[jsonid]).val(id);
                    $(tulertekek[jsonid]).val(value);
                });
            });
        } catch {
        }
        // atirni
        try {
            var json = row.data().meretek.split(",");
            var tulnevek = $('input[name="menny-nev[]"]');
            for (i = tulnevek.length; i < json.length; i++) {
                $(".add-menny").trigger("click");
            }
            tulnevek = $('input[name="menny-nev[]"]');
            var tulertekek = $('input[name="menny-ertek[]"]');
            $.each(json, function (jsonid, value) {
                value = value.split(":");
                $(tulnevek[jsonid]).val(value[0]);
                $(tulertekek[jsonid]).val(value[1]);
            });
        } catch {
        }
    });
}

function createTableLogs() {
    table = $("#table").DataTable({
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
            data: {table: "logs"},
            type: "POST",
        },
        columns: [
            {data: "id"},
            {data: "user"},
            {data: "action"},
            {data: "time"},
            {data: "ip"},
        ],
    });
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);
}

function createTableFiokok() {
    table = $("#table").DataTable({
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
            data: {table: "fiokok"},
            type: "POST",
        },
        columns: [
            {data: "id"},
            {data: "nev"},
            {data: "action"},
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
    del("U_fiokok.php");
    editFiokok();
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);
}

function editFiokok() {
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
    table = $("#table").DataTable({
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
            data: {table: "kategoriak"},
            type: "POST",
        },
        columns: [
            {data: "id"},
            {data: "nev"},
            {data: "hasznalva"},
            {
                data: "img",
                render: function (data, type, row) {
                    if (type === "display") {
                        if (data != null)
                            return (
                                '<img src="../media/main/' +
                                data +
                                '" class="img-fluid img-table" alt=""> '
                            );
                        else return "Nincs";
                    }
                    return data;
                },
            },
            {
                data: "subnev",
                render: function (data) {
                    if (data == null) return "nincs";
                    else return data;
                },
            },
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
    editKategoriak();
    del("U_kategoriak.php");
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);
}

function editKategoriak() {
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
        if (row.data().subkat == null) $("#inputKategoria").val('NULL');
        else
            $("#inputKategoria").val(row.data().subkat);
    });
}

function createTableMarkak() {
    table = $("#table").DataTable({
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
            data: {table: "markak"},
            type: "POST",
        },
        columns: [
            {data: "id"},
            {data: "nev"},
            {data: "hasznalva"},
            {
                data: "img",
                render: function (data, type, row) {
                    if (type === "display") {
                        if (data != null)
                            return (
                                '<img src="../media/main/' +
                                data +
                                '" class="img-fluid img-table" alt=""> '
                            );
                        else return "Nincs";
                    }
                    return data;
                },
            },
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
                text: "Új Márka",
                action: function (e, dt, node, config) {
                    $("#modal").modal("show");
                    if ($("#modalSubmit").attr("name") != "upload") {
                        $("#form").trigger("reset");
                        $("#modalSubmit").attr("name", "upload");
                        $("#modalSubmit").text("Feltöltés");
                        $("#modalTitle").text("Márka hozzáadása");
                    }
                },
            },
        ],
    });
    editMarkak();
    del("U_markak.php");
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 30000);
}

function editMarkak() {
    table.on("click", "td.edit", function (e) {
        e.preventDefault();
        var tr = $(this).closest("tr");
        var row = table.row(tr);
        $("#modalSubmit").attr("name", "edit");
        $("#modalSubmit").text("Szerkesztés");
        $("#modalTitle").text("Márka szerkesztése");
        $("#modal").modal("show");
        $("#form").trigger("reset");
        $("#inputId").val(row.data().id);
        $("#inputNev").val(row.data().nev);
    });
}


function destroyTable() {
    table.destroy();
}



