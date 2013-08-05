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

class AdminController extends ModuleAdminController
{
	public $defaultAction = "ViewNoTreatmentReasons";

	// No Treatment Reason views

	/**
	 * list the reasons that can be selected for not providing an injection treatment
	 */
	public function actionViewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason()
	{
		$model_list = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findAll(array('order' => 'display_order asc'));
		$this->jsVars['OphCiExamination_sort_url'] = $this->createUrl('sortNoTreatmentReasons');
		$this->jsVars['OphCiExamination_model_status_url'] = $this->createUrl('setNoTreatmentReasonStatus');

		Audit::add('admin','list',null,false,array('module'=>'OphCiExamination','model'=>'OphCiExamination_InjectionManagementComplex_NoTreatmentReason'));

		$this->render('list',array(
				'model_list'=>$model_list,
				'title'=>'No Treatment Reasons',
				'model_class'=>'OphCiExamination_InjectionManagementComplex_NoTreatmentReason',
		));
	}

	/**
	 * create a new no treatment reason for injection
	 *
	 */
	public function actionCreateOphCiExamination_InjectionManagementComplex_NoTreatmentReason()
	{
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
				Audit::add('admin','create',serialize($model->attributes),false,array('module'=>'OphCiExamination','model'=>'InjectionManagementComplex_NoTreatmentReason'));
				Yii::app()->user->setFlash('success', 'Injection Management No Treatment reason added');

				$this->redirect(array('ViewAllOphCiExamination_InjectionManagementComplex_NoTreatmentReason'));
			}
		}

		$this->render('create', array(
				'model' => $model,
		));
	}

	/**
	 * update the no treatment reason with id $id
	 *
	 * @param integer $id
	 */
	public function actionUpdateOphCiExamination_InjectionManagementComplex_NoTreatmentReason($id)
	{
		$model = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findByPk((int) $id);

		if (isset($_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'])) {
			$model->attributes = $_POST['OphCiExamination_InjectionManagementComplex_NoTreatmentReason'];

			if ($model->save()) {
				Audit::add('admin','update',serialize($model->attributes),false,array('module'=>'OphCiExamination','model'=>'InjectionManagementComplex_NoTreatmentReason'));
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
	public function actionSortNoTreatmentReasons()
	{
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

	/**
	 * Update the enabled status of the given reason
	 */
	public function actionSetNoTreatmentReasonStatus()
	{
		if ($model = OphCiExamination_InjectionManagementComplex_NoTreatmentReason::model()->findByPk((int) @$_POST['id'])) {
			if (!array_key_exists('enabled', $_POST)) {
				throw new Exception('cannot determine status for reason');
			}
			error_log('cack' . $_POST['enabled']);

			if ($_POST['enabled']) {
				$model->enabled = true;
			} else {
				$model->enabled = false;
			}
			if (!$model->save()) {
				throw new Exception("Unable to set reason status: " . print_r($model->getErrors(), true));
			}

			Audit::add('admin','set-reason-status',serialize($_POST),false,array('module'=>'OphCiExamination','model'=>'OphCiExamination_InjectionManagementComplex_NoTreatmentReason'));

		} else {
			throw new Exception('Cannot find reason with id' . @$_POST['id']);
		}
	}

	// Disorder Questions

	/**
	 * list the questions set for the given disorder id
	 */
	public function actionViewOphCiExamination_InjectionManagementComplex_Question()
	{
		$this->jsVars['OphCiExamination_sort_url'] = $this->createUrl('sortQuestions');
		$this->jsVars['OphCiExamination_model_status_url'] = $this->createUrl('setQuestionStatus');

		$model_list = array();
		$disorder_id = null;
		if (isset($_GET['disorder_id'])) {
			$disorder_id = (int) $_GET['disorder_id'];
			$criteria = new CDbCriteria;
			$criteria->order = "display_order asc";
			$criteria->condition = "disorder_id = :disorder_id";
			$criteria->params = array(':disorder_id' => (int) $_GET['disorder_id']);

			$model_list = OphCiExamination_InjectionManagementComplex_Question::model()->findAll($criteria);

			$this->jsVars['OphCiExamination_sort_url'] = $this->createUrl('sortQuestions');
		}

		Audit::add('admin','list-for-disorder',serialize($_GET),false,array('module'=>'OphCiExamination','model'=>'OphCiExamination_InjectionManagementComplex_Question'));

		$this->render('list_diagnosis_questions',array(
				'disorder_id'=>$disorder_id,
				'model_list'=>$model_list,
				'title'=>'Disorder Questions',
				'model_class'=>'OphCiExamination_InjectionManagementComplex_Question',
		));

	}

	/**
	 * create a question for the given disorder id
	 */
	public function actionCreateOphCiExamination_InjectionManagementComplex_Question()
	{
		$model = new OphCiExamination_InjectionManagementComplex_Question();

		if (isset($_POST['OphCiExamination_InjectionManagementComplex_Question'])) {
			// process submission
			$model->attributes = $_POST['OphCiExamination_InjectionManagementComplex_Question'];

			if ($model->disorder_id) {
				// not a valid question otherwise
				$criteria = new CDbCriteria;
				$criteria->order = "display_order desc";
				$criteria->condition = "disorder_id = :disorder_id";
				$criteria->limit  = 1;
				$criteria->params = array(':disorder_id' => $model->disorder_id);

				if ($bottom = OphCiExamination_InjectionManagementComplex_Question::model()->find($criteria) ) {
					$display_order = $bottom->display_order+1;
				} else {
					$display_order = 1;
				}
				$model->display_order = $display_order;

				if ($model->save()) {
					Audit::add('admin','create',serialize($model->attributes),false,array('module'=>'OphCiExamination','model'=>'InjectionManagementComplex_Question'));
					Yii::app()->user->setFlash('success', 'Injection Management Disorder Question added');

					$this->redirect(array('ViewOphCiExamination_InjectionManagementComplex_Question', 'disorder_id' => $model->disorder_id));
				}
			}
		} elseif (isset($_GET['disorder_id'])) {
			// allow the ability to pre-select which disorder is being set for a question
			$model->disorder_id = $_GET['disorder_id'];
		}

		$this->render('create', array(
				'model' => $model,
		));

	}

	/**
	 * update the question for the specified id
	 *
	 * @param integer $id
	 */
	public function actionUpdateOphCiExamination_InjectionManagementComplex_Question($id)
	{
		$model = OphCiExamination_InjectionManagementComplex_Question::model()->findByPk((int) $id);
		if (isset($_POST['OphCiExamination_InjectionManagementComplex_Question'])) {
			// process submission
			$model->attributes = $_POST['OphCiExamination_InjectionManagementComplex_Question'];

			if ($model->save()) {
				Audit::add('admin','update',serialize($model->attributes),false,array('module'=>'OphCiExamination','model'=>'InjectionManagementComplex_Question'));
				Yii::app()->user->setFlash('success', 'Injection Management Disorder Question updated');

				$this->redirect(array('ViewOphCiExamination_InjectionManagementComplex_Question', 'disorder_id' => $model->disorder_id));
			}
		}

		$this->render('update', array(
				'model' => $model
		));
	}

	/**
	 * sorts questions into the given order
	*/
	public function actionSortQuestions()
	{
		if (!empty($_POST['order'])) {
			foreach ($_POST['order'] as $i => $id) {
				if ($question = OphCiExamination_InjectionManagementComplex_Question::model()->findByPk($id)) {
					$question->display_order = $i+1;
					if (!$question->save()) {
						throw new Exception("Unable to save question: ".print_r($question->getErrors(),true));
					}
				}
			}
		}
	}

	/**
	 * Update the enabled status of the given question
	 */
	public function actionSetQuestionStatus()
	{
		if ($model = OphCiExamination_InjectionManagementComplex_Question::model()->findByPk((int) @$_POST['id'])) {
			if (!array_key_exists('enabled', $_POST)) {
				throw new Exception('cannot determine status for question');
			}
			error_log('cack' . $_POST['enabled']);

			if ($_POST['enabled']) {
				$model->enabled = true;
			} else {
				$model->enabled = false;
			}
			if (!$model->save()) {
				throw new Exception("Unable to set question status: " . print_r($model->getErrors(), true));
			}

			Audit::add('admin','set-question-status',serialize($_POST),false,array('module'=>'OphCiExamination','model'=>'OphCiExamination_InjectionManagementComplex_Question'));
		} else {
			throw new Exception('Cannot find question with id' . @$_POST['id']);
		}
	}
}
