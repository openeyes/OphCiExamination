<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<h5>Right</h5>
		<div class="data">
			<?php echo $element->getCombined('right') ?>
			<?php if($element->right_comments) { ?>
			(<?php echo $element->right_comments ?>)
			<?php } ?>
		</div>
	</div>
	<div class="right eventDetail">
		<h5>Left</h5>
		<div class="data">
			<?php echo $element->getCombined('left') ?>
			<?php if($element->left_comments) { ?>
			(<?php echo $element->left_comments ?>)
			<?php } ?>
		</div>
	</div>
</div>
