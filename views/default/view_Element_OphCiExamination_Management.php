<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail">
		<?php echo $element->comments ?>
	</div>
	<div class="child_elements">
		<?php $this->renderChildDefaultElements($element, $this->action->id, $form, $data); ?>
	</div>
</div>
