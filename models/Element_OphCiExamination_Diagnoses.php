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

/**
 * This is the model class for table "et_ophciexamination_diagnoses". It's worth noting that this Element was originally
 * designed to provide a shortcut interface to setting patient diagnoses. Recording the specifics in the element as well
 * is almost incidental. It is possible that this will become redundant in a future version of OE.
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property Disorder $disorder
 * @property Eye $eye
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Diagnoses extends BaseEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'et_ophciexamination_diagnoses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id', 'safe'),
				array('diagnoses', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'diagnoses' => array(self::HAS_MANY, 'OphCiExamination_Diagnosis', 'element_diagnoses_id',
					'order' => 'principal desc',
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'eye_id' => 'Eye',
				'disorder_id' => 'Disorder',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		$criteria->compare('eye_id', $this->eye_id);
		$criteria->compare('disorder_id', $this->disorder_id);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Update the diagnoses for this element using a hash structure of
	 * [{
	 * 		'disorder_id' => integer,
	 * 		'eye_id' => Eye::LEFT|Eye::RIGHT|Eye::BOTH,
	 * 		'principal' => boolean
	 * }, ... ]
	 *
	 * @param $update_disorders
	 * @throws Exception
	 */
	public function updateDiagnoses($update_disorders)
	{
		$current_diagnoses = OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=?',array($this->id));
		$curr_by_disorder_id = array();
		$secondary_disorder_ids = array();

		foreach ($current_diagnoses as $cd) {
			$curr_by_disorder_id[$cd->disorder_id] = $cd;
		}

		foreach ($update_disorders as $u_disorder) {
			if (!$curr = @$curr_by_disorder_id[$u_disorder['disorder_id']]) {
				$curr = new OphCiExamination_Diagnosis();
				$curr->element_diagnoses_id = $this->id;
				$curr->disorder_id = $u_disorder['disorder_id'];
			}
			else {
				unset($curr_by_disorder_id[$u_disorder['disorder_id']]);
			}
			if ($curr->eye_id != $u_disorder['eye_id']
				|| $curr->principal != $u_disorder['principal']) {
				// need to update & save
				$curr->eye_id = $u_disorder['eye_id'];
				$curr->principal = $u_disorder['principal'];
				if (!$curr->save()) {
					throw new Exception("save failed" . print_r($curr->getErrors(), true));
				};
			}
			if ($u_disorder['principal']) {
				$this->event->episode->setPrincipalDiagnosis($u_disorder['disorder_id'], $u_disorder['eye_id']);
			}
			else {
				//add a secondary diagnosis
				// Note that this may be creating duplicate diagnoses, but that is okay as the dates on them will differ
				$this->event->episode->patient->addDiagnosis($u_disorder['disorder_id'],
					$u_disorder['eye_id'], substr($this->event->created_date,0,10));
				// and track
				$secondary_disorder_ids[] = $u_disorder['disorder_id'];
			}
		}

		// remove any current diagnoses no longer needed
		foreach ($curr_by_disorder_id as $curr) {
			if (!$curr->delete()) {
				throw new Exception ('Unable to remove old disorder');
			};
		}

		// ensure secondary diagnoses are consistent
		// FIXME: ongoing discussion as to whether we should be removing diagnosis from the patient here
		// particularly if this is a save of an older examination record.
		foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->event->episode->patient_id)) as $sd) {
			if ($sd->disorder->specialty && $sd->disorder->specialty->code == 130) {
				if (!in_array($sd->disorder_id,$secondary_disorder_ids)) {
					$this->event->episode->patient->removeDiagnosis($sd->id);
				}
			}
		}

	}

	/*
	protected function afterSave()
	{
		$disorder_ids = array();
		$secondary_diagnosis_ids = array();

		$diagnosis_eyes = array();

		if (isset($_POST['Element_OphCiExamination_Diagnoses'])) {
			foreach ($_POST['Element_OphCiExamination_Diagnoses'] as $key => $value) {
				if (preg_match('/^eye_id_[0-9]+$/',$key)) {
					$diagnosis_eyes[] = $value;
				}
			}
		}

		if (isset($_POST['selected_diagnoses'])) {
			foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
				if (@$_POST['principal_diagnosis'] == $disorder_id) {
					$eye_id = isset($diagnosis_eyes[$i]) ? $diagnosis_eyes[$i] : Eye::BOTH;
					$principal_eye = $eye_id;
				}
			}
		}

		if (isset($_POST['principal_diagnosis'])) {
			$this->event->episode->setPrincipalDiagnosis($_POST['principal_diagnosis'], $principal_eye);
		}

		if (isset($_POST['selected_diagnoses'])) {
			foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
				$diagnosis = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and disorder_id=?',array($this->id,$disorder_id));
				$eye_id = isset($diagnosis_eyes[$i]) ? $diagnosis_eyes[$i] : Eye::BOTH;

				if (!$diagnosis) {
					$diagnosis = new OphCiExamination_Diagnosis;
					$diagnosis->element_diagnoses_id = $this->id;
					$diagnosis->disorder_id = $disorder_id;
				}

				$diagnosis->eye_id = $eye_id;

				if (@$_POST['principal_diagnosis'] == $disorder_id) {
					$diagnosis->principal = true;
				} else {
					$diagnosis->principal = false;
				}

				if (!$diagnosis->save()) {
					throw new Exception('Unable to save diagnosis: '.print_r($diagnosis->getErrors(),true));
				}

				if (@$_POST['principal_diagnosis'] != $disorder_id) {
					$this->event->episode->patient->addDiagnosis($disorder_id, $eye_id, substr($this->event->created_date,0,10));
					$secondary_diagnosis_ids[] = $disorder_id;
				}

				$disorder_ids[] = $disorder_id;
			}
		}

		foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=?',array($this->id)) as $diagnosis) {
			if (!in_array($diagnosis->disorder_id,$disorder_ids)) {
				if (!$diagnosis->delete()) {
					throw new Exception('Unable to delete diagnosis: '.print_r($diagnosis->getErrors(),true));
				}
			}
		}

		foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->event->episode->patient_id)) as $sd) {
			if ($sd->disorder->specialty && $sd->disorder->specialty->code == 130) {
				if (!in_array($sd->disorder_id,$secondary_diagnosis_ids)) {
					$this->event->episode->patient->removeDiagnosis($sd->id);
				}
			}
		}

		parent::afterSave();
	}

	public function getFormDiagnoses()
	{
		$diagnoses = array();

		$episode = Yii::app()->getController()->episode;

		$diagnosis_eyes = array();

		if (isset($_POST['Element_OphCiExamination_Diagnoses'])) {
			foreach ($_POST['Element_OphCiExamination_Diagnoses'] as $key => $value) {
				if (preg_match('/^eye_id_[0-9]+$/',$key)) {
					$diagnosis_eyes[] = $value;
				}
			}
		}

		if (!empty($_POST)) {
			if (isset($_POST['selected_diagnoses'])) {
				foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
					$diagnoses[] = array(
						'disorder' => Disorder::model()->findByPk($disorder_id),
						'eye_id' => isset($diagnosis_eyes[$i]) ? $diagnosis_eyes[$i] : Eye::BOTH,
						'principal' => (@$_POST['principal_diagnosis'] == $disorder_id),
					);
				}
			}
		} elseif ($this->event) {
			foreach ($this->diagnoses as $i => $diagnosis) {
				$diagnoses[] = array(
					'disorder' => $diagnosis->disorder,
					'eye_id' => $diagnosis->eye_id,
					'principal' => $diagnosis->principal,
				);
			}
		} else {
			if ($episode && $episode->diagnosis) {
				$diagnoses[] = array(
					'disorder' => $episode->diagnosis,
					'eye_id' => $episode->eye_id,
					'principal' => true,
				);
			}

			$patient_id = Yii::app()->controller->patient->id;
			foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($patient_id)) as $sd) {
				if (!$episode || $sd->disorder_id != $episode->disorder_id || $episode->eye_id != $sd->eye_id) {
					if ($sd->disorder->specialty && $sd->disorder->specialty->code == 130) {
						if (isset($diagnoses[$sd->disorder_id])) {
							if ($sd->eye_id != $diagnoses[$sd->disorder_id]['eye_id']) {
								$sd->eye_id = Eye::model()->find('name=?',array('Both'))->id;
							}
						}

						$diagnoses[$sd->disorder_id] = array(
							'disorder' => $sd->disorder,
							'eye_id' => $sd->eye_id,
							'principal' => false,
						);
					}
				}
			}
		}

		$principal = false;

		foreach ($diagnoses as $diagnosis) {
			if ($diagnosis['principal']) {
				$principal = true;
			}
		}

		if (!$principal && isset($diagnosis[0])) {
			$diagnoses[0]['principal'] = true;
		}

		return $this->uniqueDiagnoses($diagnoses);
	}


	public function uniqueDiagnoses($diagnoses)
	{
		$_diagnoses = array();

		foreach ($diagnoses as $diagnosis) {
			if (!$this->diagnosisInArray($diagnosis,$_diagnoses)) {
				$_diagnoses[] = $diagnosis;
			}
		}

		return $_diagnoses;
	}

	public function diagnosisInArray($diagnosis, $diagnoses)
	{
		foreach ($diagnoses as $_diagnosis) {
			if ($diagnosis['disorder']->id == $_diagnosis['disorder']->id && $diagnosis['eye_id'] == $_diagnosis['eye_id'] && $diagnosis['principal'] == $_diagnosis['principal']) {
				return true;
			}
		}

		return false;
	}
	*/

	/**
	 * Returns the disorder ids for the element diagnoses
	 *
	 * @return integer[]
	 */
	public function getSelectedDisorderIDs()
	{
		$disorder_ids = array();

		foreach ($this->diagnoses as $diagnosis) {
			$disorder_ids[] = $diagnosis->disorder_id;
		}

		return $disorder_ids;
	}

	/**
	 * Gets the common ophthalmic disorders for the given firm, not including those
	 * already part of the element diagnoses
	 *
	 * @param $firm_id
	 * @return array { id => Disorder }
	 */
	public function getCommonOphthalmicDisorders($firm_id)
	{
		$disorder_ids = $this->getSelectedDisorderIDs();

		$disorders = array();

		foreach (CommonOphthalmicDisorder::getList(Firm::model()->findByPk($firm_id)) as $id => $disorder) {
			if (!in_array($id,$disorder_ids)) {
				$disorders[$id] = $disorder;
			}
		}

		return $disorders;
	}

	/**
	 * Delete the related diagnoses for this element
	 *
	 * @return bool
	 */
	protected function beforeDelete()
	{
		foreach ($this->diagnoses as $diagnosis) {
			$diagnosis->delete();
		}

		return parent::beforeDelete();
	}

	public function getLetter_string()
	{
		$text = "";

		if ($principal = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and principal=1',array($this->id))) {
			$text .= "Principal diagnosis: ".$principal->eye->adjective." ".$principal->disorder->term."\n";
		}

		foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=? and principal=0',array($this->id)) as $diagnosis) {
			$text .= "Secondary diagnosis: ".$diagnosis->eye->adjective." ".$diagnosis->disorder->term."\n";
		}

		return $text;
	}

	/**
	 * Ensure a principal diagnosis is set for the episode.
	 *
	 */
	public function afterValidate()
	{
		foreach ($this->diagnoses as $diagnosis) {
			if ($diagnosis->principal) {
				return;
			}
		}

		$this->addError('diagnoses','Principal diagnosis required.');
	}

}
