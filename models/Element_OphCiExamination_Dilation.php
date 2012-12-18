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
 * This is the model class for table "et_ophciexamination_diagnoses".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Dilation extends SplitEventTypeElement {
	public $time_right;
	public $time_left;

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
		return 'et_ophciexamination_dilation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('event_id, eye_id', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id', 'safe', 'on' => 'search'),
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
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'left' => array(self::HAS_ONE, 'OphCiExamination_Dilation_Side', 'element_id', 'on' => "eye_id = 1"),
			'right' => array(self::HAS_ONE, 'OphCiExamination_Dilation_Side', 'element_id', 'on' => "eye_id = 2"),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'eye_id' => 'Eye',
				'disorder_id' => 'Disorder',
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
		$criteria->compare('time', $this->time);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	public function afterFind() {
		$this->time_right = $this->right ? $this->right->getTime() : date('H:i');
		$this->time_left = $this->left ? $this->left->getTime() : date('H:i');
	}

	public function setDefaultOptions() {
		if (Yii::app()->getController()->getAction()->id == 'create' || Yii::app()->getController()->getAction()->id == 'ElementForm') {
			if (empty($_POST)) {
				$this->time_right = $this->time_left = date('H:i');
			}
		}
	}

	public function getDilationDrugs($side) {
		if (empty($_POST)) {
			return $this->{'dilationDrugs'.ucfirst($side)};
		}

		if (!empty($_POST['DilationDrugs'.ucfirst($side)])) {
			$drugs = array();

			foreach ($_POST['DilationDrugs'.ucfirst($side)] as $drug_id) {
				$drug = new OphCiExamination_Dilation_Drug;
				$drug->side_id = ($side == 'left' ? 1 : 2);
				$drug->drug_id = $drug_id;
				$drug->drops = $_POST['DilationDrugDrops'.ucfirst($side).$drug_id];

				$drugs[] = $drug;
			}

			return $drugs;
		}

		return false;
	}

	public function getDilationDrugsLeft() {
		return $this->left ? $this->left->drugs : false;
	}

	public function getDilationDrugsRight() {
		return $this->right ? $this->right->drugs : false;
	}

	public function getUnselectedDilationDrugs($side) {
		$criteria = new CDbCriteria;

		if (!empty($_POST['DilationDrugs'.ucfirst($side)])) {
			$criteria->addNotInCondition('id',$_POST['DilationDrugs'.ucfirst($side)]);
		}

		$criteria->order = 'display_order asc';

		return CHtml::listData(OphCiExamination_Dilation_Drugs::model()->findAll($criteria),'id','name');
	}

	public function afterValidate() {
		if (!empty($_POST['DilationDrugsRight']) && !preg_match('/^[0-9]+:[0-9]+$/',$_POST['Element_OphCiExamination_Dilation']['time_right'])) {
			$this->addError('time_right','Please enter a valid time in the format hh:mm');
		}
		if (!empty($_POST['DilationDrugsLeft']) && !preg_match('/^[0-9]+:[0-9]+$/',$_POST['Element_OphCiExamination_Dilation']['time_left'])) {
			$this->addError('time_left','Please enter a valid time in the format hh:mm');
		}
	}

	public function beforeSave() {
		if (!empty($_POST['DilationDrugsRight']) && !empty($_POST['DilationDrugsLeft'])) {
			$this->eye_id = 3;
		} else if (!empty($_POST['DilationDrugsRight'])) {
			$this->eye_id = 2;
		} else if (!empty($_POST['DilationDrugsLeft'])) {
			$this->eye_id = 1;
		}

		return parent::beforeSave();
	}

	public function afterSave() {
		foreach (array('left'=>1,'right'=>2) as $side => $eye_id) {
			if (!empty($_POST['DilationDrugs'.ucfirst($side)])) {
				if (!$dilation_side = OphCiExamination_Dilation_Side::model()->find('element_id=? and eye_id=?',array($this->id,$eye_id))) {
					$dilation_side = new OphCiExamination_Dilation_Side;
					$dilation_side->element_id = $this->id;
					$dilation_side->eye_id = $eye_id;
				}
				$dilation_side->time = $_POST['Element_OphCiExamination_Dilation']['time_'.$side];
				if (!$dilation_side->save()) {
					throw new Exception('Unable to save '.$side.' side: '.print_r($dilation_side->getErrors(),true));
				}

				foreach ($_POST['DilationDrugs'.ucfirst($side)] as $drug_id) {
					if (!$drug = OphCiExamination_Dilation_Drug::model()->find('side_id=? and drug_id=?',array($dilation_side->id,$drug_id))) {
						$drug = new OphCiExamination_Dilation_Drug;
						$drug->side_id = $dilation_side->eye_id;
						$drug->drug_id = $drug_id;
					}
					$drug->drops = $_POST['DilationDrugDrops'.ucfirst($side).$drug_id];
					if (!$drug->save()) {
						throw new Exception('Unable to save drug: '.print_r($drug->getErrors(),true));
					}
				}

				foreach ($dilation_side->drugs as $drug) {
					if (!in_array($drug->drug_id, $_POST['DilationDrugs'.ucfirst($side)])) {
						if (!$drug->delete()) {
							throw new Exception('Unable to delete drug: '.print_r($drug->getErrors(),true));
						}
					}
				}
			}
		}

		return parent::afterSave();
	}
}
