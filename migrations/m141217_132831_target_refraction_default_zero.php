<?php

class m141217_132831_target_refraction_default_zero extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement','target_postop_refraction','decimal(5,2) DEFAULT 0');
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement_version','target_postop_refraction','decimal(5,2) DEFAULT 0');
	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement','target_postop_refraction','decimal(5,2) DEFAULT NULL');
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement_version','target_postop_refraction','decimal(5,2) DEFAULT NULL');
	}
}
