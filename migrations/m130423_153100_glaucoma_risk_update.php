<?php

class m130423_153100_glaucoma_risk_update extends OEMigration {
	
	public function up() {
		$this->delete('et_ophciexamination_glaucomarisk', 'risk_id = 1');
		$this->delete('ophciexamination_glaucomarisk_risk', 'id = 1');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id');
	}

	public function down() {
	}
}
