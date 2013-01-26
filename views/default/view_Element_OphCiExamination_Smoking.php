<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail">
		<?php if ($element->smoker) {?>
			Currently smokes<br/>
		<?php } else if ($element->past_smoker) {?>
			Has smoked in the past<br/>
		<?php } else {?>
			Has never smoked<br/>
		<?php }?>
		<?php if ($element->smoker || $element->past_smoker) {?>
			<?php echo $element->cigs_day?> cigarettes/day for <?php echo $element->duration?><br/>
		<?php }?>
	</div>
</div>
