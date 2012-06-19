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
 * This is the model class for table "ophciexamination_element_set_rule".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $clause
 * @property string $value
 * @property OphCiExamination_ElementSet $set

 */
class OphCiExamination_ElementSetRule extends BaseActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return OphCiExamination_ElementSetRule the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'ophciexamination_element_set_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
				array('id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
				'set' => array(self::BELONGS_TO, 'OphCiExamination_ElementSet', 'set_id'),
				'children' => array(self::HAS_MANY, 'OphCiExamination_ElementSetRule', 'parent_id'),
		);
	}

	/**
	 * Finds the best matching element set
	 *
	 * @param integer $site_id
	 * @param integer $subspecialty_id
	 * @param integer $status_id
	 * @return OphCiExamination_ElementSet
	 */
	public static function findSet($site_id, $subspecialty_id, $status_id) {
		$rule = self::model()->find('parent_id IS NULL');
		return $rule->processClause($site_id, $subspecialty_id, $status_id);
	}

	protected function findChild($value) {
		return $this->find('parent_id = :id AND value = :value', array(':id' => $this->id, ':value' => $value));
	}

	protected function processClause($site_id, $subspecialty_id, $status_id) {

		// Check to see if the current rule has a clause
		if($this->clause) {
			
			// Evaluate the rule clause
			// FIXME: This probably needs locking so that only a limited set of clauses are allowed
			$value = eval('return '.$this->clause.';');

			// and find the next rule that matches the result
			if($rule = $this->findChild($value)) {
				
				// Process next rule
				return $rule->processClause($site_id, $subspecialty_id, $status_id);
				
			} else {
				
				// No matching rule, so we return the current rule's element set
				return $this->set;
				
			}
		} else {
			
			// No clause, so we return the current rule's element set
			return $this->set;
			
		}

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

}