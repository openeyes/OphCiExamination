<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
	<div class="left">
		<table class="subtleWhite normalText">
			<tbody>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('status_id'))?></td>
					<td><span class="big"><?php echo $element->status ?></span></td>
				</tr>
				<?php if ($element->status && $element->status->followup) { ?>
					<tr>
						<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('followup_quantity'))?></td>
						<td><span class="big"><?php echo $element->getFollowUp() ?></span></td>
					</tr>
				<?php }?>
			</tbody>
		</table>
	</div>
</div>
