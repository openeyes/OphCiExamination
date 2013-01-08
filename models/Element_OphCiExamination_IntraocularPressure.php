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
 * This is the model class for table "et_ophciexamination_intraocularpressure".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property integer $eye_id
 * @property integer $left_instrument_id
 * @property integer $right_instrument_id
 * @property string $left_comments
 * @property string $right_comments
 */

class Element_OphCiExamination_IntraocularPressure extends SplitEventTypeElement {
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
		return 'et_ophciexamination_intraocularpressure';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('eye_id', 'required'),
				array('right_instrument_id', 'requiredIfSide', 'side' => 'right'),
				array('left_instrument_id', 'requiredIfSide', 'side' => 'left'),
				array('event_id, left_comments, right_comments', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, eye_id, left_comments, right_comments, left_instrument_id, right_instrument_id', 'safe', 'on' => 'search'),
		);
	}
	
	public function sidedFields() {
		return array('comments','instrument_id');
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
				'eye' => array(self::BELONGS_TO, 'Eye', 'eye_id'),
				'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
				'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
				'readings' => array(self::HAS_MANY, 'OphCiExamination_IntraocularPressure_Reading', 'element_id'),
				'right_readings' => array(self::HAS_MANY, 'OphCiExamination_IntraocularPressure_Reading', 'element_id', 'on' => 'right_readings.side = 0'),
				'left_readings' => array(self::HAS_MANY, 'OphCiExamination_IntraocularPressure_Reading', 'element_id', 'on' => 'left_readings.side = 1'),
				'right_instrument' => array(self::BELONGS_TO, 'OphCiExamination_Instrument', 'right_instrument_id'),
				'left_instrument' => array(self::BELONGS_TO, 'OphCiExamination_Instrument', 'left_instrument_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'left_comments' => 'Comments',
				'right_comments' => 'Comments',
				'left_instrument_id' => 'Instrument',
				'right_instrument_id' => 'Instrument'
		);
	}

	public function getInstrumentOptions() {
		return CHtml::listData(OphCiExamination_Instrument::model()->findAll(), 'id', 'name') ;
	}

	public function getValueOptions() {
		$options = array_combine(range(1,80),range(1,80));
		return $options;
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

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions() {
		
		// Default instrument
		if($default_instrument_id = $this->getSetting('default_instrument_id')) {
			$this->left_instrument_id = $default_instrument_id;
			$this->right_instrument_id = $default_instrument_id;
		}
		
		// Show instruments
		if(!$this->getSetting('show_instruments')) {
			$this->left_instrument_id = null;
			$this->right_instrument_id = null;
		}
		
	}

	/**
	 * Converts a (POSTed) form to an array of reading models.
	 * Required when redisplaying form after validation error.
	 * @param array $readings array POSTed array of readings
	 * @param string $side
	 */
	public function convertReadings($readings, $side) {
		$return = array();
		$side_id = ($side == 'right') ? 0 : 1;
		if (is_array($readings)) {
			foreach($readings as $reading) {
				if($reading['side'] == $side_id) {
					$reading_model = new OphCiExamination_IntraocularPressure_Reading();
					$reading_model->attributes = $reading;
					$return[] = $reading_model;
				}
			}
		}
		return $return;
	}
	
	protected function beforeSave() {
		return parent::beforeSave();
	}

	protected function beforeDelete() {
		foreach ($this->readings as $reading) {
			if (!$reading->delete()) {
				throw new Exception('Delete reading failed: '.print_r($reading->getErrors(),true));
			}
		}
		return parent::beforeDelete();
	}
	
	/**
	 * Save readings
	 * @todo This probably doesn't belong here, but there doesn't seem to be an easy way
	 * of doing it through the controller at the moment
	 */
	protected function afterSave() {
		// Check to see if readings have been posted
		if(isset($_POST['intraocularpressure_readings_valid']) && $_POST['intraocularpressure_readings_valid']) {

			// Get a list of ids so we can keep track of what's been removed
			$existing_reading_ids = array();
			foreach($this->readings as $reading) {
				$existing_reading_ids[$reading->id] = $reading->id;
			}

			// Process (any) posted readings
			$new_readings = (isset($_POST['intraocularpressure_reading'])) ? $_POST['intraocularpressure_reading'] : array();
			foreach($new_readings as $reading) {
				
				// Check to see if side is inactive
				if($reading['side'] == 0 && $this->eye_id == 1
						|| $reading['side'] == 1 && $this->eye_id == 2) {
					continue;
				}
				
				if(isset($reading['id']) && isset($existing_reading_ids[$reading['id']])) {

					// Reading is being updated
					$reading_model = OphCiExamination_IntraocularPressure_Reading::model()->findByPk($reading['id']);
					unset($existing_reading_ids[$reading['id']]);

				} else {

					// Reading is new
					$reading_model = new OphCiExamination_IntraocularPressure_Reading();
					$reading_model->element_id = $this->id;

				}

				// Save reading attributes
				$reading_model->value = $reading['value'];
				$reading_model->measurement_timestamp = $reading['measurement_timestamp'];
				$reading_model->side = $reading['side'];
				$reading_model->save();

			}

			// Delete remaining (removed) ids
			OphCiExamination_IntraocularPressure_Reading::model()->deleteByPk(array_values($existing_reading_ids));

		}

		return parent::afterSave();
	}
	
	/**
	 * Validate readings
	 * @todo This probably doesn't belong here, but there doesn't seem to be an easy way
	 * of doing it through the controller at the moment
	 */
	protected function beforeValidate() {
		if(isset($_POST['intraocularpressure_readings_valid']) && $_POST['intraocularpressure_readings_valid']) {
	
			// Empty side not allowed
			if(!isset($_POST['intraocularpressure_reading']) || !$_POST['intraocularpressure_reading']) {
				$this->addError(null,'At least one reading is required');
			} else {
				foreach(array('Left' => 0, 'Right' => 1) as $not_side => $side_id) {
					if($this->eye->name != $not_side) {
						$has_reading = false;
						foreach($_POST['intraocularpressure_reading'] as $reading) {
							if($reading['side'] == $side_id) {
								$has_reading = true;
							}
						}
						if(!$has_reading) {
							$this->addError(null,'At least one reading is required');
							return parent::beforeValidate();
						}
					}
				}
				
				// Check that readings validate
				foreach($_POST['intraocularpressure_reading'] as $key => $item) {
					if(($item['side'] == 0 && $this->eye->name != 'Left') || ($item['side'] == 1 && $this->eye->name != 'Right')) {
						$item_model = new OphCiExamination_IntraocularPressure_Reading();
						$item_model->measurement_timestamp = $item['measurement_timestamp'];
						$item_model->side = $item['side'];
						$item_model->value = $item['value'];
						$validate_attributes = array_keys($item_model->getAttributes(false));
						if(!$item_model->validate($validate_attributes)) {
							$this->addErrors($item_model->getErrors());
						}
					}
				}
			}
	
		}
		return parent::beforeValidate();
	}
	
	public function getLetter_reading($side) {
		// FIXME
		$segment = $side.'_reading';
		$reading = $this->$segment->name;
		return $reading == 'NR' ? 'Not recorded' : $reading.' mmHg';
	}

	public function getLetter_string() {
		return "Intra-ocular pressure:\nright: ".$this->getLetter_reading('right')."\nleft: ".$this->getLetter_reading('left')."\n";
	}
}
