<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if ($element->hasRight()) {?>
				<span>Dilation given at <?php echo date('H:i', strtotime($element->right_time)); ?></span>
				<div class="grid-view dilation_table">
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th style="width: 50px;">Drops</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($element->right_treatments as $treatment) {
								$this->renderPartial('view_Element_OphCiExamination_Dilation_Treatment',array('treatment'=>$treatment));
							}?>
						</tbody>
					</table>
				</div>
			<?php }else{?>
				<span>None given.</span>
			<?php }?>
		</div>
		<div class="right eventDetail">
			<?php if ($element->hasLeft()) {?>
				<span>Dilation given at <?php echo date('H:i', strtotime($element->left_time)); ?></span>
				<div class="grid-view dilation_table">
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th style="width: 50px;">Drops</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($element->left_treatments as $treatment) {
								$this->renderPartial('view_Element_OphCiExamination_Dilation_Treatment',array('treatment'=>$treatment));
							}?>
						</tbody>
					</table>
				</div>
			<?php }else{?>
				<span>None given</span>
			<?php }?>
		</div>
	</div>
</div>
