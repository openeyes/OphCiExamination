<?php
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
?>

<div class="cols2 clearfix">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div
		class="side left eventDetail<?php if(!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('right_eom_id')?>:
				</div>
				<?php echo CHtml::activeDropDownList($element,'right_eom_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_EOM::model()->findAll(array('order'=>'display_order')),'id','name'))?>
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('right_ct_distance_id')?>:
				</div>
				<?php echo CHtml::activeDropDownList($element,'right_ct_distance_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_CT_Distance::model()->findAll(array('order'=>'display_order')),'id','name'))?>
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('right_ct_near_id')?>:
				</div>
				<?php echo CHtml::activeDropDownList($element,'right_ct_near_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_CT_Near::model()->findAll(array('order'=>'display_order')),'id','name'))?>
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('right_details')?>:
				</div>
				<?php echo CHtml::activeTextArea($element,'right_details',array('class'=>'autosize'))?>
			</div>
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
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('left_eom_id')?>:
				</div>
				<?php echo CHtml::activeDropDownList($element,'left_eom_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_EOM::model()->findAll(array('order'=>'display_order')),
'id','name'))?> 
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('left_ct_distance_id')?>:
				</div>
				<?php echo CHtml::activeDropDownList($element,'left_ct_distance_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_CT_Distance::model()->findAll(array('order'=>'display_order')),'id','name'))?>
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('left_ct_near_id')?>:
				</div>				
				<?php echo CHtml::activeDropDownList($element,'left_ct_near_id',CHtml::listData(OphCiExamination_ExtraocularMuscles_CT_Near::model()->findAll(array('order'=>'display_order')),'id','name'))?>
			</div>
			<div>
				<div class="label">
					<?php echo $element->getAttributeLabel('left_details')?>:
				</div>
				<?php echo CHtml::activeTextArea($element,'left_details',array('class'=>'autosize'))?>
			</div>
		</div>
		<div class="inactiveForm">
			<a href="#">Add left side</a>
		</div>
	</div>
</div>
