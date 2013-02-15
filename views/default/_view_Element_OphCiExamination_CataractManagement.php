	<div class="eventDetail">
		<table class="subtleWhite normalText">
			<tbody>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('city_road'))?></th>
					<td><?php echo $element->city_road ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('satellite'))?></th>
					<td><?php echo $element->satellite ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('fast_track'))?></th>
					<td><?php echo $element->fast_track ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('target_postop_refraction'))?></th>
					<td><?php echo $element->target_postop_refraction?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('correction_discussed'))?></th>
					<td><?php echo $element->correction_discussed ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('suitable_for_surgeon_id'))?></th>
					<td><?php echo $element->suitable_for_surgeon->name?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('supervised'))?></th>
					<td><?php echo $element->supervised ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('previous_refractive_surgery'))?></th>
					<td><?php echo $element->previous_refractive_surgery ? 'Yes' : 'No'?></td>
				</tr>
				<tr>
					<th><?php echo CHtml::encode($element->getAttributeLabel('vitrectomised_eye'))?></th>
					<td><?php echo $element->vitrectomised_eye ? 'Yes' : 'No'?></td>
				</tr>
			</tbody>
		</table>
	</div>
