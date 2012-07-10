<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<div class="cols2 clearfix">
	<div class="left eventDetail">
		<div class="data">
			<?php echo $element->getCombined('right') ?>
		</div>
	</div>
	<div class="right eventDetail">
		<div class="data">
			<?php echo $element->getCombined('left') ?>
		</div>
	</div>
</div>
