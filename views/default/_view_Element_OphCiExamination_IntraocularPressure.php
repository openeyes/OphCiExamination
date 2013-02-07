	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if($element->hasRight()) { ?>
			<div class="data">
				<?php echo $element->right_instrument->name ?>
			</div>
			<div class="data">
				<table>
					<tbody>
						<?php foreach($element->right_readings as $reading) { ?>
						<tr>
							<td><?php echo date('g:ia',strtotime($reading->measurement_timestamp)) ?> - </td>
							<td><?php echo $reading->value ?> mm Hg</td>
							<td><?php if($reading->dilated) { ?>(dilated)<?php } ?></td>
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
			<div class="data">
				Not recorded
			</div>
			<?php } ?>
		</div>
		<div class="right eventDetail">
			<?php if($element->hasLeft()) { ?>
			<div class="data">
				<?php echo $element->left_instrument->name ?>
			</div>
			<div class="data">
				<table>
					<tbody>
						<?php foreach($element->left_readings as $reading) { ?>
						<tr>
							<td><?php echo date('g:ia',strtotime($reading->measurement_timestamp)) ?> - </td>
							<td><?php echo $reading->value ?> mm Hg</td>
							<td><?php if($reading->dilated) { ?>(dilated)<?php } ?></td>
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
			<div class="data">
				Not recorded
			</div>
			<?php } ?>
		</div>
	</div>
