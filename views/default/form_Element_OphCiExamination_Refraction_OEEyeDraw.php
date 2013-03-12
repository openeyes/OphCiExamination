<?php
$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array(),
		'toolbar' => false,
		'onReadyCommandArray' => array(
				array('addDoodle', array('TrialFrame')),
				array('addDoodle', array('TrialLens')),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
			'TrialLens' => array(
					'axis' => array('id' => 'Element_OphCiExamination_Refraction_'.$side.'_axis'),
			),
		),
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'edit',
		'width' => 160,
		'height' => 160,
		'model' => $element,
		'attribute' => $side.'_axis_eyedraw',
));
?>
<div class="eyedrawFields">
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_sphere'); ?>
			:
		</div>
		<div class="data segmented">
			<?php Yii::app()->getController()->renderPartial('_segmented_field', array('element' => $element, 'field' => $side.'_sphere'), false, false)?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_cylinder'); ?>
			:
		</div>
		<div class="data segmented">
			<?php Yii::app()->getController()->renderPartial('_segmented_field', array('element' => $element, 'field' => $side.'_cylinder'), false, false)?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_axis'); ?>
			:
		</div>
		<div class="data">
			<?php echo CHtml::activeTextField($element, $side.'_axis', array('class' => 'axis')) ?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_type_id'); ?>
			:
		</div>
		<div class="data">
			<?php echo CHtml::activeDropDownList($element, $side.'_type_id', OphCiExamination_Refraction_Type::model()->getOptions(), array('class' => 'refractionType'))?>
			<?php echo CHtml::activeTextField($element, $side.'_type_other')?>
		</div>
	</div>
</div>
