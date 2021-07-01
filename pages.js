//pages
$(document).ready(function() {
    $("#sidebarMenu a.nav-link").click(function(){
        $("#sidebarMenu a.nav-link.active").removeClass('active');
        $(this).addClass('active');
        $("#body").load("sec_pages/"+$(this).attr('id')+".php #body");
        
    });
  });

$(document).ready(function() {
    var pageURL = $(location).attr("hash");
        pageURL =  pageURL.replace('#','');
    if(pageURL != ''){
        $("#body").load("sec_pages/"+pageURL+".php #body");
        $("a.nav-link.active").removeClass('active');
        $('#'+pageURL).addClass('active');
    }else{
        $("#body").load("sec_pages/dashboard.php #body");
    }
        
});

//form navbar(edit)
/*$(document).ready(function(){
    $('#editTab a.nav-link').click(function(){
        $("#editTab a.nav-link.active").removeClass('active');
        $(this).addClass('active');
        $("#tabEditContent div.tab-pane.active input").val("");
        $("#tabEditContent div.tab-pane.active").removeClass("active");
        clicked = this.replace('-tab', '');
        $("#"+clicked).addClass('active');
        $("#"+clicked+ "input").attr('disabled', false);
    });
});*/

$(document).ready(function(){
    $('#editTabContent img.image-md').click(function () {
        $('#tabEditContent img.image-md.select').removeClass('select');
        $(this).addClass('select');
        $(this + ' #fileToSelect').val(this);
      })
});

//form navbar(upload)
function nav_switch(clicked){
    $("#tabContent div.tab-pane.active input").val("");
    clicked = clicked.replace('-tab','');
    $("#"+clicked).addClass('active');
    $("#"+clicked+ "input").attr('disabled', false);

}

function fileToSelect(clicked){
    $("#tabContent img.image-md.select").removeClass('select');
    //$('#'+clicked).addClass('select');
    $("#tabContent #fileToSelect").val(clicked);

}