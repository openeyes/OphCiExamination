<?php
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array('Geographic','VitreousOpacity','DiabeticNV','CNV','Circinate','CystoidMacularOedema','EpiretinalMembrane','HardDrusen','PRPPostPole','MacularHole'),
		'onReadyCommandArray' => array(
				array('addDoodle', array('PostPole')),
				array('deselectDoodles', array()),
		),
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'edit',
		'model' => $element,
		'attribute' => $side.'_eyedraw',
));
?>
<div class="eyedrawFields">
	<div>
		<div class="label">
			<?php echo $element->getAttributeLabel($side . '_description'); ?>
			:
		</div>
		<div class="data">
			<?php echo CHtml::activeTextArea($element, $side . '_description', array('rows' => "2", 'cols' => "20", 'class' => 'autosize clearWithEyedraw')) ?>
		</div>
	</div>
	<button class="ed_report">Report</button>
	<button class="ed_clear">Clear</button>
</div>
