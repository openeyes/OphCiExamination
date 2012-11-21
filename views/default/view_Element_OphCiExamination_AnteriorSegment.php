<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) {
				$this->widget('application.modules.eyedraw.OEEyeDrawWidgetAnteriorSegment', array(
					'identifier' => 'right_'.$element->elementType->id,
					'side' => 'R',
					'mode' => 'view',
					'size' => 200,
					'model' => $element,
					'attribute' => 'right_eyedraw',
				));
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) {
				$this->widget('application.modules.eyedraw.OEEyeDrawWidgetAnteriorSegment', array(
					'identifier' => 'left_'.$element->elementType->id,
					'side' => 'L',
					'mode' => 'view',
					'size' => 200,
					'model' => $element,
					'attribute' => 'left_eyedraw',
				));
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
	</div>
</div>
