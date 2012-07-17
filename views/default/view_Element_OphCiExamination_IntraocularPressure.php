<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data">
				<?php if($element->right_reading) { ?>
				<?php echo $element->right_reading ?>
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
				<?php if($element->left_reading) { ?>
				<?php echo $element->left_reading ?>
				<?php if($element->left_instrument) { 
					echo '('.$element->left_instrument->name.')';
} ?>
				<?php } else { ?>
				Not Recorded
				<?php }?>
			</div>
		</div>
	</div>
</div>
