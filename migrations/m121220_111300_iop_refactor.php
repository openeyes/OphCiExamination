<?php

class m121220_111300_iop_refactor extends OEMigration {

	public function up() {
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_li_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_lri_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_ri_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_rri_fk', 'et_ophciexamination_intraocularpressure');
		$this->delete('ophciexamination_intraocularpressure_reading');
		$elements = $this->getDbConnection()->createCommand()
		->select('*')
		->from('et_ophciexamination_intraocularpressure')
		->queryAll();
		foreach($elements as $element) {
			if($element['left_reading_id']) {
				$left_reading = new OphCiExamination_IntraocularPressure_Reading();
				$left_reading->reading = $element['left_reading_id'];
				$left_reading->instrument_id = $element['left_instrument_id'];
				$left_reading->element_id = $element->id;
				$left_reading->side = 1;
				$left_reading->save();
			}
			if($element['right_reading_id']) {
				$right_reading = new OphCiExamination_IntraocularPressure_Reading();
				$right_reading->reading = $element['right_reading_id'];
				$right_reading->instrument_id = $element['right_instrument_id'];
				$right_reading->element_id = $element->id;
				$right_reading->side = 0;
				$right_reading->save();
			}
		}
		// TODO: Update eye_id now that this is a split element
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_instrument_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_reading_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_instrument_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_reading_id');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_comments', 'text');
	}

	public function down() {
		// TODO: implement
	}

}
