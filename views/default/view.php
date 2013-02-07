<?php $this->header() ?>

<h3 class="withEventIcon">
	<?php echo $this->event_type->name ?>
</h3>
<!-- START EVENT CONTENT -->

<div id="event_<?php echo $this->module->name?>">
	<div id="elements" class="view">
		<?php $this->renderDefaultElements('view'); ?>
	</div>
</div>

<div class="metaData">
	<span class="info">Examination created by <span class="user"><?php echo $this->event->user->fullname ?></span>
		on <?php echo $this->event->NHSDate('created_date') ?>
		at <?php echo date('H:i', strtotime($this->event->created_date)) ?></span>
	<span class="info">Examination last modified by <span class="user"><?php echo $this->event->usermodified->fullname ?></span>
		on <?php echo $this->event->NHSDate('last_modified_date') ?>
		at <?php echo date('H:i', strtotime($this->event->last_modified_date)) ?></span>
</div>

<div class="cleartall"></div>
<?php
	// Event actions
	$this->event_actions[] = EventAction::button('Print', 'print');
	$this->renderPartial('//patient/event_actions');
?>

<iframe id="print_iframe" name="print_iframe" style="display: none;" src="<?php echo Yii::app()->createUrl('OphCiExamination/Default/print/'.$this->event->id)?>"></iframe>

<?php $this->footer() ?>
