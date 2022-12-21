/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

//ajax reload

$(document).on('click','a.nav-link', function(e){
    e.preventDefault();
    var pageURL=$(this).attr('href');
    
     history.pushState(null, '', pageURL);
      
     $.ajax({    
        type: "GET",
        url: "pageload.php", 
        data:{page:pageURL},            
        dataType: "html",                  
        success: function(data){ 
          
         $('#pageContent').html(data);    
         loadTables();       
        }
    });
 });

//modify
const sel = document.getElementById("md_select");
const inp = document.getElementById("inputcheck");

function modifyAll(id){
    scrollTo(top);
    document.getElementById("md_select").value = id;
    modif_switch_t();
}

function modif_switch(){
    if(sel.value == "")
        modif_switch_f();
    else
        modif_switch_t();
}

function modif_switch_f(){
    inp.checked = false;
    inp.disabled = true;
    sub_text();
}

function modif_switch_t(){
    inp.checked = true;
    inp.disabled = false;
    sub_text();
}
function sub_text(){
    if(inp.checked == true)
        document.getElementById("sub").textContent = "Módosit";
    else
        document.getElementById("sub").textContent = "Feltölt";;
}

function del_btn(id){
    document.getElementById("del_id").innerHTML = id;
    document.getElementById('del_hidden').value = id;
}

//success
function showSuccess(){
    var toastLiveExample = document.getElementById('successToast')
    var toastName = document.getElementById('succesName');
    toastName.textContent = document.getElementById('pageName').textContent;
    var toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
}


