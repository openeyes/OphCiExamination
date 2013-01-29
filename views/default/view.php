<?php
$this->breadcrumbs=array($this->module->id);
$this->header();
?>

<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;">
	<?php echo $this->event_type->name ?>
</h3>

<div id="event_<?php echo $this->module->name?>">
	<div id="elements" class="view">
		<?php $this->renderDefaultElements($this->action->id); ?>
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
<div class="form_button">
	<img class="loader" style="display: none;" src="<?php echo Yii::app()->createUrl('img/ajax-loader.gif')?>" alt="loading..." />&nbsp;
	<button type="submit" class="classy blue venti" id="et_print" name="print"><span class="button-span button-span-blue">Print</span></button>
</div>

<iframe id="print_iframe" name="print_iframe" style="display: none;" src="<?php echo Yii::app()->createUrl('OphCiExamination/Default/print/'.$this->event->id)?>"></iframe>

<?php $this->footer() ?>
