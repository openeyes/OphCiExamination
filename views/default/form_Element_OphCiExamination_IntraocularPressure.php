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
<script type="text/javascript">
	var Element_OphCiExamination_IntraocularPressure_link_instruments = <?php echo $element->getSetting('link_instruments') ? 'true' : 'false'?>;
</script>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<div class="data">
			<?php if($element->getSetting('show_instruments')) {
				echo $form->dropDownList($element, 'right_instrument_id', $element->getInstrumentValues(), array('class' => 'iopInstrument', 'nowrapper'=>true));
			} else {
				echo $form->hiddenField($element, 'right_instrument_id');
			} ?>
			<?php echo $form->dropDownList($element, 'right_reading_id', CHtml::listData(OphCiExamination_IntraocularPressure_Reading::model()->findAll(array('order'=>'display_order')),'id','name'), array('class' => 'iopReading', 'nowrapper'=>true))?>
		</div>
	</div>
	<div class="right eventDetail">
		<div class="data">
			<?php echo $form->dropDownList($element, 'left_reading_id', CHtml::listData(OphCiExamination_IntraocularPressure_Reading::model()->findAll(array('order'=>'display_order')),'id','name'), array('class' => 'iopReading', 'nowrapper'=>true))?>
			<?php if($element->getSetting('show_instruments')) {
				echo $form->dropDownList($element, 'left_instrument_id', $element->getInstrumentValues(), array('class' => 'iopInstrument', 'nowrapper'=>true));
			} else {
				echo $form->hiddenField($element, 'left_instrument_id');
			} ?>
		</div>
	</div>
</div>

