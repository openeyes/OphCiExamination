var dr_grade_et_class = 'Element_OphCiExamination_DRGrading';

function gradeCalculator(_drawing) {
    var doodleArray = _drawing.doodleArray;
    
    // Array to store counts of doodles of relevant classes
    var countArray = new Array();
    countArray['Microaneurysm'] = 0;
    countArray['HardExudate'] = 0;
    countArray['Circinate'] = 0;
    countArray['BlotHaemorrhage'] = 0;
    countArray['PreRetinalHaemorrhage'] = 0;
    countArray['CottonWoolSpot'] = 0;
    countArray['DiabeticNV'] = 0;
    countArray['FibrousProliferation'] = 0;            
    countArray['PRPPostPole'] = 0;
    
    var retinopathy = "R0"
    var maculopathy = "M0";
    
    // Get reference to PostPole doodle
    var postPole = _drawing.lastDoodleOfClass('PostPole');
    
    if (postPole)
    {
        // Iterate through doodles counting, and checking location
        for (var i = 0; i < doodleArray.length; i++)
        {
            var doodle = doodleArray[i];
            countArray[doodle.className]++;
            
            // Exudates within one disk diameter of fovea
            if (doodle.className == 'HardExudate' || doodle.className == 'Circinate')
            {
                if (postPole.isWithinDiscDiametersOfFovea(doodle, 1)) maculopathy = 'M1';
            }
        }
        
        // R1 (Background)
        if (countArray['Microaneurysm'] > 0 || countArray['BlotHaemorrhage'] > 0 || countArray['HardExudate'] > 0 || countArray['CottonWoolSpot'] > 0 || countArray['Circinate'] > 0)
        {
            retinopathy = "R1";
        }
        
        // R2
        if (countArray['BlotHaemorrhage'] > 2)
        {
            retinopathy = "R2";                        
        }
        
        // R3
        if (countArray['PRPPostPole'] > 0)
        {
            retinopathy = "R3S";
        }
        if (countArray['DiabeticNV'] > 0 || countArray['PreRetinalHaemorrhage'] > 0 || countArray['FibrousProliferation'] > 0)
        {
            retinopathy = "R3A";
        }
        
        
        return [retinopathy, maculopathy];
        
    }
    return false;
}

function updateDRGrades(_drawing, retinopathy, maculopathy) {
    if (_drawing.eye) {
    	var side = 'left';
    }
    else {
    	var side = 'right';
    }
    
    var dr_grade = $('#' + _drawing.canvas.id).closest('.element').find('.active_child_elements .' + dr_grade_et_class);
    // Retinopathy
    var retSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id');
    retSel.find('option').each(function() {
    	if ($(this).attr('data-val') == retinopathy) {
    		retSel.val($(this).val());
    	}
    });
    // display description
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_nscretinopathy_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_nscretinopathy_desc_' + retinopathy).show();
   
    // Maculopathy
    var macSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_id');
    macSel.find('option').each(function() {
    	if ($(this).attr('data-val') == maculopathy) {
    		macSel.val($(this).val());
    	}
    });
    // display description
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc_' + maculopathy).show();
	
}

function posteriorListener(_drawing) {
	this.drawing = _drawing;
	var side = 'right';
	if (this.drawing.eye) {
		side = 'left';
	}
	this.side = side;
	
	this.drawing.registerForNotifications(this, 'callBack', ['doodleAdded', 'doodleDeleted', 'parameterChanged']);
	
	this.callBack = function (_messageArray) {
		var dr_grade = $('#' + this.drawing.canvas.id).closest('.element').find('.active_child_elements .' + dr_grade_et_class);
		var dr_side = dr_grade.find('.side.eventDetail[data-side="'+this.side+'"]');
		
		if (dr_side.hasClass('uninitialised')) {
			// the dr grade element has been loaded from the db, so if the doodle is ready, need to check whether
			// the grade is in sync with the eyedraw
			if (this.drawing.lastDoodleOfClass('PostPole')) { 
				OphCiExamination_DRGrading_dirtyCheck(this.drawing);
			}
		}
		else if (!$('#drgrading_dirty').is(":visible")) {
			var grades = gradeCalculator(this.drawing);
			if (grades) {
				updateDRGrades(this.drawing, grades[0], grades[1] );
			}
		}
	}
}


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
	
	function addElement(element, animate, is_child) {
		if (typeof (animate) === 'undefined')
			animate = true;
		if (typeof (is_child) === 'undefined')
			is_child = false;
		
		var element_type_id = $(element).attr('data-element-type-id');
		var display_order = $(element).attr('data-element-display-order');
		$.get(baseUrl + "/OphCiExamination/Default/ElementForm", {
			id : element_type_id,
			patient_id : et_patient_id,
		}, function(data) {
			if (is_child) {
				var container = $(element).closest('.inactive_child_elements').parent().find('.active_child_elements');
			} else {
				var container = $('#active_elements');
			}
			
			var insert_before = container.find('.element').first();
			
			while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
				insert_before = insert_before.nextAll('div:first');
			}
			$(element).remove();
			if (insert_before.length) {
				insert_before.before(data);
			} else {
				$(container).append(data);
			}
			$('#event_display textarea.autosize').autosize();
			var inserted = (insert_before.length) ? insert_before.prevAll('div:first') : container.find('.element:last');
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

			var el_class = $(element).attr('data-element-type-class');
			try {
				// work around to match the function name inits
				window[el_class.replace('Element_','') + '_init']();
			} catch (err) {
				// nothing to do here
			}
			
			// now init any children
			$(".element." + el_class).find('.active_child_elements').find('.element').each(function() {
				try {
					var el_class = $(this).attr('data-element-type-class');
					// work around to match the function name inits
					window[el_class.replace('Element_','') + '_init']();
				} catch (err) {
					// nothing to do here
				}
				$(this).removeClass('uninitialised');
			});
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
		if (!$(this).parents('.active_child_elements').length) {
			var element = $(this).closest('.element');
			removeElement(element);
		}
		e.preventDefault();
	});
	
	/*
	 * Remove a child element
	 */
	$('#active_elements').delegate('.active_child_elements .removeElement button', 'click', function(e) {
		var element = $(this).closest('.element');
		removeElement(element, true);
		e.preventDefault();
		
	})

	function removeElement(element, is_child) {
		if (typeof(is_child) == 'undefined')
			is_child = false;
		var element_type_name = $(element).attr('data-element-type-name');
		var display_order = $(element).attr('data-element-display-order');
		$(element).html($('<h5>' + element_type_name + '</h5>'));
		if (is_child) {
			var container = $(element).closest('.active_child_elements').parent().find('.inactive_child_elements');
		}
		else {
			var container = $('#inactive_elements');
		}
		var insert_before = $(container).find('.element').first();
		while (parseInt(insert_before.attr('data-element-display-order')) < parseInt(display_order)) {
			insert_before = insert_before.next();
		}
		if (insert_before.length) {
			insert_before.before(element);
		} else {
			$(container).append(element);
		}
	}
	
	/**
	 * Add optional child element
	 */
	$("#active_elements").delegate('.inactive_child_elements .element', 'click', function(e) {
		if (!$(this).hasClass('clicked')) {
			$(this).addClass('clicked');
			addElement(this, true, true);
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

	// dr grading
	$('#event_OphCiExamination').delegate('a.drgrading_images_link', 'click', function(e) {
		$('.drgrading_images_dialog').dialog('open');
		e.preventDefault();
	});
	
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_DRGrading_right_nscretinopathy_id, ' +
		'#Element_OphCiExamination_DRGrading_left_nscretinopathy_id, ' + 
		'#Element_OphCiExamination_DRGrading_right_nscmaculopathy_id, ' +
		'#Element_OphCiExamination_DRGrading_left_nscmaculopathy_id'
			, 'change', function(e) {
		var gradePK = $(this).val();
		var grade = null;
		
		$(this).find('option').each(function() {
        	if ($(this).attr('value') == gradePK) {
        		grade = $(this).attr('data-val');
        		return false;
        	}
        });
		
		var id = $(this).attr('id');
		var dr_grade = $(this).parents('.element');
		var desc = id.substr(0,id.length-2) + 'desc';
		dr_grade.find('.'+desc).hide();
		dr_grade.find('#'+desc + '_' + grade).show();
		$('#drgrading_dirty').show();
	})
	
	$('#event_OphCiExamination').delegate('a#drgrading_dirty', 'click', function(e) {
		$('div.Element_OphCiExamination_PosteriorSegment').find('canvas').each(function() {
			var drawingName = $(this).attr('data-drawing-name');
			if (window[drawingName]) {
				// the posterior segment drawing is available to sync values with
				// TODO: this should only occur if the values are synced
				var grades = gradeCalculator(window[drawingName]);
				
				updateDRGrades(window[drawingName], grades[0], grades[1]);
			}
		});
		$(this).hide();
		e.preventDefault();
	})
	
	
	
	
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

	$('body').delegate('.gonioBasic', 'change', function(e) {
		var side = $(this).closest('div[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		var position = $(this).attr('data-position');
		switch(position) {
			case 'sup':
				doodle = eyedraw.firstDoodleOfClass('AngleGradeNorth');
				break;
			case 'nas':
				doodle = eyedraw.firstDoodleOfClass('AngleGradeEast');
				break;
			case 'tem':
				doodle = eyedraw.firstDoodleOfClass('AngleGradeWest');
				break;
			case 'inf':
				doodle = eyedraw.firstDoodleOfClass('AngleGradeSouth');
				break;
		}
		if($(this).val() == 0) {
			var grade = 'III';
		} else {
			var grade = 'O';
		}
		doodle.setParameterWithAnimation('grade', grade);
		e.preventDefault();
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
		if($('#risks_selected ul').length == 0) {
			$('#risks_unselected').append(' <a href="#">Remove All</a>');
			$('#risks_selected').html('<ul></ul>');
		}
		$('#risks_selected ul').append('<li data-id="'+id+'"><span>'+text+'</span> <a href="" title="Remove Risk">-</a></li>');
		sort_ul($('#risks_selected ul'));
		e.preventDefault();
	});
	
	function removeRisk(li) {
		var id = li.attr('data-id');
		var text = $('span',li).text();
		$('#risks_risks :selected').attr('selected', function () {
			return ($(this).val() != id);
		});
		li.remove();
		if($('#risks_selected ul li').length == 0) {
			$('#risks_selected').html('<p>No risks</p>');
			$('#risks_unselected a').remove();
		}
		$('#risks_unselected select').append('<option value="'+id+'">'+text+'</option>');
	}
	
	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Risks #risks_selected a', 'click', function(e) {
		removeRisk($(this).parent());
		sort_selectbox($('#risks_unselected select'));
		e.preventDefault();
	});

	$('#event_OphCiExamination').delegate('.Element_OphCiExamination_Risks #risks_unselected a', 'click', function(e) {
		$('#risks_selected li').each(function() {
			removeRisk($(this));
		});
		sort_selectbox($('#risks_unselected select'));
		e.preventDefault();
	});

	// perform the inits for the elements
	$('#active_elements .element').each(function() {
		try {
			var el_class = $(this).attr('data-element-type-class');
			// work around to match the function name inits
			window[el_class.replace('Element_','') + '_init']();
		} catch (err) {
			// nothing to do here
		}
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

function gonioscopyListener(_drawing) {
	this.drawing = _drawing;
	this.drawing.registerForNotifications(this, 'callBack', ['parameterChanged']);
	this.callBack = function(_messageArray) {
		if(_messageArray.selectedDoodle) {
			_doodle = _messageArray.selectedDoodle;
			var side = (_drawing.eye == 0) ? 'right' : 'left';
			var position;
			switch(_doodle.className) {
				case 'AngleGradeNorth':
					position = 'sup';
					break;
				case 'AngleGradeEast':
					position = 'nas';
					break;
				case 'AngleGradeWest':
					position = 'tem';
					break;
				case 'AngleGradeSouth':
					position = 'inf';
					break;
			}
			if (position) {
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

function OphCiExamination_DRGrading_dirtyCheck(_drawing) {
	var dr_grade = $('.' + dr_grade_et_class);
		
	var grades = gradeCalculator(_drawing);
	var retinopathy = grades[0],
		maculopathy = grades[1]
		side = 'right';

	if (_drawing.eye) {
    	side = 'left';
    }
    var retSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id');
    var retSelVal = retSel.val();
    var dirty = false;
    
    retSel.find('option').each(function() {
    	if ($(this).attr('value') == retSelVal) {
    		if ($(this).attr('data-val') != retinopathy) {
    			dirty = true;
    			retinopathy = $(this).attr('data-val');
    			return false;
    		}
    	}
    });
    
    // Maculopathy
    var macSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_id');
    var macSelVal = macSel.val();
    
    macSel.find('option').each(function() {
    	if ($(this).attr('value') == macSelVal) {
    		if ($(this).attr('data-val') != maculopathy) {
    			dirty = true;
    			maculopathy = $(this).attr('data-val');
    			return false;
    		}
    	}
    });

    // display descriptions
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_nscretinopathy_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_nscretinopathy_desc_' + retinopathy).show();
    
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc_' + maculopathy).show();

    if (dirty) {
    	$('#drgrading_dirty').show();
    }
	dr_grade.find('.side.eventDetail[data-side="'+side+'"]').removeClass('uninitialised');
}



function OphCiExamination_DRGrading_init() {
	$(".Element_OphCiExamination_DRGrading").find(".drgrading_images_dialog").dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		width: 480
	});
	
	
	$('div.Element_OphCiExamination_PosteriorSegment').find('canvas').each(function() {
		
		var drawingName = $(this).attr('data-drawing-name');
		
		if (window[drawingName]) {
			var _drawing = window[drawingName];
			var is_saved = $(this).attr('data-element-saved');
			var grades = gradeCalculator(_drawing);
			if (!$("." + dr_grade_et_class).hasClass('uninitialised')) {
				updateDRGrades(_drawing, grades[0], grades[1] );
			}
		}
	});
	
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
	$('#risks_risks').parent().append($('<div id="risks_unselected"><select><option value="">-- Add --</option></select></div>'));
	$('#risks_risks option:not(:selected)').each(function() {
		$('#risks_unselected select').append('<option value="' + $(this).val() + '">' + $(this).text() + '</option>');
	});
	var selected = $('#risks_risks option:selected');
	$('#risks_risks').parent().append($('<div id="risks_selected"></div>'));
	if(selected.length > 0) {
		$('#risks_unselected').append(' <a href="#">Remove All</a>');
		$('#risks_selected').html($('<ul></ul>'));
		$('#risks_risks option:selected').each(function() {
			$('#risks_selected ul').append('<li data-id="' + $(this).val() + '"><span>' + $(this).text() + '</span> <a href="#" title="Remove Risk">-</a></li>');
		});		
	} else {
		$('#risks_selected').html('<p>No risks</p>');
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
