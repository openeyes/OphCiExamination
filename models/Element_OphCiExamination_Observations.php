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
 * This is the model class for table "et_ophciexamination_observations".
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

class Element_OphCiExamination_Observations extends BaseEventTypeElement {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_Observations
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'et_ophciexamination_observations';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, pulse_bpm, pulse_radial_id,pulse_pedial_id,pressure_systolic,pressure_diastolic,respiratory_rate,saturation,temperature,jvp_raised,jvp_cm', 'safe'),
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
			'radial' => array(self::BELONGS_TO, 'OphCiExamination_Observations_Pulse', 'pulse_radial_id'),
			'pedial' => array(self::BELONGS_TO, 'OphCiExamination_Observations_Pulse', 'pulse_pedial_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'pulse_bpm' => 'Pulse (BPM)',
				'pulse_radial_id' => 'Radial',
				'pulse_pedial_id' => 'Pedial',
				'pressure_systolic' => 'Systolic pressure',
				'pressure_diastolic' => 'Diastolic pressure',
				'respiratory_rate' => 'Respiratory rate',
				'saturation' => 'Saturation',
				'temperature' => 'Temperature',
				'jvp_raised' => 'JVP raised',
				'jvp_cm' => 'JVP cm',
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

	public function getFormOptions($table) {
		if ($table == 'ophciexamination_observations_pulse') {
			return CHtml::listData(OphCiExamination_Observations_Pulse::model()->findAll(array('order'=>'display_order')),'id','name');
		}
	}
}
