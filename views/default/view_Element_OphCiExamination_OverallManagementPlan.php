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
<div class="element-data element-eyes row">
	<div class="element-eye right-eye column">
		<div class="data-row">
			<div class="data-value">
				<?php if ($element->hasRight()) {?>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_target_iop'))?></div></div>
						<div class="large-7 column end"><div class="data-value" id="OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_right_target_iop"><?php echo $element->right_target_iop?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_clinic_internal_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->right_clinic_internal ? $element->right_clinic_internal->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_photo_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->right_photo ? $element->right_photo->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_oct_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->right_oct ? $element->right_oct->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_hfa_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->right_hfa ? $element->right_hfa->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_gonio_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->right_gonio ? $element->right_gonio->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('right_comments'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo CHtml::encode($element->right_comments)?></div></div>
					</div>
				<?php
				} else {?>
					Not recorded
				<?php }?>
			</div>
		</div>
	</div>
	<div class="element-eye left-eye column">
		<div class="data-row">
			<div class="data-value">
				<?php if ($element->hasLeft()) {?>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_target_iop'))?></div></div>
						<div class="large-7 column end"><div class="data-value" id="OEModule_OphCiExamination_models_Element_OphCiExamination_OverallManagementPlan_left_target_iop"><?php echo $element->left_target_iop?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_clinic_internal_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->left_clinic_internal ? $element->left_clinic_internal->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_photo_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->left_photo ? $element->left_photo->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_oct_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->left_oct ? $element->left_oct->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_hfa_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->left_hfa ? $element->left_hfa->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_gonio_id'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo $element->left_gonio ? $element->left_gonio->name : 'None'?></div></div>
					</div>
					<div class="row data-row">
						<div class="large-5 column"><div class="data-label"><?php echo CHtml::encode($element->getAttributeLabel('left_comments'))?></div></div>
						<div class="large-7 column end"><div class="data-value"><?php echo CHtml::encode($element->left_comments)?></div></div>
					</div>
				<?php
				} else {?>
					Not recorded
				<?php }?>
			</div>
		</div>
	</div>
</div>
