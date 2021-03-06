$(document).ready(function(){
	$('[data-row]').click(function(e){
		var container = $(this).parent();
		$(container).prepend('<input type="text" placeholder="Param" id="row">');
		var input = $(container).find('#row');
		var path = $(this).attr('data-row');
		path = path.split('{');
		$(input).attr('data-url', path[0]);

		$(input).focus();

		$(input).on('blur', function(){
			$(this).remove();
		});

		$(input).on('keydown', function(e){
			if(e.keyCode == 13){
				var val = $(this).prop('value');
				var path = $(this).attr('data-url');

				$.get(document.location.origin + path + val, function(data){
					alert(data);
				});
			}

			if(e.keyCode == 27){
				$(this).remove();
			}
		});

		return false;
	});
});