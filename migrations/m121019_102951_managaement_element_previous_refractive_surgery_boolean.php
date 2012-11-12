<?php

class m121019_102951_managaement_element_previous_refractive_surgery_boolean extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_management','previous_refractive_surgery','tinyint(1) unsigned not null default 0');
		$this->alterColumn('et_ophciexamination_management','previous_refractive_surgery','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_management','previous_refractive_surgery');
	}
}
