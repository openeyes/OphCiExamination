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
 * This is the model class for table "et_ophciexamination_dilation".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property string $left_time
 * @property string $right_time
 * 
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Dilation extends SplitEventTypeElement {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_Dilation
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'et_ophciexamination_dilation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, eye_id', 'safe'),
				array('left_time', 'requiredIfSide', 'side' => 'left'),
				array('right_time', 'requiredIfSide', 'side' => 'right'),
				array('id, event_id, eye_id, left_time, right_time', 'safe', 'on' => 'search'),
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
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'treatments' => array(self::HAS_MANY, 'OphCiExamination_Dilation_Treatment', 'element_id'),
			'right_treatments' => array(self::HAS_MANY, 'OphCiExamination_Dilation_Treatment', 'element_id', 'on' => 'right_treatments.side = 0'),
			'left_treatments' => array(self::HAS_MANY, 'OphCiExamination_Dilation_Treatment', 'element_id', 'on' => 'left_treatments.side = 1'),
		);
	}

	public function sidedFields() {
		return array('time');
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'eye_id' => 'Eye',
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

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function setDefaultOptions() {
		$this->left_time = date('H:i');
		$this->right_time = date('H:i');
	}

	/**
	 * Converts a (POSTed) form to an array of treatment models.
	 * Required when redisplaying form after validation error.
	 * @param array $treatments array POSTed array of treatments
	 * @param string $side
	 */
	public function convertTreatments($treatments, $side) {
		$return = array();
		$side_id = ($side == 'right') ? 0 : 1;
		if (is_array($treatments)) {
			foreach($treatments as $treatment) {
				if($treatment['side'] == $side_id) {
					$treatment_model = new OphCiExamination_Dilation_Treatment();
					$treatment_model->attributes = $treatment;
					$return[] = $treatment_model;
				}
			}
		}
		return $return;
	}

	public function getUnselectedDilationDrugs($side) {
		$criteria = new CDbCriteria;
		if (!empty($_POST['dilation_treatment'])) {
			$treatments = $this->convertTreatments($_POST['dilation_treatment'], $side);
		} else {
			$treatments = $this->{$side.'_treatments'};
		}
		$drug_ids = CHtml::listData($treatments, 'id', 'drug_id');
		$criteria->addNotInCondition('id',$drug_ids);
		$criteria->order = 'display_order asc';
		return CHtml::listData(OphCiExamination_Dilation_Drugs::model()->findAll($criteria),'id','name');
	}

	protected function beforeValidate() {
		if (!isset($_POST['dilation_treatment'])) {
			$this->addError('dilation_treatment','Please select at least one treatment, or remove the element');
		} else {
			$sides = array(0 => false, 1 => false);
			foreach($_POST['dilation_treatment'] as $dilation_treatment) {
				$sides[$dilation_treatment['side']] = true;
			}
			if($this->hasLeft() && !$sides[1]) {
				$this->addError('dilation_treatment','Please select at least one treatment, or remove the left side');
			}
			if($this->hasRight() && !$sides[0]) {
				$this->addError('dilation_treatment','Please select at least one treatment, or remove the right side');
			}
		}

		return parent::beforeValidate();
	}

	protected function beforeDelete() {
		foreach ($this->treatments as $treatment) {
			if (!$treatment->delete()) {
				throw new Exception('Delete treatment failed: '.print_r($treatment->getErrors(),true));
			}
		}
		return parent::beforeDelete();
	}
	
	protected function afterSave() {
		// Check to see if treatments have been posted
		if(isset($_POST['dilation_treatments_valid']) && $_POST['dilation_treatments_valid']) {

			// Get a list of ids so we can keep track of what's been removed
			$existing_treatment_ids = array();
			foreach($this->treatments as $treatment) {
				$existing_treatment_ids[$treatment->id] = $treatment->id;
			}

			// Process (any) posted treatments
			$new_treatments = (isset($_POST['dilation_treatment'])) ? $_POST['dilation_treatment'] : array();
			foreach($new_treatments as $treatment) {
				
				// Check to see if side is inactive
				if($treatment['side'] == 0 && $this->eye_id == 1
						|| $treatment['side'] == 1 && $this->eye_id == 2) {
					continue;
				}
				
				if(isset($treatment['id']) && isset($existing_treatment_ids[$treatment['id']])) {

					// Treatment is being updated
					$treatment_model = OphCiExamination_Dilation_Treatment::model()->findByPk($treatment['id']);
					unset($existing_treatment_ids[$treatment['id']]);

				} else {

					// Treatment is new
					$treatment_model = new OphCiExamination_Dilation_Treatment();
					$treatment_model->element_id = $this->id;

				}

				// Save treatment attributes
				$treatment_model->drops = $treatment['drops'];
				$treatment_model->drug_id = $treatment['drug_id'];
				$treatment_model->side = $treatment['side'];
				$treatment_model->save();

			}

			// Delete remaining (removed) ids
			OphCiExamination_Dilation_Treatment::model()->deleteByPk(array_values($existing_treatment_ids));

		}

		return parent::afterSave();
	}

	public function wrap() {
		return parent::wrap(array(
			'ophciexamination_dilation_treatment' => 'element_id',
		));
	}
}
