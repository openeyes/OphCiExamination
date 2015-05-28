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
use Yii;

/**
 * This is the model class for table "et_ophciexamination_history".
 *
 * The followings are the available columns in table:
 * @property string $id
 * @property integer $event_id
 * @property string $description
 *
 * The followings are the available model relations:
 */

class Element_OphCiExamination_Allergy extends \PatientAllergyAssignment
{

	/**
	 * Set default values for forms on create
	 */
	public function setDefaultOptions() {
		/*if ($api = Yii::app()->moduleAPI->get('OphCoCataractReferral')) {
			if ($episode = Yii::app()->getController()->patient->getEpisodeForCurrentSubspecialty()) {
				if ($history = $api->getHistoryForLatestCataractReferralInEpisode($episode->id)) {
					$this->description = $history;
				}
			}
		}*/
	}


}
