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
				array('further_findings', 'safe'),
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
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'further_findings' => array(self::MANY_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings', 'ophciexamination_further_findings_assignment(element_id, further_finding_id)', 'order' => 'display_order, name'),
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

	public function getFurtherFindingsAssignedString()
	{
		$further_findings = array();

		if (count($this->further_findings) > 0 ) {
			foreach ($this->further_findings as $ff) {
				$further_findings[] = $ff->name;
			}
			$further_findings = implode(', ', $further_findings);
		}
		else{
			return '';
		}

		return $further_findings;
	}
}
