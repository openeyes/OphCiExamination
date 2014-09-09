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

class OphCiExamination_APITest extends CDbTestCase
{
	private $api;

	static public function setupBeforeClass()
	{
		Yii::app()->getModule('OphCiExamination');
	}

	public function setUp()
	{
		parent::setUp();

		$this->api = Yii::app()->moduleAPI->get('OphCiExamination');
		Yii::app()->session['selected_firm_id'] = 2;
	}

	public $fixtures = array(
		'ssa' => 'ServiceSubspecialtyAssignment',
		'firm' => 'Firm',
		'patient' => 'Patient',
		'episode' => 'Episode',
		'event' => 'Event',
		'cct' => '\OEModule\OphCiExamination\models\Element_OphCiExamination_AnteriorSegment_CCT',
		'cct_method'=> '\OEModule\OphCiExamination\models\OphCiExamination_AnteriorSegment_CCT_Method',
		'gonioscopy'=> '\OEModule\OphCiExamination\models\Element_OphCiExamination_Gonioscopy',
		'iop' => '\OEModule\OphCiExamination\models\Element_OphCiExamination_IntraocularPressure',
		'iop_value' => '\OEModule\OphCiExamination\models\OphCiExamination_IntraocularPressure_Value',
		'optic_disc' => '\OEModule\OphCiExamination\models\Element_OphCiExamination_OpticDisc',
		'episode'=> 'Episode'
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

	public function testGetPrincipalCCTBoth()
	{
		$event = $this->createEvent();
		$element = $this->createCctElement($event, Eye::BOTH);

		$principalCCT = $this->api->getPrincipalCCT($this->patient('patient1'));
		$expected  = 'Left Eye: 50 µm using Ultrasound pachymetry. Right Eye: 50 µm using Ultrasound pachymetry. ';
		$this->assertEquals($expected, $principalCCT);
	}

	public function testGetPrincipalCCTNoPrincipalEye()
	{
		$episode = $this->episode('episode2');
		$episode->eye_id = null;
		if (!$episode->save()) {
			throw new Exception("Failed to save episode: " . print_r($episode->getErrors(), true));
		}

		$principalCCT = $this->api->getPrincipalCCT($this->patient('patient1'));
		$expected  = '';
		$this->assertEquals($expected, $principalCCT);
	}

	public function testGetPrincipalCCTRight()
	{
		$episode = $this->episode('episode2');
		$episode->eye_id = Eye::RIGHT;
		if (!$episode->save()) {
			throw new Exception("Failed to save episode: " . print_r($episode->getErrors(), true));
		}

		$event = $this->createEvent();
		$element = $this->createCctElement($event, Eye::RIGHT);

		$principalCCT = $this->api->getPrincipalCCT($this->patient('patient1'));
		$expected  = 'Right Eye: 50 µm using Ultrasound pachymetry. ';
		$this->assertEquals($expected, $principalCCT);
	}

	public function testGetPrincipalCCTLeft()
	{
		$episode = $this->episode('episode2');
		$episode->eye_id = Eye::LEFT;
		if (!$episode->save()) {
			throw new Exception("Failed to save episode: " . print_r($episode->getErrors(), true));
		}

		$event = $this->createEvent();
		$element = $this->createCctElement($event, Eye::LEFT);

		$principalCCT = $this->api->getPrincipalCCT($this->patient('patient1'));
		$expected  = 'Left Eye: 50 µm using Ultrasound pachymetry. ';
		$this->assertEquals($expected, $principalCCT);
	}

	public function testGetPrincipalCCT_NotLatestEvent()
	{
		$event1 = $this->createEvent('2001-01-01');
		$element = $this->createCctElement($event1, Eye::BOTH);

		$event2 = $this->createEvent('2002-02-02');

		$expected  = 'Left Eye: 50 µm using Ultrasound pachymetry. Right Eye: 50 µm using Ultrasound pachymetry. ';
		$this->assertEquals($expected, $this->api->getPrincipalCCT($this->patient('patient1')));
	}

	public function testGetCCTLeft_NotLatestEvent()
	{
		$event1 = $this->createEvent('2001-01-01');
		$element = $this->createCctElement($event1, Eye::LEFT);

		$event2 = $this->createEvent('2002-02-02');

		$expected  = '50 µm';
		$this->assertEquals($expected, $this->api->getCCTLeft($this->patient('patient1')));
	}

	public function testGetCCTRight_NotLatestEvent()
	{
		$event1 = $this->createEvent('2001-01-01');
		$element = $this->createCctElement($event1, Eye::RIGHT);

		$event2 = $this->createEvent('2002-02-02');

		$expected  = '50 µm';
		$this->assertEquals($expected, $this->api->getCCTRight($this->patient('patient1')));
	}

	public function testGetCCTAbbr_Right()
	{
		$event = $this->createEvent();
		$this->createCctElement($event, Eye::RIGHT);

		$expected = 'r:50';
		$this->assertEquals($expected, $this->api->getCCTAbbr($this->patient('patient1')));
	}

	public function testGetCCTAbbr_Left()
	{
		$event = $this->createEvent();
		$this->createCctElement($event, Eye::LEFT);

		$expected = 'l:50';
		$this->assertEquals($expected, $this->api->getCCTAbbr($this->patient('patient1')));
	}

	public function testGetCCTAbbr_Both()
	{
		$event = $this->createEvent();
		$this->createCctElement($event, Eye::BOTH);

		$expected = 'r:50, l:50';
		$this->assertEquals($expected, $this->api->getCCTAbbr($this->patient('patient1')));
	}

	public function testGetPricipalVanHerick(){
		$gonio = $this->gonioscopy('gonioscopy1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		 $episode = $this->episode('episode2');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_Gonioscopy')
			->will($this->returnValue($gonio));

		$principalVH = $api->getPrincipalVanHerick($patient);
		$expected  = 'Left Eye: Van Herick grade is 30%. Right Eye: Van Herick grade is 5%. ';
		$this->assertEquals($expected, $principalVH);
	}

	public function testGetPricipalVanHerickNoPrincipalEye(){
		$gonio = $this->gonioscopy('gonioscopy1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode1');
		$episode->patient = $patient;

		$patient->expects($this->any())
			->method('getEpisodeForCurrentSubspecialty')
			->will($this->returnValue($episode));

		$api = $this->getMockBuilder('\OEModule\OphCiExamination\components\OphCiExamination_API')
			->disableOriginalConstructor()
			->setMethods(array( 'getElementForLatestEventInEpisode'))
			->getMock();

		$api->expects($this->any())
			->method('getElementForLatestEventInEpisode')
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_Gonioscopy')
			->will($this->returnValue($gonio));

		$principalVH = $api->getPrincipalVanHerick($patient);
		$expected  = '';
		$this->assertEquals($expected, $principalVH);
	}

	public function testGetPricipalVanHerickRight(){
		$gonio = $this->gonioscopy('gonioscopy1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode3');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_Gonioscopy')
			->will($this->returnValue($gonio));

		$principalVH = $api->getPrincipalVanHerick($patient);
		$expected  = 'Right Eye: Van Herick grade is 5%. ';
		$this->assertEquals($expected, $principalVH);
	}

	public function testGetPricipalVanHerickLeft(){
		$gonio = $this->gonioscopy('gonioscopy1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode4');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_Gonioscopy')
			->will($this->returnValue($gonio));

		$principalVH = $api->getPrincipalVanHerick($patient);
		$expected  = 'Left Eye: Van Herick grade is 30%. ';
		$this->assertEquals($expected, $principalVH);
	}

	public function testGetPricipalOpticDiscDescription(){
		$opticdisc = $this->optic_disc('opticdisc1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode2');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_OpticDisc')
			->will($this->returnValue($opticdisc));

		$principalODD = $api->getPrincipalOpticDiscDescription($patient);
		$expected  = 'Left Eye: Not Checked Well. Right Eye: Some Description. ';
		$this->assertEquals($expected, $principalODD);
	}

	public function testGetPricipalOpticDiscDescriptionNoPrincipalEye(){
		$opticdisc = $this->optic_disc('opticdisc1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode1');
		$episode->patient = $patient;

		$patient->expects($this->any())
			->method('getEpisodeForCurrentSubspecialty')
			->will($this->returnValue($episode));

		$api = $this->getMockBuilder('\OEModule\OphCiExamination\components\OphCiExamination_API')
			->disableOriginalConstructor()
			->setMethods(array( 'getElementForLatestEventInEpisode'))
			->getMock();

		$api->expects($this->any())
			->method('getElementForLatestEventInEpisode')
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_OpticDisc')
			->will($this->returnValue($opticdisc));

		$principalODD = $api->getPrincipalOpticDiscDescription($patient);
		$expected  = '';
		$this->assertEquals($expected, $principalODD);
	}

	public function testGetPricipalOpticDiscDescriptionRight(){
		$opticdisc = $this->optic_disc('opticdisc1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode3');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_OpticDisc')
			->will($this->returnValue($opticdisc));

		$principalODD = $api->getPrincipalOpticDiscDescription($patient);
		$expected  = 'Right Eye: Some Description. ';
		$this->assertEquals($expected, $principalODD);
	}

	public function testGetPricipalOpticDiscDescriptionLeft(){
		$opticdisc = $this->optic_disc('opticdisc1');

		$patient = $this->getMockBuilder('Patient')->disableOriginalConstructor()
			->setMethods(array( 'getEpisodeForCurrentSubspecialty'))
			->getMock();

		$episode = $this->episode('episode4');
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
			->with($this->equalTo($patient), $this->equalTo($episode), 'models\Element_OphCiExamination_OpticDisc')
			->will($this->returnValue($opticdisc));

		$principalODD = $api->getPrincipalOpticDiscDescription($patient);
		$expected  = 'Left Eye: Not Checked Well. ';
		$this->assertEquals($expected, $principalODD);
	}

	public function testGetLetterIOPReadingAbbr_Right()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::RIGHT);
		$this->addIopReading($element, Eye::RIGHT, 1);

		$expected = 'r:1';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	public function testGetLetterIOPReadingAbbr_Right_Avg()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::RIGHT);
		$this->addIopReading($element, Eye::RIGHT, 1);
		$this->addIopReading($element, Eye::RIGHT, 3);

		$expected = 'r:2 (avg)';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	public function testGetLetterIOPReadingAbbr_Left()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::LEFT);
		$this->addIopReading($element, Eye::LEFT, 2);

		$expected = 'l:2';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	public function testGetLetterIOPReadingAbbr_Left_Avg()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::LEFT);
		$this->addIopReading($element, Eye::LEFT, 2);
		$this->addIopReading($element, Eye::LEFT, 3);

		$expected = 'l:3 (avg)';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	public function testGetLetterIOPReadingAbbr_Both()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::BOTH);
		$this->addIopReading($element, Eye::RIGHT, 1);
		$this->addIopReading($element, Eye::LEFT, 2);

		$expected = 'r:1, l:2';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	public function testGetLetterIOPReadingAbbr_Both_Avg()
	{
		$event = $this->createEvent();
		$element = $this->createIopElement($event, Eye::BOTH);
		$this->addIopReading($element, Eye::RIGHT, 1);
		$this->addIopReading($element, Eye::RIGHT, 3);
		$this->addIopReading($element, Eye::LEFT, 2);
		$this->addIopReading($element, Eye::LEFT, 3);

		$expected = 'r:2 (avg), l:3 (avg)';
		$this->assertEquals($expected, $this->api->getLetterIOPReadingAbbr($this->patient('patient1')));
	}

	private function createEvent($event_date = null)
	{
		$event = new Event;
		$event->episode_id = $this->episode['episode2']['id'];
		$event->event_type_id = Yii::app()->db->createCommand('select id from event_type where class_name = "OphCiExamination"')->queryScalar();
		if ($event_date) $event->event_date = $event_date;
		$event->save(false);
		return $event;
	}

	private function createCctElement(Event $event, $eye_id)
	{
		$element = new models\Element_OphCiExamination_AnteriorSegment_CCT;
		$element->event_id = $event->id;
		$element->eye_id = $eye_id;

		if ($eye_id == Eye::LEFT || $eye_id == Eye::BOTH) {
			$element->left_method_id = $this->cct_method['method1']['id'];
			$element->left_value = 50;
		}

		if ($eye_id == Eye::RIGHT || $eye_id == Eye::BOTH) {
			$element->right_method_id = $this->cct_method['method1']['id'];
			$element->right_value = 50;
		}

		$element->save(false);

		return $element;
	}

	private function createIopElement(Event $event, $eye_id)
	{
		$element = new models\Element_OphCiExamination_IntraocularPressure;
		$element->event_id = $event->id;
		$element->eye_id = $eye_id;
		$element->save(false);
		return $element;
	}

	private function addIopReading(models\Element_OphCiExamination_IntraocularPressure $element, $eye_id, $value)
	{
		$reading = new models\OphCiExamination_IntraocularPressure_Value;
		$reading->element_id = $element->id;
		$reading->eye_id = $eye_id;
		$reading->reading_id = Yii::app()->db->createCommand('select id from ophciexamination_intraocularpressure_reading where value = ?')->queryScalar(array($value));
		$reading->save(false);
		return $reading;
	}
}
