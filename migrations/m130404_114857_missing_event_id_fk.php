<?php

class m130404_114857_missing_event_id_fk extends CDbMigration
{
	public function up()
	{
		$this->createIndex('et_ophciexamination_clinicoutcome_event_id_fk','et_ophciexamination_clinicoutcome','event_id');
		$this->addForeignKey('et_ophciexamination_clinicoutcome_event_id_fk','et_ophciexamination_clinicoutcome','event_id','event','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_clinicoutcome_event_id_fk','et_ophciexamination_clinicoutcome');
		$this->dropIndex('et_ophciexamination_clinicoutcome_event_id_fk','et_ophciexamination_clinicoutcome');
	}
}
