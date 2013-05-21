$(document).ready(function() {

	$('.sortable').sortable({
		update: function(event, ui) {
			var ids = [];
			$('div.sortable').children('li').map(function() {
				ids.push($(this).attr('data-attr-id'));
			});
			$.ajax({
				'type': 'POST',
				'url': OphCiExamination_sort_url,
				'data': {order: ids},
				'success': function(data) {
					alert('Questions reordered');
				}
			});
			
		}
	});
	
	$('#question_disorder').bind('change', function() {
		did = $(this).val();
		if (did) {
			window.location.href = URI(window.location.href).setSearch('disorder_id',did);
		}
	});
	
});