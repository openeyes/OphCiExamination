<?php

class m121220_111300_iop_refactor extends OEMigration {

	public function up() {
		
		// Refactor IP table
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_lri_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_rri_fk', 'et_ophciexamination_intraocularpressure');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_comments', 'text');
		
		// Refactor reading table
		$this->delete('ophciexamination_intraocularpressure_reading');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'side', 'TINYINT(1) UNSIGNED NOT NULL');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'element_id', 'INT(10) UNSIGNED NOT NULL');
		$this->addColumn('ophciexamination_intraocularpressure_reading', 'measurement_timestamp', 'TIME');
		$this->addForeignKey('ophciexamination_intraocularpressure_reading_eid_fk', 'ophciexamination_intraocularpressure_reading', 'element_id', 'et_ophciexamination_intraocularpressure', 'id');
		
		// Remap
		$elements = $this->getDbConnection()->createCommand()
		->select('*')
		->from('et_ophciexamination_intraocularpressure')
		->queryAll();
		foreach($elements as $element) {
			$eyes = 0;
			if($element['left_reading_id']) {
				$left_reading = new OphCiExamination_IntraocularPressure_Reading();
				$left_reading->value = $element['left_reading_id'];
				$left_reading->element_id = $element->id;
				$left_reading->side = 1;
				$left_reading->save();
				$eyes = 2;
			}
			if($element['right_reading_id']) {
				$right_reading = new OphCiExamination_IntraocularPressure_Reading();
				$right_reading->value = $element['right_reading_id'];
				$right_reading->element_id = $element->id;
				$right_reading->side = 0;
				$right_reading->save();
				$eyes += 1;
			}
			if($eyes) {
				$this->update('et_ophciexamination_intraocularpressure', array('eye_id' => $eyes));
			} else {
				throw new CException('Invalid eye');
			}
		}
		
		// Clear out dead columns
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'display_order');
		$this->dropColumn('ophciexamination_intraocularpressure_reading', 'name');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_reading_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_reading_id');
	}

	public function down() {
		// TODO: implement
	}

}
