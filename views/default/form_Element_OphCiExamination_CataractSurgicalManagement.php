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
<div class="sub-element-fields">
	<div class="field-row">
		<?php echo $form->radioButtons($element, 'eye_id', CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_CataractSurgicalManagement_Eye::model()->findAll(),'id','name'),null,false,false,false,false,array('nowrapper'=>true))?>
	</div>
	<div class="field-row">
		<?php echo $form->checkbox($element, 'city_road', array('nowrapper'=>true))?>
		<?php echo $form->checkbox($element, 'satellite', array('nowrapper'=>true))?>
		<?php echo $form->checkbox($element, 'fast_track', array('nowrapper'=>true))?>
	</div>
	<?php echo $form->slider($element, 'target_postop_refraction', array('min'=>-10,'max'=>10,'step'=>0.25), array(), array('label' => 3, 'field' => 6))?>
	<?php echo $form->radioBoolean($element, 'correction_discussed', array(), array('label' => 3, 'field' => 9))?>
	<div class="row field-row">
		<div class="large-3 column">
			<label for="<?php echo get_class($element).'_suitable_for_surgeon_id';?>">
				<?php echo $element->getAttributeLabel('suitable_for_surgeon_id')?>:
			</label>
		</div>
		<div class="large-9 column">
			<?php echo $form->dropDownList($element,'suitable_for_surgeon_id', '\OEModule\OphCiExamination\models\OphCiExamination_CataractSurgicalManagement_SuitableForSurgeon',array('class'=>'inline','empty'=>'- Please select -','nowrapper'=>true))?>
			<label class="inline">
				<?php echo $form->checkbox($element, 'supervised', array('nowrapper' => true, 'no-label'=>true))?>
				<?php echo $element->getAttributeLabel('supervised')?>
			</label>
		</div>
	</div>
	<?php echo $form->radioBoolean($element, 'previous_refractive_surgery', array(), array('label' => 3, 'field' => 9))?>
	<?php echo $form->radioBoolean($element, 'vitrectomised_eye', array(), array('label' => 3, 'field' => 9))?>
	<div class="row field-row">
		<div class="large-3 column">
			<label for="<?php echo get_class($element).'reasonForSurgery';?>">
				<?php echo $element->getAttributeLabel('reasonForSurgery')?>:
			</label>
		</div>
		<div class="large-6 column">
			<?php
			echo $form->multiSelectList(
				$element,
				'OEModule_OphCiExamination_models_Element_OphCiExamination_CataractSurgicalManagement[reasonForSurgery]',
				'reasonForSurgery',
				'id',
				\CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_Primary_Reason_For_Surgery::model()->findAll(), 'id', 'name'),
				array(),
				array(
					'empty' => '',
					'label' => 'Primary Reason For Cataract Surgery',
					'nowrapper' => true
				),
				false,
				true,
				null,
				false,
				false,
				array('label' => 3, 'field' => 9)
			);
			?>
		</div>
		<div class="large-3 column">
		</div>
	</div>
</div>
