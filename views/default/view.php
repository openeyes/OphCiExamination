<?php
$this->breadcrumbs=array($this->module->id);
$this->header();
?>

<h3 class="withEventIcon" style="background:transparent url(<?php echo $this->assetPath?>/img/medium.png) center left no-repeat;">
	<?php echo $this->event_type->name ?>
</h3>

<div>
	<?php $this->renderDefaultElements($this->action->id); ?>
	<div class="cleartall"></div>
</div>

<div class="OphCiExamination_footer">
	Created on <?php echo $this->event->NHSDate('created_date')?> at <?php echo substr($this->event->created_date,11,5)?> by <?php echo User::model()->findByPk($this->event->created_user_id)->fullnameandtitle?><br/>
	Last modified on <?php echo $this->event->NHSDate('last_modified_date')?> at <?php echo substr($this->event->last_modified_date,11,5)?> by <?php echo User::model()->findByPk($this->event->last_modified_user_id)->fullnameandtitle?><br/>
</div>

<div class="form_button">
	<img class="loader" style="display: none;" src="<?php echo Yii::app()->createUrl('img/ajax-loader.gif')?>" alt="loading..." />&nbsp;
	<button type="submit" class="classy blue venti" id="et_print" name="print"><span class="button-span button-span-blue">Print</span></button>
</div>

<iframe id="print_iframe" name="print_iframe" style="display: none;" src="<?php echo Yii::app()->createUrl('OphCiExamination/Default/print/'.$this->event->id)?>"></iframe>

<?php $this->footer() ?>
