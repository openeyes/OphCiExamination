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

		// Update diagnoses
		var code = eyedraw.diagnosis();
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
					if (html.length > 0) {
						$('#OphCiExamination_diagnoses').append(html);
						$('#selected_diagnoses').append('<input type="hidden" name="selected_diagnoses[]" value="'+code+'">');
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
			$('#Element_OphCiExamination_PosteriorSegment_'+side+'_description').val('');
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
		if (!axis.match(/^[0-9]+$/)) {
			axis = 0;
		}
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
	
	$('#event_OphCiExamination').delegate('a.foster_images_link', 'click', function(e) {
		var side = $(this).closest('[data-side]').attr('data-side');
		$('.foster_images_dialog[data-side="'+side+'"]').dialog('open');
		e.preventDefault();
	});
	$('body').delegate('.foster_images_dialog area', 'click', function() {
		var value = $(this).attr('data-vh');
		var side = $(this).closest('[data-side]').attr('data-side');
		$(this).closest('.foster_images_dialog').dialog('close');
		$('#Element_OphCiExamination_Gonioscopy_'+side+'_van_herick_id option').attr('selected', function () {
			return ($(this).text() == value + '%');
		});		
	});

	$('#event_OphCiExamination').delegate('#event_content .opticCupToggle', 'click', function(e) {
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		var doodle = eyedraw.firstDoodleOfClass('OpticCup');
		doodle.toggleMode();
		//doodle.setHandleProperties();
		eyedraw.repaint();
		e.preventDefault();
	});

	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Risks #risks_unselected select', 'change', function(e) {
		var id = $(this).val();
		var text = $('option:selected', this).text();
		$('#risks_risks :not(:selected)').attr('selected', function () {
			return ($(this).val() == id);
		});
		$('option:selected', this).remove();
		$('#risks_selected').append('<li data-id="'+id+'"><span>'+text+'</span> <a href="" title="Remove Risk">-</a></li>');
		sort_ul($('#risks_selected'));
		e.preventDefault();
	});
	
	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Risks #risks_selected a', 'click', function(e) {
		var li = $(this).parent();
		var id = li.attr('data-id');
		var text = $('span',li).text();
		$('#risks_risks :selected').attr('selected', function () {
			return ($(this).val() != id);
		});
		li.remove();
		$('#risks_unselected select').append('<option value="'+id+'">'+text+'</option>');
		sort_selectbox($('#risks_unselected select'));
		e.preventDefault();
	});

});

function sort_ul(element) {
rootItem = element.children('li:first').text();
element.append(element.children('li').sort(selectSort));
}

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
			case 'NuclearCataract':
				$('#Element_OphCiExamination_AnteriorSegment_' + side + '_nuclear_id').val('');
				break;
		}
	}
}

function updateElement_OphCiExamination_Gonioscopy(drawing, doodle) {
	var side = (drawing.eye == 0) ? 'right' : 'left';
	if (doodle) {
		if (doodle.className == 'AngleGrade') {
			var position;
			switch(doodle.id) {
			case 1:
				position = 'sup';
				break;
			case 2:
				position = 'nas';
				break;
			case 3:
				position = 'tem';
				break;
			case 4:
				position = 'inf';
				break;
			}
			if (position) {
				var grade = doodle.getParameter('grade');
				var expert_options = $('#Element_OphCiExamination_Gonioscopy_' + side + '_gonio_' + position + '_id option');
				expert_options.attr('selected', function () {
					return ($(this).text() == grade);
				});
				OphCiExamination_Gonioscopy_updateBasic(side, position);
			}
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

	var eye_id = $('input[name="Element_OphCiExamination_Diagnoses[eye_id]"]:checked').val();
	var eye_text = $('input[name="Element_OphCiExamination_Diagnoses[eye_id]"]:checked').next('label');

	var checked_right = (eye_id == 2 ? 'checked="checked" ' : '');
	var checked_both = (eye_id == 3 ? 'checked="checked" ' : '');
	var checked_left = (eye_id == 1 ? 'checked="checked" ' : '');
	var checked_principal = (count == 0 ? 'checked="checked" ' : '');

	var row = '<tr><td>'+name+'</td><td><span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="2" '+checked_right+'/> Right</span> <span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="3" '+checked_both+'/> Both</span> <span class="OphCiExamination_eye_radio"><input type="radio" name="Element_OphCiExamination_Diagnoses[eye_id_'+id+']" value="1" '+checked_left+'/> Left</span></td><td><input type="radio" name="principal_diagnosis" value="'+disorder_id+'" '+checked_principal+'/></td><td><a href="#" class="small removeDiagnosis" rel="'+disorder_id+'"><strong>Remove</strong></a></td></tr>';

	$('#OphCiExamination_diagnoses').append(row);

	$('#selected_diagnoses').append('<input type="hidden" name="selected_diagnoses[]" value="'+disorder_id+'" />');
}

function OphCiExamination_Gonioscopy_init() {
	$('.gonioBasic').each(function () {
		var side = $(this).closest('div[data-side]').attr('data-side');
		var position = $(this).attr('data-position');
		OphCiExamination_Gonioscopy_updateBasic(side, position);
	});
	$(".foster_images_dialog").dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		width: 480
	});
}

function OphCiExamination_Gonioscopy_updateBasic(side, position) {
	var basic = $('#' + side + '_gonio_' + position + '_basic');
	var grade = $('#Element_OphCiExamination_Gonioscopy_' + side + '_gonio_' + position + '_id option:selected').text();
	if (grade == 'III' || grade == 'IV') {
		basic.val(0);
	} else {
		basic.val(1);
	}	
}

function OphCiExamination_Risks_init() {
	$('#risks_risks').hide();
	$('#risks_risks').parent().append($('<ul id="risks_selected"></ul>'));
	$('#risks_risks option:selected').each(function() {
		$('#risks_selected').append('<li data-id="' + $(this).val() + '"><span>' + $(this).text() + '</span> <a href="#" title="Remove Risk">-</a></li>');
	});
	$('#risks_risks').parent().append($('<div id="risks_unselected"><select><option value="">-- Add Risk --</option></select></div>'));
	$('#risks_risks option:not(:selected)').each(function() {
		$('#risks_unselected select').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
	});
}

function OphCiExamination_Risks_sort() {
	// TODO
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

$('#Element_OphCiExamination_AnteriorSegment_right_cortical_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_right_' + $(this).closest('.element').attr('data-element-type-id')];

	if ($(this).val() == 1) {
		eyedraw.deleteDoodlesOfClass('CorticalCataract');
	} else {
		var doodle = eyedraw.firstDoodleOfClass('CorticalCataract');
		if (!doodle) {
			eyedraw.addDoodle('CorticalCataract',"0",$('#Element_OphCiExamination_AnteriorSegment_right_cortical_id').children('option:selected').text());
		} else {
			doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_right_cortical_id').children('option:selected').text());
			eyedraw.repaint();
		}
	}
	return false;
});

$('#Element_OphCiExamination_AnteriorSegment_left_cortical_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_left_' + $(this).closest('.element').attr('data-element-type-id')];

	if ($(this).val() == 1) {
		eyedraw.deleteDoodlesOfClass('CorticalCataract');
	} else {
		var doodle = eyedraw.firstDoodleOfClass('CorticalCataract');
		if (!doodle) {
			eyedraw.addDoodle('CorticalCataract',"0",$('#Element_OphCiExamination_AnteriorSegment_left_cortical_id').children('option:selected').text());
		} else {
			doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_left_cortical_id').children('option:selected').text());
			eyedraw.repaint();
		}
	}
	return false;
});

$('#Element_OphCiExamination_AnteriorSegment_right_pupil_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_right_' + $(this).closest('.element').attr('data-element-type-id')];
	var doodle = eyedraw.firstDoodleOfClass('AntSeg');
	doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_right_pupil_id').children('option:selected').text());
	eyedraw.repaint();
	return false;
});

$('#Element_OphCiExamination_AnteriorSegment_left_pupil_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_left_' + $(this).closest('.element').attr('data-element-type-id')];
	var doodle = eyedraw.firstDoodleOfClass('AntSeg');
	doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_left_pupil_id').children('option:selected').text());
	eyedraw.repaint();
	return false;
});

$('#Element_OphCiExamination_AnteriorSegment_right_nuclear_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_right_' + $(this).closest('.element').attr('data-element-type-id')];

	if ($(this).val() == 1) {
		eyedraw.deleteDoodlesOfClass('NuclearCataract');
	} else {
		var doodle = eyedraw.firstDoodleOfClass('NuclearCataract');
		if (!doodle) {
			eyedraw.addDoodle('NuclearCataract',"0",$('#Element_OphCiExamination_AnteriorSegment_right_nuclear_id').children('option:selected').text());
		} else {
			doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_right_nuclear_id').children('option:selected').text());
			eyedraw.repaint();
		}
	}
	return false;
});

$('#Element_OphCiExamination_AnteriorSegment_left_nuclear_id').live('change',function() {
	var eyedraw = window['ed_drawing_edit_left_' + $(this).closest('.element').attr('data-element-type-id')];

	if ($(this).val() == 1) {
		eyedraw.deleteDoodlesOfClass('NuclearCataract');
	} else {
		var doodle = eyedraw.firstDoodleOfClass('NuclearCataract');
		if (!doodle) {
			eyedraw.addDoodle('NuclearCataract',"0",$('#Element_OphCiExamination_AnteriorSegment_left_nuclear_id').children('option:selected').text());
		} else {
			doodle.setParameter('grade',$('#Element_OphCiExamination_AnteriorSegment_left_nuclear_id').children('option:selected').text());
			eyedraw.repaint();
		}
	}
	return false;
});

$('.Element_OphCiExamination_Gonioscopy .gonioGrade').live('change',function() {
	var side = $(this).closest('div[data-side]').attr('data-side');
	var element_type_id = $(this).closest('.element').attr('data-element-type-id');
	var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
	var position = $(this).attr('data-position');
	switch(position) {
		case 'sup':
			doodle = eyedraw.doodleArray[1];
			break;
		case 'nas':
			doodle = eyedraw.doodleArray[2];
			break;
		case 'tem':
			doodle = eyedraw.doodleArray[3];
			break;
		case 'inf':
			doodle = eyedraw.doodleArray[4];
			break;
	}
	if($(this).hasClass('gonioBasic')) {
		var expert_options = $('#Element_OphCiExamination_Gonioscopy_' + side + '_gonio_' + position + '_id option');
		if($(this).val() == 0) {
			var grade = 'III';
		} else {
			var grade = 'O';
		}
		expert_options.attr('selected', function () {
			return ($(this).text() == grade);
		});		
	} else {
		var grade = $('option:selected', this).text();
		OphCiExamination_Gonioscopy_updateBasic(side, position);
	}
	doodle.setParameter('grade', grade);
	eyedraw.repaint();
	return false;
});
