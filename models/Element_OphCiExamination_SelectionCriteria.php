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
 * This is the model class for table "et_ophciexamination_selectioncriteria".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $description
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_SelectionCriteria extends \BaseEventTypeElement
{
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
		return 'et_ophciexamination_selectioncriteria';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('blindness_id, age_id, vip, prognosis_id, suitable_teaching_case, request_special_consideration, comments', 'safe'),
				array('blindness_id, age_id, vip, prognosis_id, suitable_teaching_case', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, description, ', 'safe', 'on' => 'search'),
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
			'blindness' => array(self::BELONGS_TO, '\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Blindness', 'blindness_id'),
			'age' => array(self::BELONGS_TO, '\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Age', 'age_id'),
			'prognosis' => array(self::BELONGS_TO, '\OEModule\OphCiExamination\models\OphCiExamination_SelectionCriteria_Prognosis', 'prognosis_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'blindness_id' => 'Blindness',
			'age_id' => 'Age',
			'vip' => 'VIP',
			'prognosis_id' => 'Surgical prognosis',
			'suitable_teaching_case' => 'Suitable teaching case',
			'request_special_consideration' => 'Request special consideration',
			'comments' => 'Comments',
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

		$criteria->compare('description', $this->description);

		return new \CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function canCopy()
	{
		return false;
	}

	public function getPriority()
	{
		if (
			($this->blindness && $this->blindness->name == 'Unilateral') ||
			($this->age && $this->age->name == 'Old') ||
			($this->vip == 1) ||
			($this->prognosis && $this->prognosis->name == 'Poor') ||
			($this->suitable_teaching_case !== null && $this->suitable_teaching_case == 0)) {
			return 'Low';
		}

		return 'High';
	}
}
