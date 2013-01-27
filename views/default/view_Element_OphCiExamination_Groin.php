<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail clearfix">
		<?php
		$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
			'mode'=>'view',
			'width'=>200,
			'height'=>200,
			'idSuffix'=> $element->elementType->id,
			'model'=>$element,
			'attribute'=>'eyedraw',
		));
		?>
	<div class="eyedrawFields view">
		<div>
			<div class="label">Bruising:</div>
			<div class="data">
				<?php echo ($element->bruising) ? 'Yes' : 'No'; ?>
			</div>
		</div>
		<div>
			<div class="label">Mass:</div>
			<div class="data">
				<?php echo ($element->mass) ? 'Yes' : 'No'; ?>
			</div>
		</div>
		<div>
			<div class="label">Mass Type:</div>
			<div class="data">
				<?php echo $element->mass_type ?>
			</div>
		</div>
		<?php if($element->mass_type == 'pulsitile') { ?>
		<div>
			<div class="label">Expansile:</div>
			<div class="data">
				<?php echo ($element->expansile) ? 'Yes' : 'No'; ?>
			</div>
		</div>
		<?php } ?>
		<div>
			<div class="label">Bruit:</div>
			<div class="data">
				<?php echo ($element->bruit) ? 'Yes' : 'No'; ?>
			</div>
		</div>
	</div>
</div>
