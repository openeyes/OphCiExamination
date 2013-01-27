<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="clearfix eventDetail">
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
			<?php if($description = $element->description) { ?>
			<div>
				<div class="data">
					<?php echo $description ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
