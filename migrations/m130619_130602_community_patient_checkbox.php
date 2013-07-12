<?php

class m130619_130602_community_patient_checkbox extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_clinicoutcome','community_patient','tinyint(1) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_clinicoutcome','community_patient');
	}
}
