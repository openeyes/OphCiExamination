<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<?php echo $form->textField($element, 'pulse_bpm', array('style'=>'width: 60px;'))?>
<?php echo $form->radioButtons($element, 'pulse_radial_id', 'ophciexamination_observations_pulse')?>
<?php echo $form->radioButtons($element, 'pulse_pedial_id', 'ophciexamination_observations_pulse')?>
<?php echo $form->textField($element, 'pressure_systolic', array('style'=>'width: 60px;'))?>
<?php echo $form->textField($element, 'pressure_diastolic', array('style'=>'width: 60px;'))?>
<?php echo $form->textField($element, 'respiratory_rate', array('style'=>'width: 60px;'))?>
<?php echo $form->textField($element, 'saturation', array('style'=>'width: 60px;'))?>
<?php echo $form->textField($element, 'temperature', array('style'=>'width: 60px;'))?>
<?php echo $form->radioBoolean($element, 'jvp_raised', array('style'=>'width: 60px;'))?>
<?php echo $form->textField($element, 'jvp_cm', array('style'=>'width: 60px;','hide'=>(!$element->jvp_raised)))?>
<script type="text/javascript">
	$('input[name="Element_OphCiExamination_Observations[jvp_raised]"]').click(function() {
		if ($('#Element_OphCiExamination_Observations_jvp_raised_1').is(':checked')) {
			$('#div_Element_OphCiExamination_Observations_jvp_cm').show();
		} else {
			$('#div_Element_OphCiExamination_Observations_jvp_cm').hide();
		}
	});
/*
	$('input[name="Element_OphCiExamination_Observations[pulse_radial_id]"]').click(function() {
		checkPulseSetting();
	});
	$('input[name="Element_OphCiExamination_Observations[pulse_pedial_id]"]').click(function() {
		checkPulseSetting();
	});

	function checkPulseSetting() {
		if ($('#Element_OphCiExamination_Observations_pulse_radial_id_2').is(':checked')) {
			if ($('#Element_OphCiExamination_Observations_pulse_pedial_id_1').is(':checked')) {
				$('#Element_OphCiExamination_Observations_pulse_pedial_id_1').removeAttr('checked');
			}
		}
	}
	*/
</script>
