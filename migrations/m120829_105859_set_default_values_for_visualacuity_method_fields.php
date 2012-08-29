<?php

class m120829_105859_set_default_values_for_visualacuity_method_fields extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_visualacuity','left_method_id',"int(10) unsigned NOT NULL DEFAULT '1'");
		$this->alterColumn('et_ophciexamination_visualacuity','right_method_id',"int(10) unsigned NOT NULL DEFAULT '1'");
	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_visualacuity','left_method_id',"int(10) unsigned NOT NULL DEFAULT '5'");
		$this->alterColumn('et_ophciexamination_visualacuity','right_method_id',"int(10) unsigned NOT NULL DEFAULT '5'");
	}
}
