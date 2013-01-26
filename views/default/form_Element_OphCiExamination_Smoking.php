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
<?php echo $form->radioBoolean($element, 'smoker')?>
<?php echo $form->radioBoolean($element, 'past_smoker')?>
<?php echo $form->textField($element, 'cigs_day', array('style'=>'width: 60px;','hide'=>(!$element->smoker && !$element->past_smoker)))?>
<div id="div_Element_OphCiExamination_Smoking_timeframe" class="eventDetail"<?php if (!$element->smoker && !$element->past_smoker) {?> style="display: none;"<?php }?>>
	<div class="label">For how long</div>
	<div class="data">
		<?php echo $form->textField($element, 'duration_years', array('nowrapper'=>true, 'style'=>'width: 60px'))?> year(s)&nbsp;&nbsp;
		<?php echo $form->textField($element, 'duration_months', array('nowrapper'=>true, 'style'=>'width: 60px'))?> month(s)&nbsp;&nbsp;
		<?php echo $form->textField($element, 'duration_days', array('nowrapper'=>true, 'style'=>'width: 60px'))?> day(s)
	</div>
</div>
<script type="text/javascript">
	$('#Element_OphCiExamination_Smoking_smoker').die('click').live('click',function() {
		checkSmoker();
	});
	$('#Element_OphCiExamination_Smoking_past_smoker').die('click').live('click',function() {
		checkSmoker();
	});

	function checkSmoker() {
		if ($('#Element_OphCiExamination_Smoking_smoker_1').is(':checked') || $('#Element_OphCiExamination_Smoking_past_smoker_1').is(':checked')) {
			$('#div_Element_OphCiExamination_Smoking_cigs_day').show();
			$('#div_Element_OphCiExamination_Smoking_timeframe').show();
		} else {
			$('#div_Element_OphCiExamination_Smoking_cigs_day').hide();
			$('#div_Element_OphCiExamination_Smoking_timeframe').hide();
		}
	}
</script>
