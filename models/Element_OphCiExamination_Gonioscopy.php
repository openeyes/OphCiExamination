<?php

/**
 * OpenEyes
 *
 * (C) University of Cardiff, 2012
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) University of Cardiff, 2012
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<?php

/**
 * This is the model class for table "element_gonioscopy".
 *
 * The followings are the available columns in table 'element_gonioscopy':
 * @property string $id
 * @property string $event_id
 * @property string $description
 *
 * The followings are the available model relations:
 * @property Event $event
 */
class Element_OphCiExamination_Gonioscopy extends OphCiExamination_EyeDrawBase {
	/** */

	const VAN_HERICK_UNSET = 0;
	/** Represents Van Herick value at 5%. */
	const VAN_HERICK_005 = 5;
	/** Represents Van Herick value at 15%. */
	const VAN_HERICK_015 = 15;
	/** Represents Van Herick value at 25%. */
	const VAN_HERICK_025 = 25;
	/** Represents Van Herick value at 30%. */
	const VAN_HERICK_030 = 30;
	/** Represents Van Herick value at 75%. */
	const VAN_HERICK_075 = 75;
	/** Represents Van Herick value at 100%. */
	const VAN_HERICK_100 = 100;

	/** Option for 'open' gonioscopy. */
	const OPTION_OPEN = 1;
	/** Option for 'narrow(i)' gonioscopy. */
	const OPTION_NARROW_1 = 2;
	/** Option for 'narrow(ii)' gonioscopy. */
	const OPTION_NARROW_2 = 3;
	/** Option for 'closed' gonioscopy. */
	const OPTION_CLOSED = 4;

	/**
	 *
	 */
	function __construct($scenario = 'insert') {
		parent::__construct($scenario);
		$this->setDoodleInfo(array('AngleNV', 'AntSynech', 'AngleRecession'));
	}

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
		return 'et_ophciexamination_gonioscopy';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('id, event_id, gonio_left, gonio_right, van_herick_left, van_herick_right, description_left, description_right, image_string_left, image_string_right', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, event_id, description_left, description_right, image_string_left, image_string_right', 'safe', 'on' => 'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
				'event' => array(self::BELONGS_TO, 'Event', 'event_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
				'id' => 'ID',
				'event_id' => 'Event',
				'van_herick_left' => 'Van Herick',
				'van_herick_right' => 'Van Herick',
				'gonio_left' => 'Gonioscopy',
				'gonio_right' => 'Gonioscopy',
				'description_left' => 'Description',
				'description_right' => 'Description',
				'image_string_left' => 'EyeDraw (left)',
				'image_string_right' => 'EyeDraw (right)'
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
		$criteria->compare('gonio_left', $this->gonio_left, true);
		$criteria->compare('gonio_right', $this->gonio_right, true);
		$criteria->compare('van_herick_left', $this->van_herick_left, true);
		$criteria->compare('van_herick_right', $this->van_herick_right, true);
		$criteria->compare('description_left', $this->description_left, true);
		$criteria->compare('description_right', $this->description_right, true);
		$criteria->compare('image_string_left', $this->image_string_left, true);
		$criteria->compare('image_string_right', $this->image_string_right, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
		));
	}

	/**
	 *
	 * @return type
	 */
	function getGonioscopyOptions() {
		return array(
				self::OPTION_OPEN => 'Open',
				self::OPTION_NARROW_1 => 'Narrow (I)',
				self::OPTION_NARROW_2 => 'Narrow (II)',
				self::OPTION_CLOSED => 'Closed',
		);
	}

	/**
	 *
	 * @return type
	 */
	function getVanHerickOptions() {
		return array(
				self::VAN_HERICK_UNSET => 'NR',
				self::VAN_HERICK_005 => '5%',
				self::VAN_HERICK_015 => '15%',
				self::VAN_HERICK_025 => '25%',
				self::VAN_HERICK_030 => '30%',
				self::VAN_HERICK_075 => '75%',
				self::VAN_HERICK_100 => '100%',
		);
	}

	/**
	 *
	 * @param string $description_string
	 * @param int $type
	 * @param int $vanHerick
	 * @return string
	 */
	function getVerboseDescription($description_string, $type, $vanHerick) {
		$description = "";
		if ($description_string) {
			$description = $description_string;
		}
		$gonioOptions = $this->getGonioscopyOptions();
		$vanHerickOptions = $this->getVanHerickOptions();
		if ($description_string) {
			$description .= ", ";

			$description .= $gonioOptions[$type];
			if ($vanHerick) {
				if (strlen($description)) {
					$description .= ", ";
				}
				$description .= "Van Herick: " . $vanHerickOptions[$vanHerick];
			}
		}
		return $description;
	}

}
