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
 * This is the model class for table "et_ophciexamination_surgeryman". It's worth noting that this Element was originally
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

class Element_OphCiExamination_SurgeryManagement extends \BaseEventTypeElement
{
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
		return 'et_ophciexamination_surgeryman';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('biome_needed, lenses_needed, interop_laser_needed, procedures', 'safe'),
				array('biome_needed, lenses_needed, interop_laser_needed, procedures', 'required'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'procedure_assignments' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_SurgeryManagement_Procedure', 'element_id'),
			'procedures' => array(self::HAS_MANY, 'Procedure', 'procedure_id', 'through' => 'procedure_assignments'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'biome_needed' => 'Biome needed?',
			'lenses_needed' => 'Lenses needed?',
			'interop_laser_needed' => 'Interop laser needed?',
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

	public function afterValidate()
	{
		foreach ($this->procedure_assignments as $assignment) {
			if (!$assignment->validate()) {
				foreach ($assignment->errors as $field => $errors) {
					foreach ($errors as $error) {
						$this->addError($field,$error);
					}
				}
			}
		}

		return parent::afterValidate();
	}
}
