<?php

class m130423_153100_glaucoma_risk_update extends OEMigration {
	
	public function up() {
		$this->delete('ophciexamination_glaucomarisk_risk', 'id = 4');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id');
	}

	public function down() {
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id', 'm130311_132000_glaucoma_risk_update');
	}
}
