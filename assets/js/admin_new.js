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
				'data': {
					order: ids,
					YII_CSRF_TOKEN: YII_CSRF_TOKEN
				},
				'success': function(data) {
					new OpenEyes.Dialog.Alert({
						content: 'Questions reordered'
					}).open();
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

	$('input.model_enabled').bind('change', function() {
		var model_id = $(this).parents('tr').data('attr-id');
		var model_name = $(this).parents('tr').data('attr-name');

		var enabled = 0;
		if ($(this).attr('checked')) {
			enabled = 1;
		}
		$.ajax({
			type: 'POST',
			url: OphCiExamination_model_status_url,
			data: {
				id: model_id,
				enabled: enabled,
				YII_CSRF_TOKEN: YII_CSRF_TOKEN
			},
			'success': function() {
				if (enabled) {
					new OpenEyes.Dialog.Alert({
						content: model_name + ' enabled'
					}).open();
				}
				else {
					new OpenEyes.Dialog.Alert({
						content: model_name + ' disabled'
					}).open();
				}
			}
		});
	});

});