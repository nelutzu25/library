$(function(){
	$('table .sterge').live('click', function(e) {
		e.preventDefault();
		$(this).addClass('selected');
		$('body').click();
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:240,
			modal: true,
			autoOpen: false,
			buttons: {
				"Sterge": function() {
					$( this ).dialog( "close" );
					window.location = $.data(this, 'href');
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		$( ".confirm" ).click(function() {
			$( "#dialog-confirm" ).dialog( "open" ).data('href', $(this).attr('data-load'));
		});
	});
});