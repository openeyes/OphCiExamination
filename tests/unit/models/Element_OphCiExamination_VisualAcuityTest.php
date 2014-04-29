<?php
/**
 * Created by PhpStorm.
 * User: msmith
 * Date: 29/04/2014
 * Time: 12:20
 */

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
		$test = $this->getMockBuilder('Element_OphCiExamination_VisualAcuity')
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

}