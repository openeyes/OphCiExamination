<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<h5>Right</h5>
		<div class="data">
			<?php echo $element->right_instrument->name ?>
			:
			<?php echo $element->right_reading ?>
		</div>
	</div>
	<div class="right eventDetail">
		<h5>Left</h5>
		<div class="data">
			<?php echo $element->left_instrument->name ?>
			:
			<?php echo $element->left_reading ?>
		</div>
	</div>
</div>
