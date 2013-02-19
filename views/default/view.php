<?php $this->header() ?>

<h3 class="withEventIcon">
	<?php echo $this->event_type->name ?>
</h3>

<?php
	// Event actions
	$this->event_actions[] = EventAction::button('Print', 'print');
	$this->renderPartial('//patient/event_actions');
?>

<div id="event_<?php echo $this->module->name?>">
	<div id="elements" class="view">
		<?php $this->renderDefaultElements('view'); ?>
	</div>
</div>

<?php $this->footer() ?>
