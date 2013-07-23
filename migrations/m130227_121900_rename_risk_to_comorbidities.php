<?php

class m130227_121900_rename_risk_to_comorbidities extends OEMigration
{
	public function up()
	{
		$this->update('element_type', array('class_name' => 'Element_OphCiExamination_Comorbidities'), "class_name = 'Element_OphCiExamination_Risks'");
		$this->dropForeignKey('ophciexamination_risks_assign_e_id_fk', 'ophciexamination_risks_assignment');
		$this->dropForeignKey('ophciexamination_risks_assign_r_id_fk', 'ophciexamination_risks_assignment');
		$this->renameTable('et_ophciexamination_risks', 'et_ophciexamination_comorbidities');
		$this->renameTable('ophciexamination_risks_risk', 'ophciexamination_comorbidities_item');
		$this->renameTable('ophciexamination_risks_assignment', 'ophciexamination_comorbidities_assignment');
		$this->renameColumn('ophciexamination_comorbidities_assignment', 'risk_id', 'item_id');
		$this->addForeignKey('ophciexamination_comorbidities_assign_e_id_fk', 'ophciexamination_comorbidities_assignment', 'element_id', 'et_ophciexamination_comorbidities', 'id');
		$this->addForeignKey('ophciexamination_comorbidities_assign_i_id_fk', 'ophciexamination_comorbidities_assignment', 'item_id', 'ophciexamination_comorbidities_item', 'id');
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_comorbidities_assign_e_id_fk', 'ophciexamination_comorbidities_assignment');
		$this->dropForeignKey('ophciexamination_comorbidities_assign_i_id_fk', 'ophciexamination_comorbidities_assignment');
		$this->renameTable('ophciexamination_comorbidities_assignment', 'ophciexamination_risks_assignment');
		$this->renameTable('ophciexamination_comorbidities_item', 'ophciexamination_risks_risk');
		$this->renameTable('et_ophciexamination_comorbidities', 'et_ophciexamination_risks');
		$this->renameColumn('ophciexamination_risks_assignment', 'item_id', 'risk_id');
		$this->addForeignKey('ophciexamination_risks_assign_e_id_fk', 'ophciexamination_risks_assignment', 'element_id', 'et_ophciexamination_risks', 'id');
		$this->addForeignKey('ophciexamination_risks_assign_r_id_fk', 'ophciexamination_risks_assignment', 'risk_id', 'ophciexamination_risks_risk', 'id');
		$this->update('element_type', array('class_name' => 'Element_OphCiExamination_Risks'), "class_name = 'Element_OphCiExamination_Comorbidities'");
	}

}
