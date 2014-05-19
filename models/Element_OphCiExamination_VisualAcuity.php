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
use Yii;

/**
 * This is the model class for table "et_ophciexamination_visualacuity".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property string $left_comments
 * @property string $right_comments
 * @property boolean $left_unable_to_assess
 * @property boolean $right_unable_to_assess
 * @property boolean $left_eye_missing
 * @property boolean $right_eye_missing
 *
 * The followings are the available model relations:
 * @property OphCiExamination_VisualAcuityUnit $unit
 * @property OphCiExamination_VisualAcuity_Reading[] $readings
 * @property OphCiExamination_VisualAcuity_Reading[] $left_readings
 * @property OphCiExamination_VisualAcuity_Reading[] $right_readings
 * @property User $user
 * @property User $usermodified
 * @property Eye eye
 * @property EventType $eventType
 * @property Event $event
 */

class Element_OphCiExamination_VisualAcuity extends \SplitEventTypeElement
{
	public $service;

	/**
	 * Returns the static model of the specified AR class.
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
		return 'et_ophciexamination_visualacuity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('left_comments, right_comments, eye_id, unit_id, left_unable_to_assess, right_unable_to_assess, left_eye_missing, right_eye_missing', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, left_comments, right_comments, eye_id', 'safe', 'on' => 'search'),
		);
	}

	public function sidedFields()
	{
		return array('comments');
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
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'unit' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_VisualAcuityUnit', 'unit_id'),
			'readings' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Reading', 'element_id'),
			'right_readings' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Reading', 'element_id', 'on' => 'right_readings.side = ' . OphCiExamination_VisualAcuity_Reading::RIGHT),
			'left_readings' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Reading', 'element_id', 'on' => 'left_readings.side = ' . OphCiExamination_VisualAcuity_Reading::LEFT),
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
			'left_comments' => 'Comments',
			'right_comments' => 'Comments',
			'left_unable_to_assess' => 'Unable to assess',
			'right_unable_to_assess' => 'Unable to assess',
			'left_eye_missing' => 'Eye missing',
			'right_eye_missing' => 'Eye missing',
		);
	}


	/**
	 * Perform dependent validation for readings and flags.
	 */
	protected function afterValidate()
	{
		$contra_flags = array('_unable_to_assess', '_eye_missing');
		foreach (array('left', 'right') as $side) {
			$check = 'has'.ucfirst($side);
			if ($this->$check()) {
				if ($this->{$side . '_readings'}) {
					foreach ($this->{$side . '_readings'} as $i => $reading) {
						if (!$reading->validate()) {
							foreach ($reading->getErrors() as $fld => $err) {
								$this->addError($side . '_readings', ucfirst($side) . ' reading(' .($i+1) . '): ' . implode(', ', $err) );
							}
						}
					}
					foreach ($contra_flags as $f) {
						if ($this->{$side . $f}) {
							$this->addError($side . $f, 'Cannot be ' . $this->getAttributeLabel($side.$f) . ' with VA readings.');
						}
					}
				}
				else {
					$valid = false;
					foreach ($contra_flags as $f) {
						if ($this->{$side . $f}) {
							$valid = true;
						}
					}
					if (!$valid && !$this->{$side . '_comments'}) {
						$this->addError('eye_id', 'Must have some information for ' . $side . ' side to be valid');
					}
				}
			}
			else {
				$error = false;
				if ($this->{$side . '_readings'}) {
					$error =  true;
				}
				else {
					foreach ($contra_flags as $f) {
						if ($this->{$side . $f}) {
							$error = true;
						}
					}
				}
				if ($error) {
					$this->addError('eye_id', ucfirst($side) . ' data not allowed for VA when ' . $side . ' side not set.');
				}
			}
		}

		parent::afterValidate();
	}

	public function setDefaultOptions()
	{
		$this->unit_id = $this->getSetting('unit_id');
	}

	/**
	 * Array of unit values for dropdown
	 * @param integer $unit_id
	 * @param boolean $selectable - whether want selectable values or all unit values
	 * @return array
	 */
	public function getUnitValues($unit_id = null, $selectable=true)
	{
		if ($unit_id) {
			$unit = OphCiExamination_VisualAcuityUnit::model()->findByPk($unit_id);
		} else {
			$unit = $this->unit;
		}
		if ($selectable) {
			return \CHtml::listData($unit->selectableValues, 'base_value', 'value');
		} else {
			return \CHtml::listData($unit->values, 'base_value', 'value');
		}
	}

	public function getUnitValuesForForm($unit_id = null)
	{
		if ($unit_id) {
			$unit = OphCiExamination_VisualAcuityUnit::model()->findByPk($unit_id);
		} else {
			$unit = $this->unit;
		}

		$unit_values = $unit->selectableValues;

		$criteria = new \CDbCriteria();
		$criteria->condition = 'id <> :unit_id AND active = 1';
		$criteria->params = array(':unit_id' => $unit->id);
		$criteria->order = 'name';
		$tooltip_units = OphCiExamination_VisualAcuityUnit::model()->findAll($criteria);

		$options = array();

		// getting the conversion values
		foreach ($unit_values as $uv) {
			$idx = (string) $uv->base_value;
			$options[$idx] = array('data-tooltip' => array());
			foreach ($tooltip_units as $tt) {
				$last = null;
				foreach ($tt->values as $tt_val) {

					if ($tt_val->base_value <= $uv->base_value) {
						$val = $tt_val->value;

						if ($last != null && (abs($uv->base_value - $tt_val->base_value) > abs($uv->base_value - $last->base_value))) {
							$val = $last->value;
						}
						$map = array('name' => $tt->name, 'value' => $val, 'approx' => false);
						if ($tt_val->base_value < $uv->base_value) {
							$map['approx'] = true;
						}
						$options[$idx]['data-tooltip'][] = $map;
						break;
					}

					$last = $tt_val;

				}
			}
			// need to JSONify the options data
			$options[$idx]['data-tooltip'] = \CJSON::encode($options[$idx]['data-tooltip']);
		}

		return array(\CHtml::listData($unit_values, 'base_value', 'value'), $options);

	}

	/**
	 * Get a combined string of the different readings. If a unit_id is given, the readings will
	 * be converted to unit type of that id.
	 *
	 * @param string $side
	 * @param null $unit_id
	 * @return string
	 */
	public function getCombined($side, $unit_id = null)
	{
		$combined = array();
		foreach ($this->{$side.'_readings'} as $reading) {
			$combined[] = $reading->convertTo($reading->value, $unit_id) . ' ' . $reading->method->name;
		}
		return implode(', ',$combined);
	}

	/**
	 * Get the best reading for the given side
	 *
	 * @param string $side
	 * @return OphCiExamination_VisualAcuity_Reading|null
	 */
	public function getBestReading($side)
	{
		$best = null;
		foreach ($this->{$side.'_readings'} as $reading) {
			if (!$best || $reading->value >= $best->value) {
				$best = $reading;
			}
		}
		return $best;
	}

	/**
	 * Get the best reading for the specified side in current units
	 * @param string $side
	 * @return string
	 */
	public function getBest($side)
	{
		$best = $this->getBestReading($side);
		if ($best) {
			return $best->convertTo($best->value);
		}
	}

	/**
	 * Convenience function for generating string of why a reading wasn't recorded for a side.
	 *
	 * @param $side
	 * @return string
	 */
	public function getTextForSide($side)
	{
		$checkFunc = 'has' . ucfirst($side);
		if ($this->$checkFunc() && !$this->{$side . '_readings'}) {
			if ($this->{$side . '_unable_to_assess'}) {
				$text = $this->getAttributeLabel($side . '_unable_to_assess');
				if ($this->{$side . '_eye_missing'}) {
					$text .= ", " . $this->getAttributeLabel($side . '_eye_missing');
				}
				return $text;
			}
			elseif ($this->{$side . '_eye_missing'}) {
				return $this->getAttributeLabel($side . '_eye_missing');
			}
			else {
				return "not recorded";
			}
		}
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
		$criteria->compare('left_comments', $this->left_comments);
		$criteria->compare('right_comments', $this->right_comments);

		return new \CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	protected function beforeDelete()
	{
		foreach ($this->readings as $reading) {
			if (!$reading->delete()) {
				throw new Exception('Delete reading failed: '.print_r($reading->getErrors(),true));
			}
		}
		return parent::beforeDelete();
	}

	/**
	 * Update the readings for the given side
	 *
	 * @param $side Eye::LEFT or Eye::RIGHT
	 * @param $readings
	 * @throws Exception
	 */
	public function updateReadings($side, $readings)
	{
		if ($side == \Eye::LEFT) {
			$side = OphCiExamination_VisualAcuity_Reading::LEFT;
		}
		else {
			$side = OphCiExamination_VisualAcuity_Reading::RIGHT;
		}

		$curr_by_id = array();
		$save = array();

		foreach ($this->readings as $r) {
			if ($r->side == $side) {
				$curr_by_id[$r->id] = $r;
			}
		}

		if ($readings) {
			foreach ($readings as $reading) {
				if (!isset($reading['id']) || !array_key_exists($reading['id'], $curr_by_id)) {
					$obj = new OphCiExamination_VisualAcuity_Reading();
				}
				else {
					$obj = $curr_by_id[$reading['id']];
					unset($curr_by_id[$reading['id']]);
				}
				$obj->attributes = $reading;
				$obj->element_id = $this->id;
				$obj->side = $side;
				$save[] = $obj;
			}
		}

		foreach ($save as $s) {
			if (!$s->save()) {
				throw new Exception('unable to save va reading:' . print_r($s->getErrors(), true));
			};
		}

		foreach ($curr_by_id as $curr) {
			if (!$curr->delete()) {
				throw new Exception('unable to delete va reading:' . print_r($curr->getErrors(), true));
			}
		}
	}


	/**
	 * returns the default letter string for the va readings. Converts all readings to Snellen Metre
	 * as this is assumed to be the standard for correspondence.
	 *
	 * @TODO: The units for correspondence should become a configuration variable
	 *
	 * @throws Exception
	 * @return string
	 */
	public function getLetter_string()
	{
		if (!$unit = OphCiExamination_VisualAcuityUnit::model()->find('name = ?', array(Yii::app()->params['ophciexamination_visualacuity_correspondence_unit']))) {
			throw new Exception("Configured visual acuity correspondence unit was not found: ".Yii::app()->params['ophciexamination_visualacuity_correspondence_unit']);
		}

		$text = "Visual acuity:\n";

		if ($this->hasRight()) {
			$text .= "Right Eye: ";
			if ($this->getCombined('right')) {
				$text .= $this->getCombined('right', $unit->id);
			} else {
				$text .= $this->getTextForSide('right');
			}

			if (trim($this->right_comments)) {
				$text .= ", ".$this->right_comments;
			}
		}
		else {
			$text .= "Right Eye: not recorded";
		}
		$text .= "\n";

		if ($this->hasLeft()) {
			$text .= "Left Eye: ";
			if ($this->getCombined('left')) {
				$text .= $this->getCombined('left', $unit->id);
			} else {
				$text .= $this->getTextForSide('left');
			}
			if (trim($this->left_comments)) {
				$text .= ", ".$this->left_comments;
			}
		}
		else {
			$text .= "Left Eye: not recorded";
		}

		return $text."\n";
	}

	/**
	 * Get the list of currently used method ids
	 */
	public function getMethodValues()
	{
		$method_values = array();

		foreach ($this->readings as $reading) {
			$method_values[] = $reading->method_id;
		}

		return $method_values;
	}
}
