<?php 
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'idSuffix' => $side.'_'.$element->elementType->id.'_'.$element->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'view',
		'width' => 200,
		'height' => 200,
		'model' => $element,
		'attribute' => $side.'_eyedraw',
			
));
?>
<div class="eyedrawFields view">
	<?php if($description = $element->{$side . '_description'}) { ?>
	<div>
		<div class="data">
			<?php echo $description ?>
		</div>
	</div>
	<?php } ?>
	<div>
		<div class="label aligned">
			<?php echo $element->getAttributeLabel($side . '_cd_ratio_id') ?>:
			<?php echo $element[$side . '_cd_ratio']->name ?>
		</div>
	</div>
</div>
