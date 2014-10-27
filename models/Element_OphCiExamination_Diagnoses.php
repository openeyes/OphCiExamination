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

namespace OEModule\OphCiExamination\models;

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

class Element_OphCiExamination_Diagnoses extends \BaseEventTypeElement
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
				//array('diagnoses', 'required'),
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
				'diagnoses' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_Diagnosis', 'element_diagnoses_id',
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

		$criteria = new \CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		$criteria->compare('eye_id', $this->eye_id);
		$criteria->compare('disorder_id', $this->disorder_id);

		return new \CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Update the diagnoses for this element using a hash structure of
	 * [{
	 * 		'disorder_id' => integer,
	 * 		'eye_id' => \Eye::LEFT|\Eye::RIGHT|\Eye::BOTH,
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
					throw new \Exception("save failed" . print_r($curr->getErrors(), true));
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
				throw new \Exception ('Unable to remove old disorder');
			};
		}

		// ensure secondary diagnoses are consistent
		// FIXME: ongoing discussion as to whether we should be removing diagnosis from the patient here
		// particularly if this is a save of an older examination record.
		foreach (\SecondaryDiagnosis::model()->findAll('patient_id=?',array($this->event->episode->patient_id)) as $sd) {
			if ($sd->disorder->specialty && $sd->disorder->specialty->code == 130) {
				if (!in_array($sd->disorder_id,$secondary_disorder_ids)) {
					$this->event->episode->patient->removeDiagnosis($sd->id);
				}
			}
		}

	}

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
		$secondary_to = array();
		list($common, $common_secondary_to) = \CommonOphthalmicDisorder::getListWithSecondaryTo(\Firm::model()->findByPk($firm_id));
		// pre-filter to remove disorders patient already has
		foreach ($common as $id => $disorder) {
			if (!in_array($id,$disorder_ids)) {
				$disorders[$id] = $disorder;
			}
		}
		// pre-filter to remove any disorders in the secondary-to lists the patient already has
		foreach ($common_secondary_to as $id => $secondary_tos) {
			if (!in_array($id, $disorder_ids)) {
				$secondary_to[$id] = array();
				foreach ($secondary_tos as $stid => $term) {
					if (!in_array($stid, $disorder_ids)) {
						$secondary_to[$id][$stid] = $term;
					}
				}
			}
		}

		return array($disorders, $secondary_to);
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

		if($ff = Element_OphCiExamination_FurtherFindings::model()->find('event_id=?',array($this->event_id))){
			$text .= "Further Findings: ". $ff->getFurtherFindingsAssignedString() ."\n";
		}

		return $text;
	}

	/**
	 * Ensure a principal diagnosis is set for the episode.
	 *
	 */
	public function afterValidate()
	{
		if (count($this->diagnoses)) {
			foreach ($this->diagnoses as $diagnosis) {
				if ($diagnosis->principal) {
					return;
				}
			}
			$this->addError('diagnoses','Principal diagnosis required.');
		}
		parent::afterValidate();
	}

	public function getPrint_view()
	{
		return 'print_'.$this->getDefaultView();
	}

}
