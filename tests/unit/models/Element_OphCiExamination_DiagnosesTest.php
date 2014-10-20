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
class Element_OphCiExamination_DiagnosesTest extends CDbTestCase {

	/**
	 * @var Element_OphCiExamination_Diagnoses
	 */
	protected $model;
	public $fixtures = array(
		'furtherFindings' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses',
		'etFurtherFindings' => 'OEModule\OphCiExamination\models\OphCiExamination_FurtherFindings',
		'furtherFindingsAssignment' => ':ophciexamination_further_findings_assignment',
		'diagnoses' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses',
	);

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp() {
		parent::setUp();
		$this->model = new OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses;
	}

	/**
	 * @covers OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses::model
	 */
	public function testModel() {
		$this->assertEquals('OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses', get_class($this->model), 'Class name should match model.');
	}

	/**
	 * @covers OEModule\OphCiExamination\models\Element_OphCiExamination_Diagnoses::tableName
	 */
	public function testTableName() {
		$this->assertEquals('et_ophciexamination_diagnoses', $this->model->tableName());
	}


	public function testGetLetter_string(){
		$etDiagString = $this->diagnoses('et_further_diagnoses1')->getLetter_string();
		$this->assertEquals("Further Findings: Finding 2\n", $etDiagString);
	}

}
