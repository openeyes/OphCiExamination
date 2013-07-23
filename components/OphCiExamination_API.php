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

class OphCiExamination_API extends BaseAPI
{
	/**
	 * Get the patient history for the given episode. This is from the most recent
	 * examination that has an history element
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @return string
	 */
	public function getLetterHistory($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($history = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_History')) {
				return strtolower($history->description);
			}
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
	public function getLetterIOPReadingBoth($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($iop = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_IntraocularPressure')) {
				return $iop->getLetter_reading('right')." on the right, and ".$iop->getLetter_reading('left')." on the left";
			}
		}
	}

	public function getLetterIOPReadingLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($iop = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_IntraocularPressure')) {
				return $iop->getLetter_reading('left');
			}
		}
	}

	public function getLetterIOPReadingRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($iop = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_IntraocularPressure')) {
				return $iop->getLetter_reading('right');
			}
		}
	}

	public function getLetterIOPReadingPrincipal($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($episode->eye) {
				$method = 'getLetterIOPReading'.$episode->eye->name;
				return $this->{$method}($patient);
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
	public function getLetterAnteriorSegmentLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($as = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AnteriorSegment')) {
				return $as->left_description;
			}
		}
	}

	public function getLetterAnteriorSegmentRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($as = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AnteriorSegment')) {
				return $as->right_description;
			}
		}
	}

	public function getLetterAnteriorSegmentPrincipal($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($episode->eye) {
				$method = 'getLetterAnteriorSegment'.$episode->eye->name;
				return $this->{$method}($patient);
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
	public function getLetterPosteriorPoleLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($ps = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_PosteriorPole')) {
				return $ps->left_description;
			}
		}
	}

	public function getLetterPosteriorPoleRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($ps = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_PosteriorPole')) {
				return $ps->right_description;
			}
		}
	}

	public function getLetterPosteriorPolePrincipal($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($episode->eye) {
				$method = 'getLetterPosteriorPole'.$episode->eye->name;
				return $this->{$method}($patient);
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
	public function getBestVisualAcuity($patient, $episode, $side)
	{
		if ($va = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_VisualAcuity')) {
			switch ($side) {
				case 'left':
					return $va->getBestReading('left');
				case 'right':
					return $va->getBestReading('right');
			}
		}
	}

	public function getLetterVisualAcuityLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return ($best = $this->getBestVisualAcuity($patient, $episode, 'left')) ? $best->convertTo($best->value) : null;
		}
	}

	public function getLetterVisualAcuityRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return ($best = $this->getBestVisualAcuity($patient, $episode, 'right')) ? $best->convertTo($best->value) : null;
		}
	}

	public function getLetterVisualAcuityBoth($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			$left = $this->getBestVisualAcuity($patient, $episode, 'left');
			$right = $this->getBestVisualAcuity($patient, $episode, 'right');

			return ($right ? $right->convertTo($right->value)  : "not recorded")." on the right and ". ($left ? $left->convertTo($left->value) : "not recorded")." on the left";
		}
	}

	public function getLetterVisualAcuityPrincipal($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($episode->eye) {
				$method = 'getLetterVisualAcuity'.$episode->eye->name;
				return $this->{$method}($patient);
			}
		}
	}

	/**
	 * get the conclusion text from the most recent examination in the patient examination that has a conclusion element
	 *
	 * @param unknown $patient
	 * @param unknown $episode
	 * @return string
	 */
	public function getLetterConclusion($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($conclusion = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Conclusion')) {
				return $conclusion->description;
			}
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
	public function getLetterManagement($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($management = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Management')) {
				return $management->comments;
			}
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
	public function getLetterAdnexalComorbidityRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($ac = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AdnexalComorbidity')) {
				return $ac->right_description;
			}
		}
	}

	public function getLetterAdnexalComorbidityLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($ac = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_AdnexalComorbidity')) {
				return $ac->left_description;
			}
		}
	}

	public function getEpisodeHTML($episode_id)
	{
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

	/**
	 * Get the NSC Retinopathy grade
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side 'left' or 'right'
	 * @return string
	 */
	public function getLetterDRRetinopathy($patient, $episode, $side)
	{
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			$res = $dr->{$side."_nscretinopathy"};
			if ($dr->{$side."_nscretinopathy_photocoagulation"}) {
				$res .= " and evidence of photocoagulation";
			}
			return $res;
		}
	}

	public function getLetterDRRetinopathyLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getLetterDRRetinopathy($patient, $episode, 'left');
		}
	}

	public function getLetterDRRetinopathyRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getLetterDRRetinopathy($patient, $episode, 'right');
		}
	}

	/**
	 * Get the NSC Maculopathy grade
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side 'left' or 'right'
	 * @return string
	 */
	public function getDRMaculopathy($patient, $episode, $side)
	{
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			$res = $dr->{$side."_nscmaculopathy"};
			if ($dr->{$side."_nscmaculopathy_photocoagulation"}) {
				$res .= " and evidence of photocoagulation";
			}
			return $res;
		}
	}

	public function getLetterDRMaculopathyLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getDRMaculopathy($patient, $episode, 'left');
		}
	}

	public function getLetterDRMaculopathyRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getDRMaculopathy($patient, $episode, 'right');
		}
	}

	/**
	 * Get the clinical diabetic retinopathy grade
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side 'left' or 'right'
	 * @return string
	 */
	public function getDRClinical($patient, $episode, $side)
	{
		if ($dr = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_DRGrading')) {
			return $dr->{$side."_clinical"};
		}
	}

	public function getLetterDRClinicalLeft($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getDRClinical($patient, $episode, 'left');
		}
	}

	public function getLetterDRClinicalRight($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			return $this->getDRClinical($patient, $episode, 'right');
		}
	}

	/**
	 * get the laser management plan
	 *
	 * @param Patient $patient
	 */
	public function getLetterLaserManagementPlan($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($m = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_LaserManagement')) {
				return $m->getLetter_lmp();
			}
		}
	}

	/**
	 * get laser management comments
	 *
	 * @param Patient $patient
	 * @return string
	 */
	public function getLetterLaserManagementComments($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($m = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_Management')) {
				return $m->comments;
			}
		}
	}

	/**
	 * get follow up period from clinical outcome
	 *
	 * @param Patient $patient
	 * @return string
	 */
	public function getLetterOutcomeFollowUpPeriod($patient)
	{
		if ($episode = $patient->getEpisodeForCurrentSubspecialty()) {
			if ($o = $this->getElementForLatestEventInEpisode($patient, $episode, 'Element_OphCiExamination_ClinicOutcome')) {
				if ($o->followup_quantity) {
					return $o->followup_quantity . " " . $o->followup_period;
				}
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
	public function getOrderedDisorders($patient, $episode)
	{
		$events = $this->getEventsInEpisode($patient, $episode);
		$disorders = array();

		if ($events) {
			foreach (@$events as $event) {
				$criteria = new CDbCriteria;
				$criteria->compare('event_id',$event->id);

				$diagnoses_el = Element_OphCiExamination_Diagnoses::model()->find($criteria);
				if ($diagnoses_el) {
					foreach ($diagnoses_el->diagnoses as $diagnosis) {
						$disorders[] = array('disorder_id' => $diagnosis->disorder_id, 'eye_id' => $diagnosis->eye_id);
					}
				}
			}
		}

		return $disorders;
	}

	public function getLetterStringForModel($patient, $episode, $element_type_id)
	{
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
	public function getElementsForLatestEventInEpisode($patient, $episode)
	{
		$element_types = array();

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		if ($event_type && $event = $this->getMostRecentEventInEpisode($episode->id, $event_type->id)) {
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

	/**
	 * Get the most recent InjectionManagementComplex element in this episode for the given side
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 *
	 * @return Element_OphCiExamination_InjectionManagementComplex
	 */
	public function getInjectionManagementComplexInEpisodeForSide($patient, $episode, $side)
	{
		$events = $this->getEventsInEpisode($patient, $episode);

		$eye_vals = array(SplitEventTypeElement::BOTH);
		if ($side == 'left') {
			$eye_vals[] = SplitEventTypeElement::LEFT;
		} else {
			$eye_vals[] = SplitEventTypeElement::RIGHT;
		}
		foreach (@$events as $event) {
			$criteria = new CDbCriteria;
			$criteria->compare('event_id', $event->id);
			$criteria->addInCondition('eye_id', $eye_vals);

			if ($el = Element_OphCiExamination_InjectionManagementComplex::model()->find($criteria)) {
				return $el;
			}
		}
	}

	/**
	 * Get the most recent InjectionManagementComplex element in this episode for the given side and disorder
	 *
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side
	 * @param int $disorder1_id
	 * @param int $disorder2_id
	 *
	 * @return Element_OphCiExamination_InjectionManagementComplex
	 */
	public function getInjectionManagementComplexInEpisodeForDisorder($patient, $episode, $side, $disorder1_id, $disorder2_id)
	{
		$events = $this->getEventsInEpisode($patient, $episode);
		$elements = array();

		if ($events) {
			foreach ($events as $event) {
				$criteria = new CDbCriteria;
				$criteria->compare('event_id',$event->id);
				$criteria->compare($side . '_diagnosis1_id', $disorder1_id);
				if ($disorder2_id) {
					$criteria->compare($side . '_diagnosis2_id', $disorder2_id);
				} else {
					$criteria->addCondition($side . '_diagnosis2_id IS NULL');
				}

				if ($el = Element_OphCiExamination_InjectionManagementComplex::model()->find($criteria)) {
					return $el;
				}
			}
		}
	}

	/**
	 * wrapper to retrieve question objects for a given disorder id
	 *
	 * @param int $disorder_id
	 * @return OphCiExamination_InjectionMangementComplex_Question[]
	 */
	public function getInjectionManagementQuestionsForDisorder($disorder_id)
	{
		try {
			Element_OphCiExamination_InjectionManagementComplex::model()->getInjectionQuestionsForDisorderId($disorder_id);
		} catch (Exception $e) {
			return array();
		}
	}

	/**
	 * retrieve OCT measurements for the given side for the patient in the given episode
	 * @param Patient $patient
	 * @param Episode $episode
	 * @param string $side - 'left' or 'right'
	 * @return array(maximum_CMT, central_SFT) or null
	 */
	public function getOCTForSide($patient, $episode, $side)
	{
		$events = $this->getEventsInEpisode($patient, $episode);
		if ($side == 'left') {
			$side_list = array(Eye::LEFT, Eye::BOTH);
		} else {
			$side_list = array(Eye::RIGHT, Eye::BOTH);
		}
		if ($events) {
			foreach ($events as $event) {
				$criteria = new CDbCriteria;
				$criteria->compare('event_id',$event->id);
				$criteria->addInCondition('eye_id', $side_list);

				if ($el = Element_OphCiExamination_OCT::model()->find($criteria)) {
					return array($el->{$side . '_cmt'}, $el->{$side . '_sft'});
				}
			}
		}
	}
}
