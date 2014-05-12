<?php
/**
 * OpenEyes
 *
 * (C) OpenEyes Foundation, 2014
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2014, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

use OEModule\OphCiExamination\models;

class Element_OphCiExamination_VisualAcuityTest extends PHPUnit_Framework_TestCase {


	public function letter_stringProvider() {
		return array(
			array(
				array(null, true, false, 'test comments'),
				null,
				"Visual acuity:\nRight Eye: Unable to assess, test comments\nLeft Eye: not recorded\n"
			),
			array(
					array('12/3', false, false, 'test comments'),
					array(null, false, false, 'other comments'),
					"Visual acuity:\nRight Eye: 12/3, test comments\nLeft Eye: not recorded, other comments\n"
			),
				array(
						array(null, true, true, ''),
						array('3/6, 1/12', false, false, ''),
						"Visual acuity:\nRight Eye: Unable to assess, Eye missing\nLeft Eye: 3/6, 1/12\n"
				),
		);
	}

	/**
	 * @dataProvider letter_stringProvider
	 */
	public function testgetLetter_String($right_eye, $left_eye, $res) {
		$test = $this->getMockBuilder('\OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity')
				->disableOriginalConstructor()
				->setMethods(array('getCombined'))
				->getMock();

		$combined_at = 0;

		if ($right_eye) {
			if ($left_eye) {
				$test->eye_id = Eye::BOTH;
			}
			else {
				$test->eye_id = Eye::RIGHT;
			}

			$test->right_unable_to_assess = $right_eye[1];
			$test->right_eye_missing = $right_eye[2];
			$test->right_comments = $right_eye[3];

			$combined = $right_eye[0];
			$test->expects($this->at($combined_at))
					->method('getCombined')
					->with('right')
					->will($this->returnValue($combined));
			$combined_at++;
			if ($combined) {
				$test->expects($this->at($combined_at))
						->method('getCombined')
						->with('right')
						->will($this->returnValue($combined));
				$combined_at++;
			}
		}
		else {
			$test->eye_id = Eye::LEFT;
		}

		if ($left_eye) {
			$test->left_unable_to_assess = $left_eye[1];
			$test->left_eye_missing = $left_eye[2];
			$test->left_comments = $left_eye[3];
			$combined = $left_eye[0];

			$test->expects($this->at($combined_at))
					->method('getCombined')
					->with('left')
					->will($this->returnValue($combined));
			$combined_at++;
			if ($combined) {
				$test->expects($this->at($combined_at))
						->method('getCombined')
						->with('left')
						->will($this->returnValue($combined));
			}
		}
		$this->assertEquals($res, $test->getLetter_string());
	}

	public function getTextForSide_Provider()
	{
		return array(
			array('left', false, true, true, 'Unable to assess, Eye missing'),
			array('right', false, true, true, 'Unable to assess, Eye missing'),
			array('left', false, true, false, 'Unable to assess'),
			array('left', false, false, true, 'Eye missing'),
			array('left', false, false, false, 'not recorded'),
			array('left', true, false, false, null),
		);
	}

	/**
	 * @dataProvider getTextForSide_Provider
	 */
	public function testgetTextForSide($side, $readings, $unable, $eye_missing, $res)
	{
		$test = new models\Element_OphCiExamination_VisualAcuity();
		if ($side == 'left') {
			$test->eye_id = Eye::LEFT;
		} else {
			$test->eye_id = Eye::RIGHT;
		}
		if ($readings) {
			$test->{$side . '_readings'} = array(new models\OphCiExamination_VisualAcuity_Reading());
		}
		$test->{$side . '_unable_to_assess'} = $unable;
		$test->{$side . '_eye_missing'} = $eye_missing;

		$this->assertEquals($res, $test->getTextForSide($side));
	}

	public function validate_Provider()
	{
		return array(
			array(
				array('eye_id' => Eye::LEFT, 'left_readings' => array(new models\OphCiExamination_VisualAcuity_Reading()), 'left_unable_to_assess' => true),
				false
			),
			array(
					array('eye_id' => Eye::RIGHT, 'left_readings' => array(new models\OphCiExamination_VisualAcuity_Reading())),
					false
			),
			array(
					array('eye_id' => Eye::RIGHT),
					false
			),
			array(
					array('eye_id' => Eye::LEFT, 'left_unable_to_assess' => true),
					true
			),
			array(
				array('eye_id' => Eye::LEFT, 'right_readings' => array(new models\OphCiExamination_VisualAcuity_Reading())),
				false
			),
			array(
					array('eye_id' => Eye::LEFT, 'left_readings' => array(new models\OphCiExamination_VisualAcuity_Reading()), 'left_eye_missing' => true),
					false
			),
		);
	}


	/**
	 * @dataProvider validate_Provider
	 */
	public function testValidate(array $attributes, $should_be_valid)
	{
		$test = new models\Element_OphCiExamination_VisualAcuity();
		foreach ($attributes as $attr => $v) {
			$test->$attr = $v;
		}

		$this->assertEquals($should_be_valid, $test->validate());
	}
}