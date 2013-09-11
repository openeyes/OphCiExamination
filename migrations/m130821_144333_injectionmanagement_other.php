<?php

class m130821_144333_injectionmanagement_other extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_injectionmanagementcomplex', 'no_treatment_reason_other', 'text');
		$this->addColumn('ophciexamination_injectmanagecomplex_notreatmentreason', 'other', 'boolean NOT NULL DEFAULT false');
		$this->update('ophciexamination_injectmanagecomplex_notreatmentreason', array('other' => true), 'name = :nm', array(':nm' => 'Other'));

	}

	public function down()
	{
		$this->dropColumn('ophciexamination_injectmanagecomplex_notreatmentreason', 'other');
		$this->dropColumn('et_ophciexamination_injectionmanagementcomplex', 'no_treatment_reason_other');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}