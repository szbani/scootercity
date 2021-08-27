$(document).ready(function () {
    $('#navbar').removeClass('sticky-top');
    $('#navbar').addClass('fixed-top');
});

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
