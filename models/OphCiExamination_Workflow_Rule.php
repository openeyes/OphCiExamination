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
 * This is the model class for table "ophciexamination_workflow_rule".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $clause
 * @property string $value
 * @property OphCiExamination_Workflow $workflow
 */

class OphCiExamination_Workflow_Rule extends BaseActiveRecordVersioned
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return OphCiExamination_Workflow_Rule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ophciexamination_workflow_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('subspecialty_id, firm_id, episode_status_id, workflow_id', 'safe'),
			array('id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'workflow' => array(self::BELONGS_TO, 'OphCiExamination_Workflow', 'workflow_id'),
			'parent' => array(self::BELONGS_TO, 'OphCiExamination_Workflow_Rule', 'parent_id'),
			'children' => array(self::HAS_MANY, 'OphCiExamination_Workflow_Rule', 'parent_id'),
			'subspecialty' => array(self::BELONGS_TO, 'Subspecialty', 'subspecialty_id'),
			'firm' => array(self::BELONGS_TO, 'Firm', 'firm_id'),
			'episode_status' => array(self::BELONGS_TO, 'EpisodeStatus', 'episode_status_id'),
		);
	}

	/**
	 * Finds the best matching workflow
	 * @param integer $firm_id
	 * @param integer $status_id
	 * @return OphCiExamination_Workflow
	 */
	public static function findWorkflow($firm_id, $status_id)
	{
		$subspecialty_id = null;

		if ($firm = Firm::model()->findByPk($firm_id)) {
			$subspecialty_id = ($firm->serviceSubspecialtyAssignment) ? $firm->serviceSubspecialtyAssignment->subspecialty_id : null;
		}

		if ($rule = OphCiExamination_Workflow_Rule::model()->find('subspecialty_id=? and firm_id=? and episode_status_id=?',array($subspecialty_id,$firm_id,$status_id))) {
			return $rule->workflow;
		}

		if ($rule = OphCiExamination_Workflow_Rule::model()->find('subspecialty_id=? and episode_status_id=?',array($subspecialty_id,$status_id))) {
			return $rule->workflow;
		}

		if ($rule = OphCiExamination_Workflow_Rule::model()->find('subspecialty_id=?',array($subspecialty_id))) {
			return $rule->workflow;
		}

		if ($rule = OphCiExamination_Workflow_Rule::model()->find('subspecialty_id is null and episode_status_id is null')) {
			return $rule->workflow;
		}

		throw new CException('Cannot find default workflow rule');
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subspecialty_id' => 'Subspecialty',
			'firm_id' => 'Firm',
			'episode_status_id' => 'Episode status',
			'workflow_id' => 'Workflow',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

	public function beforeValidate()
	{
		$whereParams = array();

		if ($this->id) {
			$where = 'id != :id and ';
			$whereParams[':id'] = $this->id;
		} else {
			$where = '';
		}

		if (!$this->subspecialty_id) {
			$where .= ' subspecialty_id is null and ';
		} else {
			$where .= ' subspecialty_id = :subspecialty_id and ';
			$whereParams[':subspecialty_id'] = $this->subspecialty_id;
		}

		if (!$this->episode_status_id) {
			$where .= ' episode_status_id is null';
		} else {
			$where .= ' episode_status_id = :episode_status_id';
			$whereParams[':episode_status_id'] = $this->episode_status_id;
		}

		if (OphCiExamination_Workflow_Rule::model()->find($where,$whereParams)) {
			$this->addError('id','There is already a rule for this subspecialty and episode status combination');
		}

		return parent::beforeValidate();
	}
}