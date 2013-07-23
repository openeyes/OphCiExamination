	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_clinical_id') ?>:</div>
		<div class="data"><?php echo $element[$side . '_clinical']->name ?></div>
	</div>
	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_nscretinopathy_id') ?>:</div>
		<div class="data"><?php echo $element[$side . '_nscretinopathy']->name ?></div>
	</div>
	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_nscretinopathy_photocoagulation') ?>:</div>
		<div class="data"><?php echo ($element[$side . '_nscretinopathy_photocoagulation']) ? "Yes" : "No" ?></div>
	</div>
	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_nscmaculopathy_id') ?>:</div>
		<div class="data"><?php echo $element[$side . '_nscmaculopathy']->name ?></div>
	</div>
	<div class="eventDetail aligned">
		<div class="label"><?php echo $element->getAttributeLabel($side . '_nscmaculopathy_photocoagulation') ?>:</div>
		<div class="data"><?php echo ($element[$side . '_nscmaculopathy_photocoagulation']) ? "Yes" : "No" ?></div>
	</div>
