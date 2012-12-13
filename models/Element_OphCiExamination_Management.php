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
 * This is the model class for table "et_ophciexamination_management".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $laser_id
 * @property string $laserdeferral_reason_id
 * @property string $laserdeferral_reason_other
 * @property string $comments
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Management extends BaseEventTypeElement {
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
		return 'et_ophciexamination_management';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, laser_id, laserdeferral_reason_id, laserdeferral_reason_other, comments', 'safe'),
				array('laser_id', 'required'),
				array('laser_id', 'laserDependencyValidation'),
				array('laserdeferral_reason_id', 'laserDeferralReasonDependencyValidation'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, laser_id, laserdeferral_reason_id, laserdeferral_reason_other, comments', 'safe', 'on' => 'search'),
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
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'laser' => array(self::BELONGS_TO, 'OphCiExamination_Management_Laser', 'laser_id'),
				'laserdeferral_reason' => array(self::BELONGS_TO, 'OphCiExamination_Management_LaserDeferral', 'laserdeferral_reason_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'laser_id' => "Laser",
				'laserdeferral_reason_id' => 'Deferral reason',
				'laserdeferral_reason_other' => 'Deferral reason',
				'comments' => 'Comments',
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

		$criteria->compare('laser_id', $this->laser_id);
		$criteria->compare('laserdeferral_reason_id', $this->laser_deferral_reason_id);
		$criteria->compare('laserdeferral_reason_other', $this->laserdeferral_reason_other);
		
		$criteria->compare('comments', $this->comments);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}
	
	/*
	 * deferral reason is only required for laser status that are flagged deferred
	 */
	public function laserDependencyValidation($attribute) {
		if ($this->laser->deferred) {
			$v = CValidator::createValidator('required', $this, array('laserdeferral_reason_id'));
			$v->validate($this);
		}
	}
	
	/*
	 * only need a text "other" reason for reasons that are flagged "other"
	 */	
	public function laserDeferralReasonDependencyValidation($attribute) {
		if ($this->laserdeferral_reason && $this->laserdeferral_reason->other) {
			$v = CValidator::createValidator('required', $this, array('laserdeferral_reason_other'), array('message' => '{attribute} required when deferral reason is ' . $this->laserdeferral_reason));
			$v->validate($this);
		}
	}
	
	public function getLaserDeferralReason() {
		if ($this->laserdeferral_reason) {
			if ($this->laserdeferral_reason->other) {
				return $this->laserdeferral_reason_other;
			}
			else {
				return $this->laserdeferral_reason->name;
			}
		}
		else {
			// shouldn't get to this point really
			return "N/A";
		}
	}

	/**
	 * Returns the laser management plan section  for use in correspondance
	 * 
	 * @return string
	 */
	public function getLetter_lmp() {
		$text = array();
		
		if ($this->laser) {
			$text[] = $this->laser;
		}

		return implode(', ',$text)."\n";
	}
}
