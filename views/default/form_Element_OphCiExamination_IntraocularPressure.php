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
<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<div class="removeElement">
		<button class="classy blue mini">
			<span class="button-span icon-only"><img
				src="/img/_elements/btns/mini-cross.png" alt="+" width="24"
				height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data">
				<?php echo CHtml::activeDropDownList($element, 'right_reading', $element->getReadingValues(), array('class' => 'iopReading')); ?>
				<?php if($element->getSetting('show_instruments')) {
					echo CHtml::activeDropDownList($element, 'right_instrument_id', $element->getInstrumentValues(), array('class' => 'iopInstrument'));
				} else {
					echo CHtml::activeHiddenField($element, 'right_instrument_id');
				} ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="data">
				<?php echo CHtml::activeDropDownList($element, 'left_reading', $element->getReadingValues(), array('class' => 'iopReading')); ?>
				<?php if($element->getSetting('show_instruments')) {
					echo CHtml::activeDropDownList($element, 'left_instrument_id', $element->getInstrumentValues(), array('class' => 'iopInstrument'));
				} else {
					echo CHtml::activeHiddenField($element, 'left_instrument_id');
				} ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
	
	$("#event_content .Element_OphCiExamination_IntraocularPressure .iopReading").each(function() {
		updateType(this);
	});
	
	$("#event_content .Element_OphCiExamination_IntraocularPressure").delegate('.iopReading', 'change', function() {
		updateType(this);
	});
	
	<?php if($element->getSetting('link_instruments')) { ?>
	$("#event_content .Element_OphCiExamination_IntraocularPressure").delegate('.iopInstrument', 'change', function() {
		$(this).closest('.element').find('.iopInstrument').val($(this).val());
	});
	<?php } ?>
	
	/**
	 * Disable associated reading type field if reading is not recorded
	 */
	function updateType(field) {
		var type = $(field).next();
		if($(field).val() == 0) {
			type.attr('disabled', 'disabled');
		} else {
			type.removeAttr('disabled');
		}
	}
	
});
</script>
