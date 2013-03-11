<?php
$widget = $this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array(
				array('Geographic','VitreousOpacity','DiabeticNV','CNV','Circinate','CystoidMacularOedema',
				'EpiretinalMembrane','HardDrusen'),
				array('MacularHole', 'Microaneurysm', 'HardExudate', 'BlotHaemorrhage',
				'PreRetinalHaemorrhage', 'CottonWoolSpot', 'FibrousProliferation', 'TractionRetinalDetachment', 'IRMA', 'MacularThickening'),
				array('LaserSpot', 'FocalLaser', 'MacularGrid', 'SectorPRPPostPole', 'PRPPostPole'),
				),
		'onReadyCommandArray' => array(
				array('addDoodle', array('PostPole')),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
				'PostPole' => array(
						'cdRatio' => array('id' => 'Element_OphCiExamination_PosteriorSegment_'.$side.'_cd_ratio_id', 'attribute' => 'data-val'),
				),
		),
		'listenerArray' => array('posteriorListener'),
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
