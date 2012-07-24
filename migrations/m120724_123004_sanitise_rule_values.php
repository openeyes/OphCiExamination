<?php

class m120724_123004_sanitise_rule_values extends CDbMigration
{
	public function up()
	{
		$this->update('ophciexamination_element_set_rule',array('clause'=>'subspecialty_id'),'id=1');
		$this->update('ophciexamination_element_set_rule',array('clause'=>'status_id'),'id=2');
	}

	public function down()
	{
		$this->update('ophciexamination_element_set_rule',array('clause'=>'$subspecialty_id'),'id=1');
		$this->update('ophciexamination_element_set_rule',array('clause'=>'$status_id'),'id=2');
	}
}
