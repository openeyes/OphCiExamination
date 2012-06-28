<?php /**
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
 * This is the model class for table "et_ophciexamination_visualacuity".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $left_initial_id
 * @property integer $left_wearing_id
 * @property integer $left_corrected_id
 * @property integer $left_method
 * @property string $left_comments
 * @property integer $right_initial_id
 * @property integer $right_wearing_id
 * @property integer $right_corrected_id
 * @property integer $right_method
 * @property string $right_comments
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_VisualAcuity extends BaseEventTypeElement {
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
		return 'et_ophciexamination_visualacuity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, left_comments, right_comments', 'safe'),
				array('left_initial_id, left_wearing_id, left_corrected_id, left_method,
						right_initial_id, right_wearing_id, right_corrected_id, right_method', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, comments, ', 'safe', 'on' => 'search'),
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
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'left_initial_id' => 'Left Initial',
				'left_wearing_id' => 'Left Wearing',
				'left_corrected_id' => 'Left Corrected',
				'left_method' => 'Left Method',
				'left_comments' => 'Left Comments',
				'right_initial_id' => 'Right Initial',
				'right_wearing_id' => 'Right Wearing',
				'right_corrected_id' => 'Right Corrected',
				'right_method' => 'Right Method',
				'right_comments' => 'Right Comments',
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

		$criteria->compare('left_initial_id', $this->left_initial_id);
		$criteria->compare('left_wearing_id', $this->left_wearing_id);
		$criteria->compare('left_corrected_id', $this->left_corrected_id);
		$criteria->compare('left_method', $this->left_method);
		$criteria->compare('left_comments', $this->left_comments);
		$criteria->compare('right_initial_id', $this->right_initial_id);
		$criteria->compare('right_wearing_id', $this->right_wearing_id);
		$criteria->compare('right_corrected_id', $this->right_corrected_id);
		$criteria->compare('right_method', $this->right_method);
		$criteria->compare('right_comments', $this->right_comments);
						
		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions() {
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
