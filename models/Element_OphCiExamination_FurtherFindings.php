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
 * This is the model class for table "et_ophciexamination_further_findings".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id

 *
 * The followings are the available model relations:
 * @property OphCiExamination_VisualAcuityUnit $unit
 * @property User $user
 * @property User $usermodified
 * @property Event $event
 */

class Element_OphCiExamination_FurtherFindings extends \BaseEventTypeElement
{
	public $service;
	protected $auto_update_relations = true;
	/*protected $relation_defaults = array(
		'left_readings' => array(
		'side' => OphCiExamination_FurtherFindings_Reading::LEFT
		),
		'right_readings' => array(
		'side' => OphCiExamination_FurtherFindings_Reading::RIGHT
		),
	);*/

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
		return 'et_ophciexamination_further_findings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				//array('further', 'safe'),
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
			//'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			//'fluidtype_assignments' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_OCT_FluidTypeAssignment' , 'element_id' ),
			//'left_fluidtypes' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_OCT_FluidType', 'fluidtype_id', 'through' => 'fluidtype_assignments', 'on' => 'fluidtype_assignments.eye_id = ' . \Eye::LEFT),
			'further_findings' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings',array('further_finding_id'=>'id'), 'through' => 'further_findings_assignments'),
			'further_findings_assignments' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings_Assignment' , 'element_id' ),


			//'further_findings' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings', 'element_id'),
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
			'further_findings' => 'Findings',
		);
	}

	/**
	 * Perform dependent validation for readings and flags.
	 */
	/*protected function afterValidate()
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
					if (!$valid) {
						$this->addError($side, ucfirst($side) . ' side has no data.');
					}
				}
			}
		}

		parent::afterValidate();
	}

	/*public function setDefaultOptions()
	{
		$this->unit_id = $this->getSetting('unit_id');
		if ($rows = $this->getSetting('default_rows')) {
			$left_readings = array();
			$right_readings = array();
			for ($i = 0; $i < $rows; $i++) {
				$left_readings[]  = new OphCiExamination_VisualAcuity_Reading();
				$right_readings[]  = new OphCiExamination_VisualAcuity_Reading();
			}
			$this->left_readings = $left_readings;
			$this->right_readings = $right_readings;
		}
	}*/

	/**
	 * Array of unit values for dropdown
	 * @param integer $unit_id
	 * @param boolean $selectable - whether want selectable values or all unit values
	 * @return array
	 */
	/*public function getUnitValues($unit_id = null, $selectable=true)
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
	}*/

	/*public function getUnitValuesForForm($unit_id = null)
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
	/*public function getCombined($side, $unit_id = null)
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
	/*public function getBestReading($side)
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
	/*public function getBest($side)
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
	/*public function getTextForSide($side)
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
		return new \CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function canViewPrevious()
	{
		return true;
	}

	public function getFurtherFindingsAssigned()
	{
		$further_findings = array();

		if ($this->id) {
			foreach (OphCiExamination_FurtherFindings_Assignment::model()->findAll('element_id=?',array($this->id)) as $ff) {
				$further_findings[] = $ff->further_finding_id;
			}
		}

		return $further_findings;
	}
}
