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
 * This is the model class for table "et_ophciexamination_cataractmanagement".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_CataractManagement extends BaseEventTypeElement {
	public $service;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_CataractManagement the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'et_ophciexamination_cataractmanagement';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, city_road, satellite, fast_track, target_postop_refraction, correction_discussed, suitable_for_surgeon_id, supervised, previous_refractive_surgery, vitrectomised_eye', 'safe'),
				array('city_road, satellite, fast_track, target_postop_refraction, correction_discussed, suitable_for_surgeon_id, supervised, previous_refractive_surgery', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, city_road, satellite, fast_track, target_postop_refraction, correction_discussed, suitable_for_surgeon_id, supervised, previous_refractive_surgery', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'suitable_for_surgeon' => array(self::BELONGS_TO, 'OphCiExamination_SuitableForSurgeon', 'suitable_for_surgeon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'city_road' => 'At City Road',
				'satellite' => 'At Satellite',
				'fast_track' => 'Straightforward case',
				'target_postop_refraction' => 'Post operative refractive target in dioptres',
				'correction_discussed' => 'The post operative refractive target has been discussed with the patient',
				'suitable_for_surgeon_id' => 'Suitable for surgeon',
				'supervised' => 'Supervised',
				'previous_refractive_surgery' => 'Previous refractive surgery',
				'vitrectomised_eye' => 'Vitrectomised eye',
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

		$criteria->compare('description', $this->description);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function getLetter_string() {
		$text = array();

		if ($this->city_road) {
			$text[]= "at City Road";
		}
		if ($this->satellite) {
			$text[] = "at satellite";
		}
		if ($this->fast_track) {
			$text[] = "straightforward case";
		}
		$text[] = "target post-op refraction: ".$this->target_postop_refraction;

		if ($this->correction_discussed) {
			$text[] = "refractive correction discussed with patient";
		}

		$text[] = "suitable for ".$this->suitable_for_surgeon->name.' ('.($this->supervised ? 'supervised' : 'unsupervised').')';

		if ($this->comments) {
			// FIXME: Comments moved to parent
			$text[] = strtolower($this->comments);
		}

		return "Management: ".implode(', ',$text)."\n";
	}
}
