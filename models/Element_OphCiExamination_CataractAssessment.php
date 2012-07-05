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
 * This is the model class for table "et_ophciexamination_cataractassessment".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $left_eyedraw
 * @property string $left_pupil
 * @property string $left_nuclear
 * @property string $left_cortical
 * @property boolean $left_pxe
 * @property boolean $left_phako
 * @property string $left_description
 * @property string $right_eyedraw
 * @property string $right_pupil
 * @property string $right_nuclear
 * @property string $right_cortical
 * @property boolean $right_pxe
 * @property boolean $right_phako
 * @property string $right_description
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_CataractAssessment extends BaseEventTypeElement {
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
		return 'et_ophciexamination_cataractassessment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id', 'safe'),
				array('left_eyedraw, left_pupil, left_nuclear, left_cortical, left_pxe, left_phako, left_description,
						right_eyedraw, right_pupil, right_nuclear, right_cortical, right_pxe, right_phako, right_description', 'required'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, left_eyedraw, left_pupil, left_nuclear, left_cortical, left_pxe, left_phako, left_description,
						right_eyedraw, right_pupil, right_nuclear, right_cortical, right_pxe, right_phako, right_description', 'safe', 'on' => 'search'),
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
				'left_eyedraw' => 'Eyedraw',
				'left_pupil' => 'Pupil Size',
				'left_nuclear' => 'Nuclear',
				'left_cortical' => 'Cortical',
				'left_pxe' => 'PXE',
				'left_phako' => 'Phakodonesis',
				'left_description' => 'Description',
				'right_eyedraw' => 'Eyedraw',
				'right_pupil' => 'Pupil Size',
				'right_nuclear' => 'Nuclear',
				'right_cortical' => 'Cortical',
				'right_pxe' => 'PXE',
				'right_phako' => 'Phakodonesis',
				'right_description' => 'Description',
		);
	}

	public function getPupilValues() {
		return array(
				'Large' => 'Large',
				'Medium' => 'Medium',
				'Small' => 'Small',
		);
	}

	public function getNuclearValues() {
		return array(
				'None' => 'None',
				'Mild' => 'Mild',
				'Moderate' => 'Moderate',
				'Brunescent' => 'Brunescent',
		);
	}

	public function getCorticalValues() {
		return array(
				'None' => 'None',
				'Mild' => 'Mild',
				'Moderate' => 'Moderate',
				'White' => 'White',
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

		$criteria->compare('left_eyedraw', $this->left_eyedraw);
		$criteria->compare('left_pupil', $this->left_pupil);
		$criteria->compare('left_nuclear', $this->left_nuclear);
		$criteria->compare('left_cortical', $this->left_cortical);
		$criteria->compare('left_pxe', $this->left_pxe);
		$criteria->compare('left_phako', $this->left_phako);
		$criteria->compare('left_description', $this->left_description);
		$criteria->compare('right_eyedraw', $this->right_eyedraw);
		$criteria->compare('right_pupil', $this->right_pupil);
		$criteria->compare('right_nuclear', $this->right_nuclear);
		$criteria->compare('right_cortical', $this->right_cortical);
		$criteria->compare('right_pxe', $this->right_pxe);
		$criteria->compare('right_phako', $this->right_phako);
		$criteria->compare('right_description', $this->right_description);

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
