<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) {
				$this->beginWidget('application.modules.eyedraw2.OEEyeDrawWidget', array(
						'scriptArray' => array('ED_MedicalRetina.js', 'ED_VitreoRetinal.js'),
						'idSuffix' => 'right_'.$element->elementType->id,
						'side' => 'R',
						'mode' => 'view',
						'width' => 200,
						'height' => 200,
						'model' => $element,
						'attribute' => 'right_eyedraw',
							
				));
				$this->renderPartial('view_' . get_class($element) . '_OEEyeDraw', 
					array('side' => 'right', 'element' => $element)); 
				$this->endWidget();
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) {
				$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
					'scriptArray' => array('ED_MedicalRetina.js', 'ED_VitreoRetinal.js'),
					'idSuffix' => 'left_'.$element->elementType->id,
					'side' => 'L',
					'mode' => 'view',
					'width' => 200,
					'height' => 200,
					'model' => $element,
					'attribute' => 'left_eyedraw',
			));
			$this->renderPartial('view_' . get_class($element) . '_OEEyeDraw',
				array('side' => 'left', 'element' => $element));
			} else { ?>
			Not recorded
			<?php } ?>
		</div>
	</div>
</div>
