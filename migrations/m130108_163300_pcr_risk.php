<?php

class m130108_163300_pcr_risk extends CDbMigration {
	
	public function up() {
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_pcr_risk', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_pcr_risk', 'decimal(5,2)');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_pcr_risk');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_pcr_risk');
	}
}
