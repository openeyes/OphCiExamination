<?php

class m121108_125109_add_radio_boolean_for_previous_refractive_surgery extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_history','previous_refractive_surgery','tinyint(1) unsigned NOT NULL');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_history','previous_refractive_surgery');
	}
}
