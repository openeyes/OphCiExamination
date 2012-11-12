<?php

class m121030_145511_none_value_for_adnexal_comorbidity extends OEMigration
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
