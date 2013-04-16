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
	
	/**
	 * Get the patient history for the given episode. This is from the most recent
	 * examination that has an history element
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @return string
	 */
	public function getLetterHistory($patient, $episode) {
		if ($history = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_History')) {
			return strtolower($history->description);
		}
	}

	/**
	 * Get the Intraocular Pressure reading for the given eye. This is from the most recent
	 * examination that has an IOP element
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 * @return string
	 */
	public function getLetterIOPReading($patient, $episode, $side) {
		if ($iop = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_IntraocularPressure')) {
			switch ($side) {
				case 'both':
					return $iop->getLetter_reading('right')." on the right, and ".$iop->getLetter_reading('left')." on the left";
				case 'left':
					return $iop->getLetter_reading('left');
				case 'right':
					return $iop->getLetter_reading('right');
				case 'episode':
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
	
	/**
	 * return the anterior segment description for the given eye. This is from the most recent
	 * examination that has an anterior segment element
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 */
	public function getLetterAnteriorSegment($patient, $episode, $side) {
		if ($as = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AnteriorSegment')) {
			switch ($side) {
				case 'left':
					return $as->left_description;
				case 'right':
					return $as->right_description;
				case 'both':
					# Bill: not for 1.1 [OE-2207]
					break;
				case 'episode':
					return $this->getLetterAnteriorSegment($patient, $episode, strtolower($episode->eye->name));
			}
		}
	}

	/**
	 * return the posterior pole description for the given eye. This is from the most recent
	 * examination that has a posterior pole element
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 */
	public function getLetterPosteriorPole($patient, $episode, $side) {
		if ($ps = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_PosteriorPole')) {
			switch ($side) {
				case 'left':
					return $ps->left_description;
				case 'right':
					return $ps->right_description;
				case 'both':
					# Bill: not for 1.1 [OE-2207]
					break;
				case 'episode':
					return $this->getLetterAnteriorSegment($patient, strtolower($episode->eye->name));
			}
		}
	}
	
	/**
	 * returns the best visual acuity for the specified side in the given episode for the patient. This is from the most recent
	 * examination that has a visual acuity element
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 * @return OphCiExamination_VisualAcuity_Reading
	 */
	public function getBestVisualAcuity($patient, $episode, $side) {
		if ($va = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_VisualAcuity')) {
			switch ($side) {
				case 'left':
					return $va->getBestReading('left');
				case 'right':
					return $va->getBestReading('right');
			}
		}
	}
	
	/**
	 * get the description of the best visual acuity for the given eye for the patient episode. This is from the most recent examination
	 * that has a visual acuity element.
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 * @return string
	 */
	public function getLetterVisualAcuity($patient, $episode, $side) {
		switch ($side) {
			case 'left':
				return ($best = $this->getBestVisualAcuity($patient, $episode, 'left')) ? $best->convertTo($best->value) : null;
			case 'right':
				return ($best = $this->getBestVisualAcuity($patient, $episode, 'right')) ? $best->convertTo($best->value) : null;
			case 'both':
				$left = $this->getBestVisualAcuity($patient, $episode, 'left');
				$right = $this->getBestVisualAcuity($patient, $episode, 'right');
				return ($right ? $right->convertTo($right->value)  : "not recorded")." on the right and ". ($left ? $left->convertTo($left->value) : "not recorded")." on the left";
			case 'episode':
				return $this->getLetterVisualAcuity($patient, strtolower($episode->eye->name));
		}
	}

	/**
	 * get the conclusion text from the most recent examination in the patient examination that has a conclusion element
	 *  
	 * @param unknown $patient
	 * @param unknown $episode
	 * @return string
	 */
	public function getLetterConclusion($patient, $episode) {
		if ($conclusion = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Conclusion')) {
			return $conclusion->description;
		}
	}

	/**
	 * get the letter txt from the management element for the given patient and episode. This is from the most recent
	 * examination that has a management element
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @return string
	 */
	public function getLetterManagement($patient, $episode) {
		if ($management = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Management')) {
			return $management->comments;
		}
	}
	
	/**
	 * return the adnexal comorbidity for the patient episode on the given side. This is from the most recent examination that
	 * has an adnexal comorbidity element.
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 */
	public function getLetterAdnexalComorbidity($patient, $episode, $side) {
		if ($ac = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AdnexalComorbidity')) {
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
	

	public function getLetterDRRetinopathy($patient, $episode, $side) {
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			$res = $dr->{$side."_nscretinopathy"};
			if ($dr->{$side."_nscretinopathy_photocoagulation"}) {
				$res .= " and evidence of photocoagulation";
			}
			return $res;
		}
	}
	
	public function getLetterDRMaculopathy($patient, $episode, $side) {
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			$res = $dr->{$side."_nscmaculopathy"};
			if ($dr->{$side."_nscmaculopathy_photocoagulation"}) {
				$res .= " and evidence of photocoagulation";
			}
			return $res;
		}
	}
	
	public function getLetterDRClinical($patient, $episode, $side) {
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			return $dr->{$side."_clinical"};
		}
	}
	
	public function getLetterLaserManagementPlan($patient, $episode) {
		if ($m = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_LaserManagement')) {
			return $m->getLetter_lmp();
		}
	}
	
	public function getLetterLaserManagementComments($patient, $episode) {
		if ($m = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Management')) {
			return $m->comments;
		}
	}
	
	public function getLetterOutcomeFollowUpPeriod($patient, $episode) {
		if ($o = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_ClinicOutcome')) {
			if ($o->followup_quantity) {
				return $o->followup_quantity . " " . $o->followup_period;
			}
		}
	}
	
	/**
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
						
			$diagnoses_el = Element_OphCiExamination_Diagnoses::model()->find($criteria);
			if ($diagnoses_el) { 
				foreach ($diagnoses_el->diagnoses as $diagnosis) {
					$disorders[] = array('disorder_id' => $diagnosis->disorder_id, 'eye_id' => $diagnosis->eye_id);
				}
			}
		}
		
		return $disorders;
	}

	public function getLetterStringForModel($patient, $episode, $element_type_id) {
		if (!$element_type = ElementType::model()->findByPk($element_type_id)) {
			throw new Exception("Unknown element type: $element_type_id");
		}

		if ($element = $this->getElementForLatestEventInEpisode($patient, $episode, $element_type->class_name)) {
			return $element->letter_string;
		}
	}

	/**
	 * 
	 * returns all the elements from the most recent examination of the patient in the given episode
	 * 
	 * @param Patient $patient
	 * @param Episode $episode
	 * @return ElementType[] - array of various different element type objects
	 */
	public function getElementsForLatestEventInEpisode($patient, $episode) {
		$element_types = array();

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		if ($event = $this->getMostRecentEventInEpisode($episode->id, $event_type->id)) {
			$criteria = new CDbCriteria;
			$criteria->compare('event_type_id',$event_type->id);
			$criteria->order = 'display_order';

			foreach (ElementType::model()->findAll($criteria) as $element_type) {
				$class = $element_type->class_name;

				if ($element = $class::model()->find('event_id=?',array($event->id))) {
					if (method_exists($element, 'getLetter_string')) {
						$element_types[] = $element_type;
					}
				}
			}
		}

		return $element_types;
	}
}
