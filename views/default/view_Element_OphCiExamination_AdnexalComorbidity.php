<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left">
		<h4>
			<?php echo CHtml::encode($element->getAttributeLabel('left_description'))?>
		</h4>
		<p>
			<?php echo $element->left_description ?>
		</p>
	</div>
	<div class="right">
		<h4>
			<?php echo CHtml::encode($element->getAttributeLabel('right_description'))?>
		</h4>
		<p>
			<?php echo $element->right_description ?>
		</p>
	</div>
</div>
