<?php

class m130411_140900_optic_disc_mode extends OEMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_opticdisc', 'left_expert_mode', 'tinyint(1) NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_opticdisc', 'right_expert_mode', 'tinyint(1) NOT NULL DEFAULT 0');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_opticdisc', 'left_expert_mode');
		$this->dropColumn('et_ophciexamination_opticdisc', 'right_expert_mode');
	}

}
