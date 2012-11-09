<?php

class m121109_084419_management_surgeon_id_should_be_nullable extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_management','suitable_for_surgeon_id','int(10) unsigned NULL');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_management','suitable_for_surgeon_id');
	}
}
