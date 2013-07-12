<h2><?php echo $element->elementType->name ?></h2>
<div class="details">
	<div class="eventDetail aligned">
		<div class="label"><?php echo CHtml::encode($element->getAttributeLabel('laser_status_id'))?>:</div>
		<div class="data"><?php echo $element->laser_status ?></div>
	</div>
	<?php if ($element->laser_status && $element->laser_status->deferred) { ?>
	<div class="eventDetail aligned">
		<div class="label"><?php echo CHtml::encode($element->getAttributeLabel('laser_deferralreason_id'))?>:</div>
		<div class="data"><?php echo $element->getLaserDeferralReason() ?></div>
	</div>
	<?php } ?>
</div>
