<?php

class m120627_115100_anterior_segment extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_anteriorsegment', 'eyedraw', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'description', 'text');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'diagnosis_id', 'int(10) unsigned');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'diagnosis_id');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'description');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'eyedraw');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}