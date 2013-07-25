<?php

class m130725_075406_dr_function_3 extends CDbMigration
{
	public function up()
	{
		$this->update('ophciexamination_drgrading_nscmaculopathy', array('name' => 'M1A', 'display_order' => 3), 'name = :cname', array(':cname' => 'M1'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M1S', 'display_order' => '2', 'class' =>'moderate', 'description' => 'Stable maculopathy needs no further treatment'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'U', 'display_order' => '4', 'class' =>'ungradable', 'description' => 'Ungradable/unobtainable'));
	}

	public function down()
	{
		$this->delete('ophciexamination_drgrading_nscmaculopathy', "name = 'M1S'");
		$this->delete('ophciexamination_drgrading_nscmaculopathy', "name = 'U'");
		$this->update('ophciexamination_drgrading_nscmaculopathy', array('name' => 'M1', 'display_order' => 2), 'name = :cname', array(':cname' => 'M1A'));
		
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}