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
<div class="element-fields">
	<div id="div_<?php echo CHtml::modelName($element)?>_status">
		<div class="field-row row">
			<div class="large-3 column">
				<label for="<?php echo CHtml::modelName($element).'_status_id';?>">
					<?php echo $element->getAttributeLabel('status_id')?>:
				</label>
			</div>
			<div class="large-3 column end">
				<?php
				$html_options = array('empty'=>'- Please select -', 'nowrapper' => true, 'options' => array());
				foreach (\OEModule\OphCiExamination\models\OphCiExamination_ClinicOutcome_Status::model()->activeOrPk($element->status_id)->findAll(array('order'=>'display_order')) as $opt) {
					$html_options['options'][(string) $opt->id] = array('data-followup' => $opt->followup);
				}
				echo $form->dropDownList($element, 'status_id', '\OEModule\OphCiExamination\models\OphCiExamination_ClinicOutcome_Status', $html_options)?>
			</div>
		</div>
	</div>

	<div id="div_<?php echo CHtml::modelName($element)?>_followup"<?php if (!($element->status && $element->status->followup)) {?> style="display: none;"<?php }?>>
		<fieldset class="field-row row">
			<legend class="large-3 column">
					<?php echo $element->getAttributeLabel('followup_quantity')?>:
			</legend>
			<div class="large-9 column end">
				<?php
				$html_options = array('empty'=>'- Please select -', 'options' => array());
				echo CHtml::activeDropDownList($element,'followup_quantity', $element->getFollowUpQuantityOptions(), array_merge($html_options, array('class'=>'inline')))?>
				<?php
				$html_options = array('empty'=>'- Please select -', 'options' => array());
				echo CHtml::activeDropDownList($element,'followup_period_id', CHtml::listData(\Period::model()->findAll(array('order'=>'display_order')),'id','name'), array_merge($html_options, array('class'=>'inline')))?>
				<label class="inline">
					<?php echo CHtml::activeCheckBox($element,'community_patient')?>
					<?php echo $element->getAttributeLabel('community_patient')?>
				</label>
			</div>
		</fieldset>
	</div>

	<div id="div_<?php echo CHtml::modelName($element)?>_role"<?php if (!($element->status && $element->status->followup)) {?> style="display: none;"<?php }?>>
		<fieldset class="field-row row">
			<legend class="large-3 column">
				<?php echo $element->getAttributeLabel('role')?>:
			</legend>
			<div class="large-9 column end">
				<div class="row">
					<div class="large-3 column">
						<?php
						$html_options = array('empty'=>'- Please select -', 'options' => array());
						echo $form->dropDownList($element, 'role_id', '\OEModule\OphCiExamination\models\OphCiExamination_ClinicOutcome_Role', $html_options) ?>
					</div>
					<div class="large-3 column end">
						<?php echo CHtml::activeTextField($element, 'role_comments')?>
					</div>
				</div>
			</div>
		</fieldset>
	</div>

	<script type="text/javascript">
			var Element_OphCiExamination_ClinicOutcome_templates = {
			<?php foreach (\OEModule\OphCiExamination\models\OphCiExamination_ClinicOutcome_Template::model()->findAll() as $template) { ?>
			"<?php echo $template->id?>": {
				"clinic_outcome_status_id": <?php echo $template->clinic_outcome_status_id ?>,
				"followup_quantity": "<?php echo $template->followup_quantity ?>",
				"followup_period_id": "<?php echo $template->followup_period_id ?>"
			},
			<?php } ?>
			};
	</script>
</div>
