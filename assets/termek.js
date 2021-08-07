$(document).ready(function () {
    $('#navbar').removeClass('sticky-top');
    $('#navbar').addClass('fixed-top');
});

function modal_show(clicked){
    $('#Termek_Neve').text($("#"+clicked.id+" #Param_Nev").text());
    $('#Termek_Ara').text($('#'+clicked.id+' #Param_Ar').text());
    
    $('#Termek_Raktar').attr('src', $('#'+clicked.id+' #Param_Raktar').attr('src'));
}

//#termek_modal