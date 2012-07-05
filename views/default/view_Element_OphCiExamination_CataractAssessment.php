<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<h5>Right</h5>
		<div>
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
		</div>
		<div class="eyedrawFields view">
			<div>
				<div class="data">
					<?php echo $element->right_description ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_pupil'); ?>
					:
					<?php echo $element->right_pupil ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_nuclear'); ?>
					:
					<?php echo $element->right_nuclear ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_cortical'); ?>
					:
					<?php echo $element->right_cortical ?>
				</div>
			</div>
			<?php if($element->right_pxe) { ?>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_pxe'); ?>
				</div>
			</div>
			<?php } ?>
			<?php if($element->right_phako) { ?>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('right_phako'); ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="right eventDetail">
		<h5>Left</h5>
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
					<?php echo $element->getAttributeLabel('left_pupil'); ?>
					:
					<?php echo $element->left_pupil ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('left_nuclear'); ?>
					:
					<?php echo $element->left_nuclear ?>
				</div>
			</div>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('left_cortical'); ?>
					:
					<?php echo $element->left_cortical ?>
				</div>
			</div>
			<?php if($element->left_pxe) { ?>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('left_pxe'); ?>
				</div>
			</div>
			<?php } ?>
			<?php if($element->left_phako) { ?>
			<div>
				<div class="data">
					<?php echo $element->getAttributeLabel('left_phako'); ?>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>
