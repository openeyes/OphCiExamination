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

<div id="div_<?php echo get_class($element)?>_no_treatment"
	class="eventDetail">
	<div class="label">
		<?php echo $element->getAttributeLabel('no_treatment') ?>:
	</div>
	<div class="data">
		<?php
			echo $form->checkbox($element, 'no_treatment', array('nowrapper' => true)); 
		?> 
	</div>
</div>

<div id="div_<?php echo get_class($element)?>_no_treatment_reason_id" class="eventDetail"<?php if (!$element->no_treatment) {?> style="display: none;"<?php }?>>
	<div class="label">
		<?php echo $element->getAttributeLabel('no_treatment_reason_id') ?>
	</div>
	<div class="data">
		<?php echo $form->dropDownlist($element, 'no_treatment_reason_id', 
				CHtml::listData(OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findAll(array('order'=> 'display_order asc')),'id','name'),
				array('empty'=>'- Please select -', 'nowrapper' => true)) ?>
	</div>
</div>

<div class="cols2 clearfix" id="div_<?php echo get_class($element)?>_treatment_fields">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div
		class="side left eventDetail<?php if(!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php $this->renderPartial('form_' . get_class($element) . '_fields',
				array('side' => 'right', 'element' => $element, 'form' => $form)); ?>
		</div>
		<div class="inactiveForm">
			<a href="#">Add right side</a>
		</div>
	</div>
	<div
		class="side right eventDetail<?php if(!$element->hasLeft()) { ?> inactive<?php } ?>"
		data-side="left">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php $this->renderPartial('form_' . get_class($element) . '_fields',
				array('side' => 'left', 'element' => $element, 'form' => $form)); ?>
		</div>
		<div class="inactiveForm">
			<a href="#">Add left side</a>
		</div>
	</div>
</div>
