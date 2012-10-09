<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
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
</div>
