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
 * This is the model class for table "et_ophciexamination_oct".
 *
 * The followings are the available columns in table:
 * @property integer $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property string $left_crt
 * @property string $right_crt
 * @property string $left_sft
 * @property string $right_sft
 *
 */

class Element_OphCiExamination_OCT extends SplitEventTypeElement {

	/**
	 * Returns the static model of the specified AR class.
	 * @return Element_OphCiExamination_AnteriorSegment_CCT
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'et_ophciexamination_oct';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('eye_id, event_id, left_method_id, left_crt, left_sft, right_method_id, right_crt, right_sft', 'safe'),
				array('left_method_id, left_crt, left_sft', 'requiredIfSide', 'side' => 'left'),
				array('right_method_id, right_crt, right_sft', 'requiredIfSide', 'side' => 'right'),
				array('left_crt', 'numerical', 'integerOnly' => true, 'max' => 600, 'min' => 250, 
						'tooBig' => 'Left {attribute} must be between 250 and 600', 
						'tooSmall' => 'Left {attribute} must be between 250 and 600'),
				array('right_crt', 'numerical', 'integerOnly' => true, 'max' => 600, 'min' => 250, 
						'tooBig' => 'Right {attribute} must be between 250 and 600',
						'tooSmall' => 'Right {attribute} must be between 250 and 600'),
				array('left_sft', 'numerical', 'integerOnly' => true, 'max' => 400, 'min' => 50, 
						'tooBig' => 'Left {attribute} must be between 50 and 400',
						'tooSmall' => 'Left {attribute} must be between 50 and 400'),
				array('right_sft', 'numerical', 'integerOnly' => true, 'max' => 400, 'min' => 50, 
					'tooBig' => 'Left {attribute} must be between 50 and 400',
					'tooSmall' => 'Left {attribute} must be between 50 and 400'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, left_method_id, left_crt, left_sft, right_method_id, right_crt, right_sft', 'safe', 'on' => 'search'),
		);
	}

	public function sidedFields() {
		return array('method_id', 'crt', 'sft');
	}
	
	public function sidedDefaults() {
		return array();
	}
	/**
	 * @return array relational rules.
	 */
	public function relations() {
		return array(
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'left_method' => array(self::BELONGS_TO, 'OphCiExamination_OCT_Method', 'left_method_id'),
				'right_method' => array(self::BELONGS_TO, 'OphCiExamination_OCT_Method', 'right_method_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'left_method_id' => 'Image Type',
				'right_method_id' => 'Image Type',
				'left_crt' => 'Maximum CRT',
				'right_crt' => 'Maximum CRT',
				'left_sft' => 'Central SFT',
				'right_sft' => 'Central SFT',
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
		$criteria->compare('left_method_id', $this->left_method_id);
		$criteria->compare('right_method_id', $this->right_method_id);
		$criteria->compare('left_crt', $this->left_crt);
		$criteria->compare('right_crt', $this->right_crt);
		$criteria->compare('left_sft', $this->left_sft);
		$criteria->compare('right_sft', $this->right_sft);
		
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	protected function beforeSave() {
		return parent::beforeSave();
	}

	protected function afterSave() {
		return parent::afterSave();
	}

	protected function beforeValidate() {
		return parent::beforeValidate();
	}

}
