$(document).ready(function()
{
	var open         = true;
	var timeline2    = $('#timeline-two');
	var timeline3    = $('#timeline-three');
	var timeline4    = $('#timeline-four');
	var timeline5    = $('#timeline-five');
	var timeline6    = $('#timeline-six');
	var normalHeight = 220;
	var maxHeight    = 345;
	var maxHeight2   = 355;
	var maxHeight3   = 245;
	var maxHeight4   = 465;
	var maxHeight5   = 230;

	timeline2.on('click', function()
	{
		if(open)
		{
			timeline2.animate({height: maxHeight}, 400);
			$('.timeline-two-content').fadeIn(500).css('display', 'normal');
			open = false;
		}
		else
		{
			timeline2.animate({height: normalHeight}, 400);
			$('.timeline-two-content').fadeOut(300, function()
			{
				$('.timeline-two-content').css('display', 'none');
			});
			open = true;
		}
	});

	timeline3.on('click', function()
	{
		if(open)
		{
			timeline3.animate({height: maxHeight2}, 400);
			$('.timeline-three-content').fadeIn(500).css('display', 'normal');
			open = false;
		}
		else
		{
			timeline3.animate({height: normalHeight}, 400);
			$('.timeline-three-content').fadeOut(300, function()
			{
				$('.timeline-three-content').css('display', 'none');
			});
			open = true;
		}
	});

	timeline4.on('click', function()
	{
		if(open)
		{
			timeline4.animate({height: maxHeight3}, 400);
			$('.timeline-four-content').fadeIn(500).css('display', 'normal');
			open = false;
		}
		else
		{
			timeline4.animate({height: normalHeight}, 400);
			$('.timeline-four-content').fadeOut(300, function()
			{
				$('.timeline-four-content').css('display', 'none');
			});
			open = true;
		}
	});

	timeline5.on('click', function()
	{
		if(open)
		{
			timeline5.animate({height: maxHeight4}, 400);
			$('.timeline-five-content').fadeIn(500).css('display', 'normal');
			open = false;
		}
		else
		{
			timeline5.animate({height: normalHeight}, 400);
			$('.timeline-five-content').fadeOut(300, function()
			{
				$('.timeline-five-content').css('display', 'none');
			});
			open = true;
		}
	});

	timeline6.on('click', function()
	{
		if(open)
		{
			timeline6.animate({height: maxHeight5}, 400);
			$('.timeline-six-content').fadeIn(500).css('display', 'normal');
			open = false;
		}
		else
		{
			timeline6.animate({height: normalHeight}, 400);
			$('.timeline-six-content').fadeOut(300, function()
			{
				$('.timeline-six-content').css('display', 'none');
			});
			open = true;
		}
	});
});