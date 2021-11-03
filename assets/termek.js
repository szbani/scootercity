
/*function modal_show(clicked){
    $('#Termek_Neve').text($("#"+clicked.id+" #Param_Nev").text());
    $('#Termek_Ara').text($('#'+clicked.id+' #Param_Ar').text());
    
    $('#Termek_Raktar').attr('src', $('#'+clicked.id+' #Param_Raktar').attr('src'));
}*/
function modal_show(clicked){
    
    $.ajax({
        url: "/scootercity/parts/termek_modal.php",
        type: 'POST',
        data: {
            prod_name: clicked.id
        },
        success: function (result) {
    $('#termek_modal').replaceWith(result);
    $('#termek_modal').modal('show');
    swiper();
    $('select[name="colorpicker"]').simplecolorpicker({theme: 'fontawesome'});
    }
    })
}
function modal_c_change(szin){
    $.ajax({
        url:"/scootercity/parts/modal_change.php",
        type: 'post',
        data: {
            prod_szin: szin
        },
    success: function (result) {
        result = JSON.parse(result);
        var mennyiseg = result.mennyiseg;
        var kepek = result.kepek;
        var raktar = "/scootercity/media/products/termek_";
        
        if(mennyiseg > 2){raktar=raktar + 'ok.png';}
        else if(mennyiseg > 0){raktar=raktar + 'some.png';}
        else{raktar=raktar + 'cancel.png';}
        //raktar_status
        $('#raktar_status').attr('src', raktar);
        $('#kepek').html(kepek);
        $('#kepek1').html(kepek);
        $('#kepek2').html(kepek);
        }
    })
}





