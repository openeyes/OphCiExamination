<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left">
		<h4>Left</h4>
		<p>
			<?php echo $element->getAttributeLabel('left_initial_id'); ?>
			:
			<?php echo $element->left_initial_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('left_wearing_id'); ?>
			:
			<?php echo $element->left_wearing_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('left_corrected_id'); ?>
			:
			<?php echo $element->left_corrected_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('left_method'); ?>
			:
			<?php echo $element->left_method ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('left_comments'); ?>
			:
			<?php echo $element->left_comments ?>
		</p>
	</div>
	<div class="right">
		<h4>Right</h4>
		<p>
			<?php echo $element->getAttributeLabel('right_initial_id'); ?>
			:
			<?php echo $element->right_initial_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('right_wearing_id'); ?>
			:
			<?php echo $element->right_wearing_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('right_corrected_id'); ?>
			:
			<?php echo $element->right_corrected_id ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('right_method'); ?>
			:
			<?php echo $element->right_method ?>
		</p>
		<p>
			<?php echo $element->getAttributeLabel('right_comments'); ?>
			:
			<?php echo $element->right_comments ?>
		</p>
	</div>
</div>
