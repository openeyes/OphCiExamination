<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) { ?>
			<div class="data">
				<?php echo $element->unit->name ?>
			</div>
			<div class="data">
				<table>
					<tbody>
						<?php foreach($element->right_readings as $reading) { ?>
						<tr>
							<td><?php echo $reading->convertTo($reading->value) ?>
							</td>
							<td><?php echo $reading->method->name ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php if($element->right_comments) { ?>
			<div class="data">
				(<?php echo $element->right_comments ?>)
			</div>
			<?php } ?>
			<?php } else { ?>
			<div class="data">Not recorded</div>
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) { ?>
			<div class="data">
				<?php echo $element->unit->name ?>
			</div>
			<div class="data">
				<table>
					<tbody>
						<?php foreach($element->left_readings as $reading) { ?>
						<tr>
							<td><?php echo $reading->convertTo($reading->value) ?>
							</td>
							<td><?php echo $reading->method->name ?>
							</td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<?php if($element->left_comments) { ?>
			<div class="data">
				(<?php echo $element->left_comments ?>)
			</div>
			<?php } ?>
			<?php } else { ?>
			<div class="data">Not recorded</div>
			<?php } ?>
		</div>
	</div>
</div>
