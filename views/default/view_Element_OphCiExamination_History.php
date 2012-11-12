<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail">
		<?php  echo $element->description ?><br/><br/>
		<?php if ($element->previous_refractive_surgery) {?>
			Has had previous refractive surgery.
		<?php }else{?>
			Has not had previous refractive surgery.
		<?php }?>
	</div>
</div>
