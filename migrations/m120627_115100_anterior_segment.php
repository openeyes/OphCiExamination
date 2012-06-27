<?php

class m120627_115100_anterior_segment extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_diagnosis_id', 'int(10) unsigned');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_diagnosis_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_ldi_fk', 'et_ophciexamination_anteriorsegment', 'left_diagnosis_id', 'disorder', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rdi_fk', 'et_ophciexamination_anteriorsegment', 'right_diagnosis_id', 'disorder', 'id');
	}

	public function down() {
		$this->dropForeignKey('et_ophciexamination_anteriorsegment_rdi_fk', 'et_ophciexamination_anteriorsegment');
		$this->dropForeignKey('et_ophciexamination_anteriorsegment_ldi_fk', 'et_ophciexamination_anteriorsegment');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_diagnosis_id');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_description');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_eyedraw');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_diagnosis_id');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_description');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_eyedraw');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}