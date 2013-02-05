<?php $this->header() ?>

<h3 class="withEventIcon">
	<?php echo $this->event_type->name ?>
</h3>

<div id="event_<?php echo $this->module->name?>">
	<?php
	$form = $this->beginWidget('BaseEventTypeCActiveForm', array(
			'id' => 'clinical-create',
			'enableAjaxValidation' => false,
			'htmlOptions' => array('class' => 'sliding'),
	));
	?>

	<div id="elements" class="form">
		<?php $this->displayErrors($errors)?>
		<div id="active_elements">
			<?php $this->renderDefaultElements($this->action->id, $form); ?>
		</div>
		<div class="optionals-header clearfix">
			<h4>Optional Elements</h4>
			<div>
				<span class="allButton"><a class="add-all" href="#">Add all</a><img
					src="<?php echo Yii::app()->createUrl('img/_elements/icons/extra-element_added.png')?>"
					alt="extra-element_added" width="30" height="20" /></span>
				<span class="allButton"><a class="remove-all" href="#">Remove all</a><img
					src="<?php echo Yii::app()->createUrl('img/_elements/icons/extra-element_remove.png')?>"
					alt="extra-element_remove" width="30" height="20" /></span>
			</div>
		</div>
		<div id="inactive_elements">
			<?php $this->renderOptionalElements($this->action->id, $form); ?>
		</div>
	</div>

	<?php $this->displayErrors($errors)?>

	<div class="cleartall"></div>
	<?php
		// Event actions
		$this->event_actions[] = EventAction::button('Save', 'save', array('colour' => 'green'));
		$this->renderPartial('//patient/event_actions');
	?>
	<?php $this->endWidget(); ?>
</div>

<?php $this->footer() ?>
