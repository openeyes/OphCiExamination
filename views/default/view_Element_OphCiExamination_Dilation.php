<div class="element <?php echo $element->elementType->class_name ?>">
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="left eventDetail">
			<?php if ($element->hasRight()) {?>
				<span>Dilation given at <?php echo $element->right->getTime()?></span>
				<div class="grid-view dilation_table_right">
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th style="width: 50px;">Drops</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($element->getDilationDrugs('right') as $drug) {
								$this->renderPartial('_dilation_drug_item_view',array('drug'=>$drug));
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
				<span>Dilation given at <?php echo $element->left->getTime()?></span>
				<div class="grid-view dilation_table_left">
					<table>
						<thead>
							<tr>
								<th>Drug</th>
								<th style="width: 50px;">Drops</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($element->getDilationDrugs('left') as $drug) {
								$this->renderPartial('_dilation_drug_item_view',array('drug'=>$drug));
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
