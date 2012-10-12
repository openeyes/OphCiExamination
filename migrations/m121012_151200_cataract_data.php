<?php

class m121012_151200_cataract_data extends OEMigration {

	public function up() {
		$this->delete('ophciexamination_attribute_option');
		$this->delete('ophciexamination_attribute');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
	}

}
