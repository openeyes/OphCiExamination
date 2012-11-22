<?php 
$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
		'idSuffix' => $side.'_'.$element->elementType->id,
		'side' => ($side == 'right') ? 'R' : 'L',
		'mode' => 'view',
		'width' => 200,
		'height' => 200,
		'model' => $element,
		'attribute' => $side.'_eyedraw',
));
?>
<div class="eyedrawFields view">
	<?php if($description = $element->{$side.'_description'}) { ?>
	<div>
		<div class="data">
			<?php echo $description ?>
		</div>
	</div>
	<?php } ?>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_pupil_id') ?>
			:
		</div>
		<div class="data">
			<?php echo $element->{$side.'_pupil'}->name ?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_nuclear_id') ?>
			:
		</div>
		<div class="data">
			<?php echo $element->{$side.'_nuclear'}->name ?>
		</div>
	</div>
	<div class="aligned">
		<div class="label">
			<?php echo $element->getAttributeLabel($side.'_cortical_id') ?>
			:
		</div>
		<div class="data">
			<?php echo $element->{$side.'_cortical'}->name ?>
		</div>
	</div>
	<?php if($element->{$side.'_pxe'}) { ?>
	<div>
		<div class="data">
			<?php echo $element->getAttributeLabel($side.'_pxe') ?>
		</div>
	</div>
	<?php } ?>
	<?php if($element->{$side.'_phako'}) { ?>
	<div>
		<div class="data">
			<?php echo $element->getAttributeLabel($side.'_phako') ?>
		</div>
	</div>
	<?php } ?>
</div>
