<?php

class m140115_132726_fix_workflow_rule_version_table_name extends CDbMigration
{
	public function up()
	{
		$this->dropForeignKey('acv_ophciexamination_element_set_rule_created_user_id_fk','ophciexamination_element_set_rule_version');
		$this->dropForeignKey('acv_ophciexamination_element_set_rule_last_modified_user_id_fk','ophciexamination_element_set_rule_version');
		$this->dropForeignKey('acv_ophciexamination_element_set_rule_parent_id_fk','ophciexamination_element_set_rule_version');
		$this->dropForeignKey('acv_ophciexamination_element_set_rule_workflow_id_fk','ophciexamination_element_set_rule_version');

		$this->dropIndex('acv_ophciexamination_element_set_rule_created_user_id_fk','ophciexamination_element_set_rule_version');
		$this->dropIndex('acv_ophciexamination_element_set_rule_last_modified_user_id_fk','ophciexamination_element_set_rule_version');
		$this->dropIndex('acv_ophciexamination_element_set_rule_parent_id_fk','ophciexamination_element_set_rule_version');
		$this->dropIndex('acv_ophciexamination_element_set_rule_workflow_id_fk','ophciexamination_element_set_rule_version');

		$this->renameTable('ophciexamination_element_set_rule_version','ophciexamination_workflow_rule_version');

		$this->addForeignKey('acv_ophciexamination_workflow_rule_created_user_id_fk','ophciexamination_workflow_rule_version','created_user_id','user','id');
		$this->addForeignKey('acv_ophciexamination_workflow_rule_last_modified_user_id_fk','ophciexamination_workflow_rule_version','last_modified_user_id','user','id');
		$this->addForeignKey('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version','parent_id','ophciexamination_workflow_rule','id');
		$this->addForeignKey('acv_ophciexamination_workflow_rule_workflow_id_fk','ophciexamination_workflow_rule_version','workflow_id','ophciexamination_workflow','id');
	}

	public function down()
	{
		$this->dropForeignKey('acv_ophciexamination_workflow_rule_created_user_id_fk','ophciexamination_workflow_rule_version');
		$this->dropForeignKey('acv_ophciexamination_workflow_rule_last_modified_user_id_fk','ophciexamination_workflow_rule_version');
		$this->dropForeignKey('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version');
		$this->dropForeignKey('acv_ophciexamination_workflow_rule_workflow_id_fk','ophciexamination_workflow_rule_version');

		$this->dropIndex('acv_ophciexamination_workflow_rule_created_user_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('acv_ophciexamination_workflow_rule_last_modified_user_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('acv_ophciexamination_workflow_rule_workflow_id_fk','ophciexamination_workflow_rule_version');

		$this->renameTable('ophciexamination_workflow_rule_version','ophciexamination_element_set_rule_version');

		$this->addForeignKey('acv_ophciexamination_element_set_rule_created_user_id_fk','ophciexamination_element_set_rule_version','created_user_id','user','id');
		$this->addForeignKey('acv_ophciexamination_element_set_rule_last_modified_user_id_fk','ophciexamination_element_set_rule_version','last_modified_user_id','user','id');
		$this->addForeignKey('acv_ophciexamination_element_set_rule_parent_id_fk','ophciexamination_element_set_rule_version','parent_id','ophciexamination_element_set_rule_version','id');
		$this->addForeignKey('acv_ophciexamination_element_set_rule_workflow_id_fk','ophciexamination_element_set_rule_version','workflow_id','ophciexamination_workflow_version','id');
	}
}
