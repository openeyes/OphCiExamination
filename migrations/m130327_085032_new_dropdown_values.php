<?php

class m130327_085032_new_dropdown_values extends OEMigration
{
	public function up()
	{
		$this->delete('ophciexamination_attribute_option');
		$this->initialiseData(dirname(__FILE__));
	}

	public function down()
	{
	}
}
