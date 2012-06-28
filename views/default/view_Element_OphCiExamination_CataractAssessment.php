<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<h5>Left</h5>
<p>
	<?php
	$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
			'identifier' => 'left_'.$element->elementType->id,
			'side' => 'L',
			'mode' => 'view',
			'size' => 200,
			'model' => $element,
			'attribute' => 'left_eyedraw',
	));
	?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_description'); ?>
	:
	<?php echo $element->left_description ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_pupil'); ?>
	:
	<?php echo $element->left_pupil ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_nuclear'); ?>
	:
	<?php echo $element->left_nuclear ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_cortical'); ?>
	:
	<?php echo $element->left_cortical ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_pxe'); ?>
	:
	<?php echo $element->left_pxe ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_phako'); ?>
	:
	<?php echo $element->left_phako ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('left_surgeon'); ?>
	:
	<?php echo $element->left_surgeon ?>
</p>

<h5>Right</h5>
<p>
	<?php
	$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
			'identifier' => 'right_'.$element->elementType->id,
			'side' => 'R',
			'mode' => 'view',
			'size' => 200,
			'model' => $element,
			'attribute' => 'right_eyedraw',
	));
	?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_description'); ?>
	:
	<?php echo $element->right_description ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_pupil'); ?>
	:
	<?php echo $element->right_pupil ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_nuclear'); ?>
	:
	<?php echo $element->right_nuclear ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_cortical'); ?>
	:
	<?php echo $element->right_cortical ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_pxe'); ?>
	:
	<?php echo $element->right_pxe ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_phako'); ?>
	:
	<?php echo $element->right_phako ?>
</p>
<p>
	<?php echo $element->getAttributeLabel('right_surgeon'); ?>
	:
	<?php echo $element->right_surgeon ?>
</p>
