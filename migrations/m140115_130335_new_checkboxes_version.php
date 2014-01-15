<?php

class m140115_130335_new_checkboxes_version extends CDbMigration
{
	public function up()
	{
		$this->addColumn('et_ophciexamination_visualacuity_version','left_unable_to_assess','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_visualacuity_version','right_unable_to_assess','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_visualacuity_version','left_eye_missing','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_visualacuity_version','right_eye_missing','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('et_ophciexamination_visualacuity_version','left_unable_to_assess');
		$this->dropColumn('et_ophciexamination_visualacuity_version','right_unable_to_assess');
		$this->dropColumn('et_ophciexamination_visualacuity_version','left_eye_missing');
		$this->dropColumn('et_ophciexamination_visualacuity_version','right_eye_missing');
	}
}
