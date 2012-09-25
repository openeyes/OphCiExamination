<?php

class m120925_122900_uat_changes extends OEMigration {

	public function up() {
		// Add other field to refraction types
		$this->addColumn('et_ophciexamination_refraction', 'left_type_other', 'varchar(100)');
		$this->addColumn('et_ophciexamination_refraction', 'right_type_other', 'varchar(100)');

		// Remove "Other" from refraction types and add "Own Glasses"
		$this->alterColumn('et_ophciexamination_refraction','left_type_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_refraction','right_type_id','int(10) unsigned');
		$other_id = OphCiExamination_Refraction_Type::model()->find("name = 'Other'")->id;
		$this->update('et_ophciexamination_refraction',array('left_type_id' => null), "left_type_id = $other_id");
		$this->update('et_ophciexamination_refraction',array('right_type_id' => null), "right_type_id = $other_id");
		$this->delete('ophciexamination_refraction_type', "id = $other_id");
		$this->insert('ophciexamination_refraction_type', array('name' => 'Own Glasses', 'display_order' => 4));
		
	}

	public function down() {
		$this->delete('ophciexamination_refraction_type', "name = 'Own Glasses'");
		$this->insert('ophciexamination_refraction_type', array('name' => 'Other', 'display_order' => 4));
		$this->dropColumn('et_ophciexamination_refraction', 'left_type_other');
		$this->dropColumn('et_ophciexamination_refraction', 'right_type_other');
	}
}
