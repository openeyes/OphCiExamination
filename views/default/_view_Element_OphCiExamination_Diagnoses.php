	<?php foreach ($element->diagnoses as $diagnosis) {?>
		<div class="eventDetail">
			<?php if ($diagnosis->principal) {?>
				<strong>
			<?php }?>
			<?php echo $diagnosis->eye->adjective; ?>
			<?php echo $diagnosis->disorder->term; ?>
			<?php if ($diagnosis->principal) {?>
				</strong>
			<?php }?>
		</div>
	<?php }?>
