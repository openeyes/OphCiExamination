<?php

class m130319_110800_clinic_outcome_tweak extends OEMigration {

	public function up() {
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id');
	}

	public function down() {
	}

}
