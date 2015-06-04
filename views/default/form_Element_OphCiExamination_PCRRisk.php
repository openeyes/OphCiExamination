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

if (!isset($side)) {
	$side = 'left';
}

if ($side == 'left') {
	$assetManager = Yii::app()->getAssetManager();
	$baseAssetsPath = Yii::getPathOfAlias('application.modules.OphCiExamination.assets');

	Yii::app()->clientScript->registerScriptFile($assetManager->getPublishedUrl($baseAssetsPath)."/js/PCRCalculation.js", CClientScript::POS_HEAD);
}
?>

<div class="sub-element-fields" id="div_<?php echo CHtml::modelName($element) ?>_injection">
	<div>
		<header class="sub-element-header">
			<h4 class="sub-element-title"> PCR Risk (<?php echo $side; ?>) </h4>
		</header>
		<div class="row field-row"></div>
	</div>
	<?php

	$patientId = Yii::app()->request->getParam('patient_id');

	if ($patientId == "") {
		$patientId = Yii::app()->request->getParam('patientId');
	} elseif ($patientId == "") {
		$patientId = $this->patient->hos_num;
	}

	$pcr = OEModule\OphCiExamination\controllers\DefaultController::getPCRData($patientId, $side);
	//echo '<pre>'; print_r($pcr);
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
				echo CHtml::dropDownList('age', 'age',
					array(1 => '<60', 2 => '60-69', 3 => '70-79', 4 => '80-89', 5 => '90+'),
					array('options' => array($pcr['age_group'] => array('selected' => true))));
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
				echo CHtml::dropDownList('pxf_phako', 'pxf_phako', array('N' => 'Not Known', 'N' => 'No', 'Y' => 'Yes'),
					array('options' => array($pcr['anteriorsegment']['pxf_phako'] => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if (($pcr['anteriorsegment']['pxf_phako']) == 'N') { ?>
					<div id='nkpxf<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
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
				echo CHtml::dropDownList('gender', 'gender', array('Male' => 'Male', 'Female' => 'Female'),
					array('options' => array($pcr['gender'] => array('selected' => true))));
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
				echo CHtml::dropDownList('pupil_size', 'pupil_size',
					array('Large' => 'Large', 'Medium' => 'Medium', 'Small' => 'Small'),
					array('options' => array($pcr['anteriorsegment']['pupil_size'] => array('selected' => true))));
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
				echo CHtml::dropDownList('glaucoma', 'glaucoma',
					array('N' => 'Not Known', 'N' => 'No Glaucoma', 'Y' => 'Glaucoma present'),
					array('options' => array($pcr['glaucoma'] => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if ($pcr['glaucoma'] == 'N') { ?>
					<div id='nkglaucoma<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php } ?>&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					Axial Length (mm)
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('axial_length', 'axial_length',
					array('N' => 'Not Known', 1 => '< 26', 2 => '> or = 26'),
					array('options' => array($pcr['axial_length_group'] => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if ($pcr['axial_length_group'] == 'NK') { ?>
					<div id='nkaxial<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php } ?>&nbsp;
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
				echo CHtml::dropDownList('diabetic', 'diabetic',
					array('N' => 'Not Known', 'N' => 'No Diabetes', 'Y' => 'Diabetes present'),
					array('options' => array($pcr['diabetic'] => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if ($pcr['diabetic'] == 'N') { ?>
					<div id='nkdiabetic<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php } ?>&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					Alpha receptor blocker
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('arb', 'arb', array('N' => 'Not Known', 'N' => 'No', 'Y' => 'Yes'),
					array('options' => array('N' => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<div id='nkarb<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
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
				echo CHtml::dropDownList('no_fundal_view', 'no_fundal_view',
					array('NK' => 'Not Known', 'N' => 'No', 'Y' => 'Yes'),
					array('options' => array($pcr['noview'] => array('selected' => true))));
				?>
			</div>
			<div class="large-2 column pcr-nkr">
				<?php if ($pcr['noview'] == 'N') { ?>
					<div id='nknofv<?php echo $side;?>' class="alert-box alert with-icon pcr-nk">Not Known</div>
				<?php } ?>
				&nbsp;
			</div>
			<div class="large-2 column">
				<label>
					Can lie flat
				</label>
			</div>
			<div class="large-2 column">
				<?php
				echo CHtml::dropDownList('abletolieflat', 'abletolieflat', array('N' => 'No', 'Y' => 'Yes'),
					array('options' => array($pcr['lie_flat'] => array('selected' => true))));
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
				echo CHtml::dropDownList('brunescent_white_cataract', 'brunescent_white_cataract',
					array('NK' => 'Not Known', 'N' => 'No', 'Y' => 'Yes'),
					array('options' => array($pcr['anteriorsegment']['brunescent_white_cataract'] => array('selected' => true))));
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
				<?php echo CHtml::dropDownList('doctor_grade_id', 'doctor_grade_id',
					CHtml::listData(DoctorGrade::model()->findAll(array('order' => 'display_order')), 'id', 'grade'),
					array(
						'empty' => '- Select Doctor Grade -',
						'options' => array($pcr['doctor_grade_id'] => array('selected' => true))
					)); ?>
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
					Excess risk compared to average eye <span class="pcr-erisk"> <strong>
							<span> 3  </span></strong> </span> times
				</label>
			</div>
		</div>
	</div>
</div>
