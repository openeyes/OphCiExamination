<?php

class m130114_094914_dilation_element_eye_id_null extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_dilation','eye_id','int(10) unsigned NULL');
	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_dilation','eye_id','int(10) unsigned NOT NULL');
	}
}
