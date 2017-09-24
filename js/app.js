$(document).foundation();


$(document).ready(function() {
	$('#faq-box').click(function() {
		$(this).each(function() {
			$('.faq-box-answer').slideToggle();
		});
	});
});