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

	$('#et_print').unbind('click').click(function() {
		window.print_iframe.print();
		return false;
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

		var max_id = -1;
		var count = 0;
		var already_in_list = false;
		var list_eye_id = null;
		var existing_id = null;

		$('#OphCiExamination_diagnoses').children('tr').map(function() {
			var id = parseInt($(this).children('td:nth-child(2)').children('span:nth-child(1)').children('input').attr('name').match(/[0-9]+/));
			if (id >= max_id) {
				max_id = id;
			}
			count += 1;

			if ($(this).children('td:nth-child(4)').children('a:first').attr('rel') == code) {
				already_in_list = true;
				list_eye_id = $('input[name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']"]:checked').val();
				existing_id = id;
			}
		});

		if (already_in_list) {
			var side_n = side == 'right' ? 2 : 1;

			if ((side_n == 1 && list_eye_id == 2) || (side_n == 2 && list_eye_id == 1)) {
				$('input[name="Element_OphCiExamination_Diagnoses[eye_id_'+existing_id+']"][value="3"]').attr('checked','checked');
			}

		} else {
			var id = max_id + 1;

			$.ajax({
				'type': 'GET',
				'url': baseUrl+'/OphCiExamination/default/getDisorderTableRow?disorder_id='+code+'&side='+side+'&id='+id,
				'success': function(html) {
					if (html.length >0) {
						$('#OphCiExamination_diagnoses').append(html);
					}
				}
			});
		}

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

		if (element.attr('data-element-type-name') == 'Anterior Segment') {
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_pupil_id').val('');
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_nuclear_id').val('');
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_cortical_id').val('');
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_description').val('');
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_pxe').attr('checked',false);
			$('#Element_OphCiExamination_AnteriorSegment_'+side+'_phako').attr('checked',false);

			eyedraw.setParameterForDoodleOfClass('AntSeg', 'pxe', false);
		}

		if (element.attr('data-element-type-name') == 'Posterior Segment') {
			$('#Element_OphCiExamination_PosteriorSegment_'+side+'_cd_ratio_id').val(5);
			$('#Element_OphCiExamination_PosteriorSegment_right_description').val('');
		}

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
		var block = $(this).closest('.data');
		$(this).closest('tr').remove();
		if ($('tbody', block).children('tr').length == 0) {
			$('.noReadings', block).show();
			$('table', block).hide();
		}
		e.preventDefault();
	});

	$(this).delegate('#event_content .Element_OphCiExamination_VisualAcuity .addReading', 'click', function(e) {
		var side = $(this).closest('.side').attr('data-side');
		OphCiExamination_VisualAcuity_addReading(side);
		e.preventDefault();
	});

	$(this).delegate('#event_content .side .activeForm a.removeSide', 'click', function(e) {
		
		// Update side field to indicate other side
		var side = $(this).closest('.side');
		var side_field = $(this).closest('.element').find('input.sideField');
		if(side.attr('data-side') == 'left') {
			side_field.val(2); // Right
		} else {
			side_field.val(1); // Left
		}
		
		// If other side is already inactive, then activate it (can't have both sides inactive
		$(this).closest('.element').find('.side').removeClass('inactive');
		
		// Make this side inactive
		side.addClass('inactive');
		
		e.preventDefault();
	});

	$(this).delegate('#event_content .side .inactiveForm a', 'click', function(e) {
		$(this).closest('.element').find('input.sideField').val(3); // Both eyes
		$(this).closest('.side').removeClass('inactive');
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

function updateElement_OphCiExamination_AnteriorSegment(drawing, doodle) {
	var side = (drawing.eye == 0) ? 'right' : 'left';
	if (doodle) {
		switch (doodle.className) {
		case 'AntSeg':
			$('#Element_OphCiExamination_AnteriorSegment_' + side + '_pupil_id option:contains(' + doodle.getParameter('grade') + ')').attr('selected',true);
			break;
		case 'NuclearCataract':
			$('#Element_OphCiExamination_AnteriorSegment_' + side + '_nuclear_id option:contains(' + doodle.getParameter('grade') + ')').attr('selected',true);
			break;
		case 'CorticalCataract':
			$('#Element_OphCiExamination_AnteriorSegment_' + side + '_cortical_id option:contains(' + doodle.getParameter('grade') + ')').attr('selected',true);
			break;
		}
	}

	if (drawing.deletedDoodle) {
		switch (drawing.deletedDoodle) {
			case 'CorticalCataract':
				$('#Element_OphCiExamination_AnteriorSegment_' + side + '_cortical_id').val('');
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
		$('#Element_OphCiExamination_PosteriorSegment_' + side + '_cd_ratio_id option:contains(' + doodle.getParameter('cdRatio') + ')').attr('selected',true);
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
	var keys = $('#event_content .Element_OphCiExamination_VisualAcuity .visualAcuityReading').map(function(index, el) {
		return parseInt($(el).attr('data-key'));
	}).get();
	return Math.max.apply(null, keys) + 1;
}

function OphCiExamination_VisualAcuity_addReading(side) {
	var template = $('#visualacuity_reading_template').html();
	var data = {
		"key" : OphCiExamination_VisualAcuity_getNextKey(),
		"side" : (side == 'right' ? 0 : 1),
	};
	var form = Mustache.render(template, data);
	$('#event_content .Element_OphCiExamination_VisualAcuity .[data-side="' + side + '"] .noReadings').hide();
	var table = $('#event_content .Element_OphCiExamination_VisualAcuity .[data-side="' + side + '"] table');
	table.show();
	var nextMethodId = OphCiExamination_VisualAcuity_getNextMethodId(side);
	$('tbody', table).append(form);
	$('.method_id', table).last().val(nextMethodId);
}

/**
 * Which method ID to preselect on newly added readings.
 * Returns the next unused ID.
 * @param side
 * @returns integer
 */
function OphCiExamination_VisualAcuity_getNextMethodId(side) {
	var method_ids = OphCiExamination_VisualAcuity_method_ids;
	$('#event_content .Element_OphCiExamination_VisualAcuity .[data-side="' + side + '"] .method_id').each(function() {
		var method_id = $(this).val();
		method_ids = $.grep(method_ids, function(value) {
			return value != method_id;
		});
	});
	return method_ids.shift();
}

function OphCiExamination_VisualAcuity_init() {
}

function OphCiExamination_AddDiagnosis(disorder_id, name) {
	var max_id = -1;
	var count = 0;

	$('#OphCiExamination_diagnoses').children('tr').map(function() {
		var id = parseInt($(this).children('td:nth-child(2)').children('span:nth-child(1)').children('input').attr('name').match(/[0-9]+/));
		if (id >= max_id) {
			max_id = id;
		}
		count += 1;
	});

	var id = max_id + 1;

	var eye_id = $('input[name="eye_id"]:checked').val();
	var eye_text = $('input[name="eye_id"]:checked').next('label');

	var checked_right = (eye_id == 2 ? 'checked="checked" ' : '');
	var checked_both = (eye_id == 3 ? 'checked="checked" ' : '');
	var checked_left = (eye_id == 1 ? 'checked="checked" ' : '');
	var checked_principal = (count == 0 ? 'checked="checked" ' : '');

	var row = '<tr><td>'+name+'</td><td><span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="2" '+checked_right+'/> Right</span> <span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="3" '+checked_both+'/> Both</span> <span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="1" '+checked_left+'/> Left</span></td><td><input type="radio" name="principal_diagnosis" value="'+disorder_id+'" '+checked_principal+'/></td><td><a href="#" class="small removeDiagnosis" rel="'+disorder_id+'"><strong>Remove</strong></a></td></tr>';

	$('#OphCiExamination_diagnoses').append(row);

	$('#selected_diagnoses').append('<input type="hidden" name="selected_diagnoses[]" value="'+disorder_id+'" />');
}

$('a.removeDiagnosis').live('click',function() {
	var disorder_id = $(this).attr('rel');
	var new_principal = false;

	if ($('input[name="principal_diagnosis"]:checked').val() == disorder_id) {
		new_principal = true;
	}

	$('#selected_diagnoses').children('input').map(function() {
		if ($(this).val() == disorder_id) {
			$(this).remove();
		}
	});

	$(this).parent().parent().remove();

	if (new_principal) {
		$('input[name="principal_diagnosis"]:first').attr('checked','checked');
	}

	$.ajax({
		'type': 'GET',
		'url': baseUrl+'/disorder/iscommonophthalmic/'+disorder_id,
		'success': function(html) {
			if (html.length >0) {
				$('#DiagnosisSelection_disorder_id').append(html);
				sort_selectbox($('#DiagnosisSelection_disorder_id'));
			}
		}
	});

	return false;
});
