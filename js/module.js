$(document).ready(
		function() {

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
			$('#event_display').delegate(
					'#et_cancel',
					'click',
					function() {
						if (!$(this).hasClass('inactive')) {
							disableButtons();
							if (m = window.location.href.match(/\/update\/[0-9]+/)) {
								window.location.href = window.location.href.replace('/update/',
										'/view/');
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
			$('#event_display').delegate(
					'#et_canceldelete',
					'click',
					function() {
						if (!$(this).hasClass('inactive')) {
							disableButtons();
							if (m = window.location.href.match(/\/delete\/[0-9]+/)) {
								window.location.href = window.location.href.replace('/delete/',
										'/view/');
							} else {
								window.location.href = '/patient/episodes/' + et_patient_id;
							}
						}
						return false;
					});

			/**
			 * Add an optional element
			 */
			$('#inactive_elements').delegate('.addElement', 'click', function() {
				var element_type_id = $(this).attr('data-element-type-id');
				var optional_element = $(this).parent();
				$.get("/OphCiExamination/Default/ElementForm", {
					id : element_type_id,
				}, function(data) {
					$('#active_elements').append(data);
					optional_element.remove();
				});
				return false;
			});

			/**
			 * Remove an optional element
			 */
			$('#active_elements').delegate(
					'.removeElement',
					'click',
					function() {
						var element_type_id = $(this).attr('data-element-type-id');
						var element_type_name = $(this).next('h5').html();
						var optional_element = $('<a href="#" class="addElement"'
								+ 'data-element-type-id="' + element_type_id
								+ '">' + element_type_name + '</a>');
						optional_element = $('<h5></h5>').append(optional_element);
						$('#inactive_elements').append(optional_element);
						$(this).parent().remove();
						return false;
					});

		});
