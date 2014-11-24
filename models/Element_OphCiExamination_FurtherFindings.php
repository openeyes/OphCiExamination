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
	public function tableName()
	{
		return 'et_ophciexamination_further_findings';
	}

	public function rules()
	{
		return array(
				array('further_findings_assignment', 'safe'),
				array('further_findings_assignment', 'required'),
		);
	}

	public function relations()
	{
		return array(
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'further_findings_assignment' => array(self::HAS_MANY, 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings_Assignment', 'element_id'),
			'further_findings' => array(self::HAS_MANY, 'Finding', 'finding_id', 'through' => 'further_findings_assignment'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'event_id' => 'Event',
			'further_findings' => 'Findings',
		);
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
				$further_findings[] = $ff->finding_id;
			}
		}

		return $further_findings;
	}

	public function getFurtherFindingsAssignedString()
	{
		$further_findings = array();

		if (!empty($this->further_findings_assignment)) {
			foreach ($this->further_findings_assignment as $assignment) {
				$further_findings[] = $assignment->finding->requires_description ? $assignment->finding->name.": ".$assignment->description : $assignment->finding->name;
			}
			return implode(', ', $further_findings);
		}

		return '';
	}

	public function afterValidate()
	{
		foreach ($this->further_findings_assignment as $assignment) {
			if (!$assignment->validate()) {
				foreach ($assignment->errors as $field => $errors) {
					$this->addError($field,$errors[0]);
				}
			}
		}

		return parent::afterValidate();
	}
}
