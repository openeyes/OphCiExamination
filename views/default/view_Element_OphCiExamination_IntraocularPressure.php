<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<h5>Right</h5>
		<div class="data">
			<?php if($element->right_reading) { ?>
			<?php echo $element->right_reading ?>
			(<?php echo $element->right_instrument->name ?>)
			<?php } else { ?>
			Not Recorded
			<?php }?>
		</div>
	</div>
	<div class="right eventDetail">
		<h5>Left</h5>
		<div class="data">
			<?php if($element->left_reading) { ?>
			<?php echo $element->left_reading ?>
			(<?php echo $element->left_instrument->name ?>)
			<?php } else { ?>
			Not Recorded
			<?php }?>
		</div>
	</div>
</div>
