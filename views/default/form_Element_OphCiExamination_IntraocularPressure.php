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
<?php
$instruments = CHtml::listData(OphCiExamination_Instrument::model()->findAll(),'id','name');
$key = 0;
?>
<div class="cols2 clearfix">
	<input type="hidden" name="intraocularpressure_readings_valid" value="1" />
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div
		class="side left eventDetail<?php if(!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<div class="data">
				<?php $right_readings = $element->right_readings ?>
				<table <?php if(!$right_readings) { ?> style="display: none;"
<?php } ?>>
					<tbody>
						<?php foreach($right_readings as $reading) { 
							$this->renderPartial('form_Element_OphCiExamination_IntraocularPressure_Reading', array(
								'key' => $key,
								'reading' => $reading,
								'side' => $reading->side,
								'instruments' => $instruments
						));
						$key++;
						}?>
					</tbody>
				</table>
				<div class="data noReadings" <?php if($right_readings) { ?>
					style="display: none;" <?php } ?>>Not recorded</div>
				<button class="addReading classy green mini" type="button">
					<span class="button-span button-span-green">Add</span>
				</button>
			</div>
			<?php if($element->right_comments || $element->getSetting('notes')) { ?>
			<div class="data">
				<?php echo $form->textArea($element, 'right_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62, 'nowrapper'=>true)) ?>
			</div>
			<?php } ?>
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
			<div class="data">
				<?php $left_readings = $element->left_readings ?>
				<table <?php if(!$left_readings) { ?> style="display: none;"
						<?php } ?>>
					<tbody>
						<?php foreach($left_readings as $reading) { 
							$this->renderPartial('form_Element_OphCiExamination_IntraocularPressure_Reading', array(
								'key' => $key,
								'reading' => $reading,
								'side' => $reading->side,
								'instruments' => $instruments
						));
						$key++;
						}?>
					</tbody>
				</table>
				<div class="data noReadings" <?php if($left_readings) { ?>
					style="display: none;" <?php } ?>>Not recorded</div>
				<button class="addReading classy green mini" type="button">
					<span class="button-span button-span-green">Add</span>
				</button>
			</div>
			<?php if($element->left_comments || $element->getSetting('notes')) { ?>
			<div class="data">
				<?php echo $form->textArea($element, 'left_comments', array('class' => 'autosize', 'rows' => 1, 'cols' => 62, 'nowrapper'=>true)) ?>
			</div>
			<?php } ?>
		</div>
		<div class="inactiveForm">
			<a href="#">Add left side</a>
		</div>
	</div>
</div>

<script id="intraocularpressure_reading_template" type="text/html">
	<?php
	$this->renderPartial('form_Element_OphCiExamination_IntraocularPressure_Reading', array(
			'key' => '{{key}}',
			'side' => '{{side}}',
			'instruments' => $instruments
	));
	?>
</script>
