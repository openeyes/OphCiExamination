<?php

class m130122_124400_other_risks extends OEMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_risks', 'comments', 'text');
		$this->insert('ophciexamination_risks_risk', array('name' => 'Other', 'display_order' => 9999));
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_risks', 'comments');
		$this->delete('ophciexamination_risks_risk',"name = 'Other'");
	}
	
}
