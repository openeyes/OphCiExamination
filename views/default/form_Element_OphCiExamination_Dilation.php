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
<div class="element <?php echo $element->elementType->class_name ?>"
	data-element-type-id="<?php echo $element->elementType->id ?>"
	data-element-type-class="<?php echo $element->elementType->class_name ?>"
	data-element-type-name="<?php echo $element->elementType->name ?>"
	data-element-display-order="<?php echo $element->elementType->display_order ?>">
	<div class="removeElement">
		<button class="classy blue mini">
			<span class="button-span icon-only"><img
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>"
				alt="+" width="24" height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<div class="cols2 clearfix">
		<div class="side left eventDetail" data-side="right">
			<?php echo $form->textField($element,'time_right',array('label'=>'Time'))?>
			<?php echo $form->dropDownListNoPost('dilation_drug_right',CHtml::listData(OphCiExamination_Dilation_Drugs::model()->findAll(array('order'=>'display_order')),'id','name'),'',array('empty'=>'--- Please select ---'))?>
			<button class="clearDilationRight classy green mini" type="button">
				<span class="button-span button-span-green">Clear</span>
			</button>
			<div class="grid-view dilation_table_right" style="display: none;">
				<table>
					<thead>
						<tr>
							<th>Drug</th>
							<th style="width: 50px;">Drops</th>
							<th style="width: 40px;"></th>
						</tr>
					</thead>
					<tbody id="dilation_right">
					</tbody>
				</table>
			</div>
		</div>
		<div class="side right eventDetail" data-side="left">
			<?php echo $form->textField($element,'time_left',array('label'=>'Time'))?>
			<?php echo $form->dropDownListNoPost('dilation_drug_left',CHtml::listData(OphCiExamination_Dilation_Drugs::model()->findAll(array('order'=>'display_order')),'id','name'),'',array('empty'=>'--- Please select ---'))?>
			<button class="clearDilationLeft classy green mini" type="button">
				<span class="button-span button-span-green">Clear</span>
			</button>
			<div class="grid-view dilation_table_left" style="display: none;">
				<table>
					<thead>
						<tr>
							<th>Drug</th>
							<th>Drops</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="dilation_right">
					</tbody>
				</table>
			</div>
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
	var body = $(this).parent().parent().parent();
	var id = $(this).parent().parent().children('td:first').children('input').val();
	var name = $(this).parent().parent().children('td:first').children('span').text();
	var select = body.parent().parent().parent().children('div').children('div').children('select');
	$(this).parent().parent().remove();
	select.append('<option value="'+id+'">'+name+'</option>');
	sort_selectbox(select);
	if (body.children('tr').length == 0) {
		body.parent().parent().hide();
	}
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
				element.children('option[value="'+element.val()+'"]').remove();
			}
		});
	}
}
</script>
