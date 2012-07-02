<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left">
		<h4>Left</h4>
		<p>
			<?php echo $element->getCombined('left') ?>
			<?php if($element->left_comments) { ?>
			(<?php echo $element->left_comments ?>)
			<?php } ?>
		</p>
	</div>
	<div class="right">
		<h4>Right</h4>
		<p>
			<?php echo $element->getCombined('right') ?>
			<?php if($element->right_comments) { ?>
			(<?php echo $element->right_comments ?>)
			<?php } ?>
		</p>
	</div>
</div>
