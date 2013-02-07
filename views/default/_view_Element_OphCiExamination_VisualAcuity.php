	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) { ?>
			<div class="data">
				<?php echo $element->unit->name ?>
			</div>
			<div class="data">
				<?php echo $element->getCombined('right') ?>
			</div>
			<?php if($element->right_comments) { ?>
			<div class="data">
				(<?php echo $element->right_comments ?>)
			</div>
			<?php } ?>
			<?php } else { ?>
			<div class="data">Not recorded</div>
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) { ?>
			<div class="data">
				<?php echo $element->unit->name ?>
			</div>
			<div class="data">
				<?php echo $element->getCombined('left') ?>
			</div>
			<?php if($element->left_comments) { ?>
			<div class="data">
				(<?php echo $element->left_comments ?>)
			</div>
			<?php } ?>
			<?php } else { ?>
			<div class="data">Not recorded</div>
			<?php } ?>
		</div>
	</div>
