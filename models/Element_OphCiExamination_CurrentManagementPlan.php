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
 * @property integer $iop
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

class Element_OphCiExamination_CurrentManagementPlan  extends  \BaseEventTypeElement
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
			array('event_id, iop, glaucoma_status_id, drop-related_prob_id, drops_id, surgery_id, other-service, refraction, lva, orthoptics, cl_clinic, vf, us, biometry, oct, hrt, disc_photos, edt, ', 'safe'),
			array('iop, glaucoma_status_id, drop-related_prob_id, drops_id, surgery_id, other-service, refraction, lva, orthoptics, cl_clinic, vf, us, biometry, oct, hrt, disc_photos, edt, ', 'required'),
			array('id, event_id, iop, glaucoma_status_id, drop-related_prob_id, drops_id, surgery_id, other-service, refraction, lva, orthoptics, cl_clinic, vf, us, biometry, oct, hrt, disc_photos, edt, ', 'safe', 'on' => 'search'),
			array('iop', 'numerical', 'integerOnly' => true, 'min' => 6, 'max' => 60, 'message' => 'IOP must be between 6 - 60'),
		);
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
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'glaucoma_status' => array(self::BELONGS_TO, 'Gender', 'glaucoma_status_id'),
			'drop-related_prob' => array(self::BELONGS_TO, 'Gender', 'drop-related_prob_id'),
			'drops' => array(self::BELONGS_TO, 'Gender', 'drops_id'),
			'surgery' => array(self::BELONGS_TO, 'Gender', 'surgery_id'),
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
			'iop' => 'IOP',
			'glaucoma_status_id' => 'Glaucoma status',
			'drop-related_prob_id' => 'Drop-related problems',
			'drops_id' => 'Drops',
			'surgery_id' => 'Surgery',
			'other-service' => 'Other Service',
			'refraction' => 'Refraction',
			'lva' => 'LVA',
			'orthoptics' => 'Orthoptics',
			'cl_clinic' => 'CL cLinic',
			'vf' => 'VF',
			'us' => 'US',
			'biometry' => 'Biometry',
			'oct' => 'OCT',
			'hrt' => 'HRT',
			'disc_photos' => 'Disc Photos',
			'edt' => 'EDT',
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
		$criteria->compare('iop', $this->iop);
		$criteria->compare('glaucoma_status_id', $this->glaucoma_status_id);
		$criteria->compare('drop-related_prob_id', $this->drop-related_prob_id);
		$criteria->compare('drops_id', $this->drops_id);
		$criteria->compare('surgery_id', $this->surgery_id);
		$criteria->compare('other-service', $this->other-service);
		$criteria->compare('refraction', $this->refraction);
		$criteria->compare('lva', $this->lva);
		$criteria->compare('orthoptics', $this->orthoptics);
		$criteria->compare('cl_clinic', $this->cl_clinic);
		$criteria->compare('vf', $this->vf);
		$criteria->compare('us', $this->us);
		$criteria->compare('biometry', $this->biometry);
		$criteria->compare('oct', $this->oct);
		$criteria->compare('hrt', $this->hrt);
		$criteria->compare('disc_photos', $this->disc_photos);
		$criteria->compare('edt', $this->edt);

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