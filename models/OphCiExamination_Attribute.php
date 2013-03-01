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
 * This is the model class for table "ophciexamination_attribute".
 *
 * @property integer $id
 * @property string $name
 * @property string $label
 * @property OphCiExamination_AttributeOption[] $options
 * @property integer $element_type_id

 */
class OphCiExamination_Attribute extends BaseActiveRecord {

	/**
	 * Returns the static model of the specified AR class.
	 * @return OphCiExamination_Attribute the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'ophciexamination_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		return array(
				array('name', 'required'),
				array('id, name', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
				'options' => array(self::HAS_MANY, 'OphCiExamination_AttributeOption', 'attribute_id'),
		);
	}

	/**
	 *
	 * @param integer $subspecialty_id
	 */
	public function findAllOptionsForSubspecialty($subspecialty_id = null) {
		$condition = 'attribute_id = :attribute_id AND ';
		$params = array(':attribute_id' => $this->id);
		if($subspecialty_id) {
			$condition .=  '(subspecialty_id = :subspecialty_id OR subspecialty_id IS NULL)';
			$params[':subspecialty_id'] = $subspecialty_id;
		} else {
			$condition .=  'subspecialty_id IS NULL';
		}
		return OphCiExamination_AttributeOption::model()->findAll($condition, $params);
	}
	
	/**
	 * 
	 * @param BaseEventTypeElement $element
	 */
	public function findAllByElement($element) {
		$element_type = $element->getElementType();
		return $this->findAll('element_type_id = :element_type_id', array(':element_type_id' => $element_type->id));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		return new CActiveDataProvider(get_class($this), array(
				'criteria'=>$criteria,
		));
	}

}
