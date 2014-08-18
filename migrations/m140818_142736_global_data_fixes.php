<?php

class m140818_142736_global_data_fixes extends OEMigration
{
	public function safeUp()
	{
		$this->update('ophciexamination_instrument', array('name' => 'ORA IOPcc'), 'name = "ORA"');
	}

	public function safeDown()
	{
		echo "m140818_142736_global_data_fixes does not support migration down.\n";
		return false;
	}
}