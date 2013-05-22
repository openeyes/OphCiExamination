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

/**
 * This is the model class for table "et_ophciexamination_injectionmanagement".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property boolean $no_treatment
 * @property integer $no_treatment_reason_id
 * @property integer $left_diagnosis_id
 * @property integer $right_diagnosis_id
 * 
 * The followings are the available model relations:
 * @property OphCiExamination_InjectionManagementComplex_NoTreatmentReason $no_treatment_reason
 * @property Disorder $left_diagnosis
 * @property Disorder $right_diagnosis
 *
 */

class Element_OphCiExamination_InjectionManagementComplex extends SplitEventTypeElement {
	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'et_ophciexamination_injectionmanagementcomplex';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, eye_id, no_treatment, no_treatment_reason_id, left_diagnosis_id, right_diagnosis_id, left_comments, right_comments', 'safe'),
				array('no_treatment', 'required'),
				array('left_diagnosis_id', 'requiredIfSide', 'side' => 'left'),
				array('right_diagnosis_id', 'requiredIfSide', 'side' => 'right'),
				array('left_answers', 'answerValidation', 'side' => 'left'),
				array('right_answers', 'answerValidation', 'side' => 'right'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, eye_id, no_treatment, no_treatment_reason_id, left_diagnosis_id, right_diagnosis_id, left_comments, right_comments', 'safe', 'on' => 'search'),
		);
	}
	
	public function sidedFields() {
		return array('diagnosis_id', 'comments');
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'no_treatment_reason' => array(self::BELONGS_TO, 'OphCiExamination_InjectionManagementComplex_NoTreatmentReason', 'no_treatment_reason_id'),
				'left_diagnosis' => array(self::BELONGS_TO, 'Disorder', 'left_diagnosis_id'),
				'right_diagnosis' => array(self::BELONGS_TO, 'Disorder', 'right_diagnosis_id'),
				'answers' => array(self::HAS_MANY, 'OphCiExamination_InjectionManagementComplex_Answer', 'element_id'),
				'left_answers' => array(self::HAS_MANY, 'OphCiExamination_InjectionManagementComplex_Answer', 'element_id', 'on' => 'left_answers.eye_id = ' . SplitEventTypeElement::LEFT),
				'right_answers' => array(self::HAS_MANY, 'OphCiExamination_InjectionManagementComplex_Answer', 'element_id', 'on' => 'right_answers.eye_id = ' . SplitEventTypeElement::RIGHT),
		);
	}
	
	/**
	* @return array customized attribute labels (name=>label)
	*/
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'no_treatment' => "No Treatment",
				'no_treatment_reason_id' => 'Reason for No Treatment',
				'left_diagnosis_id' => 'Diagnosis',
				'right_diagnosis_id' => 'Diagnosis',
				'left_comments' => 'Comments', 
				'right_comments' => 'Comments',
		);
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
	
		$criteria = new CDbCriteria;
	
		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
	
		$criteria->compare('no_treatment', $this->no_treatment);
		$criteria->compare('no_treatment_reason_id', $this->no_treatment_reason_id);
		$criteria->compare('eye_id', $this->eye_id);
		$criteria->compare('left_diagnosis_id', $this->left_diagnosis_id);
		$criteria->compare('right_diagnosis_id', $this->right_diagnosis_id);
	
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}
	
	/**
	 * validate that all the questions for the set diagnosis have been answered
	 * 
	 * @param unknown $attribute
	 * @param array $params
	 */
	public function answerValidation($attribute, $params) {
		$side = $params['side'];
		if ($disorder_id = $this->{$side . '_diagnosis_id'}) {
			$criteria = new CDbCriteria;
			$criteria->condition = 'disorder_id = :disorder_id';
			$criteria->params = array(':disorder_id' => $disorder_id);
			
			$questions = OphCiExamination_InjectionManagementComplex_Question::model()->findAll($criteria);
			$answer_q_ids = array();
			foreach ($this->{$side . '_answers'} as $ans) {
				$answer_q_ids[] = $ans->question_id;
			}
			foreach ($questions as $required_question) {
				if (!in_array($required_question->id, $answer_q_ids)) {
					$this->addError($attribute, ucfirst($side)." ".$required_question->question." must be answered.");
				}
			}
		}
	}
	
	/**
	 * store the answers for the questions asked for the $side diagnosis
	 * 
	 * @param string $side
	 * @param array $update_answers - associate array of question id to answer value
	 */
	public function updateQuestionAnswers($side, $update_answers) {
		$current_answers = array();
		$save_answers = array();
		
		// note we operate on answers relation here, so that we avoid any custom assignment
		// that might have taken place for the purposes of validation (for $side_answers)
		// TODO: when looking at OE-2927 it might be better if we update the interventions in a different way
		// where the changes are stored when set for validation, and then afterSave is used to do the actual database changes
		foreach ($this->answers as $curr) {
			if ($curr->eye_id == $side) {
				$current_answers[$curr->question_id] = $curr;
			}
		}
		
		// go through each question answer, if there isn't one for this element,
		// create it and store for saving
		// if there is, check if the value is the same ... if it has changed
		// update and store for saving, otherwise remove from the current answers array
		// anything left in current answers at the end is ripe for deleting
		foreach ($update_answers as $question_id => $answer) {
			if (!array_key_exists($question_id, $current_answers)) {
				$s = new OphCiExamination_InjectionManagementComplex_Answer();
				$s->attributes = array('element_id' => $this->id, 'eye_id' => $side, 'question_id' => $question_id, 'answer' => $answer);
				$save_answers[] = $s;
			} else {
				if ($current_answers[$question_id]->answer != $answer) {
					$current_answers[$question_id]->answer = $answer;
					$save_answers[] = $current_answers[$question_id];
				}
				// don't want to delete this, so remove from list which we use later to delete
				unset($current_answers[$question_id]);
			}
		}
		
		// save what needs saving
		foreach ($save_answers as $save) {
			$save->save();
		}
		// delete any that are no longer relevant
		foreach ($current_answers as $curr) {
			$curr->delete();
		}
		
	}
	
	/**
	 * returns list of disorders as defined in the therapy application module
	 */
	public function getDisorders() {
		return Element_OphCoTherapyapplication_Therapydiagnosis::model()->getTherapyDisorders();
	}
	
	/**
	 * return the questions for a given disorder id
	 * 
	 * @param unknown $disorder_id
	 * @throws Exception
	 */
	public function getInjectionQuestionsForDisorderId($disorder_id) {
		if (!$disorder_id) {
			throw new Exception('Disorder id required for injection questions');
		}
	
		$criteria = new CDbCriteria;
		$criteria->condition = 'disorder_id = :disorder_id';
		$criteria->params = array(':disorder_id' => $disorder_id);
	
		$tdis = OphCoTherapyapplication_TherapyDisorder::model()->find($criteria);
		if (!$tdis) {
			throw new Exception('Invalid disorder id for injection questions');
		}
	
		$criteria->order = 'display_order asc';
	
		// get the questions
		return OphCiExamination_InjectionManagementComplex_Question::model()->findAll($criteria);
	}
	
	/**
	 * get the answer that has been set for the $side and $question_id
	 * 
	 * @param unknown $side
	 * @param unknown $question_id
	 */
	public function getQuestionAnswer($side, $question_id) {
		foreach ($this->{$side . '_answers'} as $answer) {
			if ($answer->question_id == $question_id) {
				return $answer->answer;
			}
		}
	}
}
