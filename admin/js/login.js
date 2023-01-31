(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$("togglePassword").click(function() {
		console.log("asd");
	  $(this).toggleClass("fa-eye fa-eye-slash");
	  var input = $($(this).attr("toggle"));
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
	});

})(jQuery);

function showPw(ob){
	$(ob).toggleClass("fa-eye fa-eye-slash");
	  var input = $("#password-field");
	  if (input.attr("type") == "password") {
	    input.attr("type", "text");
	  } else {
	    input.attr("type", "password");
	  }
}

var toastnumber = 0;
function createToast(title, messages, success) {
  var text = "<strong>";
  if (Array.isArray(messages)) {
    $.each(messages, function (key, value) {
      if (key != 0) text += "<br>";
      text += value;
    });
  }else text += messages;
  text += "</strong>";

  var type = "bg-danger";
  if (success == true) type = "bg-success";

  var toast =
    '<div id="toast-' +
    toastnumber +
    '" class="toast" role="alert" aria-live="assertive" aria-atomic="true">' +
    '<div class="toast-header ' +
    type +
    ' text-white">' +
    '<strong class="me-auto" id="succesName">' +
    title +
    "</strong>" +
    '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>' +
    "</div>" +
    '<div class="toast-body">' +
    text +
    "</div>" +
    "</div>";
  $(".toast-container").append(toast);
  var t = new bootstrap.Toast($("#toast-" + toastnumber));
  t.show();
  toastnumber++;
}
