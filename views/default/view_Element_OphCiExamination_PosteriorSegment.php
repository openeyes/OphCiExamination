<div class="element <?php echo $element->elementType->class_name ?>">
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
					'attribute' => 'right_eyedraw',
			))?>
			<div class="eyedrawFields view">
				<div>
					<div class="data">
						<?php echo $element->right_description ?>
					</div>
				</div>
				<div>
					<div class="data">
						<?php echo $element->getAttributeLabel('right_cd_ratio_id') ?>
						:
						<?php echo $element->right_cd_ratio->name ?>
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
						<?php echo $element->getAttributeLabel('left_cd_ratio_id') ?>
						:
						<?php echo $element->left_cd_ratio->name ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
