<?php
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array('Geographic','VitreousOpacity','DiabeticNV','CNV','Circinate','CystoidMacularOedema','EpiretinalMembrane','HardDrusen','PRPPostPole','MacularHole'),
		'onReadyCommandArray' => array(
				array('addDoodle', array('PostPole')),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
				'PostPole' => array(
						'cdRatio' => array('Element_OphCiExamination_PosteriorSegment_'.$side.'_cd_ratio_id', 'ed_val'),
				),
		),
		'scriptArray' => array('ED_MedicalRetina.js'),
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
			<?php echo $element->getAttributeLabel($side . '_cd_ratio_id'); ?>
			:
			<?php 
			$cd_ratio_html_options = array('options' => array());
			foreach (OphCiExamination_PosteriorSegment_CDRatio::model()->findAll(array('order'=>'display_order')) as $ratio) {
				$cd_ratio_html_options['options'][(string)$ratio->id] = array('ed_val'=> number_format((float)$ratio->name, 1, '.', ''));
			}
			?>
			<?php echo CHtml::activeDropDownList($element, $side . '_cd_ratio_id', CHtml::listData(OphCiExamination_PosteriorSegment_CDRatio::model()->findAll(array('order'=>'display_order')),'id','name'), $cd_ratio_html_options) ?>
		</div>
	</div>
	<div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side . '_description'); ?>
			:
		</div>
		<div class="data">
			<?php echo CHtml::activeTextArea($element, $side . '_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize')) ?>
		</div>
	</div>
	<button class="ed_report">Report</button>
	<button class="ed_clear">Clear</button>
</div>
