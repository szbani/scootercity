$(document).ready(function () {
    $('#navbar').removeClass('sticky-top');
    $('#navbar').addClass('fixed-top');
});

function modal_show(clicked){
    $('#Termek_Neve').text($("#"+clicked.id+" #Param_Nev").text());
    
}

//#termek_modal