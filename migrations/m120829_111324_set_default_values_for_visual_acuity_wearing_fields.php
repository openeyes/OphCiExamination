<?php

class m120829_111324_set_default_values_for_visual_acuity_wearing_fields extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_visualacuity','left_wearing_id',"int(10) unsigned NOT NULL DEFAULT '1'");
		$this->alterColumn('et_ophciexamination_visualacuity','right_wearing_id',"int(10) unsigned NOT NULL DEFAULT '1'");
	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_visualacuity','left_wearing_id',"int(10) unsigned NOT NULL");
		$this->alterColumn('et_ophciexamination_visualacuity','right_wearing_id',"int(10) unsigned NOT NULL");
	}
}
