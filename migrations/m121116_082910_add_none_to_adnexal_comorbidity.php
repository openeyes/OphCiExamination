<?php

class m121116_082910_add_none_to_adnexal_comorbidity extends CDbMigration
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
