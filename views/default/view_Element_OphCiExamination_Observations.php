<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="eventDetail">
		Pulse: <?php echo $element->pulse_bpm?> BPM<br/>
		Radial: <?php echo $element->radial->name?><br/>
		Pedial: <?php echo $element->pedial->name?><br/>
		Systolic pressure: <?php echo $element->pressure_systolic?><br/>
		Diastolic pressure: <?php echo $element->pressure_diastolic?><br/>
		Respiratory rate: <?php echo $element->respiratory_rate?><br/>
		Saturation: <?php echo $element->saturation?><br/>
		Temperature: <?php echo $element->temperature?><br/>
		JVP: <?php echo $element->jvp_raised ? 'Raised '.$element->jvp_cm.' cm' : 'Not raised'?><br/>
	</div>
</div>
