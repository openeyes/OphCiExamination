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

	public function getLetterVisualAcuity($patient, $side) {
		if ($va = $this->getElementForLatestEventInEpisode($patient, 'Element_OphCiExamination_VisualAcuity')) {
			switch ($side) {
				case 'left':
					return $va->hasLeft() ? $va->getBest('left') : null;
				case 'right':
					return $va->hasRight() ? $va->getBest('right') : null;
				case 'both':
					return ($va->hasRight() ? $va->getBest('right') : "not recorded")." on the right and ".($va->hasLeft() ? $va->getBest('left') : "not recorded")." on the left";
				case 'episode':
					$episode = $patient->getEpisodeForCurrentSubspecialty();
					return $this->getLetterVisualAcuity($patient, strtolower($episode->eye->name));
			}
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
}
