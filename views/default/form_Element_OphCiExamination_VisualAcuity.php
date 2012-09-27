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
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="24" height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<?php
	$values = $element->getUnitValues();
	$methods = CHtml::listData(OphCiExamination_VisualAcuity_Method::model()->findAll(array('order'=>'display_order')),'id','name');
	$key = 0;
	?>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data" data-side="right">
				<input type="hidden" name="visualacuity_readings_valid" value="1" />
				<table>
					<thead>
						<tr>
							<th>Value</th>
							<th>Method</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($element->right_readings as $reading) { 
							// Adjust currently element readings to match unit steps
							$reading->loadClosest();
							$this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
									'key' => $key,
									'reading' => $reading,
									'side' => $reading->side,
									'values' => $values,
									'methods' => $methods
							));
							$key++;
							}?>
					</tbody>
				</table>
				<a class="addReading" href="#">Add</a>
			</div>
			<?php if($element->right_comments || $element->getSetting('notes')) { ?>
			<div class="data">
				<?php echo $form->textArea($element, 'right_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62, 'nowrapper'=>true)) ?>
			</div>
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<div class="data" data-side="left">
				<table>
					<thead>
						<tr>
							<th>Value</th>
							<th>Method</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($element->left_readings as $reading) { 
							// Adjust currently element readings to match unit steps
							$reading->loadClosest();
							$this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
									'key' => $key,
									'reading' => $reading,
									'side' => $reading->side,
									'values' => $values,
									'methods' => $methods
							));
							$key++;
							}?>
					</tbody>
				</table>
				<a class="addReading" href="#">Add</a>
			</div>
			<?php if($element->left_comments || $element->getSetting('notes')) { ?>
			<div class="data">
				<?php echo $form->textArea($element, 'left_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62, 'nowrapper'=>true)) ?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<script id="visualacuity_reading_template" type="text/html">
	<?php
	$this->renderPartial('form_Element_OphCiExamination_VisualAcuity_Reading', array(
			'key' => '{{key}}',
			'side' => '{{side}}',
			'values' => $values,
			'methods' => $methods
	));
	?>
</script>

<script type="text/javascript">
	$(document).ready(function() {
		OphCiExamination_VisualAcuity_init();
	});
</script>
