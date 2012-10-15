<?php

class m121015_123351_add_consultant_to_suitable_dropdown_in_management_element extends CDbMigration
{
	public function up()
	{
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>2),'id=1');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>3),'id=2');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>4),'id=3');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>5),'id=4');

		$this->insert('ophciexamination_management_suitable_for_surgeon',array('name'=>'Consultant','display_order'=>1));
	}

	public function down()
	{
		$this->delete('ophciexamination_management_suitable_for_surgeon',"name='Consultant'");

		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>1),'id=1');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>2),'id=2');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>3),'id=3');
		$this->update('ophciexamination_management_suitable_for_surgeon',array('display_order'=>4),'id=4');
	}
}
