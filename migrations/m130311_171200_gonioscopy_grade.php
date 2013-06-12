<?php

class m130311_171200_gonioscopy_grade extends OEMigration {

	public function up() {
		$this->addColumn('ophciexamination_gonioscopy_description', 'seen', 'tinyint(1) unsigned NOT NULL DEFAULT 1');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path, 'id');
	}

	public function down() {
		$this->dropColumn('ophciexamination_gonioscopy_description', 'seen');
	}

}
