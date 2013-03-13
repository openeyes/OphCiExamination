/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

$(document).ready(function() {

	/**
	 * Save event
	 */
	handleButton($('#et_save'));

	handleButton($('#et_print'),function(e) {
		OphCiExamination_do_print();
		e.preventDefault();
	});

	/**
	 * Delete event
	 */
	handleButton($('#et_deleteevent'));

	/**
	 * Cancel event delete
	 */
	handleButton($('#et_canceldelete'),function(e) {
		if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
			window.location.href = window.location.href.replace('/delete/', '/view/');
		} else {
			window.location.href = baseUrl + '/patient/episodes/' + OE_patient_id;
		}
		e.preventDefault();
	});

	$('#event_display').delegate('#Element_OphCiExamination_GlaucomaRisk_risk_id', 'change', function(e) {
		// Update Clinic Outcome follow up
		var clinic_outcome_element = $('#active_elements .Element_OphCiExamination_ClinicOutcome');
		if(clinic_outcome_element.length) {
			var template_id = $('option:selected', this).attr('data-clinicoutcome-template-id');
			OphCiExamination_ClinicOutcome_LoadTemplate(template_id);
		}
		
		// Change colour of dropdown background
		$('.Element_OphCiExamination_GlaucomaRisk .risk_wrapper').attr('class', 'risk_wrapper ' + $('option:selected', this).attr('class'));
	});
	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_GlaucomaRisk a.descriptions_link', 'click', function(e) {
		$('#Element_OphCiExamination_GlaucomaRisk_descriptions').dialog('open');
		e.preventDefault();
	});
	$('body').delegate('#Element_OphCiExamination_GlaucomaRisk_descriptions a', 'click', function(e) {
		var value = $(this).attr('data-risk-id');
		$('#Element_OphCiExamination_GlaucomaRisk_descriptions').dialog('close');
		$('#Element_OphCiExamination_GlaucomaRisk_risk_id').val(value).trigger('change');
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

		// Clear inputs marked as clearWithEyedraw
		if(side) {
			var element_or_side = $(this).closest('.side');			
		} else {
			var element_or_side = element;
		}
		$('.clearWithEyedraw',element_or_side).each(function() {
			if($(this).is(':checkbox')) {
				$(this).attr('checked', false);
			} else {
				$(this).val('');
			}
			$(this).trigger('change');
		})
		
		e.preventDefault();
	});

	$('#event_display').delegate('.element input[name$="_pxe]"]', 'change', function() {
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		eyedraw.setParameterForDoodleOfClass('AntSeg', 'pxe', $(this).is(':checked'));
	});

	$(this).delegate('#event_content .Element_OphCiExamination_Refraction .refractionType', 'change', function() {
		OphCiExamination_Refraction_updateType(this);
	});

	$('#event_display').delegate('.element .segmented select', 'change', function() {
		var field = $(this).nextAll('input');
		OphCiExamination_Refraction_updateSegmentedField(field);
	});

	$(this).delegate('#event_content .Element_OphCiExamination_IntraocularPressure .iopInstrument', 'change', function() {
		if (Element_OphCiExamination_IntraocularPressure_link_instruments) {
			$(this).closest('.element').find('.iopInstrument').val($(this).val());
		}
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
		
		var remove_physical_side = 'left';
		var show_physical_side = 'right';
		
		var eye_side = 1;
		if(side.attr('data-side') == 'left') {
			eye_side = 2; // Right
			remove_physical_side = 'right';
			show_physical_side = 'left';
		} 
		
		$(this).closest('.element').find('input.sideField').each(function() {
			$(this).val(eye_side);
		});
		
		// If other side is already inactive, then activate it (can't have both sides inactive)
		$(this).closest('.element').find('.side.'+show_physical_side).removeClass('inactive');
		
		// Make this side inactive
		$(this).closest('.element').find('.side.'+remove_physical_side).addClass('inactive');
		
		e.preventDefault();
	});

	$(this).delegate('#event_content .side .inactiveForm a', 'click', function(e) {
		var element = $(this).closest('.element'); 
		element.find('input.sideField').each(function() {
			$(this).val(3); // Both eyes
		});
		
		element.find('.side').removeClass('inactive');
		
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
		$('.foster_images_dialog[data-side="'+side+'"]').dialog('close');
		$('#Element_OphCiExamination_Gonioscopy_'+side+'_van_herick_id option').attr('selected', function () {
			return ($(this).text() == value + '%');
		});		
	});

	/**
	 * Update gonioExpert when gonioBasic is changed (gonioBasic controls are not stored in DB)
	 */
	$('body').delegate('.gonioBasic', 'change', function(e) {
		var position = $(this).attr('data-position');
		var expert = $(this).closest('.side').find('.gonioExpert[data-position="'+position+'"]');
		if($(this).val() == 0) {
			$('option',expert).attr('selected', function () {
				return ($(this).attr('data-value') == 'III');
			});
		} else {
			$('option',expert).attr('selected', function () {
				return ($(this).attr('data-value') == 'I');
			});			
		}
		e.preventDefault();
	});

	$('#Element_OphCiExamination_Dilation_time_right').die('keypress').live('keypress',function(e) {
		if (e.keyCode == 13) {
			return false;
		}
		return true;
	});

	$('#Element_OphCiExamination_Dilation_time_left').die('keypress').live('keypress',function(e) {
		if (e.keyCode == 13) {
			return false;
		}
		return true;
	});

	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_OpticDisc .opticDiscToggle', 'click', function(e) {
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		var doodle = eyedraw.firstDoodleOfClass('OpticDisc');
		if(doodle.mode == 'Basic') {
			doodle.mode = 'Expert'
		} else {
			doodle.mode = 'Basic';
		}
		doodle.setHandleProperties();
		eyedraw.repaint();
		e.preventDefault();
	});


	$(this).delegate('#event_content .Element_OphCiExamination_Dilation .dilation_drug', 'change', function(e) {
		var side = $(this).closest('.side').attr('data-side');
		OphCiExamination_Dilation_addTreatment(this, side);
		e.preventDefault();
	});

	$(this).delegate('#event_content .Element_OphCiExamination_Dilation .removeTreatment', 'click', function(e) {
		var wrapper = $(this).closest('.side');
		var side = wrapper.attr('data-side');
		var row = $(this).closest('tr');
		var id = $('td:first input', row).val();
		var name = $('td:first span', row).text();
		row.remove();
		var dilation_drug = wrapper.find('.dilation_drug');
		dilation_drug.append('<option value="'+id+'">'+name+'</option>');
		sort_selectbox(dilation_drug);
		if ($('.dilation_table tbody tr', wrapper).length == 0) {
			$('.dilation_table', wrapper).hide();
			$('.timeDiv', wrapper).hide();
		}
		e.preventDefault();
	});

	$(this).delegate('#event_content .Element_OphCiExamination_Dilation .clearDilation', 'click', function(e) {
		var side = $(this).closest('.side').attr('data-side');
		$(this).closest('.side').find('tr.dilationTreatment a.removeTreatment').click();
		e.preventDefault();
	});

	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Comorbidities #comorbidities_unselected select', 'change', function(e) {
		var id = $(this).val();
		var text = $('option:selected', this).text();
		$('#comorbidities_items :not(:selected)').attr('selected', function () {
			return ($(this).val() == id);
		});
		$('option:selected', this).remove();
		if($('#comorbidities_selected ul').length == 0) {
			$('#comorbidities_unselected').append(' <a href="#">Remove All</a>');
			$('#comorbidities_selected').html('<ul></ul>');
		}
		$('#comorbidities_selected ul').append('<li data-id="'+id+'"><span>'+text+'</span> <a href="" title="Remove Comorbidity">-</a></li>');
		sort_ul($('#comorbidities_selected ul'));
		e.preventDefault();
	});
	
	function removeComorbidity(li) {
		var id = li.attr('data-id');
		var text = $('span',li).text();
		$('#comorbidities_items :selected').attr('selected', function () {
			return ($(this).val() != id);
		});
		li.remove();
		if($('#comorbidities_selected ul li').length == 0) {
			$('#comorbidities_selected').html('<p>No comorbidities</p>');
			$('#comorbidities_unselected a').remove();
		}
		$('#comorbidities_unselected select').append('<option value="'+id+'">'+text+'</option>');
	}
	
	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Comorbidities #comorbidities_selected a', 'click', function(e) {
		removeComorbidity($(this).parent());
		sort_selectbox($('#comorbidities_unselected select'));
		e.preventDefault();
	});

	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Comorbidities #comorbidities_unselected a', 'click', function(e) {
		$('#comorbidities_selected li').each(function() {
			removeComorbidity($(this));
		});
		sort_selectbox($('#comorbidities_unselected select'));
		e.preventDefault();
	});

	// clinic outcome functions
	function isClinicOutcomeStatusFollowup() {
		var statusPK = $('#Element_OphCiExamination_ClinicOutcome_status_id').val();
		var followup = false;
		
		$('#Element_OphCiExamination_ClinicOutcome_status_id').find('option').each(function() {
			if ($(this).attr('value') == statusPK) {
				if ($(this).attr('data-followup') == "1") {
					followup = true;
					return false;
				}
			}
		});
		
		return followup;
	}

	function showOutcomeStatusFollowup() {
		// Retrieve any previously stashed values
		if ($('#Element_OphCiExamination_ClinicOutcome_followup_quantity').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_followup_quantity').val($('#Element_OphCiExamination_ClinicOutcome_followup_quantity').data('store-value'));
		}
		if ($('#Element_OphCiExamination_ClinicOutcome_followup_period_id').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_followup_period_id').val($('#Element_OphCiExamination_ClinicOutcome_followup_period_id').data('store-value'));
		}
		if ($('#Element_OphCiExamination_ClinicOutcome_role_id').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_role_id').val($('#Element_OphCiExamination_ClinicOutcome_role_id').data('store-value'));
		}
		if ($('#Element_OphCiExamination_ClinicOutcome_role_comments').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_role_comments').val($('#Element_OphCiExamination_ClinicOutcome_role_comments').data('store-value'));
		}
		
		$('#div_Element_OphCiExamination_ClinicOutcome_followup').slideDown();
		$('#div_Element_OphCiExamination_ClinicOutcome_role').slideDown();
		
	}

	function hideOutcomeStatusFollowup() {
		if ($('#div_Element_OphCiExamination_ClinicOutcome_followup').is(':visible')) {
			// only do hiding and storing if currently showing something.
			$('#div_Element_OphCiExamination_ClinicOutcome_role').slideUp();
			$('#div_Element_OphCiExamination_ClinicOutcome_followup').slideUp();
			
			// Stash current values as data in case we need them again and to avoid saving them
			$('#Element_OphCiExamination_ClinicOutcome_role_id').data('store-value', $('#Element_OphCiExamination_ClinicOutcome_role_id').val());
			$('#Element_OphCiExamination_ClinicOutcome_role_id').val('');
			$('#Element_OphCiExamination_ClinicOutcome_role_comments').data('store-value', $('#Element_OphCiExamination_ClinicOutcome_role_comments').val());
			$('#Element_OphCiExamination_ClinicOutcome_role_comments').val('');
			$('#Element_OphCiExamination_ClinicOutcome_followup_quantity').data('store-value', $('#Element_OphCiExamination_ClinicOutcome_followup_quantity').val());
			$('#Element_OphCiExamination_ClinicOutcome_followup_quantity').val('');
			$('#Element_OphCiExamination_ClinicOutcome_followup_period_id').data('store-value', $('#Element_OphCiExamination_ClinicOutcome_followup_period_id').val());
			$('#Element_OphCiExamination_ClinicOutcome_followup_period_id').val('');
		}
	}

	// show/hide the followup period fields
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_ClinicOutcome_status_id', 'change', function(e) {
		var followup = isClinicOutcomeStatusFollowup();
		if (followup) {
			showOutcomeStatusFollowup();
		}
		else {
			hideOutcomeStatusFollowup();
		}
	});
	// end of clinic outcome functions

	
	// perform the inits for the elements
	$('#active_elements .element').each(function() {
		var initFunctionName = $(this).attr('data-element-type-class').replace('Element_', '') + '_init';
		if(typeof(window[initFunctionName]) == 'function') {
			window[initFunctionName]();
		}
	});

});

function OphCiExamination_Dilation_getNextKey() {
	var keys = $('#event_content .Element_OphCiExamination_Dilation .dilationTreatment').map(function(index, el) {
		return parseInt($(el).attr('data-key'));
	}).get();
	if(keys.length) {
		return Math.max.apply(null, keys) + 1;		
	} else {
		return 0;
	}
}

function OphCiExamination_Dilation_addTreatment(element, side) {
	var drug_id = $('option:selected', element).val();
	var drug_name = $('option:selected', element).text();
	$('option:selected', element).remove();
	var template = $('#dilation_treatment_template').html();
	var data = {
		"key" : OphCiExamination_Dilation_getNextKey(),
		"side" : (side == 'right' ? 0 : 1),
		"drug_name" : drug_name,
		"drug_id" : drug_id,
	};
	var form = Mustache.render(template, data);
	var table = $('#event_content .Element_OphCiExamination_Dilation .[data-side="' + side + '"] .dilation_table');
	table.show();
	$(element).closest('.side').find('.timeDiv').show();
	$('tbody', table).append(form);
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

function sort_ul(element) {
rootItem = element.children('li:first').text();
element.append(element.children('li').sort(selectSort));
}

function OphCiExamination_Refraction_updateSegmentedField(field) {
	var parts = $(field).parent().children('select');
	var value = $(parts[0]).val() * (parseFloat($(parts[1]).val()) + parseFloat($(parts[2]).val()));
	$(field).val(value.toFixed(2));
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
	if(keys.length) {
		return Math.max.apply(null, keys) + 1;		
	} else {
		return 0;
	}
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
	return method_ids[0];
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
	$(".foster_images_dialog").dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		width: 480
	});
}

function OphCiExamination_GlaucomaRisk_init() {
	$("#Element_OphCiExamination_GlaucomaRisk_descriptions").dialog({
		title: 'Glaucoma Risk Stratifications',
		autoOpen: false,
		modal: true,
		resizable: false,
		width: 800
	});
}

function OphCiExamination_ClinicOutcome_LoadTemplate(template_id) {
	if(Element_OphCiExamination_ClinicOutcome_templates[template_id]) {
		$('#Element_OphCiExamination_ClinicOutcome_status_id')
			.val(Element_OphCiExamination_ClinicOutcome_templates[template_id]['clinic_outcome_status_id'])
			.trigger('change');
		$('#Element_OphCiExamination_ClinicOutcome_followup_quantity')
			.val(Element_OphCiExamination_ClinicOutcome_templates[template_id]['followup_quantity']);
		$('#Element_OphCiExamination_ClinicOutcome_followup_period_id')
			.val(Element_OphCiExamination_ClinicOutcome_templates[template_id]['followup_period_id']);
		
	}
}

function OphCiExamination_Comorbidities_init() {
	$('#comorbidities_items').hide();
	$('#comorbidities_items').after($('<div id="comorbidities_unselected"><select><option value="">-- Add --</option></select></div>'));
	$('#comorbidities_items option:not(:selected)').each(function() {
		$('#comorbidities_unselected select').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
	});
	var selected = $('#comorbidities_items option:selected');
	$('#comorbidities_unselected').after($('<div id="comorbidities_selected"></div>'));
	if(selected.length > 0) {
		$('#comorbidities_unselected').append(' <a href="#">Remove All</a>');
		$('#comorbidities_selected').html($('<ul></ul>'));
		$('#comorbidities_items option:selected').each(function() {
			$('#comorbidities_selected ul').append('<li data-id="' + $(this).val() + '"><span>' + $(this).text() + '</span> <a href="#" title="Remove Comorbidity">-</a></li>');
		});		
	} else {
		$('#comorbidities_selected').html('<p>No comorbidities</p>');
	}
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

function OphCiExamination_do_print() {
	printIFrameUrl(OE_print_url, null);
}
