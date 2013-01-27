<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail">
		<?php if ($element->present) { ?>
		Peripheral Oedema present in <?php echo $element->body_part ?>
		<?php } else { ?>
		No Peripheral Oedema present
		<?php } ?>
	</div>
</div>
