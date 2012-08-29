<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php
			$this->widget('application.modules.eyedraw.OEEyeDrawWidgetCataractAssessment', array(
					'identifier' => 'right_'.$element->elementType->id,
					'side' => 'R',
					'mode' => 'view',
					'size' => 200,
					'model' => $element,
					'attribute' => 'right_eyedraw',
			))?>
		</div>
		<div class="right eventDetail">
			<?php
			$this->widget('application.modules.eyedraw.OEEyeDrawWidgetCataractAssessment', array(
					'identifier' => 'left_'.$element->elementType->id,
					'side' => 'L',
					'mode' => 'view',
					'size' => 200,
					'model' => $element,
					'attribute' => 'left_eyedraw',
			))?>
		</div>
	</div>
</div>
