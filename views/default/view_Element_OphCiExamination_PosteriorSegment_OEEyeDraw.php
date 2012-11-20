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