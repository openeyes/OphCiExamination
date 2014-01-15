<?php

class m140115_135258_simplify_workflow_rules_version extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_workflow_rule_version','subspecialty_id','int(10) unsigned null');
		$this->addColumn('ophciexamination_workflow_rule_version','episode_status_id','int(10) unsigned null');

		$this->addForeignKey('acv_ophciexamination_workflow_rule_subspecialty_id_fk','ophciexamination_workflow_rule_version','subspecialty_id','subspecialty','id');
		$this->addForeignKey('acv_ophciexamination_workflow_rule_episode_status_id_fk','ophciexamination_workflow_rule_version','episode_status_id','episode_status','id');

		$this->dropForeignKey('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version');
		$this->dropColumn('ophciexamination_workflow_rule_version','parent_id');

		$this->dropColumn('ophciexamination_workflow_rule_version','clause');
		$this->dropColumn('ophciexamination_workflow_rule_version','value');
	}

	public function down()
	{
		$this->addColumn('ophciexamination_workflow_rule_version','parent_id','int(10) unsigned null');
		$this->addColumn('ophciexamination_workflow_rule_version','clause','varchar(255) DEFAULT NULL');
		$this->addColumn('ophciexamination_workflow_rule_version','value','varchar(255) DEFAULT NULL');

		$this->dropForeignKey('acv_ophciexamination_workflow_rule_episode_status_id_fk','ophciexamination_workflow_rule_version');
		$this->dropForeignKey('acv_ophciexamination_workflow_rule_subspecialty_id_fk','ophciexamination_workflow_rule_version');

		$this->dropIndex('acv_ophciexamination_workflow_rule_episode_status_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('acv_ophciexamination_workflow_rule_subspecialty_id_fk','ophciexamination_workflow_rule_version');

		$this->dropColumn('ophciexamination_workflow_rule_version','subspecialty_id');
		$this->dropColumn('ophciexamination_workflow_rule_version','episode_status_id');

		$this->addForeignKey('acv_ophciexamination_workflow_rule_parent_id_fk','ophciexamination_workflow_rule_version','parent_id','ophciexamination_workflow_rule_version','id');
	}
}
