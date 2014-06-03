<?php

class m140213_105046_cataract_target_accuracy extends CDbMigration
{
	public function up()
	{
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement', 'target_postop_refraction', 'decimal(5,2)');
	}

	public function down()
	{
		echo "WARNING: this will reduce accuracy of any records stored since this migration was initially run!";
		$this->alterColumn('et_ophciexamination_cataractsurgicalmanagement', 'target_postop_refraction', 'decimal(5,1)');
	}
}
