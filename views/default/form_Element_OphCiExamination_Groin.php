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
<div class="clearfix eventDetail">
	<?php
	$this->widget('application.modules.eyedraw2.OEEyeDrawWidget', array(
	'template' => 'OEEyeDrawWidgetHelp',
	'doodleToolBarArray'=>array('Bruising', 'Haematoma', 'Bruit'),
	'scriptArray'=>array('ED_Cardiology.js'),
	'mode'=>'edit',
	'width'=>300,
	'height'=>300,
	'idSuffix'=> $element->elementType->id,
	'model'=>$element,
	'attribute'=>'eyedraw',
	'onReadyCommandArray'=>array(
		array('addDoodle', array('Groin')),
		array('deselectDoodles'),
	),
));
?>
	<div class="eyedrawFields">
		<div class="aligned">
			<div class="data">
				<?php echo $form->radioBoolean($element, 'bruising')?>
			</div>
		</div>
		<div class="aligned">
			<div class="data">
				<?php echo $form->radioBoolean($element, 'mass')?>
			</div>
		</div>
		<div class="aligned">
			<div class="data">
				<?php echo $form->dropDownList($element, 'mass_type', $element->getMassTypeOptions()); ?>
			</div>
		</div>
		<div class="aligned">
			<div class="data">
				<?php echo $form->radioBoolean($element, 'expansile')?>
			</div>
		</div>
		<div class="aligned">
			<div class="data">
				<?php echo $form->radioBoolean($element, 'bruit')?>
			</div>
		</div>
		<div>
			<div class="data">
				<?php echo $form->textArea($element, 'description', array('nowrapper' => true, 'rows' => 2, 'cols' => '40', 'class' => 'autosize clearWithEyedraw')); ?>
			</div>
		</div>
		<button class="ed_report">Report</button>
		<button class="ed_clear">Clear</button>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	if($('#Element_OphCiExamination_Groin_mass_type').val() == 'pulsitile') {
		$('#Element_OphCiExamination_Groin_expansile').closest('.aligned').show();
	} else {
		$('#Element_OphCiExamination_Groin_expansile').closest('.aligned').hide();
		$('#Element_OphCiExamination_Groin_expansile').val('');
	}
	$('#Element_OphCiExamination_Groin_mass_type').change(function() {
		if($('#Element_OphCiExamination_Groin_mass_type').val() == 'pulsitile') {
			$('#Element_OphCiExamination_Groin_expansile').closest('.aligned').show();
		} else {
			$('#Element_OphCiExamination_Groin_expansile').closest('.aligned').hide();
			$('#Element_OphCiExamination_Groin_expansile').val('');
		}
	});
});
</script>
