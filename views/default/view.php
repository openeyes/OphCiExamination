<?php $this->header() ?>

<h3 class="withEventIcon">
	<?php echo $this->event_type->name ?>
</h3>

<?php
	// Event actions
	$this->event_actions[] = EventAction::button('Print', 'print');
	if($next_step = $this->getNextStep()) {
		$this->event_actions[] = EventAction::link($next_step->name,
				Yii::app()->createUrl($this->event->eventType->class_name.'/default/step/'.$this->event->id));
	}
	$this->renderPartial('//patient/event_actions');
?>

<div id="event_<?php echo $this->module->name?>">
	<div id="elements" class="view">
		<?php $this->renderDefaultElements('view'); ?>
	</div>
</div>

<?php $this->footer() ?>
