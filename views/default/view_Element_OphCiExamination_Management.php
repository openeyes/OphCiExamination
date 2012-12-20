<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
	<div class="left">
		<table class="subtleWhite normalText">
			<tbody>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('laser_status_id'))?></td>
					<td><span class="big"><?php echo $element->laser_status ?></span></td>
				</tr>
				<?php if ($element->laser_status && $element->laser_status->deferred) { ?>
					<tr>
						<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('laser_deferralreason_id'))?></td>
						<td><span class="big"><?php echo $element->getLaserDeferralReason() ?></span></td>
					</tr>
				<?php }?>
				<tr>
					<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('injection_status_id'))?></td>
					<td><span class="big"><?php echo $element->injection_status ?></span></td>
				</tr>
				<?php if ($element->injection_status && $element->injection_status->deferred) { ?>
					<tr>
						<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('injection_deferralreason_id'))?></td>
						<td><span class="big"><?php echo $element->getInjectionDeferralReason() ?></span></td>
					</tr>
				<?php }?>
				<?php if ($element->comments) {?>
					<tr>
						<td width="30%"><?php echo CHtml::encode($element->getAttributeLabel('comments'))?></td>
						<td colspan="2"><span class="big"><?php echo $element->comments?></span></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
