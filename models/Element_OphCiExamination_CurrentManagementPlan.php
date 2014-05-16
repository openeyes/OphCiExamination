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
/**
 * This is the model class for table "et_ophciexamination_currentmanagementplan".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $glaucoma_status_id
 * @property integer $drop-related_prob_id
 * @property integer $drops_id
 * @property integer $surgery_id
 * @property integer $other-service
 * @property integer $refraction
 * @property integer $lva
 * @property integer $orthoptics
 * @property integer $cl_clinic
 * @property integer $vf
 * @property integer $us
 * @property integer $biometry
 * @property integer $oct
 * @property integer $hrt
 * @property integer $disc_photos
 * @property integer $edt
 *
 * The followings are the available model relations:
 *
 * @property ElementType $element_type
 * @property EventType $eventType
 * @property Event $event
 * @property User $user
 * @property User $usermodified
 * @property Gender $glaucoma_status
 * @property Gender $drop-related_prob
 * @property Gender $drops
 * @property Gender $surgery
 */

class Element_OphCiExamination_CurrentManagementPlan  extends  \SplitEventTypeElement
{
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
		return 'et_ophciexamination_currentmanagementplan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('event_id, left_glaucoma_status_id, left_drop-related_prob_id, left_drops_id, left_surgery_id,
			left_other-service, left_refraction, left_lva, left_orthoptics, left_cl_clinic, left_vf, left_us,
			left_biometry, left_oct, left_hrt, left_disc_photos, left_edt,
			right_glaucoma_status_id, right_drop-related_prob_id, right_drops_id, right_surgery_id, right_other-service,
			 right_refraction, right_lva, right_orthoptics, right_cl_clinic, right_vf, right_us, right_biometry,
			 right_oct, right_hrt, right_disc_photos, right_edt, eye_id', 'safe'),
			array('left_glaucoma_status_id, left_drop-related_prob_id, left_drops_id, left_surgery_id,
			left_other-service, left_refraction, left_lva, left_orthoptics, left_cl_clinic, left_vf, left_us,
			left_biometry, left_oct, left_hrt, left_disc_photos, left_edt,
			right_glaucoma_status_id, right_drop-related_prob_id, right_drops_id, right_surgery_id, right_other-service,
			 right_refraction, right_lva, right_orthoptics, right_cl_clinic, right_vf, right_us, right_biometry,
			 right_oct, right_hrt, right_disc_photos, right_edt, eye_id ', 'required'),
			array('id, event_id, left_glaucoma_status_id, left_drop-related_prob_id, left_drops_id, left_surgery_id,
			left_other-service, left_refraction, left_lva, left_orthoptics, left_cl_clinic, left_vf, left_us,
			left_biometry, left_oct, left_hrt, left_disc_photos, left_edt,
			right_glaucoma_status_id, right_drop-related_prob_id, right_drops_id, right_surgery_id, right_other-service,
			 right_refraction, right_lva, right_orthoptics, right_cl_clinic, right_vf, right_us, right_biometry,
			 right_oct, right_hrt, right_disc_photos, right_edt, eye_id ', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array
	 * @see parent::sidedFields()
	 */
	public function sidedFields()
	{
		return array( 'glaucoma_status_id', 'drop-related_prob_id', 'drops_id', 'surgery_id', 'other-service',
			'refraction', 'lva', 'orthoptics', 'cl_clinic', 'vf', 'us', 'biometry','oct', 'hrt', 'disc_photos', 'edt');
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'element_type' => array(self::HAS_ONE, 'ElementType', 'id','on' => "element_type.class_name='".get_class($this)."'"),
			'eventType' => array(self::BELONGS_TO, 'EventType', 'event_type_id'),
			'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
			'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'right_glaucoma_status' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_GlaucomaStatus', 'right_glaucoma_status_id'),
			'left_glaucoma_status' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_GlaucomaStatus', 'left_glaucoma_status_id'),
			'right_drop-related_prob' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_DropProb', 'right_drop-related_prob_id'),
			'left_drop-related_prob' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_DropProb', 'left_drop-related_prob_id'),
			'right_drops' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_Drops', 'right_drops_id'),
			'left_drops' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_Drops', 'left_drops_id'),
			'right_surgery' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_Surgery', 'right_surgery_id'),
			'left_surgery' => array(self::BELONGS_TO, 'OEModule\OphCiExamination\models\OphCiExamination_Surgery', 'left_surgery_id'),
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
			'right_glaucoma_status_id' => 'Glaucoma status',
			'left_glaucoma_status_id' => 'Glaucoma status',
			'right_drop-related_prob_id' => 'Drop-related problems',
			'left_drop-related_prob_id' => 'Drop-related problems',
			'right_drops_id' => 'Drops',
			'left_drops_id' => 'Drops',
			'right_surgery_id' => 'Surgery',
			'left_surgery_id' => 'Surgery',
			'right_other-service' => 'Other Service',
			'left_other-service' => 'Other Service',
			'right_refraction' => 'Refraction',
			'left_refraction' => 'Refraction',
			'right_lva' => 'LVA',
			'left_lva' => 'LVA',
			'right_orthoptics' => 'Orthoptics',
			'left_orthoptics' => 'Orthoptics',
			'right_cl_clinic' => 'CL cLinic',
			'left_cl_clinic' => 'CL cLinic',
			'right_vf' => 'VF',
			'left_vf' => 'VF',
			'right_us' => 'US',
			'left_us' => 'US',
			'right_biometry' => 'Biometry',
			'left_biometry' => 'Biometry',
			'right_oct' => 'OCT',
			'left_oct' => 'OCT',
			'right_hrt' => 'HRT',
			'left_hrt' => 'HRT',
			'right_disc_photos' => 'Disc Photos',
			'left_disc_photos' => 'Disc Photos',
			'right_edt' => 'EDT',
			'left_edt' => 'EDT',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('event_id', $this->event_id, true);
		$criteria->compare('right_glaucoma_status_id', $this->right_glaucoma_status_id);
		$criteria->compare('left_glaucoma_status_id', $this->left_glaucoma_status_id);
		$criteria->compare('right_drop-related_prob_id', $this->drop-right_related_prob_id);
		$criteria->compare('left_drop-related_prob_id', $this->left_drop-related_prob_id);
		$criteria->compare('right_drops_id', $this->right_drops_id);
		$criteria->compare('left_drops_id', $this->left_drops_id);
		$criteria->compare('right_surgery_id', $this->right_surgery_id);
		$criteria->compare('left_surgery_id', $this->left_surgery_id);
		$criteria->compare('right_other-service', $this->right_other-service);
		$criteria->compare('left_other-service', $this->left_other-service);
		$criteria->compare('right_refraction', $this->right_refraction);
		$criteria->compare('left_refraction', $this->left_refraction);
		$criteria->compare('right_lva', $this->right_lva);
		$criteria->compare('left_lva', $this->left_lva);
		$criteria->compare('right_orthoptics', $this->right_orthoptics);
		$criteria->compare('left_orthoptics', $this->left_orthoptics);
		$criteria->compare('right_cl_clinic', $this->right_cl_clinic);
		$criteria->compare('left_cl_clinic', $this->left_cl_clinic);
		$criteria->compare('right_vf', $this->right_vf);
		$criteria->compare('left_vf', $this->left_vf);
		$criteria->compare('right_us', $this->right_us);
		$criteria->compare('left_us', $this->left_us);
		$criteria->compare('right_biometry', $this->right_biometry);
		$criteria->compare('left_biometry', $this->left_biometry);
		$criteria->compare('right_oct', $this->right_oct);
		$criteria->compare('left_oct', $this->left_oct);
		$criteria->compare('right_hrt', $this->right_hrt);
		$criteria->compare('left_hrt', $this->left_hrt);
		$criteria->compare('right_disc_photos', $this->right_disc_photos);
		$criteria->compare('left_disc_photos', $this->left_disc_photos);
		$criteria->compare('right_edt', $this->right_edt);
		$criteria->compare('left_edt', $this->left_edt);

		return new CActiveDataProvider(get_class($this), array(
			'criteria' => $criteria,
		));
	}



	protected function afterSave()
	{

		return parent::afterSave();
	}
}
?>