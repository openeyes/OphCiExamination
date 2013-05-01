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

class AdminController extends ModuleAdminController {
	public $defaultAction = "ViewNoTreatmentReasons";
	
	// No Treatment Reason views
	
	public function actionViewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason() {
		$model_list = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findAll(array('order' => 'display_order asc'));
		$this->jsVars['OphCiExamination_sort_url'] = $this->createUrl('sortNoTreatmentReasons');
		
		$this->render('list',array(
				'model_list'=>$model_list,
				'title'=>'Treatment Drugs',
				'model_class'=>'OphCiExamination_InjectionManagementComplex_NoTreatmentReason',
		));
	}
	
	public function actionCreateOphCiExamination_InjectionManagementComplex_NoTreatmentReason() {
		$model = new OphCiExamination_InjectionManagementComplex_NoTreatmentReason();
	
		if (isset($_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'])) {
			$model->attributes = $_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'];
				
			if ($bottom_drug = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->find(array('order'=>'display_order desc'))) {
				$display_order = $bottom_drug->display_order+1;
			} else {
				$display_order = 1;
			}
			$model->display_order = $display_order;
				
			if ($model->save()) {
				Audit::add('OphCiExamination_InjectionManagementComplex_NoTreatmentReason', 'create', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Injection Management No Treatment reason added');
	
				$this->redirect(array('ViewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason'));
			}
		}
	
		$this->render('create', array(
				'model' => $model,
		));
	}
	
	
	public function actionUpdateOphCiExamination_InjectionManagementComplex_NoTreatmentReason($id) {
		$model = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findByPk((int)$id);
	
		if (isset($_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'])) {
			$model->attributes = $_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'];
	
			if ($model->save()) {
				Audit::add('OphCiExamination_InjectionManagementComplex_NoTreatmentReason', 'update', serialize($model->attributes));
				Yii::app()->user->setFlash('success', 'Injection Management No Treatment reason updated');
	
				$this->redirect(array('ViewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason'));
			}
		}
	
		$this->render('create', array(
				'model' => $model,
		));
	}
	
	/*
	 * sorts the no treatment reasons into the provided order (NOTE does not support a paginated list of reasons)
	*/
	public function actionSortNoTreatmentReasons() {
		if (!empty($_POST['order'])) {
			foreach ($_POST['order'] as $i => $id) {
				if ($drug = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findByPk($id)) {
					$drug->display_order = $i+1;
					if (!$drug->save()) {
						throw new Exception("Unable to save drug: ".print_r($drug->getErrors(),true));
					}
				}
			}
		}
	}
	
	// Disorder Questions
	
	public function actionViewOphCiExamination_InjectionManagementComplex_Question() {
		
		$model_list = array();
		$disorder_id = null;
		if (isset($_GET['disorder_id'])) {
			$disorder_id = (int)$_GET['disorder_id'];
			$criteria = new CDbCriteria;
			$criteria->order = "display_order desc";
			$criteria->condition = "disorder_id = :disorder_id";
			$criteria->params = array(':disorder_id' => (int)$_GET['disorder_id']);
			 
			$model_list = OphCiExamination_InjectionManagementComplex_Question::model()->find($criteria);
		}
		
		$this->render('list_diagnosis_questions',array(
				'disorder_id'=>$disorder_id,
				'model_list'=>$model_list,
				'title'=>'Disorder Questions',
				'model_class'=>'OphCiExamination_InjectionManagementComplex_Question',
		));
		
	}
	
}