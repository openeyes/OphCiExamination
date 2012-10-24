<?php

class m121024_134239_attribute_options extends OEMigration
{
	public function up()
	{
		$this->delete('ophciexamination_attribute_option');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
	}
}
