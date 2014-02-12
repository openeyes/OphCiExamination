<?php

class m140212_142912_workflow_rule_firm_id extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_workflow_rule_version','firm_id','int(10) unsigned null');
		$this->addForeignKey('ophciexamination_workflow_rule_version_firm_id_fk','ophciexamination_workflow_rule_version','firm_id','firm','id');
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_workflow_rule_version_firm_id_fk','ophciexamination_workflow_rule_version');
		$this->dropIndex('ophciexamination_workflow_rule_version_firm_id_fk','ophciexamination_workflow_rule_version');
		$this->dropColumn('ophciexamination_workflow_rule_version','firm_id');
	}
}
