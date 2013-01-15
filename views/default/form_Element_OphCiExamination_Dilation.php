<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<div class="cols2 clearfix">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>
	<div class="side left eventDetail<?php if(!$element->hasRight()) { ?> inactive<?php } ?>"
		data-side="right">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php echo $form->dropDownListNoPost('dilation_drug_right',$element->getUnselectedDilationDrugs('right'),'',array('empty'=>'--- Please select ---'))?>
			<button class="clearDilationRight classy green mini" type="button">
				<span class="button-span button-span-green">Clear</span>
			</button>
			<div class="timeDiv right"<?php if (!$element->getDilationDrugs('right')) {?> style="display: none;"<?php }?>>
				<span class="label">Time:</span>
				<?php echo $form->textField($element,'time_right',array('nowrapper'=>'true'))?>
			</div>
			<div class="grid-view dilation_table_right"<?php if (!$element->getDilationDrugs('right')) {?> style="display: none;"<?php }?>>
				<table>
					<thead>
						<tr>
							<th>Drug</th>
							<th style="width: 50px;">Drops</th>
							<th style="width: 40px;"></th>
						</tr>
					</thead>
					<tbody id="dilation_right">
						<?php if ($element->getDilationDrugs('right')) {
							foreach ($element->getDilationDrugs('right') as $drug) {
								$this->renderPartial('_dilation_drug_item',array('drug'=>$drug));
							}
						}?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="inactiveForm">
			<a href="#">Add right side</a>
		</div>
	</div>
	<div class="side right eventDetail<?php if(!$element->hasLeft()) { ?> inactive<?php } ?>"
		data-side="left">
		<div class="activeForm">
			<a href="#" class="removeSide">-</a>
			<?php echo $form->dropDownListNoPost('dilation_drug_left',$element->getUnselectedDilationDrugs('left'),'',array('empty'=>'--- Please select ---'))?>
			<button class="clearDilationLeft classy green mini" type="button">
				<span class="button-span button-span-green">Clear</span>
			</button>
			<div class="timeDiv left"<?php if (!$element->getDilationDrugs('left')) {?> style="display: none;"<?php }?>>
				<span class="label">Time:</span>
				<?php echo $form->textField($element,'time_left',array('nowrapper'=>'true'))?>
			</div>
			<div class="grid-view dilation_table_left"<?php if (!$element->getDilationDrugs('left')) {?> style="display: none;"<?php }?>>
				<table>
					<thead>
						<tr>
							<th>Drug</th>
							<th>Drops</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="dilation_left">
						<?php if ($element->getDilationDrugs('left')) {
							foreach ($element->getDilationDrugs('left') as $drug) {
								$this->renderPartial('_dilation_drug_item',array('drug'=>$drug));
							}
						}?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="inactiveForm">
			<a href="#">Add left side</a>
		</div>
	</div>
</div>
<script type="text/javascript">
$('#dilation_drug_right').change(function() {
	getDilationDrug($(this),'right');
	return false;
});

$('#dilation_drug_left').change(function() {
	getDilationDrug($(this),'left');
	return false;
});

$('.removeDilationDrug').die('click').live('click',function() {
	var side = $(this).parent().parent().parent().attr('id').match(/right/) ? 'right' : 'left';
	var id = $(this).parent().parent().children('td:first').children('input').val();
	var name = $(this).parent().parent().children('td:first').children('span').text();
	$(this).parent().parent().remove();
	$('#dilation_drug_'+side).append('<option value="'+id+'">'+name+'</option>');
	sort_selectbox($('#dilation_drug_'+side));
	if ($('#dilation_'+side).children('tr').length == 0) {
		$('#dilation_'+side).parent().parent().hide();
		$('div.timeDiv.'+side).hide();
	}
	return false;
});

$('.clearDilationRight').die('click').live('click',function() {
	$('#dilation_right').children('tr').children('td:nth-child(3)').children('a').click();
	return false;
});

$('.clearDilationLeft').die('click').live('click',function() {
	$('#dilation_left').children('tr').children('td:nth-child(3)').children('a').click();
	return false;
});

function getDilationDrug(element, side) {
	if (element.val() != '') {
		$.ajax({
			'type': 'GET',
			'url': baseUrl+'/OphCiExamination/default/dilationDrops?drug_id='+element.val()+'&side='+side,
			'success': function(html) {
				$('#dilation_'+side).append(html);
				$('div.dilation_table_'+side).show();
				$('div.timeDiv.'+side).show();
				element.children('option[value="'+element.val()+'"]').remove();
			}
		});
	}
}
</script>
