var dr_grade_et_class = 'Element_OphCiExamination_DRGrading';
var examination_print_url, module_css_path;

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
    countArray['LaserSpot'] = 0;
    countArray['FocalLaser'] = 0;
    countArray['MacularGrid'] = 0;
    countArray['SectorPRPPostPole'] = 0;
    countArray['PRPPostPole'] = 0;
    countArray['IRMA'] = 0;
    
    var retinopathy = "R0";
    var maculopathy = "M0";
    var retinopathy_photocoagulation = false;
    var maculopathy_photocoagulation = false;
    var clinical = "None";
    var dnv_within = false;
    
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
            //TODO: needs to check against optic disc, not Fovea
            /*
            if (doodle.className == 'DiabeticNV') {
            	if (postPole.isWithinDiscDiametersOfFovea(doodle,1)) dnv_within = true;
            }
            */
            if (doodle.className == 'LaserSpot' || doodle.className == 'FocalLaser') {
            	if (postPole.isWithinArcades(doodle)) {
            		retinopathy_photocoagulation = true;
            	} 
            	else {
            		maculopathy_photocoagulation = true;
            	}
            }
        }
        
        if (countArray['Microaneurysm'] > 0) {
        	clinical = 'Mild nonproliferative retinopathy';
        }
        
        if (countArray['BlotHaemorrhage'] > 0 || countArray['IRMA'] > 0 || countArray['PreRetinalHaemorrhage']) {
        	clinical = 'Moderate nonproliferative retinopathy';
        }
        
        if ((countArray['PreRetinalHaemorrhage'] || countArray['BlotHaemorrhage'] > 0) && countArray['IRMA'] > 0) {
        	clinical = 'Severe nonproliferative retinopathy';
        }
        
        if (countArray['DiabeticNV'] > 0) {
        	clinical = 'Early proliferative retinopathy';
        	if (dnv_within || countArray['PreRetinalHaemorrhage']) {
        		clinical = 'High-risk proliferative retinopathy';
        	}
        	
        }
        
        // R1 (Background)
        if (countArray['Microaneurysm'] > 0 || countArray['BlotHaemorrhage'] > 0 || countArray['HardExudate'] > 0 || countArray['CottonWoolSpot'] > 0 || countArray['Circinate'] > 0)
        {
            retinopathy = "R1";
        }
        
        // R2
        if (countArray['BlotHaemorrhage'] >= 2 || countArray['IRMA'] > 0)
        {
            retinopathy = "R2";                        
        }
        
        // R3
        if (countArray['PRPPostPole'] > 0)
        {
            retinopathy = "R3S";
            retinopathy_photocoagulation = true;
        }
        if (countArray['DiabeticNV'] > 0 || countArray['PreRetinalHaemorrhage'] > 0 || countArray['FibrousProliferation'] > 0)
        {
            retinopathy = "R3A";
        }
        
        if (countArray['SectorPRPPostPole'] > 0 || countArray['MacularGrid'] > 0) {
        	maculopathy_photocoagulation = true;
        }
        
        return [retinopathy, maculopathy, retinopathy_photocoagulation, maculopathy_photocoagulation, clinical];
        
    }
    return false;
}

//returns the number of weeks booking recommendation from the DR grades
function getDRBookingVal() {
	var dr_grade = $('.' + dr_grade_et_class);
	var sides = Array("left", "right");
	var booking = null;
	
	for (var i = 0; i < sides.length; i++) {
		var side = sides[i],
			val = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id').val();
		$('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id').find('option').each(function() {
			if ($(this).val() == val) {
				var b = parseInt($(this).attr("data-booking"));
				if (b && (booking == null || b < booking)) {
					booking = b;
					return false;
				}
			}
		});
		val = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_id').val();
		$('select#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_id').find('option').each(function() {
			if ($(this).val() == val) {
				var b = parseInt($(this).attr("data-booking"));
				if (b && (booking == null || b < booking)) {
					booking = b;
					return false;
				}
			}
		});
	}
	return booking;	
}

// sets the booking hint text based on the DR grade
function updateBookingWeeks() {
	var weeks = getDRBookingVal();
	if (weeks){
		$('.Element_OphCiExamination_LaserManagement').find('#laser_booking_hint').text('Laser treatment needs to be booked within ' + weeks.toString() + ' weeks');
	}
	else {
		$('.Element_OphCiExamination_LaserManagement').find('#laser_booking_hint').text('');
	}
}

function updateDRGrades(_drawing, retinopathy, maculopathy, ret_photo, mac_photo, clinical) {
    if (_drawing.eye) {
    	var side = 'left';
    }
    else {
    	var side = 'right';
    }
    
    var dr_grade = $('#' + _drawing.canvas.id).closest('.element').find('.active_child_elements .' + dr_grade_et_class);
    // clinical
    var cSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_clinical_id');
    cSel.find('option').each(function() {
    	if ($(this).attr('data-val') == clinical) {
    		cSel.val($(this).val());
    		return false;
    	}
    });
    
    // description
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_clinical_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_clinical_desc_' + clinical.replace(/\s+/g, '')).show();
    
    // Retinopathy
    var retSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id');
    retSel.find('option').each(function() {
    	if ($(this).attr('data-val') == retinopathy) {
    		retSel.val($(this).val());
    	}
    });
    
    ret_photo_id = dr_grade_et_class+'_'+side+'_nscretinopathy_photocoagulation_';
    if (ret_photo) {
    	dr_grade.find('input#' + ret_photo_id + '1').attr('checked', 'checked');
    }
    else {
    	dr_grade.find('input#' + ret_photo_id + '0').attr('checked', 'checked');
    }
    
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
    
    mac_photo_id = dr_grade_et_class+'_'+side+'_nscmaculopathy_photocoagulation_';
    if (mac_photo) {
    	dr_grade.find('input#' + mac_photo_id + '1').attr('checked', 'checked');
    }
    else {
    	dr_grade.find('input#' + mac_photo_id + '0').attr('checked', 'checked');
    }
    
    // display description
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_desc_' + maculopathy).show();
	
    updateBookingWeeks();
    
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
				updateDRGrades(this.drawing, grades[0], grades[1], grades[2], grades[3], grades[4]);
			}
		}
	}
}

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
			window.location.href = baseUrl + '/patient/episodes/' + et_patient_id;
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

	// dr grading
	$('#event_OphCiExamination').delegate('a.drgrading_images_link', 'click', function(e) {
		$('.drgrading_images_dialog').dialog('open');
		e.preventDefault();
	});
	
	// Note. a manual change to DR grade will mark the grade as unsynced, regardless of whether the user
	// manually syncs or not, as we are using the manual change as an indicator that we should no longer automatically
	// update the values. Although this will not apply between saves
	$('#event_OphCiExamination').delegate(
		'#Element_OphCiExamination_DRGrading_right_clinical_id, ' +
		'#Element_OphCiExamination_DRGrading_left_clinical_id, ' +
		'#Element_OphCiExamination_DRGrading_right_nscretinopathy_id, ' +
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
		dr_grade.find('#'+desc + '_' + grade.replace(/\s+/g, '')).show();
		$('#drgrading_dirty').show();
		
		updateBookingWeeks();
	})
	
	$('#event_OphCiExamination').delegate('input[name="Element_OphCiExamination_DRGrading[right_nscretinopathy_photocoagulation]"], ' +
		'input[name="Element_OphCiExamination_DRGrading[left_nscretinopathy_photocoagulation]"], ' +
		'input[name="Element_OphCiExamination_DRGrading[right_nscmaculopathy_photocoagulation]"], ' +
		'input[name="Element_OphCiExamination_DRGrading[left_nscmaculopathy_photocoagulation]"]'
			, 'change', function(e) {
		$('#drgrading_dirty').show();
	});
	
	$('#event_OphCiExamination').delegate('a#drgrading_dirty', 'click', function(e) {
		$('div.Element_OphCiExamination_PosteriorSegment').find('canvas').each(function() {
			var drawingName = $(this).attr('data-drawing-name');
			if (window[drawingName]) {
				// the posterior segment drawing is available to sync values with
				var grades = gradeCalculator(window[drawingName]);
				
				updateDRGrades(window[drawingName], grades[0], grades[1], grades[2], grades[3], grades[4]);
			}
		});
		$(this).hide();
		e.preventDefault();
	})
	
	// end of DR
	
	// management
	function isDeferralOther(element, name) {
		var reasonPK = $('#'+element+'_'+name+'_deferralreason_id').val();
		var other = false;
		
		$('#'+element+'_'+name+'_deferralreason_id').find('option').each(function() {
			if ($(this).attr('value') == reasonPK) {
				if ($(this).attr('data-other') == "1") {
					other = true;
					return false;
				}
			}
		});
		
		return other;
	}
	
	function showDeferralOther(element, name) {
		$('#div_'+element+'_'+name+'_deferralreason_other').slideDown().find('textarea').each(function(e) {
			if ($(this).data('stored-value')) {
				// must've changed their mind, restore the value
				$(this).val($(this).data('stored-value'));
			}
			$(this).autosize();
			
		});
	}
	
	function hideDeferralOther(element, name) {
		if ($('#div_'+element+'_'+name+'_deferralreason_other').is(':visible')) {	
			// because of the value storage, only want to do this if its showing
			$('#div_'+element+'_'+name+'_deferralreason_other').slideUp().find('textarea').each(function(e) {
				// clear text value to prevent submission, but store to make available if user changes their mind
				$(this).data('stored-value', $(this).val());
				$(this).val('');
			});
		}
	}
	
	// abstracted to manage the deferral fields for laser/injection
	function deferralFields(element, name) {
		var thePK = $('#'+element+'_'+name+'_status_id').val();
		// flag for deferred fields
		var deferred = false;
		// flag for booking hint
		var book = false;
		
		$('#'+element+'_'+name+'_status_id').find('option').each(function() {
			if ($(this).attr('value') == thePK) {
				if ($(this).attr('data-deferred') == "1") {
					deferred = true;
				}
				if ($(this).attr('data-book') == "1") {
					book = true;
				}
				return false;
			}
		});
		
		if (book) {
			$('.'+element).find('#'+name+'_booking_hint').slideDown();
		}
		else {
			$('.'+element).find('#'+name+'_booking_hint').slideUp();
		}
		
		if (deferred) {
			$('#div_'+element+'_'+name+'_deferralreason').slideDown();
			if ($('#'+element+'_'+name+'_deferralreason_id').data('stored-value')) {
				$('#'+element+'_'+name+'_deferralreason_id').val(
					$('#'+element+'_'+name+'_deferralreason_id').data('stored-value')
				);
				if (isDeferralOther(name)) {
					showDeferralOther(name);
				}
			}
		}
		else {
			
			$('#div_'+element+'_'+name+'_deferralreason').slideUp();
			if ($('#'+element+'_'+name+'_deferralreason_id').val()) {
				$('#'+element+'_'+name+'_deferralreason_id').data('stored-value', $('#'+element+'_'+name+'_deferralreason_id').val());
				$('#'+element+'_'+name+'_deferralreason_id').val('');
				// call the hide on other in case it's currently showing
				hideDeferralOther(name);
			}
		}
	}
	
	// show/hide the laser deferral fields
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_LaserManagement_laser_status_id', 'change', function(e) {
		deferralFields('Element_OphCiExamination_LaserManagement', 'laser');
	});
	
	// show/hide the injection deferral fields
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_InjectionManagement_injection_status_id', 'change', function(e) {
		deferralFields('Element_OphCiExamination_InjectionManagement', 'injection');
	});
	
	// show/hide the deferral reason option
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_LaserManagement_laser_deferralreason_id', 'change', function(e) {
		var other = isDeferralOther('Element_OphCiExamination_LaserManagement', 'laser');
		
		if (other) {
			showDeferralOther('Element_OphCiExamination_LaserManagement', 'laser');
		}
		else {
			hideDeferralOther('Element_OphCiExamination_LaserManagement', 'laser');
		}
	});
	
	// show/hide the deferral reason option
	$('#event_OphCiExamination').delegate('#Element_OphCiExamination_InjectionManagement_injection_deferralreason_id', 'change', function(e) {
		var other = isDeferralOther('Element_OphCiExamination_InjectionManagement', 'injection');
		
		if (other) {
			showDeferralOther('Element_OphCiExamination_InjectionManagement', 'injection');
		}
		else {
			hideDeferralOther('Element_OphCiExamination_InjectionManagement', 'injection');
		}
	});

	
	// end of management
	
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
		if ($('#Element_OphCiExamination_ClinicOutcome_followup_quantity').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_followup_quantity').val($('#Element_OphCiExamination_ClinicOutcome_followup_quantity').data('store-value'));
		}
		if ($('#Element_OphCiExamination_ClinicOutcome_followup_period_id').data('store-value')) {
			$('#Element_OphCiExamination_ClinicOutcome_followup_period_id').val($('#Element_OphCiExamination_ClinicOutcome_followup_period_id').data('store-value'));
		}
		$('#div_Element_OphCiExamination_ClinicOutcome_followup').slideDown();
		
	}

	function hideOutcomeStatusFollowup() {
		if ($('#div_Element_OphCiExamination_ClinicOutcome_followup').is(':visible')) {
			// only do hiding and storing if currently showing something.
			$('#div_Element_OphCiExamination_ClinicOutcome_followup').slideUp();
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
	return method_ids.shift();
}

function OphCiExamination_VisualAcuity_init() {
}

// setup the dr grading fields (called once the Posterior Segment is fully loaded)
// will verify whether the form values match that of the loaded eyedraws, and if not, mark as dirty
function OphCiExamination_DRGrading_dirtyCheck(_drawing) {
	var dr_grade = $('.' + dr_grade_et_class);
		
	var grades = gradeCalculator(_drawing);
	var retinopathy = grades[0],
		maculopathy = grades[1],
		ret_photo   = grades[2],
		mac_photo   = grades[3],
		clinical    = grades[4],
		dirty 	    = false,	
		side        = 'right';

	if (_drawing.eye) {
    	side = 'left';
    }
	
	// clinical
	var cSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_clinical_id');
	var cSelVal = cSel.val();
	
    cSel.find('option').each(function() {
    	if ($(this).attr('value') == cSelVal) {
        	if ($(this).attr('data-val') != clinical) {
        		dirty = true;
        		clinical = $(this).attr('data-val');
        	}
    		return false;
    	}
    });
    
    // display clinical description
    dr_grade.find('div .'+dr_grade_et_class+'_'+side+'_clinical_desc').hide();
    dr_grade.find('div#'+dr_grade_et_class+'_'+side+'_clinical_desc_' + clinical.replace(/\s+/g, '')).show();
    
    //retinopathy
    var retSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscretinopathy_id');
    var retSelVal = retSel.val();
    
    retSel.find('option').each(function() {
    	if ($(this).attr('value') == retSelVal) {
    		if ($(this).attr('data-val') != retinopathy) {
    			dirty = true;
    			retinopathy = $(this).attr('data-val');
    		}
    		return false;
    	}
    });
    
    // retinopathy photocogaulation
    if ($('input[@name='+dr_grade_et_class+'\['+side+'_nscretinopathy_photocoagulation\]]:checked').val() != ret_photo) {
    	dirty = true;
    }
    
    // maculopathy photocoagulation
    if ($('input[@name='+dr_grade_et_class+'\['+side+'_nscmaculopathy_photocoagulation\]]:checked').val() != mac_photo) {
    	dirty = true;
    }
    
    // Maculopathy
    var macSel = dr_grade.find('select#'+dr_grade_et_class+'_'+side+'_nscmaculopathy_id');
    var macSelVal = macSel.val();
    
    macSel.find('option').each(function() {
    	if ($(this).attr('value') == macSelVal) {
    		if ($(this).attr('data-val') != maculopathy) {
    			dirty = true;
    			maculopathy = $(this).attr('data-val');
    		}
    		return false;
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
				updateDRGrades(_drawing, grades[0], grades[1], grades[2], grades[3], grades[4]);
			}
		}
	});
	
	$(".Element_OphCiExamination_DRGrading").find('.grade-info').each(function(){
		var quick = $(this);
		var iconHover = $(this).parent().find('.grade-info-icon');
		
		iconHover.hover(function(e){
			var infoWrap = $('<div class="quicklook"></div>');
			infoWrap.appendTo('body');
			infoWrap.html(quick.html());
			
			var offsetPos = $(this).offset();
			var top = offsetPos.top;
			var left = offsetPos.left + 25;
			
			top = top - (infoWrap.height()/2) + 8;
			
			if (left + infoWrap.width() > 1150) left = left - infoWrap.width() - 40;
			infoWrap.css({'position': 'absolute', 'top': top + "px", 'left': left + "px"});
			infoWrap.fadeIn('fast');
		},function(e){
			$('body > div:last').remove();
		});	
	});
	
}

function OphCiExamination_Management_init() {
	updateBookingWeeks();
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
	printIFrameUrl(examination_print_url, null);
}
