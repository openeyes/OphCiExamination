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
	<a href="#" class="removeElement">Remove</a>
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data" data-side="right">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'right_'.$element->elementType->id,
						'side' => 'R',
						'mode' => 'edit',
						'size' => 300,
						'model' => $element,
						'attribute' => 'right_eyedraw',
						'no_wrapper' => true,
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
								array('setParameterForDoodleOfClass', array('AntSeg', 'pxe', $element->right_pxe)),
								array('deselectDoodles', array()),
						),
				));
				?>
				<div class="eyedrawFields">
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_pupil'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'right_pupil', $element->getPupilValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_nuclear'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'right_nuclear', $element->getNuclearValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_cortical'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'right_cortical', $element->getCorticalValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_description'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeTextArea($element, 'right_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
						</div>
					</div>
					<div>
						<div class="data">
							<?php echo CHtml::activeCheckBox($element, 'right_pxe') ?>
						</div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_pxe'); ?>
						</div>
					</div>
					<div>
						<div class="data">
							<?php echo CHtml::activeCheckBox($element, 'right_phako') ?>
						</div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_phako'); ?>
						</div>
					</div>
					<button class="ed_report">Report</button>
					<button class="ed_clear">Clear</button>
				</div>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="data" data-side="left">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'left_'.$element->elementType->id,
						'side' => 'L',
						'mode' => 'edit',
						'size' => 300,
						'model' => $element,
						'attribute' => 'left_eyedraw',
						'no_wrapper' => true,
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
								array('setParameterForDoodleOfClass', array('AntSeg', 'pxe', $element->left_pxe)),
								array('deselectDoodles', array()),
						),
				));
				?>
				<div class="eyedrawFields">
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_pupil'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'left_pupil', $element->getPupilValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_nuclear'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'left_nuclear', $element->getNuclearValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_cortical'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'left_cortical', $element->getCorticalValues()); ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_description'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeTextArea($element, 'left_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
						</div>
					</div>
					<div>
						<div class="data">
							<?php echo CHtml::activeCheckBox($element, 'left_pxe') ?>
						</div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_pxe'); ?>
						</div>
					</div>
					<div>
						<div class="data">
							<?php echo CHtml::activeCheckBox($element, 'left_phako') ?>
						</div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_phako'); ?>
						</div>
					</div>
					<button class="ed_report">Report</button>
					<button class="ed_clear">Clear</button>
				</div>
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">

$(document).ready(function() {
	$('#event_display').delegate('.element input[name$="_pxe]"]', 'change', function() {
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		eyedraw.setParameterForDoodleOfClass('AntSeg', 'pxe', $(this).is(':checked'));
	});
});

// Global function to handle eyedraw events for this element
function updateElement_OphCiExamination_CataractAssessment(doodle) {
	switch(doodle.className) {
		case 'AntSeg':
			var side = (doodle.drawing.eye == 0) ? 'right' : 'left';
			$('#Element_OphCiExamination_CataractAssessment_'+side+'_pupil').val(doodle.getParameter('grade'));
			break;
		case 'NuclearCataract':
			var side = (doodle.drawing.eye == 0) ? 'right' : 'left';
			$('#Element_OphCiExamination_CataractAssessment_'+side+'_nuclear').val(doodle.getParameter('grade'));
			break;
		case 'CorticalCataract':
			var side = (doodle.drawing.eye == 0) ? 'right' : 'left';
			$('#Element_OphCiExamination_CataractAssessment_'+side+'_cortical').val(doodle.getParameter('grade'));
			break;
	}
}

</script>
