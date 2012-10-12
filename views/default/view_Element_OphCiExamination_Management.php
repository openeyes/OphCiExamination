<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
	<div class="left">
		<table class="subtleWhite normalText">
			<tbody>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('city_road'))?></td>
					<td><span class="big"><?php echo $element->city_road ? 'Yes' : 'No'?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('satellite'))?></td>
					<td><span class="big"><?php echo $element->city_road ? 'Yes' : 'No'?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('fast_track'))?></td>
					<td><span class="big"><?php echo $element->fast_track ? 'Yes' : 'No'?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('target_postop_refraction'))?></td>
					<td><span class="big"><?php echo $element->target_postop_refraction?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('correction_discussed'))?></td>
					<td><span class="big"><?php echo $element->fast_track ? 'Yes' : 'No'?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('suitable_for_surgeon_id'))?></td>
					<td><span class="big"><?php echo $element->suitable_for_surgeon->name?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('supervised'))?></td>
					<td><span class="big"><?php echo $element->supervised ? 'Yes' : 'No'?></span></td>
				</tr>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('comments'))?></td>
					<td colspan="2"><span class="big"><?php echo $element->comments?></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
