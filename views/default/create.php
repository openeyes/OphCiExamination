<?php
$this->breadcrumbs=array($this->module->id);
$this->header();
?>

<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->imgPath?>medium.png) center left no-repeat;">
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

	<?php $this->displayErrors($errors)?>

	<div id="elements">
		<div id="active_elements">
			<?php $this->renderDefaultElements($this->action->id, $form); ?>
		</div>
		<div id="optionals_all" class="clearfix">
			<h4>Optional Elements</h4>
			<div>
				<span class="allButton"><a id="add-all" href="#">Add all</a><img
					src="/img/_elements/icons/extra-element_added.png"
					alt="extra-element_added" width="30" height="20" /></span> <span
					class="allButton"><a id="remove-all" href="#">Remove all</a><img
					src="/img/_elements/icons/extra-element_remove.png"
					alt="extra-element_remove" width="30" height="20" /></span>
			</div>
		</div>
		<div id="inactive_elements">
			<?php $this->renderOptionalElements($this->action->id, $form); ?>
		</div>
	</div>

	<?php $this->displayErrors($errors)?>

	<div class="cleartall"></div>
	<div class="form_button">
		<img class="loader" style="display: none;" src="/img/ajax-loader.gif"
			alt="loading..." />&nbsp;
		<button type="submit" class="classy green venti" id="et_save"
			name="save">
			<span class="button-span button-span-green">Save</span>
		</button>
		<button type="submit" class="classy red venti" id="et_cancel"
			name="cancel">
			<span class="button-span button-span-red">Cancel</span>
		</button>
	</div>
	<?php $this->endWidget(); ?>
</div>

<?php $this->footer() ?>

