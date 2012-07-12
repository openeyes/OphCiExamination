$(document).ready(function() {

	/**
	 * Autoadjust height of textareas
	 */
	$('#event_display textarea.autosize').autosize();

	/**
	 * Save event
	 */
	$('#event_display').delegate('#et_save', 'click', function(e) {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			return true;
		}
		e.preventDefault();
	});

	/**
	 * Cancel event edit
	 */
	$('#event_display').delegate('#et_cancel', 'click', function(e) {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			if (m = window.location.href.match(/\/update\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/update/', '/view/');
			} else {
				window.location.href = '/patient/episodes/' + et_patient_id;
			}
		}
		e.preventDefault();
	});

	/**
	 * Delete event
	 */
	$('#event_display').delegate('#et_deleteevent', 'click', function(e) {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			$('#deleteForm').submit();
		}
		e.preventDefault();
	});

	/**
	 * Cancel event delete
	 */
	$('#event_display').delegate('#et_canceldelete', 'click', function(e) {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/delete/', '/view/');
			} else {
				window.location.href = '/patient/episodes/' + et_patient_id;
			}
		}
		e.preventDefault();
	});

	/**
	 * Add a macro
	 */
	$('#event_display').delegate('.textMacro', 'change', function() {
		text = $(this).val();
		$field = $('#' + $(this).attr('data-target-field'));
		if ($field.val()) {
			text = ', ' + text;
		} else {
			text = capitaliseFirstLetter(text);
		}
		$field.val($field.val() + text);
		$(this).val('');
	});

	function capitaliseFirstLetter(string) {
		return string.charAt(0).toUpperCase() + string.slice(1);
	}

	/**
	 * Add an optional element
	 */
	$('#inactive_elements').delegate('.element', 'click', function(e) {
		if (!$(this).hasClass('clicked')) {
			$(this).addClass('clicked');
			var element = $(this);
			var element_type_id = element.attr('data-element-type-id');
			var display_order = element.attr('data-element-display-order');
			$.get("/OphCiExamination/Default/ElementForm", {
				id : element_type_id,
				patient_id : et_patient_id,
			}, function(data) {
				var insert_before = $('#active_elements .element').first();
				while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
					insert_before = insert_before.nextAll('div:first');
				}
				element.remove();
				if (insert_before.length) {
					insert_before.before(data);
				} else {
					$('#active_elements').append(data);
				}
				$('#event_display textarea.autosize').autosize();
				var inserted = (insert_before.length) ? insert_before.prevAll('div:first') : $('#active_elements .element:last');
				var offTop = inserted.offset().top - 50;
				var speed = (Math.abs($(window).scrollTop() - offTop)) * 1.5;
				$('body').animate({ scrollTop: offTop }, speed, null, function() {
					$('.elementTypeName',inserted).effect('pulsate',{ times: 2 }, 600);
				});
			});
		}
		e.preventDefault();
	});

	/**
	 * Remove an optional element
	 */
	$('#active_elements').delegate('.removeElement button', 'click', function(e) {
		var element = $(this).closest('.element');
		var element_type_name = element.attr('data-element-type-name');
		var display_order = element.attr('data-element-display-order');
		element.html($('<h5>' + element_type_name + '</h5>'));
		var insert_before = $('#inactive_elements .element').first();
		while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
			insert_before = insert_before.next();
		}
		if (insert_before.length) {
			insert_before.before(element);
		} else {
			$('#inactive_elements').append(element);
		}
		e.preventDefault();
	});

	/**
	 * Populate description from eyedraw
	 */
	$('#event_display').delegate('.ed_report', 'click', function(e) {
		var element = $(this).closest('.element');

		// Get side (if set)
		var side = null;
		if ($(this).closest('[data-side]').length) {
			side = $(this).closest('[data-side]').attr('data-side');
		}

		// Get eyedraw js object
		var eyedraw = element.attr('data-element-type-id');
		if (side) {
			eyedraw = side + '_' + eyedraw;
		}
		eyedraw = window['ed_drawing_edit_' + eyedraw];

		// Get report text and strip trailing comma
		var text = eyedraw.report();
		text = text.replace(/, +$/, '');

		// Update description
		var description = 'description';
		if (side) {
			description = side + '_' + description;
		}
		description = $('textarea[name$="[' + description + ']"]', element).first();
		if (description.val()) {
			text = description.val() + ", " + text.toLowerCase();
		}
		description.val(text);
		description.trigger('autosize');

		// Update diagnosis
		var code = eyedraw.diagnosis();
		var diagnosis_id = 'diagnosis_id';
		if (side) {
			diagnosis_id = side + '_' + diagnosis_id;
		}
		diagnosis_id = $('input[name$="[' + diagnosis_id + ']"]', element).first();
		diagnosis_id.val(code);

		e.preventDefault();
	});

	/**
	 * Clear eyedraw
	 */
	$('#event_display').delegate('.ed_clear', 'click', function(e) {
		var element = $(this).closest('.element');

		// Get side (if set)
		var side = null;
		if ($(this).closest('[data-side]').length) {
			side = $(this).closest('[data-side]').attr('data-side');
		}

		// Get eyedraw js object
		var eyedraw = element.attr('data-element-type-id');
		if (side) {
			eyedraw = side + '_' + eyedraw;
		}
		eyedraw = window['ed_drawing_edit_' + eyedraw];

		// Reset eyedraw
		eyedraw.deleteAllDoodles();
		eyedraw.deselectDoodles();
		eyedraw.drawAllDoodles();

		e.preventDefault();
	});

});

// Global function to route eyedraw event to the correct element handler
function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle) {
		var element_type = $(_drawing.canvasParent).closest('.element').attr('data-element-type-class');
		if(typeof window['update'+element_type] === 'function') {
			window['update'+element_type](_drawing.selectedDoodle);
		}
	}
}
