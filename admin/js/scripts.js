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

$(document).on('click','a.link', function(e){
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

function del_btn(id){
    document.getElementById("del_id").innerHTML = id;
    document.getElementById('del_hidden').value = id;
}

//toast
function showToast(id){
    var toastLiveExample = document.getElementById(id)
    var toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
}


