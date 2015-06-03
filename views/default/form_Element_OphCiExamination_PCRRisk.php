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

if(!isset($side))
	$side = 'left';
?>

<div class="sub-element-fields" id="div_<?php echo CHtml::modelName($element)?>_injection" >
	<div>
		<header class="sub-element-header">
			<h4 class="sub-element-title"> PCR Risk (<?php echo $side ;?>) </h4>
		</header>
		<div class="row field-row"></div>
	</div>
<?php

$patientId = Yii::app()->request->getParam('patient_id');

if($patientId == ""){
	$patientId = Yii::app()->request->getParam('patientId');
}elseif($patientId == ""){
	$patientId = $this->patient->hos_num;
}

$pcr = OEModule\OphCiExamination\controllers\DefaultController::getPCRData($patientId, $side);
//echo '<pre>'; print_r($pcr);

/*$this->patient = Patient::model()->findByPk((int) $patientId );*/
//$patientAge = $this->patient->getAge();

/*if($patientAge < 60){
	$ageGroup = 1;
}elseif(($patientAge >= 60)&& ($patientAge < 70)){
	$ageGroup = 2;
}elseif(($patientAge >= 70)&& ($patientAge < 80)){
	$ageGroup = 3;
}elseif(($patientAge >= 80)&& ($patientAge < 90)){
	$ageGroup = 4;
}elseif(($patientAge >= 90)){
	$ageGroup = 5;
}*/



/*echo '<pre>1. CNT->'.count($all_opticdiscs);
print_r($all_opticdiscs);*/
//$gender = ucfirst($this->patient->getGenderString());

//echo ' SYS -> '.$this->patient->getSyd();
//echo ' DIA-> '. $this->patient->getDmt();
/*
$is_diabetic = 0;
if (strpos($this->patient->getSyd(),'diabetes mellitus') !== false) {
	$is_diabetic = 1;
}


$is_glaucoma = 0;
if (strpos($this->patient->getSdl(),'glaucoma') !== false) {
	$is_glaucoma = 1;
}*/


/*$risk = PatientRiskAssignment::model()->findByAttributes(array("patient_id" => $patientId));
$able_to_lie_flat = 0;
if(is_object($risk)){
	$able_to_lie_flat  = $risk->risk_id;
}*/

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

/*$criteria = new CDbCriteria;
$criteria->select = 'event.id, ophciexamination_opticdisc_cd_ratio.name';
$criteria->join ='JOIN event ON event.episode_id = t.id
	JOIN et_ophciexamination_opticdisc ON et_ophciexamination_opticdisc.event_id = event.id
	JOIN ophciexamination_opticdisc_cd_ratio ON et_ophciexamination_opticdisc.left_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id OR et_ophciexamination_opticdisc.right_cd_ratio_id = ophciexamination_opticdisc_cd_ratio.id';
$criteria->condition = 't.patient_id = :patient_id and ophciexamination_opticdisc_cd_ratio.name = :name';
$criteria->params = array(":patient_id" => 10001,":name" => "No view");
$criteria->order="et_ophciexamination_opticdisc.last_modified_date DESC";
$criteria->limit="1";
$noview_opticdisc = Episode::model()->findAll($criteria);


//die;

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

echo '<pre>2 . CNT->'.count($all_opticdiscs);
print_r($all_opticdiscs);*/

/*SELECT e.id, od.* FROM openeyes.episode as ep
JOIN event as e ON e.episode_id = ep.id
JOIN et_ophciexamination_anteriorsegment as od ON od.event_id = e.id
Where ep.patient_id = 10001
ORDER BY od.last_modified_date DESC
LIMIT 1;

	SELECT e.id, od.left_eyedraw, od.right_eyedraw FROM openeyes.episode as ep
JOIN event as e ON e.episode_id = ep.id
JOIN et_ophciexamination_anteriorsegment as od ON od.event_id = e.id
Where ep.patient_id = 10001
ORDER BY od.last_modified_date DESC
LIMIT 1;
*/
/*
$json = '[{"scaleLevel": 1,"version":1.1,"subclass":"AntSeg","pupilSize":"Small","apexY":-100,"rotation":0,"pxe":true,"coloboma":false,"colour":"Blue","ectropion":false,"order":0}]';

$books = json_decode($json, true);
// numeric/associative array access
echo $books[0]['pupilSize'];
print_r($books[0]);
die();*/

$ageGroup = $pcr['age_group'];
$gender = $pcr['gender'];
$is_diabetic =  $pcr['diabetic'];
$is_glaucoma = $pcr['glaucoma'];
$able_to_lie_flat = $pcr['lie_flat'];
$noview_opticdisc = $pcr['noview'];
$all_opticdiscs = $pcr['allod'];
$doctor_grade_id = $pcr['doctor_grade_id'];

//echo 'PS-> '.$pcr['anteriorsegment']['pupil_size'];

/*$anteriorsegment = Yii::app()->db->createCommand()
	->select('as.*')
	->from('episode as ep')
	->join('event as e', 'e.episode_id = ep.id')
	->join('et_ophciexamination_anteriorsegment as', 'as.event_id = e.id')
	->where('ep.patient_id=:pid', array(':pid'=>$patientId))
	->order('as.last_modified_date DESC')
	->limit (1)
	->queryRow();*/

//$left_eyedraw_json = ($anteriorsegment['left_eyedraw']);
//$right_eyedraw_json =  ($anteriorsegment['right_eyedraw']);

/*$left_eyedraw = json_decode($anteriorsegment['left_eyedraw'], true);
$right_eyedraw = json_decode($anteriorsegment['right_eyedraw'], true);*/

/*echo '<pre>CNT->';
echo count($left_eyedraw);

echo '<br> RIGHT <br> CNT->';
echo count($right_eyedraw);*/



/*
foreach($left_eyedraw as $key => $val)
{
	$left_eye_ps = $val['pupilSize'];
	$left_eye_pxe = $val['pxe'];
	//echo '<br>';
	//print_r($val);
}*/

/*echo '<br> PS-> '.$left_eye_ps;
echo '<br> PXE-> '.$left_eye_pxe;*/

/*foreach($right_eyedraw as $key => $val)
{
	if(!empty($val['pupilSize']))
		$right_eye_ps = $val['pupilSize'];

	if(!empty($val['pxe']))
		$right_eye_pxe = $val['pxe'];
}*/

/* echo '<br> PS-> '.$right_eye_ps;
echo '<br> RIGHT PXE->'.$right_eye_pxe;
echo "<br>-----------<br>";
die;

if(!empty($left_eyedraw[0]['pupilSize']))
	echo 'Left psize->'.($left_eyedraw[0]['pupilSize']);

if(!empty($right_eyedraw[1]['pupilSize']))
	echo '<br>right psize->'.($right_eyedraw[1]['pupilSize']);*/

/*echo '<br>Left Nuclear ID->'.($anteriorsegment['left_nuclear_id']);
echo '<br>Right Nuclear ID->'.($anteriorsegment['right_nuclear_id']);

echo '<br>Left Cortical ID->'.($anteriorsegment['left_cortical_id']);
echo '<br>Right Cortical ID->'.($anteriorsegment['right_cortical_id']);*/

/*die;
echo 'psize->'.($left_eyedraw[0]['pupilSize']);
echo '<br>right psize->'.($right_eyedraw[0]['pupilSize']);

echo '<br><br>psize->'.($left_eyedraw[0]['pupilSize']);
echo '<br>right psize->'.($right_eyedraw[0]['pupilSize']);*/

//PXF (Pseudoexfoliation) / Phacodonesis
/*if(!empty($left_eyedraw[0]['pxe'])) {
	echo '<br><br>Left Pxe->' . ($left_eyedraw[0]['pxe']);
}

if(!empty($right_eyedraw[0]['pxe'])) {
	echo '<br>Right Pxe->' . ($right_eyedraw[0]['pxe']);
}

die;*/

//$session = new CHttpSession;
//$session->open();
//echo '<br><pre>>';
//print_r($session);
/*$user = Yii::app()->session['user'];
//print_r($user);

$user_data = User::model()->findByPk($user->id);
$doctor_grade_id = $user_data['originalAttributes']['doctor_grade_id'];*/

//SELECT axial_length_left, axial_length_right FROM openeyes.et_ophinbiometry_lenstype;
//SELECT * FROM openeyes.et_ophinbiometry_lenstype;

/*$lenstype = Yii::app()->db->createCommand()
	->select('as.*')
	->from('episode as ep')
	->join('event as e', 'e.episode_id = ep.id')
	->join('et_ophinbiometry_lenstype as', 'as.event_id = e.id')
	->where('ep.patient_id=:pid', array(':pid'=>$patientId))
	->order('as.last_modified_date DESC')
	->limit (1)
	->queryRow();
echo 'LAL-> '.$lenstype['axial_length_left'];
echo ' RAL-> '.$lenstype['axial_length_right'];*/
?>
	<div id="left_eye_pcr">
		<div class="row field-row">
			<div class="large-2 column">
				<label>
					Age
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('age','age',array(1=>'<60',2=>'60-69',3=>'70-79',4=>'80-89',5=>'90+'), array('options' => array($pcr['age_group']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					PXF/ Phacodonesis
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('pxf_phako','pxf_phako',array('NK'=>'Not Known','N'=>'No','Y'=>'Yes'), array('options' => array($pcr['anteriorsegment']['pxf_phako']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if($pcr['anteriorsegment']['pxf_phako_nk']){?>
					<div class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php } ?>
				&nbsp;
			</div>
		</div>
		<div class="row field-row">
			<div class="large-2 column">
				<label>
					Gender
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('gender','gender',array('Male'=>'Male','Female'=>'Female'), array('options' => array($pcr['gender']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					Pupil Size
				</label>
			</div>

			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('pupil_size','pupil_size',array('Large'=>'Large','Medium'=>'Medium','Small'=>'Small'), array('options' => array($pcr['anteriorsegment']['pupil_size']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
		</div>

		<div class="row field-row">
			<div class="large-2 column">
				<label>
					Glaucoma
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('glaucoma','glaucoma',array('NK'=>'Not Known','N'=>'No Glaucoma','Y'=>'Glaucoma present'), array('options' => array($pcr['glaucoma']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<div class="alert-box alert with-icon pcr-nk">Not Known</div>
			</div>
			<div class="large-2 column">
				<label>
					Axial Length (mm)
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('axial_length','axial_length',array('NK'=>'Not Known',1=>'< 26',2=>'> or = 26'), array('options' => array($pcr['axial_length_group']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<div class="alert-box alert with-icon pcr-nk">Not Known</div>
			</div>
		</div>

		<div class="row field-row">
			<div class="large-2 column">
				<label>
					Diabetic
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('diabetic','diabetic',array('NK'=>'Not Known','N'=>'No Diabetes','Y'=>'Diabetes present'), array('options' => array($pcr['diabetic']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<div class="alert-box alert with-icon pcr-nk">Not Known</div>
			</div>
			<div class="large-2 column">
				<label>
					Alpha receptor blocker
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('arb','arb',array('NK'=>'Not Known','N'=>'No','Y'=>'Yes'), array('options' => array('N'=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
					<div class="alert-box alert with-icon pcr-nk">Not Known</div>
			</div>
		</div>

		<div class="row field-row">
			<div class="large-2 column">
				<label>
					No fundal view/ vitreous opacities
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('no_fundal_view','no_fundal_view',array('NK'=>'Not Known','N'=>'No','Y'=>'Yes'), array('options' => array($pcr['noview']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php //if(count($all_opticdiscs) == 0){?>
						<div class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php //} ?>
				&nbsp;
				</div>
			<div class="large-2 column">
				<label>
					Can lie flat
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('abletolieflat','abletolieflat',array('N'=>'No','Y'=>'Yes'), array('options' => array($pcr['lie_flat']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
		</div>

		<div class="row field-row">
			<div class="large-2 column">
				<label>
					Brunescent/ White Cataract
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('brunescent_white_cataract','brunescent_white_cataract',array('NK'=>'Not Known','N'=>'No','Y'=>'Yes'), array('options' => array($pcr['anteriorsegment']['brunescent_white_cataract']=>array('selected'=>true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					Surgeon Grade
				</label>
			</div>
			<div class="large-2 column">
				<?php  echo CHtml::dropDownList('doctor_grade_id','doctor_grade_id', CHtml::listData(DoctorGrade::model()->findAll(array('order' => 'display_order')), 'id', 'grade'), array('empty' => '- Select Doctor Grade -', 'options' => array($pcr['doctor_grade_id']=>array('selected'=>true))));?>
			</div>
			<div class="large-2 column pcr-nkr">
				&nbsp;
			</div>
		</div>
		<div class="row field-row">
			<div class="large-1 column">
				&nbsp;
			</div>
			<div class="large-2 column" id="pcr-risk-div">
				<label>
					PCR Risk <span class="pcr-span"> 6.1 </span> %
				</label>
			</div>
			<div class="large-3 column">
				&nbsp;
			</div>

			<div class="large-6 column">
				<label>
					Excess risk compared to average eye  <span class="pcr-erisk"> <strong> <span> 3  </span></strong> </span> times
				</label>
			</div>
		</div>
	</div>
</div>
