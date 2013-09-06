<?php

/**
 * This is the model class for table "ophciexamination_eyedraw_config".
 *
 * The followings are the available columns in table 'ophciexamination_eyedraw_config':
 * @property string $id
 * @property string $event_id
 * @property string $config
 * @property string $subspeciality_id
 * @property string $last_modified_user_id
 * @property string $last_modified_date
 * @property string $created_user_id
 * @property string $created_date
 *
 * The followings are the available model relations:
 * @property User $lastModifiedUser
 * @property User $createdUser
 * @property ServiceSubspecialtyAssignment $subspeciality
 * @property EventType $event
 */
class OphCiExamination_EyeDrawConfig extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OphCiExamination_EyeDrawConfig the static model class
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
		return 'ophciexamination_eyedraw_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('event_id, config, subspeciality_id', 'required'),
			array('event_id, last_modified_user_id, created_user_id', 'length', 'max'=>10),
			array('subspeciality_id', 'length', 'max'=>11),
			array('last_modified_date, created_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, event_id, config, subspeciality_id, last_modified_user_id, last_modified_date, created_user_id, created_date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'lastModifiedUser' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'createdUser' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'subspeciality' => array(self::BELONGS_TO, 'ServiceSubspecialtyAssignment', 'subspeciality_id'),
			'event' => array(self::BELONGS_TO, 'EventType', 'event_id'),
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
			'config' => 'Config',
			'subspeciality_id' => 'Subspeciality',
			'last_modified_user_id' => 'Last Modified User',
			'last_modified_date' => 'Last Modified Date',
			'created_user_id' => 'Created User',
			'created_date' => 'Created Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('config',$this->config,true);
		$criteria->compare('subspeciality_id',$this->subspeciality_id,true);
		$criteria->compare('last_modified_user_id',$this->last_modified_user_id,true);
		$criteria->compare('last_modified_date',$this->last_modified_date,true);
		$criteria->compare('created_user_id',$this->created_user_id,true);
		$criteria->compare('created_date',$this->created_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}