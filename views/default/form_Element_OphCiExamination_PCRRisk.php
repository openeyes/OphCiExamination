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

<div class="sub-element-fields" id="div_<?php echo CHtml::modelName($element)?>_injection" >
	<div>
		<header class="sub-element-header">
			<h4 class="sub-element-title"> PCR Risk</h4>
		</header>
		<div class="row field-row"></div>
	</div>
<?php
$patientId = Yii::app()->request->getParam('patient_id');
if($patientId == ""){
	$patientId = Yii::app()->request->getParam('patientId');
}
$this->patient = Patient::model()->findByPk((int) $patientId );
//var_dump($this->patient);
//riskAssignments
//die;
$patientAge = $this->patient->getAge();

if($patientAge < 60){
	$ageGroup = 1;
}elseif(($patientAge >= 60)&& ($patientAge < 70)){
	$ageGroup = 2;
}elseif(($patientAge >= 70)&& ($patientAge < 80)){
	$ageGroup = 3;
}elseif(($patientAge >= 80)&& ($patientAge < 90)){
	$ageGroup = 4;
}elseif(($patientAge >= 90)){
	$ageGroup = 5;
}

$gender = ucfirst($this->patient->getGenderString());

//echo ' SYS -> '.$this->patient->getSyd();
//echo ' DIA-> '. $this->patient->getDmt();

$is_diabetic = 0;
if (strpos($this->patient->getSyd(),'diabetes mellitus') !== false) {
	$is_diabetic = 1;
}


$is_glaucoma = 0;
if (strpos($this->patient->getSdl(),'glaucoma') !== false) {
	$is_glaucoma = 1;
}


$risk = PatientRiskAssignment::model()->findByAttributes(array("patient_id" => $patientId));
$able_to_lie_flat = 0;
if(is_object($risk)){
	$able_to_lie_flat  = $risk->risk_id;
}

//print_r($this->patient->getSdl());


	/*
	SELECT e.id,cr.name, od.* FROM openeyes.episode as ep
JOIN event as e ON e.episode_id = ep.id
JOIN et_ophciexamination_opticdisc as od ON od.event_id = e.id
JOIN ophciexamination_opticdisc_cd_ratio as cr ON od.left_cd_ratio_id = cr.id  OR od.right_cd_ratio_id = cr.id
Where ep.patient_id = 10001
AND cr.name = 'No view'
ORDER BY od.last_modified_date DESC
LIMIT 1;
*/

$criteria = new CDbCriteria;
$criteria->select = 'event.id, ophciexamination_opticdisc_cd_ratio.name';
$criteria->join ='JOIN event ON event.episode_id = t.id
	JOIN et_ophciexamination_opticdisc ON et_ophciexamination_opticdisc.event_id = event.id
	JOIN ophciexamination_opticdisc_cd_ratio ON et_ophciexamination_opticdisc.left_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id OR et_ophciexamination_opticdisc.right_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id';
$criteria->condition = 't.patient_id = :patient_id and ophciexamination_opticdisc_cd_ratio.name = :name';
$criteria->params = array(":patient_id" => 10001,":name" => "No view");
$criteria->order="et_ophciexamination_opticdisc.last_modified_date DESC";
$criteria->limit="1";
$noview_opticdisc = Episode::model()->findAll($criteria);


$criteria1 = new CDbCriteria;
$criteria1->select = 'event.id, ophciexamination_opticdisc_cd_ratio.name';
$criteria1->join ='JOIN event ON event.episode_id = t.id
	JOIN et_ophciexamination_opticdisc ON et_ophciexamination_opticdisc.event_id = event.id
	JOIN ophciexamination_opticdisc_cd_ratio ON et_ophciexamination_opticdisc.left_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id OR et_ophciexamination_opticdisc.right_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id';
$criteria1->condition = 't.patient_id = :patient_id';
$criteria1->params = array(":patient_id" => 10001);
$criteria1->order="et_ophciexamination_opticdisc.last_modified_date DESC";
//$criteria1->limit="1";
$all_opticdiscs = Episode::model()->findAll($criteria1);
?>
	<div class="row field-row">

		<div class="large-2 column">
			<label>
				Age
			</label>
		</div>
		<div class="large-4 column">
			<select name="age">
				<?php if($ageGroup ==1) {?>
					<option value="1" selected value="1">< 60</option>
				<?php } else {?>
					<option value="1">< 60</option>
				<?php }
				if($ageGroup ==2) {?>
					<option value="2" selected>60 - 69</option>
				<?php } else {?>
					<option value="2">60 - 69</option>
				<?php }
				if($ageGroup ==3) {?>
					<option value="3" selected>70 - 79</option>
				<?php } else {?>
					<option value="3">70 - 79</option>
				<?php }
				if($ageGroup ==4) {?>
					<option value="4" selected>80 - 89 </option>
				<?php } else {?>
					<option value="4" >80 - 89 </option>
				<?php }
				if($ageGroup ==5) {?>
					<option value="5" selected>90 + </option>
				<?php } else {?>
					<option value="5">90 + </option>
				<?php } ?>
			</select>
		</div>
		<div class="large-2 column">
			<label>
				PXF/ Phacodonesis
			</label>
		</div>
		<div class="large-4 column">
			<select class="dropDownTextSelection delimited">
				<option>No</option>
				<option>Yes</option>
			</select>
		</div>
	</div>

	<div class="row field-row">
		<div class="large-2 column">
			<label>
				Gender
			</label>
		</div>
		<div class="large-4 column">
			<?php
			echo CHtml::dropDownList('Gender','sex',array('Male'=>'Male','Female'=>'Female'), array('options' => array($gender=>array('selected'=>true))));
			?>
		</div>
		<div class="large-2 column">
			<label>
				Pupil Size
			</label>
		</div>
		<div class="large-4 column">
			<select>
				<option>Large</option>
				<option>Medium</option>
				<option>Small</option>
			</select>
		</div>
	</div>

	<div class="row field-row">
		<div class="large-2 column">
			<label>
				Glaucoma
			</label>
		</div>
		<div class="large-4 column">
			<select>
				<?php if($is_glaucoma) { ?>
					<option value="N">No Glaucoma</option>
					<option selected="selected" value="Y">Glaucoma present</option>
				<?php } else { ?>
					<option value="N" selected="selected">No Glaucoma</option>
					<option value="Y">Glaucoma present</option>
				<?php } ?>
			</select>
		</div>
		<div class="large-2 column">
			<label>
				Axial Length (mm)
			</label>
		</div>
		<div class="large-4 column">
			<select>
				<option> < 26 </option>
				<option> <= 26 </option>
			</select>
		</div>
	</div>

	<div class="row field-row">
		<div class="large-2 column">
			<label>
				Diabetic Retinopathy
			</label>
		</div>
		<div class="large-4 column">
			<select>
				<?php if($is_diabetic) { ?>
					<option value="N">No Diabetes</option>
					<option selected="selected" value="Y">Diabetes present</option>
				<?php } else { ?>
					<option value="N" selected="selected">No Diabetes</option>
					<option value="Y">Diabetes present</option>
				<?php } ?>
			</select>
		</div>
		<div class="large-2 column">
			<label>
				Alpha receptor blocker
			</label>
		</div>
		<div class="large-4 column">
			<select>
				<option>No</option>
				<option>Yes</option>
			</select>
		</div>
	</div>

	<div class="row field-row">
		<div class="large-2 column">
			<label>
				No fundal view/ vitreous opacities
			</label>
		</div>
		<div class="large-2 column">
			<select name="fundal_view" style="width: 200px">
				<?php if(count($noview_opticdisc) >= 1) { ?>
					<option value="N">No</option>
					<option selected="selected" value="Y">Yes</option>
				<?php } else { ?>
					<option value="N" selected="selected">No</option>
					<option value="Y">Yes</option>
				<?php } ?>
			</select>

		</div>
		<div class="large-2 column">
			<?php if(count($all_opticdiscs) == 0){?>
					<div style="width: 140px; top:-15px" class="alert-box alert with-icon">Not Known</div>
			<?php } ?>&nbsp;
			</div>
		<div class="large-2 column">
			<label>
				Able to lie flat
			</label>
		</div>
		<div class="large-4 column">
			<select name="abletolieflat" id="abletolieflat">
				<?php if($able_to_lie_flat) { ?>
					<option value="N" selected="selected">No</option>
					<option value="Y">Yes</option>
				<?php } else { ?>
					<option value="N">No</option>
					<option selected="selected" value="Y">Yes</option>
				<?php } ?>


			</select>
		</div>
	</div>

	<div class="row field-row">
		<div class="large-2 column">
			<label>
				Psuedoexfoliation
			</label>
		</div>
		<div class="large-4 column">
			<?php  //echo CHtml::dropDownList('DoctorGrade','doctor_grade_id', CHtml::listData(array('no'=>'yes','no'=>'no')), array('empty' => '- Select Doctor Grade -'));?>
			<?php echo CHtml::dropDownList('Psuedoexfoliation','sex',array('N'=>'No','Y'=>'Yes'));?>
		</div>
		<div class="large-2 column">
			<label>
				Surgeon Grade
			</label>
		</div>
		<div class="large-4 column">
			<?php  echo CHtml::dropDownList('DoctorGrade','doctor_grade_id', CHtml::listData(DoctorGrade::model()->findAll(array('order' => 'display_order')), 'id', 'grade'), array('empty' => '- Select Doctor Grade -'));?>
			<!--<select>
				<option value="">- Select Doctor Grade -</option>
				<option value="1" selected="selected">Consultant</option>
				<option value="2">Associate specialist</option>
				<option value="3">Trust doctor</option>
				<option value="4">Fellow</option>
				<option value="5">Specialist Registrar</option>
				<option value="6">Senior House Officer</option>
				<option value="7">House officer</option>
			</select>-->
		</div>
	</div>

	<div>
		<div class="row field-row" align="center">
			<input type="button" value="Calculate" id="et_pcr_calculate" class=" save event-action button secondary small">
		</div>
	</div>
	<div class="row field-row">
		<div class="large-1 column">
			&nbsp;
		</div>
		<div class="large-2 column" id="pcr_risk_div" style="background-color: red;">
			<label>
				PCR Risk <strong> <span style="background-color: white; width: 100px; "> 6.1</span> %</strong>
			</label>
		</div>
		<div class="large-3 column">
			&nbsp;
		</div>

		<div class="large-6 column">
			<label>
 				Excess risk compared to average eye  <span style="background-color: white;  ;"> <strong> <span> 3  </span></strong> </span> times
			</label>
		</div>
	</div>
</div>

<script type="application/javascript">
	$(document).ready(function() {
		$("#et_pcr_calculate").bind("click", function (e) {
			//$("#et_pcr_calculate").click(function() {
			alert('PCR Cal');
			pcrCalculate();
		});
	});

	</script>