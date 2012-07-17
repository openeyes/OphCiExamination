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
$types = array(
		'Auto-refraction',
		'Ophthalmologist',
		'Optometrist',
		'Other',
);
$types = array_combine($types,$types);
?>
<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<div class="removeElement">
		<button class="classy blue mini">
			<span class="button-span icon-only"><img
				src="/img/_elements/btns/mini-cross.png" alt="+" width="24"
				height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div data-side="right">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'right_'.$element->elementType->id,
						'side' => 'R',
						'mode' => 'edit',
						'size' => 160,
						'model' => $element,
						'attribute' => 'right_axis_eyedraw',
						'no_wrapper' => true,
						'toolbar' => false,
						'onLoadedCommandArray' => array(
								array('addDoodle', array('TrialFrame')),
								array('addDoodle', array('TrialLens')),
								array('deselectDoodles', array()),
						),
				));
				?>
				<div class="eyedrawFields">
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_sphere'); ?>
							:
						</div>
						<div class="data segmented">
							<?php $this->renderPartial(
									'_segmented_field',
									array('element' => $element, 'field' => 'right_sphere'),
									false, false
							) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_cylinder'); ?>
							:
						</div>
						<div class="data segmented">
							<?php $this->renderPartial(
									'_segmented_field',
									array('element' => $element, 'field' => 'right_cylinder'),
									false, false
							) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_axis'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeTextField($element, 'right_axis', array('class' => 'axis')) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('right_type'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'right_type', $types) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="right eventDetail">
			<div data-side="left">
				<?php
				$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
						'identifier' => 'left_'.$element->elementType->id,
						'side' => 'L',
						'mode' => 'edit',
						'size' => 160,
						'model' => $element,
						'attribute' => 'left_axis_eyedraw',
						'no_wrapper' => true,
						'toolbar' => false,
						'onLoadedCommandArray' => array(
								array('addDoodle', array('TrialFrame')),
								array('addDoodle', array('TrialLens')),
								array('deselectDoodles', array()),
						),
				));
				?>
				<div class="eyedrawFields">
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_sphere'); ?>
							:
						</div>
						<div class="data segmented">
							<?php $this->renderPartial(
									'_segmented_field',
									array('element' => $element, 'field' => 'left_sphere'),
									false, false
							) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_cylinder'); ?>
							:
						</div>
						<div class="data segmented">
							<?php $this->renderPartial(
									'_segmented_field',
									array('element' => $element, 'field' => 'left_cylinder'),
									false, false
							) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_axis'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeTextField($element, 'left_axis', array('class' => 'axis')) ?>
						</div>
					</div>
					<div>
						<div class="label">
							<?php echo $element->getAttributeLabel('left_type'); ?>
							:
						</div>
						<div class="data">
							<?php echo CHtml::activeDropDownList($element, 'left_type', $types) ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
							
$(document).ready(function() {

	$('#event_display').delegate('.element input.axis', 'change', function() {
		var axis = $(this).val();
		axis = axis % 180;
		$(this).val(axis);
		var side = $(this).closest('[data-side]').attr('data-side');
		var element_type_id = $(this).closest('.element').attr('data-element-type-id');
		var eyedraw = window['ed_drawing_edit_' + side + '_' + element_type_id];
		eyedraw.setParameterForDoodleOfClass('TrialLens', 'axis', axis);
	});

	$('#event_display').delegate('.element .segmented select', 'change', function() {
		var field = $(this).nextAll('input');
		updateSegmentedField(field);
	});
	
	function updateSegmentedField(field) {
		var parts = $(field).parent().children('select');
		var value = $(parts[0]).val() * (parseFloat($(parts[1]).val()) + parseFloat($(parts[2]).val()));
		$(field).val(value.toFixed(2));
	}

	
});

// Global function to handle eyedraw events for this element
function updateElement_OphCiExamination_Refraction(drawing, doodle) {
	if (doodle && doodle.className == 'TrialLens') {
		var side = (drawing.eye == 0) ? 'right' : 'left';
		$('#Element_OphCiExamination_Refraction_'+side+'_axis').val(doodle.getParameter('axis'));
	}
}

</script>
