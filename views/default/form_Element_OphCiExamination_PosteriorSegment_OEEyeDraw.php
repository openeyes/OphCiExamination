<?php
$widget = $this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'doodleToolBarArray' => array('Geographic','VitreousOpacity','DiabeticNV','CNV','Circinate','CystoidMacularOedema','EpiretinalMembrane','HardDrusen','PRPPostPole','MacularHole'),
		'onReadyCommandArray' => array(
				array('addDoodle', array('PostPole')),
				array('deselectDoodles', array()),
		),
		'bindingArray' => array(
				'PostPole' => array(
						'cdRatio' => array('id' => 'Element_OphCiExamination_PosteriorSegment_'.$side.'_cd_ratio_id', 'attribute' => 'data-val'),
				),
		),
		
		'controllerArray' => array('posteriorController'),
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'edit',
		'model' => $element,
		'attribute' => $side.'_eyedraw',
));
?>
<div class="eyedrawFields">
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side . '_cd_ratio_id'); ?>
			:
		</div>
		<div class="data">
			<?php 
			$cd_ratio_html_options = array('options' => array());
			foreach (OphCiExamination_PosteriorSegment_CDRatio::model()->findAll(array('order'=>'display_order')) as $ratio) {
				$cd_ratio_html_options['options'][(string)$ratio->id] = array('data-val'=> number_format((float)$ratio->name, 1, '.', ''));
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
	<?php if($element->getSetting('nsc_grade')) { ?>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_retinopathy_id'); ?>
		</div>
		<div class="data">
			<?php 
				$retinopathy_html_options = array('options' => array()); 
				foreach (OphCiExamination_PosteriorSegment_Retinopathy::model()->findAll(array('order'=>'display_order')) as $retin) {
					$retinopathy_html_options['options'][(string)$retin->id] = array('data-val' => $retin->name);
				}
				echo CHtml::activeDropDownList($element, $side . '_retinopathy_id', CHtml::listData(OphCiExamination_PosteriorSegment_Retinopathy::model()->findAll(array('order'=>'display_order')),'id','name'), $retinopathy_html_options);
			?>
		</div>
		
		<div>
		<?php foreach (OphCiExamination_PosteriorSegment_Retinopathy::model()->findAll(array('order'=>'display_order')) as $retin) {
			echo '<div style="display: none;" class="' . $side.'_'.$element->elementType->id . '_ret_desc" id="' . $side.'_'.$element->elementType->id . '_ret_desc_' . $retin->name . '">' . $retin->description . '</div>';
		}	
		?>
		</div>
		
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_maculopathy_id'); ?>
		</div>
		<div class="data">
			<?php 
				$macuopathy_html_options = array('options' => array()); 
				foreach (OphCiExamination_PosteriorSegment_Maculopathy::model()->findAll(array('order'=>'display_order')) as $macu) {
					$maculopathy_html_options['options'][(string)$macu->id] = array('data-val' => $macu->name);
				}
				echo CHtml::activeDropDownList($element, $side . '_maculopathy_id', CHtml::listData(OphCiExamination_PosteriorSegment_Maculopathy::model()->findAll(array('order'=>'display_order')),'id','name'), $maculopathy_html_options);
			?>
		</div>
		<div>
		<?php foreach (OphCiExamination_PosteriorSegment_Maculopathy::model()->findAll(array('order'=>'display_order')) as $macu) {
			echo '<div style="display: none;" class="' . $side.'_'.$element->elementType->id . '_mac_desc" id="' . $side.'_'.$element->elementType->id . '_mac_desc_' . $macu->name . '">' . $macu->description . '</div>';
		}	
		?>
		</div>
	</div>
	<?php }?>
</div>
