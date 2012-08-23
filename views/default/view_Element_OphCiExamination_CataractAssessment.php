<div class="element <?php echo $element->elementType->class_name ?>">
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
						'size' => 200,
						'model' => $element,
						'no_wrapper' => true,
						'attribute' => 'right_eyedraw',
						'onLoadedParamsArray' => array(
								array('AntSeg', 'pxe', (bool) $element->right_pxe),
						),
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
						<?php echo $element->getAttributeLabel('right_pupil_id'); ?>
						:
						<?php echo $element->right_pupil->name ?>
					</div>
				</div>
				<div>
					<div class="data">
						<?php echo $element->getAttributeLabel('right_nuclear_id'); ?>
						:
						<?php echo $element->right_nuclear->name ?>
					</div>
				</div>
				<div>
					<div class="data">
						<?php echo $element->getAttributeLabel('right_cortical_id'); ?>
						:
						<?php echo $element->right_cortical->name ?>
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
			<?php
			$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
					'identifier' => 'left_'.$element->elementType->id,
					'side' => 'L',
					'mode' => 'view',
					'size' => 200,
					'model' => $element,
					'no_wrapper' => true,
					'attribute' => 'left_eyedraw',
					'onLoadedParamsArray' => array(
							array('AntSeg', 'pxe', (bool) $element->left_pxe),
					),
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
						<?php echo $element->getAttributeLabel('left_pupil_id'); ?>
						:
						<?php echo $element->left_pupil->name ?>
					</div>
				</div>
				<div>
					<div class="data">
						<?php echo $element->getAttributeLabel('left_nuclear_id'); ?>
						:
						<?php echo $element->left_nuclear->name ?>
					</div>
				</div>
				<div>
					<div class="data">
						<?php echo $element->getAttributeLabel('left_cortical_id'); ?>
						:
						<?php echo $element->left_cortical->name ?>
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
</div>
