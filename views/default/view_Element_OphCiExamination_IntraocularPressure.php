<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left">
		<h4>Left</h4>
		<p>
			<?php echo $element->left_instrument->name ?>
			:
			<?php echo $element->left_reading ?>
		</p>
	</div>
	<div class="right">
		<h4>Right</h4>
		<p>
			<?php echo $element->right_instrument->name ?>
			:
			<?php echo $element->right_reading ?>
		</p>
	</div>
</div>
