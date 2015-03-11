(function(){

	$('.click-row').click(function()
	{
		window.document.location = $(this).data('href');
	})

	$('tr').hover(
		function(){ $(this).addClass('info') },
		function(){ $(this).removeClass('info') }
	);

})();
