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
				window.location.href = baseUrl + '/patient/episodes/' + et_patient_id;
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
			return true;
		}
		e.preventDefault();
		return false;
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
				window.location.href = baseUrl + '/patient/episodes/' + et_patient_id;
			}
		}
		e.preventDefault();
	});

	/**
	 * Add all optional elements
	 */
	$('#optionals_all').delegate('#add-all', 'click', function(e) {
		$('#inactive_elements .element').each(function() {
			addElement(this, false);
		});
		e.preventDefault();
	});

	/**
	 * Add an optional element
	 */
	$('#inactive_elements').delegate('.element', 'click', function(e) {
		if (!$(this).hasClass('clicked')) {
			$(this).addClass('clicked');
			addElement(this);
		}
		e.preventDefault();
	});

	function addElement(element, animate) {
		if (typeof (animate) === 'undefined')
			animate = true;
		var element_type_id = $(element).attr('data-element-type-id');
		var display_order = $(element).attr('data-element-display-order');
		$.get(baseUrl + "/OphCiExamination/Default/ElementForm", {
			id : element_type_id,
			patient_id : et_patient_id,
		}, function(data) {
			var insert_before = $('#active_elements .element').first();
			while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
				insert_before = insert_before.nextAll('div:first');
			}
			$(element).remove();
			if (insert_before.length) {
				insert_before.before(data);
			} else {
				$('#active_elements').append(data);
			}
			$('#event_display textarea.autosize').autosize();
			var inserted = (insert_before.length) ? insert_before.prevAll('div:first') : $('#active_elements .element:last');
			if (animate) {
				var offTop = inserted.offset().top - 50;
				var speed = (Math.abs($(window).scrollTop() - offTop)) * 1.5;
				$('body').animate({
					scrollTop : offTop
				}, speed, null, function() {
					$('.elementTypeName', inserted).effect('pulsate', {
						times : 2
					}, 600);
				});
			}
		});
	}

	/**
	 * Remove all optional elements
	 */
	$('#optionals_all').delegate('#remove-all', 'click', function(e) {
		$('#active_elements .element').each(function() {
			removeElement(this);
		});
		e.preventDefault();
	});

	/**
	 * Remove an optional element
	 */
	$('#active_elements').delegate('.removeElement button', 'click', function(e) {
		var element = $(this).closest('.element');
		removeElement(element);
		e.preventDefault();
	});

	function removeElement(element) {
		var element_type_name = $(element).attr('data-element-type-name');
		var display_order = $(element).attr('data-element-display-order');
		$(element).html($('<h5>' + element_type_name + '</h5>'));
		var insert_before = $('#inactive_elements .element').first();
		while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
			insert_before = insert_before.next();
		}
		if (insert_before.length) {
			insert_before.before(element);
		} else {
			$('#inactive_elements').append(element);
		}
	}

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

	$('#event_display').delegate('.element input[name$="_pxe]"]', 'change', function() {
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		eyedraw.setParameterForDoodleOfClass('AntSeg', 'pxe', $(this).is(':checked'));
	});

	$(this).delegate('#event_content .Element_OphCiExamination_IntraocularPressure .iopReading', 'change', function() {
		OphCiExamination_IntraocularPressure_updateType(this);
	});

	$(this).delegate('#event_content .Element_OphCiExamination_IntraocularPressure .iopInstrument', 'change', function() {
		if (Element_OphCiExamination_IntraocularPressure_link_instruments) {
			$(this).closest('.element').find('.iopInstrument').val($(this).val());
		}
	});

	$('#event_display').delegate('.element input.axis', 'change', function() {
		var axis = $(this).val();
		axis = axis % 180;
		$(this).val(axis);
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		eyedraw.setParameterForDoodleOfClass('TrialLens', 'axis', axis);
	});

	$(this).delegate('#event_content .Element_OphCiExamination_Refraction .refractionType', 'change', function() {
		OphCiExamination_Refraction_updateType(this);
	});

	$('#event_display').delegate('.element .segmented select', 'change', function() {
		var field = $(this).nextAll('input');
		OphCiExamination_Refraction_updateSegmentedField(field);
	});

	$(this).delegate('#event_content .Element_OphCiExamination_VisualAcuity .removeReading', 'click', function(e) {
		$(this).closest('tr').remove();
		e.preventDefault();
	});
	
	$(this).delegate('#event_content .Element_OphCiExamination_VisualAcuity .addReading', 'click', function(e) {
		var side = $(this).closest('.data').attr('data-side');
		OphCiExamination_VisualAcuity_addReading(side);
		e.preventDefault();
	});
	
});

// Global function to route eyedraw event to the correct element handler
function eDparameterListener(drawing) {
	var doodle = null;
	if (drawing.selectedDoodle) {
		doodle = drawing.selectedDoodle;
	}
	var element_type = $(drawing.canvasParent).closest('.element').attr('data-element-type-class');
	if (typeof window['update' + element_type] === 'function') {
		window['update' + element_type](drawing, doodle);
	}
}

function updateElement_OphCiExamination_CataractAssessment(drawing, doodle) {
	var side = (drawing.eye == 0) ? 'right' : 'left';
	if (doodle) {
		switch (doodle.className) {
		case 'AntSeg':
			$('#Element_OphCiExamination_CataractAssessment_' + side + '_pupil').val(doodle.getParameter('grade'));
			break;
		case 'NuclearCataract':
			$('#Element_OphCiExamination_CataractAssessment_' + side + '_nuclear').val(doodle.getParameter('grade'));
			break;
		case 'CorticalCataract':
			$('#Element_OphCiExamination_CataractAssessment_' + side + '_cortical').val(doodle.getParameter('grade'));
			break;
		}
	}
}

function OphCiExamination_IntraocularPressure_updateType(field) {
	var type = $(field).closest('.data').find('.iopInstrument');
	if ($(field).val() == 1) {
		type.attr('disabled', 'disabled');
	} else {
		type.removeAttr('disabled');
	}
}

function OphCiExamination_IntraocularPressure_init() {
	$("#event_content .Element_OphCiExamination_IntraocularPressure .iopReading").each(function() {
		OphCiExamination_IntraocularPressure_updateType(this);
	});
}

function updateElement_OphCiExamination_PosteriorSegment(drawing, doodle) {
	if (doodle && doodle.className == 'PostPole') {
		var side = (drawing.eye == 0) ? 'right' : 'left';
		$('#Element_OphCiExamination_PosteriorSegment_' + side + '_cd_ratio').val(doodle.getParameter('cdRatio'));
	}
}

function OphCiExamination_Refraction_updateSegmentedField(field) {
	var parts = $(field).parent().children('select');
	var value = $(parts[0]).val() * (parseFloat($(parts[1]).val()) + parseFloat($(parts[2]).val()));
	$(field).val(value.toFixed(2));
}

function updateElement_OphCiExamination_Refraction(drawing, doodle) {
	if (doodle && doodle.className == 'TrialLens') {
		var side = (drawing.eye == 0) ? 'right' : 'left';
		$('#Element_OphCiExamination_Refraction_' + side + '_axis').val(doodle.getParameter('axis'));
	}
}

/**
 * Show other type field only if type is set to "Other"
 */
function OphCiExamination_Refraction_updateType(field) {
	var other = $(field).next();
	if ($(field).val() == '') {
		other.show();
	} else {
		other.val('');
		other.hide();
	}
}

function OphCiExamination_Refraction_init() {
	$("#event_content .Element_OphCiExamination_Refraction .refractionType").each(function() {
		OphCiExamination_Refraction_updateType(this);
	});
}

/**
 * Visual Acuity
 */

function OphCiExamination_VisualAcuity_getNextKey() {
	var keys = $('#event_content .Element_OphCiExamination_VisualAcuity .visualAcuityReading').map(function(index,el) {
		return parseInt($(el).attr('data-key'));
	}).get();
	return Math.max.apply(null,keys) + 1;
}

function OphCiExamination_VisualAcuity_addReading(side) {
	var template = $('#visualacuity_reading_template').html();
	var data = { "key": OphCiExamination_VisualAcuity_getNextKey(), "side": (side == 'right' ? 0 : 1) };
	var form = Mustache.render(template, data);
	$('#event_content .Element_OphCiExamination_VisualAcuity .[data-side="'+side+'"] tbody').append(form);
}

function OphCiExamination_VisualAcuity_init() {
}

