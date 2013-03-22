<?php

class m130215_132333_vitrectomised_eye_field extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_cataractmanagement','vitrectomised_eye','tinyint(1) unsigned NOT NULL DEFAULT 0');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_cataractmanagement','vitrectomised_eye');
	}
}
