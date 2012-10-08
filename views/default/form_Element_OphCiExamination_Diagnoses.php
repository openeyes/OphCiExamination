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
				src="<?php echo Yii::app()->createUrl('img/_elements/btns/mini-cross.png')?>" alt="+" width="24"
				height="22"> </span>
		</button>
	</div>
	<h4 class="elementTypeName">
		<?php  echo $element->elementType->name; ?>
	</h4>
	<div class="whiteBox forClinicians" style="width: 70em;">
		<div class="data_row">
			<table class="subtleWhite">
				<thead>
					<tr>
						<th style="width: 400px;">Diagnosis</th>
						<th>Eye</th>
						<th>Principal</th>
						<th>Edit</th>
					</tr>
				</thead>
				<tbody id="OphCiExamination_diagnoses">
					<?php if (!empty($_POST)) {?>
						<?php foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {?>
							<tr>
								<td><?php echo Disorder::model()->findByPk($disorder_id)->term?></td>
								<td>
									<?php foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {?>
										<span class="OphCiExamination_eye_radio"><input type="radio" name="eye_id_<?php echo $i?>" value="<?php echo $eye->id?>" <?php if ($_POST['eye_id_'.$i] == $eye->id) {?>checked="checked" <?php }?>/> <?php echo $eye->name?></span>
									<?php }?>
								</td>
								<td><input type="radio" name="principal_diagnosis" value="<?php echo $disorder_id?>" <?php if ($_POST['principal_diagnosis'] == $disorder_id) {?>checked="checked" <?php }?>/></td>
								<td><a href="#" class="small removeDiagnosis" rel="<?php echo $disorder_id?>"><strong>Remove</strong></a></td>
							</tr>
						<?php }?>
					<?php } else if ($this->event) {?>
						<?php foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=?',array($element->id)) as $i => $diagnosis) {?>
							<tr>
								<td><?php echo $diagnosis->disorder->term?></td>
								<td>
									<?php foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {?>
										<span class="OphCiExamination_eye_radio"><input type="radio" name="eye_id_<?php echo $i?>" value="<?php echo $eye->id?>" <?php if ($diagnosis->eye_id == $eye->id) {?>checked="checked" <?php }?>/> <?php echo $eye->name?></span>
									<?php }?>
								</td>
								<td><input type="radio" name="principal_diagnosis" value="<?php echo $diagnosis->disorder->id?>" <?php if ($diagnosis->principal) {?>checked="checked" <?php }?>/></td>
								<td><a href="#" class="small removeDiagnosis" rel="<?php echo $diagnosis->disorder->id?>"><strong>Remove</strong></a></td>
							</tr>
						<?php }?>
					<?php } else if ($this->episode && $this->episode->diagnosis) {?>
						<tr>
							<td><?php echo $this->episode->diagnosis->term?></td>
							<td>
								<?php foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {?>
									<span class="OphCiExamination_eye_radio"><input type="radio" name="eye_id_0" value="<?php echo $eye->id?>" <?php if ($this->episode->eye_id == $eye->id) {?>checked="checked" <?php }?>/> <?php echo $eye->name?></span>
								<?php }?>
							</td>
							<td><input type="radio" name="principal_diagnosis" value="<?php echo $this->episode->disorder_id?>" checked="checked" /></td>
							<td><a href="#" class="small removeDiagnosis" rel="<?php echo $this->episode->disorder_id?>"><strong>Remove</strong></a></td>
						</tr>
						<?php $i=1; foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->episode->patient_id)) as $sd) {?>
							<?php if (!$sd->disorder->systemic) {?>
								<tr>
									<td><?php echo $sd->disorder->term?></td>
									<td>
										<?php foreach (Eye::model()->findAll(array('order'=>'display_order')) as $eye) {?>
											<span class="OphCiExamination_eye_radio"><input type="radio" name="eye_id_<?php echo $i?>" value="<?php echo $eye->id?>" <?php if ($sd->eye_id == $eye->id) {?>checked="checked" <?php }?>/> <?php echo $eye->name?></span>
										<?php }?>
									</td>
									<td><input type="radio" name="principal_diagnosis" value="<?php echo $sd->disorder_id?>" /></td>
									<td><a href="#" class="small removeDiagnosis" rel="<?php echo $sd->disorder_id?>"><strong>Remove</strong></a></td>
								</tr>
							<?php $i++; }?>
						<?php }?>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>

	<div id="selected_diagnoses">
		<?php if (!empty($_POST)) {?>
			<?php foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {?>
				<input type="hidden" name="selected_diagnoses[]" value="<?php echo $disorder_id?>" />
			<?php }?>
		<?php } else if ($this->event) {?>
			<?php foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=?',array($element->id)) as $i => $diagnosis) {?>
				<input type="hidden" name="selected_diagnoses[]" value="<?php echo $diagnosis->disorder_id?>" />
			<?php }?>
		<?php } else if ($this->episode && $this->episode->diagnosis) {?>
			<input type="hidden" name="selected_diagnoses[]" value="<?php echo $this->episode->diagnosis->id?>" />
			<?php foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->episode->patient_id)) as $i => $sd) {?>
				<?php if (!$sd->disorder->systemic) {?>
					<input type="hidden" name="selected_diagnoses[]" value="<?php echo $sd->disorder_id?>" />
				<?php }?>
			<?php }?>
		<?php }?>
	</div>

	<div id="Element_OphCiExamination_Diagnoses_eye_id" class="eventDetail">
		<div class="label">Eye(s):</div>
		<div class="data">
			<span class="group">
				<input value="2" id="eye_id_2" type="radio" name="Element_OphCiExamination_Diagnoses[eye_id]" />
				<label for="Element_OphCiExamination_Diagnoses_eye_id_2">Right</label>
			</span>
			<span class="group">
				<input value="3" id="eye_id_3" type="radio" name="Element_OphCiExamination_Diagnoses[eye_id]" />
				<label for="Element_OphCiExamination_Diagnoses_eye_id_3">Both</label>
			</span>
			<span class="group">
				<input value="1" id="eye_id_1" checked="checked" type="radio" name="Element_OphCiExamination_Diagnoses[eye_id]" />
				<label for="Element_OphCiExamination_Diagnoses_eye_id_1">Left</label>
			</span>
		</div>
	</div>

	<?php /*$this->widget('application.widgets.RadioButtonList', array(
			'field' => 'eye_id',
			'name' => get_class($element)."[eye_id]",
			//'element' => $element,
			'data' => CHtml::listData(Eye::model()->findAll(), 'id', 'name'),
			))*/ ?>
	<?php $this->widget('application.widgets.DiagnosisSelection', array(
			'field' => 'disorder_id',
			'options' => CommonOphthalmicDisorder::getList(Firm::model()->findByPk($this->selectedFirmId)),
			'layout' => 'minimal',
			'callback' => 'OphCiExamination_AddDiagnosis',
	))?>
</div>
