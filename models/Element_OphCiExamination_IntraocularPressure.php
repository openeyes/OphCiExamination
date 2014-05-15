<?php /**
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
 * This is the model class for table "et_ophciexamination_intraocularpressure".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property OphCiExamination_Instrument $left_instrument
 * @property OphCiExamination_Instrument $right_instrument
 * @property OphCiExamination_IntraocularPressure_Reading $left_reading
 * @property OphCiExamination_IntraocularPressure_Reading $right_reading
 */

class Element_OphCiExamination_IntraocularPressure extends \BaseEventTypeElement
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
		return 'et_ophciexamination_intraocularpressure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('eye_id, left_comments, right_comments', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'right_values' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_IntraocularPressure_Value', 'element_id', 'on' => 'right_values.eye_id = ' . \Eye::RIGHT),
			'left_values' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_IntraocularPressure_Value', 'element_id', 'on' => 'left_values.eye_id = ' . \Eye::LEFT),
		);
	}

	public function afterValidate()
	{
		foreach (array('right', 'left') as $side) {
			if ($this->{"{$side}_values"}) {
				foreach ($this->{"{$side}_values"} as $value) {
					if (!$value->validate()) {
						foreach ($value->getErrors() as $field => $errors) {
							foreach ($errors as $error) {
								$this->addError("{$side}_values.{$field}", $error);
							}
						}
					}
				}
			} else {
				if (!$this->{"{$side}_comments"}) {
					$this->addError("{$side}_comments", "Comments are required when no readings are recorded ($side)");
				}
			}
		}
	}

	public function beforeDelete()
	{
		OphCiExamination_Intraocularpressure_Value::model()->deleteAll("element_id = ?", array($this->id));

		return parent::beforeDelete();
	}

	public function getLetter_reading($side)
	{
		$values = $this->{"{$side}_values"};

		if (!$values) return 'Not recorded';

		$sum = 0;
		foreach ($values as $value) {
			$sum += $value->reading->value;
		}
		return round($sum / count($values)) . ' mmHg';
	}

	public function getLetter_string()
	{
		return "Intra-ocular pressure:\nright: ".$this->getLetter_reading('right')."\nleft: ".$this->getLetter_reading('left')."\n";
	}
}
