<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data">
				<?php if($element->hasRight()) { ?>
				<?php foreach($element->right_readings as $reading) { ?>
				<div>
				<?php echo $reading->value ?>
				</div>
				<?php } ?>
				<?php if($element->right_comments) { ?>
				(
				<?php echo $element->right_comments ?>
				)
				<?php } ?>
				<?php } else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="data">
				<?php if($element->hasLeft()) { ?>
				<?php foreach($element->left_readings as $reading) { ?>
				<div>
				<?php echo $reading->value ?>
				</div>
				<?php } ?>
				<?php if($element->left_comments) { ?>
				(
				<?php echo $element->left_comments ?>
				)
				<?php } ?>
				<?php } else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
	</div>
</div>
