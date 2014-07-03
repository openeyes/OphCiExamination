<?php

class m140611_065040_clinic_interval_discharge extends CDbMigration
{
	public function up()
	{
		$this->insert('ophciexamination_overallperiod',array('id'=>7,'name'=>'Discharge','display_order'=>7));
	}

	public function down()
	{
		$this->delete('ophciexamination_overallperiod','id=7');
	}
}
