<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<div>
			<?php
			$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
					'identifier' => 'right_'.$element->elementType->id,
					'side' => 'R',
					'mode' => 'view',
					'size' => 100,
					'model' => $element,
					'attribute' => 'right_axis_eyedraw',
					'no_wrapper' => true,
					'toolbar' => false,
					'onLoadedCommandArray' => array(
							array('addDoodle', array('TrialFrame')),
							array('addDoodle', array('TrialLens')),
							array('deselectDoodles', array()),
					),
			));
			?>
		</div>
		<div class="eyedrawFields view">
			<div>
				<div class="data">
					<?php echo $element->getCombined('right') ?>
				</div>
			</div>
		</div>
	</div>
	<div class="right eventDetail">
		<div>
			<?php
			$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
					'identifier' => 'left_'.$element->elementType->id,
					'side' => 'L',
					'mode' => 'view',
					'size' => 100,
					'model' => $element,
					'attribute' => 'left_axis_eyedraw',
					'no_wrapper' => true,
					'toolbar' => false,
					'onLoadedCommandArray' => array(
							array('addDoodle', array('TrialFrame')),
							array('addDoodle', array('TrialLens')),
							array('deselectDoodles', array()),
					),
			));
			?>
		</div>
		<div class="eyedrawFields view">
			<div>
				<div class="data">
					<?php echo $element->getCombined('left') ?>
				</div>
			</div>
		</div>
	</div>
</div>
