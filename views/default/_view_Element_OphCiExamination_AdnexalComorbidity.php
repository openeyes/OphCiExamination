	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<div class="data">
				<?php if($element->hasRight()) {
					echo $element->right_description;
				} else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
		<div class="right eventDetail">
			<div class="data">
				<?php if($element->hasLeft()) {
					echo $element->left_description;
				} else { ?>
				Not recorded
				<?php } ?>
			</div>
		</div>
	</div>
