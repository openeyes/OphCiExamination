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
 * This is the model class for table "et_ophciexamination_bleb_assessment".
 *
 * NOTE that this element provides the facility to set a patient secondary diagnosis for the diabetic type. To enable
 * support for deleting it, we record the id of the SecondaryDiagnosis it creates, as well as the type. A foreign key
 * constraint is not enforced to allow the SecondaryDiagnosis to be deleted as normal through the Patient view.
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property integer $secondarydiagnosis_id
 * @property integer $secondarydiagnosis_disorder_id
 * @property string $left_nscretinopathy_id
 * @property string $left_nscmaculopathy_id
 * @property string $right_nscretionopathy_id
 * @property string $right_nscmaculopathy_id
 * @property boolean $left_nscretinopathy_photocoagulation
 * @property boolean $left_nscmaculopathy_photocoagulation
 * @property boolean $right_nscretinopathy_photocoagulation
 * @property boolean $right_nscmaculopathy_photocoagulation
 * @property integer $left_clinicalret_id
 * @property integer $right_clinicalret_id
 * @property integer $left_clinicalmac_id
 * @property integer $right_clinicalmac_id
 * The followings are the available model relations:
 * @property OphCiExamination_NSCRetinopathy $left_nscretinopathy
 * @property OphCiExamination_NSCRetinopathy $right_nscretinopathy
 * @property OphCiExamination_NSCMaculopathy $left_nscmaculopathy
 * @property OphCiExamination_NSCMaculopathy $right_nscmaculopathy
 * @property OphCiExamination_ClinicalRetinopathy $left_clinicalret
 * @property OphCiExamination_ClinicalRetinopathy $right_clinicalret
 * @property OphCiExamination_ClinicalMaculopathy $left_clinicalmac
 * @property OphCiExamination_ClinicalMaculopathy $right_clinicalretmac
 *
 */

class Element_OphCiExamination_BlebAssessment extends SplitEventTypeElement
{
	public $service;
	public $secondarydiagnosis_disorder_required = false;

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
		return 'et_ophciexamination_bleb_assessment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		/*
		 * 'event_id' => 'int(10) unsigned NOT NULL',
			'eye_id' => "int(10) unsigned NOT NULL DEFAULT '3'",
			'left_central_area_id' => 'int(10) unsigned DEFAULT NULL',
			'left_max_area_id' => 'int(10) unsigned DEFAULT NULL',
			'left_height_id' => 'int(10) unsigned DEFAULT NULL',
			'left_vasc_id' => 'int(10) unsigned DEFAULT NULL',
			'right_central_area_id' => 'int(10) unsigned DEFAULT NULL',
			'right_max_area_id' => 'int(10) unsigned DEFAULT NULL',
			'right_height_id' => 'int(10) unsigned DEFAULT NULL',
			'right_vasc_id' => 'int(10) unsigned DEFAULT NULL',
		 */
		return array(
				array('event_id, eye_id, left_central_area_id, left_max_area_id, left_height_id, left_vasc_id,
					right_central_area_id, right_max_area_id, right_height_id, right_vasc_id', 'safe'),
				array('secondarydiagnosis_disorder_id', 'flagRequired', 'flag' => 'secondarydiagnosis_disorder_required'),
				array('left_central_area_id, left_max_area_id, left_height_id, left_vasc_id', 'requiredIfSide', 'side' => 'left'),
				array('right_central_area_id, right_max_area_id, right_height_id, right_vasc_id', 'requiredIfSide', 'side' => 'right'),
				// The following rule is used by search().
				array('event_id, eye_id, left_central_area_id, left_max_area_id, left_height_id, left_vasc_id,
					right_central_area_id, right_max_area_id, right_height_id, right_vasc_id', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array
	 * (non-phpdoc)
	 * @see parent::sidedFields()
	 */
	public function sidedFields()
	{
		return array( 'central_area_id', 'max_area_id', 'height_id', 'vasc_id');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
				'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'left_central_area' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_CentralArea', 'left_central_area_id'),
				'left_max_area' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_MaxArea', 'left_max_area_id'),
				'left_height' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_Height', 'left_height_id'),
				'left_vasc' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_Vascularity', 'left_vasc_id'),
				'right_central_area' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_CentralArea', 'right_central_area_id'),
				'right_max_area' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_MaxArea', 'right_max_area_id'),
				'right_height' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_Height', 'right_height_id'),
				'right_vasc' => array(self::BELONGS_TO, 'OphCiExamination_BlebAssessment_Vascularity', 'right_vasc_id'),
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
				'left_central_area_id' => 'Central Area',
				'left_max_area_id' => 'Max Area',
				'right_central_area_id' => 'Central Area',
				'right_max_area_id' => 'Max Area',
				'left_height_id' => 'Height',
				'left_vasc_id' => 'Vascularity',
				'right_height_id' => 'Height',
				'right_vasc_id' => 'Vascularity',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);

		$criteria->compare('left_central_area_id', $this->left_central_area_id);
		$criteria->compare('left_max_area_id', $this->left_max_area_id);
		$criteria->compare('left_height_id', $this->left_height_id);
		$criteria->compare('left_vasc_id', $this->left_vasc_id);
		$criteria->compare('right_central_area_id', $this->right_central_area_id);
		$criteria->compare('right_max_area_id', $this->right_max_area_id);
		$criteria->compare('right_height_id', $this->right_height_id);
		$criteria->compare('right_vasc_id', $this->right_vasc_id);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}


	/**
	 * if a secondary diagnosis disorder id has been set, we need to ensure its created on the patient
	 *
	 * @see parent::beforeSave()

	public function beforeSave()
	{
		$curr_sd = $this->_getSecondaryDiagnosis();

		if ($this->secondarydiagnosis_disorder_id
			&& $curr_sd
			&& $curr_sd->disorder_id != $this->secondarydiagnosis_disorder_id) {
			// looks like this is an edit and the previous secondary diagnosis should be removed
			// so we can set the correct value
			$curr_disorder = $curr_sd->disorder;
			$curr_sd->delete();
			$curr_sd = null;
			Yii::app()->user->setFlash('warning.alert', "Disorder '" . $curr_disorder->term . "' has been removed because DR Grading diagnosis was updated.");
		}

		if (!$curr_sd) {
			// need to determine if we are setting a specific disorder on the patient, or a generic diabetes
			// diagnosis (which is implied by recording DR)
			$patient = $this->event->episode->patient;
			$sd = null;

			if ($this->secondarydiagnosis_disorder_id) {
				// no secondary diagnosis has been set by this element yet but one has been
				// assigned (i.e. the element is being created with a diabetes type)

				// final check to ensure nothing has changed whilst processing
				if ( !$patient->hasDisorderTypeByIds(array_merge(Disorder::$SNOMED_DIABETES_TYPE_I_SET, Disorder::$SNOMED_DIABETES_TYPE_II_SET) ) ) {
					$sd = new SecondaryDiagnosis();
					$sd->patient_id = $patient->id;
					$sd->disorder_id = $this->secondarydiagnosis_disorder_id;
				}
				else {
					// clear out the secondarydiagnosis_disorder_id
					$this->secondarydiagnosis_disorder_id = null;
					// reset required flag as patient now has a diabetes type
					$this->secondarydiagnosis_disorder_required = false;
				}
			}
			elseif (!$patient->hasDisorderTypeByIds(Disorder::$SNOMED_DIABETES_SET)) {
				// Set the patient to have diabetes
				$sd = new SecondaryDiagnosis();
				$sd->patient_id = $patient->id;
				$sd->disorder_id = Disorder::SNOMED_DIABETES;
			}

			if ($sd !== null) {
				$sd->save();
				Audit::add("SecondaryDiagnosis",'add',$sd->id,null,array('patient_id' => $patient->id));
				$this->secondarydiagnosis_id = $sd->id;
				Yii::app()->user->setFlash('info.info', "Disorder '" . $sd->disorder->term . "' has been added to patient by DR Grading.");
			}
		}
		return parent::beforeSave();
	}
	 */



	public function canCopy()
	{
		return true;
	}
}
