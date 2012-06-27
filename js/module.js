$(document).ready(function() {

	/**
	 * Autoadjust height of textareas
	 */
	$('#event_display textarea.autosize').autosize();

	/**
	 * Save event
	 */
	$('#event_display').delegate('#et_save', 'click', function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			return true;
		}
		return false;
	});

	/**
	 * Cancel event edit
	 */
	$('#event_display').delegate('#et_cancel', 'click', function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			if (m = window.location.href.match(/\/update\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/update/', '/view/');
			} else {
				window.location.href = '/patient/episodes/' + et_patient_id;
			}
		}
		return false;
	});

	/**
	 * Delete event
	 */
	$('#event_display').delegate('#et_deleteevent', 'click', function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			$('#deleteForm').submit();
		}
		return false;
	});

	/**
	 * Cancel event delete
	 */
	$('#event_display').delegate('#et_canceldelete', 'click', function() {
		if (!$(this).hasClass('inactive')) {
			disableButtons();
			if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
				window.location.href = window.location.href.replace('/delete/', '/view/');
			} else {
				window.location.href = '/patient/episodes/' + et_patient_id;
			}
		}
		return false;
	});

	/**
	 * Add a macro
	 */
	$('#event_display').delegate('.textMacro', 'change', function() {
		text = $(this).val();
		$field = $('#' + $(this).attr('data-target-field'));
		if ($field.val()) {
			text = ', ' + text;
		}
		$field.val($field.val() + text);
		$(this).val('');
	});

	/**
	 * Add an optional element
	 */
	$('#inactive_elements').delegate('.addElement', 'click', function() {
		var element = $(this).closest('.element')
		var element_type_id = element.attr('data-element-type-id');
		var display_order = element.attr('data-element-display-order');
		$.get("/OphCiExamination/Default/ElementForm", {
			id : element_type_id,
		}, function(data) {
			var insert_before = $('#active_elements .element').first();
			while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
				insert_before = insert_before.next();
			}
			element.remove();
			if (insert_before.length) {
				insert_before.before(data);
			} else {
				$('#active_elements').append(data);
			}
			$('#event_display textarea.autosize').autosize();
		});
		return false;
	});

	/**
	 * Remove an optional element
	 */
	$('#active_elements').delegate('.removeElement', 'click', function() {
		var element = $(this).closest('.element');
		var element_type_name = element.attr('data-element-type-name');
		var display_order = element.attr('data-element-display-order');
		element.html($('<h5><a href="#" class="addElement">' + element_type_name + '</a></h5>'));
		var insert_before = $('#inactive_elements .element').first();
		while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
			insert_before = insert_before.next();
		}
		if (insert_before.length) {
			insert_before.before(element);
		} else {
			$('#inactive_elements').append(element);
		}
		return false;
	});

	/**
	 * Populate description from eyedraw
	 */
	$('#event_display').delegate('.ed_report', 'click', function() {
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

		return false;
	});

	/**
	 * Clear eyedraw
	 */
	$('#event_display').delegate('.ed_clear', 'click', function() {
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
		
		return false;
	});

});

function eDparameterListener(_drawing) {
	if (_drawing.selectedDoodle != null) {
		// handle event
	}
}
