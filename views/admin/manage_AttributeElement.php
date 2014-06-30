<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<?php

$form=$this->beginWidget('BaseEventTypeCActiveForm', array(
	'id'=>'OphCiExamination_adminform',
	'enableAjaxValidation'=>false,
	'layoutColumns' => array(
		'label' => 2,
		'field' => 5
	)
));
?>

<?php if (Yii::app()->user->hasFlash('success')) {?>
	<div class="alert-box success with-icon">
		<?php echo Yii::app()->user->getFlash('success'); ?>  <a href="#" class="close">×</a>
	</div>
<?php }?>

<div class="box admin">
	<h2><?php echo $title ?></h2>
<?php

echo $form->dropDownList($model,'attribute',
	CHtml::listData($attEls,'id',
		function($attEl){ return $attEl->attribute->name . ' - ' . $attEl->element_type->name ;}
	),
	array('empty'=>'- Please select -')
);


$this->endWidget();
?>
</div >
<table id='OphCiExamination_attElOptions_list'>

</table>
<?php echo EventAction::link('Add Option',
	Yii::app()->createUrl('/OphCiExamination/admin/addAttributeOption'), null, array('class'=>'button small addAttributeOption hidden'))->toHtml()?>

<div id=""></div>
<script type="text/javascript">
	var OphCiExamination_attElOptions = <?php echo json_encode($attElOptions)?>;
	var OphCiExamination_preloadedAttEl = <?php echo $preloadAttEl?>;

	$('#OEModule_OphCiExamination_models_OphCiExamination_AttributeElement_attribute').on( 'change', function(e) {
		// Update OphCiExamination_attElOptions_list
		var current_option_id = $(this).find(":selected").val();
		OphCiExamination_renderAdminAttOptions(current_option_id);
	});

	function OphCiExamination_renderAdminAttOptions(elId){
		$('#OphCiExamination_attElOptions_list').html('');
		if(typeof(OphCiExamination_attElOptions[elId]) !== 'undefined'){
			var attOptions = OphCiExamination_attElOptions[elId];
			$('.addAttributeOption').hide()
			if( ! $.isEmptyObject(attOptions) ){
				$('#OphCiExamination_attElOptions_list').attr('data-index', elId);
				$('#OphCiExamination_attElOptions_list').
					append('<tr><th>Value</th><th>Subspecialty</th><th> Operation </th></tr>')

				for(optionKey in OphCiExamination_attElOptions[elId]){
					var option = OphCiExamination_attElOptions[elId][optionKey];

					$('#OphCiExamination_attElOptions_list').
						append('<tr data-index="' + optionKey + '"><td>'+ option.value +'</td><td>'+
							option.subspecialty +'</td><td><button class="button oph-ci-delete-op small">Delete</button></td></tr>')
				};
				$('.addAttributeOption').show()
			}
		}
		else{
			$('#OphCiExamination_attElOptions_list').html('<tr><td>No Options found for this attribute</td></tr>');
		}
	}
	$('.addAttributeOption').click(function(e){
		e.preventDefault();
		current_option_id = $('#OEModule_OphCiExamination_models_OphCiExamination_AttributeElement_attribute').find(":selected").val()
		curLocation = $(this).attr('href');
		window.location = curLocation + '/id/' + current_option_id ;
	});

	function OphCiExamination_deleteAdminAttOptions(option_id){
		$.ajax({
			url: baseUrl+'/OphCiExamination/admin/deletetAttOption/'+ option_id,
			type: 'GET',
			success: function(result) {
				id = $('tr[data-index="'+  option_id +'"]').closest('table').attr('data-index');

				$('tr[data-index="'+  option_id +'"] .button').parent().html('<span class="notice">Deleted</span>')
				setTimeout(function() {
					$('tr[data-index="'+  option_id +'"]').remove()
				}, 2000);

				delete OphCiExamination_attElOptions[id][option_id];
			},
			error: function(){
				new OpenEyes.UI.Dialog.Alert({
					content: 'Error while trying to delete option'
				}).open();
			}
		});
	}

	$(document).ready(function() {
		if(OphCiExamination_preloadedAttEl){
			OphCiExamination_renderAdminAttOptions(OphCiExamination_preloadedAttEl);
			$('#OEModule_OphCiExamination_models_OphCiExamination_AttributeElement_attribute')
				.val(OphCiExamination_preloadedAttEl)
		}

		$(this).on('click', '.button.oph-ci-delete-op' , function(e) {
			option_id = $(e.srcElement).closest('tr').attr('data-index');
			OphCiExamination_deleteAdminAttOptions(option_id)
		});
	});
</script>