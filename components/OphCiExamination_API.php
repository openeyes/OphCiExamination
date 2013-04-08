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

class OphCiExamination_API extends BaseAPI {
	
	public function getLetterHistory($patient) {
		if ($history = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_History')) {
			return strtolower($history->description);
		}
	}

	public function getLetterIOPReading($patient, $side) {
		if ($iop = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_IntraocularPressure')) {
			switch ($side) {
				case 'both':
					return $iop->getLetter_reading('right')." on the right, and ".$iop->getLetter_reading('left')." on the left";
				case 'left':
					return $iop->getLetter_reading('left');
				case 'right':
					return $iop->getLetter_reading('right');
				case 'episode':
					if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
						switch ($episode->eye->name) {
							case 'Left':
								return "The intraocular pressure was ".$iop->getLetter_reading('left')." in the left eye";
							case 'Right':
								return "The intraocular pressure was ".$iop->getLetter_reading('right')." in the right eye";
							case 'Both':
								return $this->getLetterIOPReading($patient, 'both');
						}
					}
			}
		}
	}

	public function getLetterAnteriorSegment($patient, $side) {
		if ($as = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_AnteriorSegment')) {
			switch ($side) {
				case 'left':
					return $as->left_description;
				case 'right':
					return $as->right_description;
				case 'both':
					# Bill: not for 1.1 [OE-2207]
					break;
				case 'episode':
					$episode = $patient->getEpisodeForCurrentSubspecialty();
					return $this->getLetterAnteriorSegment($patient, strtolower($episode->eye->name));
			}
		}
	}

	public function getLetterPosteriorPole($patient, $side) {
		if ($ps = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_PosteriorPole')) {
			switch ($side) {
				case 'left':
					return $ps->left_description;
				case 'right':
					return $ps->right_description;
				case 'both':
					# Bill: not for 1.1 [OE-2207]
					break;
				case 'episode':
					$episode = $patient->getEpisodeForCurrentSubspecialty();
					return $this->getLetterAnteriorSegment($patient, strtolower($episode->eye->name));
			}
		}
	}
	
	/*
	 * returns the best visual acuity for the specified side
	 * 
	 * @return OphCiExamination_VisualAcuity_Reading
	 */
	public function getBestVisualAcuity($patient, $side) {
		if ($va = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_VisualAcuity')) {
			switch ($side) {
				case 'left':
					return $va->getBestReading('left');
				case 'right':
					return $va->getBestReading('right');
			}
		}
	}
	
	public function getLetterVisualAcuity($patient, $side) {
		switch ($side) {
			case 'left':
				return ($best = $this->getBestVisualAcuity($patient, 'left')) ? $best->convertTo($best->value) : null;
			case 'right':
				return ($best = $this->getBestVisualAcuity($patient, 'right')) ? $best->convertTo($best->value) : null;
			case 'both':
				$left = $this->getBestVisualAcuity($patient, 'left');
				$right = $this->getBestVisualAcuity($patient, 'right');
				error_log('oi');
				return ($right ? $right->convertTo($right->value)  : "not recorded")." on the right and ". ($left ? $left->convertTo($left->value) : "not recorded")." on the left";
			case 'episode':
				$episode = $patient->getEpisodeForCurrentSubspecialty();
				return $this->getLetterVisualAcuity($patient, strtolower($episode->eye->name));
		}
	}

	public function getLetterConclusion($patient) {
		if ($conclusion = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_Conclusion')) {
			return $conclusion->description;
		}
	}

	public function getLetterManagement($patient) {
		if ($management = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_Management')) {
			return $management->comments;
		}
	}

	public function getLetterAdnexalComorbidity($patient, $side) {
		if ($ac = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_AdnexalComorbidity')) {
			return $ac->{$side.'_description'};
		}
	}

	public function getEpisodeHTML($episode_id) {
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$return = '';

		if ($cct = $this->getMostRecentElementInEpisode($episode_id, $event_type->id, 'Element_OphCiExamination_AnteriorSegment_CCT')) {
			$return .= Yii::app()->getController()->renderPartial('application.modules.OphCiExamination.views.default._episode_cct',array('cct'=>$cct));
		}

		if ($iop = $this->getMostRecentElementInEpisode($episode_id, $event_type->id, 'Element_OphCiExamination_IntraocularPressure')) {
			$return .= Yii::app()->getController()->renderPartial('application.modules.OphCiExamination.views.default._episode_iop',array('iop'=>$iop));
		}

		return $return;
	}
	
	/*
	 * gets a list of disorders diagnosed for the patient within the current episode, ordered by event creation date
	 * 
	 * @param Patient $patient
	 * 
	 * @return array() - list of associative arrays with disorder_id and eye_id defined  
	 */
	public function getOrderedDisorders($patient) {
		$events = $this->getEventsInEpisode($patient);
		$disorders = array();
		
		foreach ($events as $event) {
			$criteria = new CDbCriteria;
			$criteria->compare('event_id',$event->id);
						
			$diagnoses = Element_OphCiExamination_Diagnoses::model()->find($criteria);
			foreach ($diagnoses->diagnoses as $diagnosis) {
				$disorders[] = array('disorder_id' => $diagnosis->disorder_id, 'eye_id' => $diagnosis->eye_id);
			}
		}
		
		return $disorders;
	}
}
