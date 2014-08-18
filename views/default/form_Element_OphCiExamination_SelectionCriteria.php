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
<div class="element-fields">
	<?php echo $form->radioButtons($element,'blindness_id',CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Blindness::model()->findAll(array('order'=>'display_order asc')),'id','name'),null,false,false,false,false,array(),array('label' => 3, 'field' => 4))?>
	<?php echo $form->radioButtons($element,'age_id',CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Age::model()->findAll(array('order'=>'display_order asc')),'id','name'),null,false,false,false,false,array(),array('label' => 3, 'field' => 4))?>
	<?php echo $form->radioBoolean($element,'vip',array('value-order' => 'reverse'),array('label' => 3, 'field' => 4))?>
	<?php echo $form->radioButtons($element,'prognosis_id',CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Prognosis::model()->findAll(array('order'=>'display_order asc')),'id','name'),null,false,false,false,false,array(),array('label' => 3, 'field' => 4))?>
	<?php echo $form->radioBoolean($element,'suitable_teaching_case',array(),array('label' => 3, 'field' => 4))?>
	<div class="selectionPriority"<?php if (!$element->blindness || !$element->age || $element->vip === null || !$element->prognosis || $element->suitable_teaching_case === null) {?> style="display: none"<?php }?>>
		<div class="row field-row">
			<div class="large-3 column">
				<label>Priority:</label>
			</div>
			<div class="large-3 column end">
				<div class="selection-priority field-highlight priority<?php echo $element->priority?>">
					<?php echo $element->priority?> priority
				</div>
			</div>
		</div>
		<?php echo $form->checkBox($element,'request_special_consideration',array('text-align' => 'right'),array('label' => 3, 'field' => 4))?>
		<?php echo $form->textArea($element,'comments',array(),false,array(),array('label' => 3, 'field' => 4))?>
	</div>
</div>
