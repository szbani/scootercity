window.addEventListener("DOMContentLoaded", (event) => {
  // Simple-DataTables
  // https://github.com/fiduswriter/Simple-DataTables/wiki

  
});

function loadTables() {
  const datatablesSimple = document.getElementsByTagName("table");
  if (datatablesSimple) {
    for (const table of datatablesSimple) {
      new simpleDatatables.DataTable(table, {
        sortable: false,
      });
    }
  }
}
function loadTablesSortable() {
  const datatablesSimple = document.getElementsByTagName("table");
  if (datatablesSimple) {
    for (const table of datatablesSimple) {
      new simpleDatatables.DataTable(table, {
        sortable: true,

        
      });
    }
  }
}
