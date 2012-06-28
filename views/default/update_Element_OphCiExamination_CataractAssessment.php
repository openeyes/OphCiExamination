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
		<?php echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="label">Left</div>
			<div class="data" data-side="left">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'left_'.$element->elementType->id,
						'side' => 'L',
						'mode' => 'edit',
						'size' => 300,
						'model' => $element,
						'attribute' => 'left_eyedraw',
						'doodleToolBarArray' => array(
								'NuclearCataract',
								'CorticalCataract',
								'PostSubcapCataract',
								'PCIOL',
								'ACIOL',
								'Bleb',
								'PI',
								'Fuchs',
								'RK',
								'LasikFlap',
								'CornealScar',
						),
						'onLoadedCommandArray' => array(
								array('addDoodle', array('AntSeg')),
								array('deselectDoodles', array()),
						),
				));
				?>
				<button class="ed_report">Report</button>
				<button class="ed_clear">Clear</button>
				<?php echo CHtml::activeTextArea($element, 'left_description', array('rows' => "2", 'cols' => "30", 'class' => 'autosize')) ?>
				<?php echo $element->getAttributeLabel('left_pupil'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'left_pupil') ?>
				<?php echo $element->getAttributeLabel('left_nuclear'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'left_nuclear') ?>
				<?php echo $element->getAttributeLabel('left_cortical'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'left_cortical') ?>
				<?php echo $element->getAttributeLabel('left_pxe'); ?>
				:
				<?php echo CHtml::activeCheckBox($element, 'left_pxe') ?>
				<?php echo $element->getAttributeLabel('left_phako'); ?>
				:
				<?php echo CHtml::activeCheckBox($element, 'left_phako') ?>
				<?php echo $element->getAttributeLabel('left_surgeon'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'left_surgeon') ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="label">Right</div>
			<div class="data" data-side="right">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'right_'.$element->elementType->id,
						'side' => 'R',
						'mode' => 'edit',
						'size' => 300,
						'model' => $element,
						'attribute' => 'right_eyedraw',
						'doodleToolBarArray' => array(
								'NuclearCataract',
								'CorticalCataract',
								'PostSubcapCataract',
								'PCIOL',
								'ACIOL',
								'Bleb',
								'PI',
								'Fuchs',
								'RK',
								'LasikFlap',
								'CornealScar',
						),
						'onLoadedCommandArray' => array(
								array('addDoodle', array('AntSeg')),
								array('deselectDoodles', array()),
						),
				));
				?>
				<button class="ed_report">Report</button>
				<button class="ed_clear">Clear</button>
				<?php echo CHtml::activeTextArea($element, 'right_description', array('rows' => "2", 'cols' => "30", 'class' => 'autosize')) ?>
				<?php echo $element->getAttributeLabel('right_pupil'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'right_pupil') ?>
				<?php echo $element->getAttributeLabel('right_nuclear'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'right_nuclear') ?>
				<?php echo $element->getAttributeLabel('right_cortical'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'right_cortical') ?>
				<?php echo $element->getAttributeLabel('right_pxe'); ?>
				:
				<?php echo CHtml::activeCheckBox($element, 'right_pxe') ?>
				<?php echo $element->getAttributeLabel('right_phako'); ?>
				:
				<?php echo CHtml::activeCheckBox($element, 'right_phako') ?>
				<?php echo $element->getAttributeLabel('right_surgeon'); ?>
				:
				<?php echo CHtml::activeTextField($element, 'right_surgeon') ?>
			</div>
		</div>
	</div>
</div>
