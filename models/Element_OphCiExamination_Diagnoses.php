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
 * This is the model class for table "et_ophciexamination_diagnoses".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property Disorder $disorder
 * @property Eye $eye
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Diagnoses extends BaseEventTypeElement {
	public $service;

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
		return 'et_ophciexamination_diagnoses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
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
	public function attributeLabels() {
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
	public function search() {
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

	protected function afterSave() {
		$disorder_ids = array();
		$secondary_diagnosis_ids = array();

		foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
			if ($_POST['principal_diagnosis'] == $disorder_id) {
				$principal_eye = $_POST['eye_id_'.$i];
			}
		}

		$episode = $this->event->episode;
		$episode->disorder_id = $_POST['principal_diagnosis'];
		$episode->eye_id = $principal_eye;
		if (!$episode->save()) {
			throw new Exception('Unable to set episode principal eye/diagnosis: '.print_r($episode->getErrors(),true));
		}

		foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
			$diagnosis = OphCiExamination_Diagnosis::model()->find('element_diagnoses_id=? and disorder_id=?',array($this->id,$disorder_id));

			if (!$diagnosis) {
				$diagnosis = new OphCiExamination_Diagnosis;
				$diagnosis->element_diagnoses_id = $this->id;
				$diagnosis->disorder_id = $disorder_id;
			}

			$diagnosis->eye_id = $_POST['eye_id_'.$i];

			if ($_POST['principal_diagnosis'] == $disorder_id) {
				$diagnosis->principal = true;
			} else {
				$diagnosis->principal = false;
			}

			if (!$diagnosis->save()) {
				throw new Exception('Unable to save diagnosis: '.print_r($diagnosis->getErrors(),true));
			}

			if ($_POST['principal_diagnosis'] != $disorder_id) {
				$sd = SecondaryDiagnosis::model()->find('patient_id=? and disorder_id=?',array($this->event->episode->patient_id,$disorder_id));
				
				if (!$sd) {
					$sd = new SecondaryDiagnosis;
					$sd->patient_id = $this->event->episode->patient_id;
					$sd->disorder_id = $disorder_id;
				}

				$sd->eye_id = $_POST['eye_id_'.$i];
				$sd->date = substr($this->event->created_date,0,10);
				if (!$sd->save()) {
					throw new Exception('Unable to save secondary diagnosis: '.print_r($sd->getErrors(),true));
				}

				$secondary_diagnosis_ids[] = $disorder_id;
			}

			$disorder_ids[] = $disorder_id;
		}

		foreach (OphCiExamination_Diagnosis::model()->findAll('element_diagnoses_id=?',array($this->id)) as $diagnosis) {
			if (!in_array($diagnosis->disorder_id,$disorder_ids)) {
				if (!$diagnosis->delete()) {
					throw new Exception('Unable to delete diagnosis: '.print_r($diagnosis->getErrors(),true));
				}
			}
		}

		foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->event->episode->patient_id)) as $sd) {
			if (!$sd->disorder->systemic) {
				if (!in_array($sd->disorder_id,$secondary_diagnosis_ids)) {
					$sd->delete();
				}
			}
		}

		parent::afterSave();
	}

	public function getFormDiagnoses() {
		$diagnoses = array();

		if (!empty($_POST)) {
			foreach ($_POST['selected_diagnoses'] as $i => $disorder_id) {
				$diagnoses[] = array(
					'disorder' => Disorder::model()->findByPk($disorder_id),
					'eye_id' => $_POST['eye_id_'.$i],
					'principal' => (boolean)$_POST['principal_diagnosis'] == $disorder_id,
				);
			}
		} else if ($this->event) {
			foreach ($this->diagnoses as $i => $diagnosis) {
				$diagnoses[] = array(
					'disorder' => $diagnosis->disorder,
					'eye_id' => $diagnosis->eye_id,
					'principal' => $diagnosis->principal,
				);
			}
		} else if ($this->episode && $this->episode->diagnosis) {
			$diagnoses[] = array(
				'disorder' => $this->episode->diagnosis,
				'eye_id' => $this->episode->eye_id,
				'principal' => true,
			);

			foreach (SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->episode->patient_id)) as $sd) {
				if (!$sd->disorder->systemic) {
					$diagnoses[] = array(
						'disorder' => $sd->disorder,
						'eye_id' => $sd->eye_id,
						'principal' => false,
					);
				}
			}
		}

		return $diagnoses;
	}

	public function getSelectedDisorderIDs() {
		$disorder_ids = array();

		foreach ($this->getFormDiagnoses() as $diagnosis) {
			$disorder_ids[] = $diagnosis['disorder']->id;
		}

		return $disorder_ids;
	}

	public function getCommonOphthalmicDisorders($firm_id) {
		$disorder_ids = $this->getSelectedDisorderIDs();

		$disorders = array();

		foreach (CommonOphthalmicDisorder::getList(Firm::model()->findByPk($firm_id)) as $id => $disorder) {
			if (!in_array($id,$disorder_ids)) {
				$disorders[$id] = $disorder;
			}
		}

		return $disorders;
	}
}
