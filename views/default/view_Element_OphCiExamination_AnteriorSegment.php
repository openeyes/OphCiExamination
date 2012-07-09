<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<?php
		$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
				'identifier' => 'right_'.$element->elementType->id,
				'side' => 'R',
				'mode' => 'view',
				'size' => 200,
				'model' => $element,
				'no_wrapper' => true,
				'attribute' => 'right_eyedraw',
		));
		?>
		<div class="eyedrawFields view">
			<div>
				<div class="data">
					<?php echo $element->right_description ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_diagnosis_id') ?>
					:
					<?php if($element->right_diagnosis) { 
						echo $element->right_diagnosis->term;
					} else {
						echo 'None';
				} ?>
				</div>
			</div>
		</div>
	</div>
	<div class="right eventDetail">
		<?php
		$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
				'identifier' => 'left_'.$element->elementType->id,
				'side' => 'L',
				'mode' => 'view',
				'size' => 200,
				'model' => $element,
				'no_wrapper' => true,
				'attribute' => 'left_eyedraw',
		));
		?>
		<div class="eyedrawFields view">
			<div>
				<div class="data">
					<?php echo $element->left_description ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('left_diagnosis_id') ?>
					:
					<?php if($element->left_diagnosis) { 
						echo $element->left_diagnosis->term;
					} else {
						echo 'None';
				} ?>
				</div>
			</div>
		</div>
	</div>
</div>
