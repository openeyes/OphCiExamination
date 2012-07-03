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
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<a href="#" class="removeElement">Remove</a>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="label">
				<?php echo CHtml::encode($element->getAttributeLabel('right_description'))?>
				:
			</div>
			<div class="data">
				<div class="textMacros inline">
					<?php foreach(OphCiExamination_Attribute::model()->findAllByElement($element) as $attribute) {
						$target_field = get_class($element) . '_right_description';
						echo CHtml::dropDownList($target_field .'_macro_'.$attribute->name, null,
								CHtml::listData($attribute->options, 'value', 'value'),
								array(
										'empty' => '-- '.$attribute->label.' --',
										'data-target-field' => $target_field,
										'class' => 'textMacro',
								));
			} ?>
				</div>
				<?php echo CHtml::activeTextArea($element, 'right_description', array(
						'rows' => "1",
						'cols' => "24",
						'class' => 'autosize',
						)) ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="label">
				<?php echo CHtml::encode($element->getAttributeLabel('left_description'))?>
				:
			</div>
			<div class="data">
				<div class="textMacros inline">
					<?php foreach(OphCiExamination_Attribute::model()->findAllByElement($element) as $attribute) {
						$target_field = get_class($element) . '_left_description';
						echo CHtml::dropDownList($target_field .'_macro_'.$attribute->name, null,
								CHtml::listData($attribute->options, 'value', 'value'),
								array(
										'empty' => '-- '.$attribute->label.' --',
										'data-target-field' => $target_field,
										'class' => 'textMacro',
								));
			} ?>
				</div>
				<?php echo CHtml::activeTextArea($element, 'left_description', array(
						'rows' => "1",
						'cols' => "24",
						'class' => 'autosize',
						)) ?>
			</div>
		</div>
	</div>
</div>
