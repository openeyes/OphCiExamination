<?php
/**
 * Created by PhpStorm.
 * User: msmith
 * Date: 28/04/2014
 * Time: 15:27
 */

class Element_OphCiExamination_ColourVisionTest extends CDbTestCase {

	public $fixtures = array(
			'methods' => 'OphCiExamination_ColourVision_Method',
	);

	public function testValidation_validatesReadings() {
		$lreading = $this->getMockBuilder('OphCiExamination_ColourVision_Reading')
				->disableOriginalConstructor()
				->setMethods(array('validate'))
				->getMock();

		$lreading->expects($this->once())
			->method('validate')
			->will($this->returnValue(false));

		$test = $this->getMockBuilder('Element_OphCiExamination_ColourVision')
			->disableOriginalConstructor()
			->setMethods(array('hasLeft', 'hasRight'))
			->getMock();
		$test->expects($this->any())
			->method('hasLeft')
			->will($this->returnValue(true));
		$test->expects($this->any())
				->method('hasRight')
				->will($this->returnValue(false));

		$test->left_readings = array($lreading);
		$this->assertFalse($test->validate());
	}

	public function testGetUnusedReadingMethods() {
		$test = new Element_OphCiExamination_ColourVision();
		$test->left_readings = array(ComponentStubGenerator::generate('OphCiExamination_ColourVision_Reading', array('method_id' => $this->methods('method1')->id)));

		$this->assertEquals(array($this->methods('method2')), $test->getUnusedReadingMethods('left'), 'Left methods should be restricted');
		$this->assertEquals(array($this->methods('method1'), $this->methods('method2')), $test->getUnusedReadingMethods('right'), 'Right should return both methods');
	}

}