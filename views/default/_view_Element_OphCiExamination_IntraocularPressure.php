<div class="cols2 clearfix">
	<div class="left eventDetail">
		<div class="data">
			<?php if($element->right_reading->name != 'NR') { ?>
			<?php echo $element->right_reading->name ?>
			<?php if($element->right_instrument) { 
					echo '('.$element->right_instrument->name.')';
			} ?>
			<?php } else { ?>
			Not Recorded
			<?php }?>
		</div>
	</div>
	<div class="right eventDetail">
		<div class="data">
			<?php if($element->left_reading->name != 'NR') { ?>
			<?php echo $element->left_reading->name ?>
			<?php if($element->left_instrument) { 
					echo '('.$element->left_instrument->name.')';
			} ?>
			<?php } else { ?>
			Not Recorded
			<?php }?>
		</div>
	</div>
</div>
