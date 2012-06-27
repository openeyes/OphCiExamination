<h4 class="elementTypeName">
	<?php  echo $element->elementType->name ?>
</h4>
<p>
	<?php
	$this->widget('application.modules.eyedraw.OEEyeDrawWidget', array(
			'side' => 'R',
			'mode' => 'view',
			'size' => 200,
			'model' => $element,
			'attribute' => 'eyedraw',
	));
	?>
</p>
<p>
	Description:
	<?php echo $element->description ?>
</p>
<p>
	Diagnosis:
	<?php echo $element->diagnosis->term ?>
</p>
