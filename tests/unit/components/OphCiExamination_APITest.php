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

class OphCiExamination_APITest extends CDbTestCase {

	static public function setupBeforeClass()
	{
		Yii::app()->getModule('OphCiExamination');
	}

	public function setUp()
	{
		parent::setUp();
	}

	public $fixtures = array(
		'cct' => ':et_ophciexamination_anteriorsegment_cct',
		'cct_method'=> ':ophciexamination_anteriorsegment_cct_method',
	);


	public function testgetLetterVisualAcuityForEpisode_Side_hasReading()
	{
		foreach (array('Left', 'Right') as $side) {
			$reading = $this->getMockBuilder('\OEModule\OphCiExamination\models\OphCiExamination_VisualAcuity_Reading')
					->disableOriginalConstructor()
					->setMethods(array('convertTo'))
					->getMock();

			$reading->expects($this->once())
				->method('convertTo')
				->will($this->returnValue('Expected Result'));

			$va = $this->getMockBuilder('\OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity')
					->disableOriginalConstructor()
					->setMethods(array('has' . $side, 'getBestReading'))
					->getMock();

			$va->expects($this->once())
				->method('has' . $side)
				->will($this->returnValue(true));

			$va->expects($this->once())
				->method('getBestReading')
				->will($this->returnValue($reading));

			$api = $this->getMockBuilder('OEModule\OphCiExamination\components\OphCiExamination_API')
					->disableOriginalConstructor()
					->setMethods(array('getElementForLatestEventInEpisode'))
					->getMock();

			$patient = new Patient();
			$episode = new Episode();
			$episode->patient = $patient;

			$api->expects($this->once())
				->method('getElementForLatestEventInEpisode')
				->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_VisualAcuity')
				->will($this->returnValue($va));

			$method = 'getLetterVisualAcuityForEpisode' . $side;
			$this->assertEquals('Expected Result', $api->$method($episode));
		}
	}

	public function testgetLetterVisualAcuityForEpisode_Side_hasNoReading()
	{
		foreach (array('Left', 'Right') as $side) {


			$va = $this->getMockBuilder('\OEModule\OphCiExamination\models\Element_OphCiExamination_VisualAcuity')
					->disableOriginalConstructor()
					->setMethods(array('has' . $side, 'getBestReading', 'getTextForSide'))
					->getMock();

			$va->expects($this->exactly(2))
					->method('has' . $side)
					->will($this->returnValue(true));

			$va->expects($this->exactly(2))
					->method('getBestReading')
					->with(strtolower($side))
					->will($this->returnValue(null));

			$va->expects($this->once())
					->method('getTextForSide')
					->with(strtolower($side))
					->will($this->returnValue('Expected Result'));

			$api = $this->getMockBuilder('\OEModule\OphCiExamination\components\OphCiExamination_API')
					->disableOriginalConstructor()
					->setMethods(array('getElementForLatestEventInEpisode'))
					->getMock();

			$patient = new Patient();
			$episode = new Episode();
			$episode->patient = $patient;

			$api->expects($this->exactly(2))
					->method('getElementForLatestEventInEpisode')
					->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_VisualAcuity')
					->will($this->returnValue($va));
			$method = 'getLetterVisualAcuityForEpisode' . $side;
			$this->assertEquals('Expected Result', $api->$method($episode, true));
			$this->assertNull($api->$method($episode, false));
		}
	}

	public function testgetLetterVisualAcuityForEpisodeBoth_recorded()
	{
		$api = $this->getMockBuilder('\OEModule\OphCiExamination\components\OphCiExamination_API')
				->disableOriginalConstructor()
				->setMethods(array('getLetterVisualAcuityForEpisodeLeft', 'getLetterVisualAcuityForEpisodeRight'))
				->getMock();

		$episode = new Episode();

		$api->expects($this->at(0))
			->method('getLetterVisualAcuityForEpisodeLeft')
			->with($this->equalTo($episode), true)
			->will($this->returnValue('Left VA'));

		$api->expects($this->at(1))
				->method('getLetterVisualAcuityForEpisodeRight')
				->with($this->equalTo($episode), true)
				->will($this->returnValue('Right VA'));

		$this->assertEquals('Right VA on the right and Left VA on the left', $api->getLetterVisualAcuityForEpisodeBoth($episode, true));

		$api->expects($this->at(0))
				->method('getLetterVisualAcuityForEpisodeLeft')
				->with($this->equalTo($episode), false)
				->will($this->returnValue('Left VA'));
		$api->expects($this->at(1))
				->method('getLetterVisualAcuityForEpisodeRight')
				->with($this->equalTo($episode), false)
				->will($this->returnValue(null));

		$this->assertEquals('not recorded on the right and Left VA on the left', $api->getLetterVisualAcuityForEpisodeBoth($episode, false));
	}

	public function testGetLetterCCT(){

		/*$cct_method_left =
			$this->getMockBuilder('\OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_CCT_Method')
			->disableOriginalConstructor()
			->getMock();
		$cct_method_left->name = 'Ultrasound pachymetry';

		$cct_method_right =
			$this->getMockBuilder('\OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_CCT_Method')
			->disableOriginalConstructor()
			->getMock();
		$cct_method_right->name = 'Corneal specular microscopy';

		$cct = $this->getMockBuilder('\OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT')
			->disableOriginalConstructor()
			->getMock();
		$cct->left_method = $cct_method_left;
		$cct->right_method = $cct_method_right;
		$cct->left_value = 33;
		$cct->right_value = 20;

		var_dump($cct);die;*/

		$cct = $this->cct('cct1');


		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = new Episode();
		$episode->patient = $patient;

		$patient->expects($this->any())
			->method('getEpisodeForCurrentSubspecialty')
			->will($this->returnValue($episode));

		$api = $this->getMockBuilder('\OEModule\OphCiExamination\components\OphCiExamination_API')
			->disableOriginalConstructor()
			->setMethods(array( 'getElementForLatestEventInEpisode'))
			->getMock();

		$api->expects($this->once())
			->method('getElementForLatestEventInEpisode')
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_AnteriorSegment_CCT')
			->will($this->returnValue($cct));

		$letterCCT = $api->getLetterCCT($patient);
		$expected  = 'Left Eye: 33 µm using Ultrasound pachymetry. Right Eye: 20 µm using Corneal specular microscopy. ';
		$this->assertEquals($expected, $letterCCT);
	}
}