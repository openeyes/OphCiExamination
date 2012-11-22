<?php
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array('NuclearCataract','CorticalCataract','PostSubcapCataract','PCIOL','ACIOL','Bleb','PI','Fuchs','RK','LasikFlap','CornealScar'),
		'onReadyCommandArray' => array(
				array('addDoodle', array('AntSeg')),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
		),
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'edit',
		'width' => 300,
		'height' => 300,
		'model' => $element,
		'attribute' => $side.'_eyedraw',
));
?>
<div class="eyedrawFields">
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_pupil_id'); ?>:
		</div>
		<div class="data">
			<?php echo CHtml::activeDropDownList($element, $side.'_pupil_id', CHtml::listData(OphCiExamination_AnteriorSegment_Pupil::model()->findAll(array('order'=>'display_order')),'id','name'))?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_nuclear_id'); ?>:
		</div>
		<div class="data">
			<?php echo CHtml::activeDropDownList($element, $side.'_nuclear_id', CHtml::listData(OphCiExamination_AnteriorSegment_Nuclear::model()->findAll(array('order'=>'display_order')),'id','name'))?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_cortical_id'); ?>:
		</div>
		<div class="data">
			<?php echo CHtml::activeDropDownList($element, $side.'_cortical_id', CHtml::listData(OphCiExamination_AnteriorSegment_Cortical::model()->findAll(array('order'=>'display_order')),'id','name'))?>
		</div>
	</div>
	<div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_description'); ?>:
		</div>
		<div class="data">
			<?php echo CHtml::activeTextArea($element, $side.'_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
		</div>
	</div>
	<div>
		<div class="data">
			<?php echo CHtml::activeCheckBox($element, $side.'_pxe') ?>
		</div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_pxe'); ?>
		</div>
	</div>
	<div>
		<div class="data">
			<?php echo CHtml::activeCheckBox($element, $side.'_phako') ?>
		</div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_phako'); ?>
		</div>
	</div>
	<button class="ed_report">Report</button>
	<button class="ed_clear">Clear</button>
</div>
