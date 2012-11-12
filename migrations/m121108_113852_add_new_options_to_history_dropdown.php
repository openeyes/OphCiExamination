<?php

class m121108_113852_add_new_options_to_history_dropdown extends OEMigration
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
