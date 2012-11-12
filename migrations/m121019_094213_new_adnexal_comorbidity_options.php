<?php

class m121019_094213_new_adnexal_comorbidity_options extends OEMigration
{
	public function up()
	{
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
	}
}
