<?php

class m121212_155342_cataractmanagement extends CDbMigration
{
	public function up()
	{
		
		$this->renameTable('ophciexamination_management_suitable_for_surgeon','ophciexamination_cataractmanagement_suitable_for_surgeon');
		
		$this->dropForeignKey('et_ophciexamination_management_created_user_id_fk','et_ophciexamination_management');
		$this->dropForeignKey('et_ophciexamination_management_event_id_fk','et_ophciexamination_management');
		$this->dropForeignKey('et_ophciexamination_management_last_modified_user_id_fk','et_ophciexamination_management');
		$this->dropForeignKey('et_ophciexamination_management_suitable_for_surgeon_id_fk','et_ophciexamination_management');
		$this->renameTable('et_ophciexamination_management','et_ophciexamination_cataractmanagement');
		$this->addForeignKey('et_ophciexamination_catmanagement_created_user_id_fk','et_ophciexamination_cataractmanagement', 'created_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_catmanagement_event_id_fk','et_ophciexamination_cataractmanagement', 'event_id', 'event', 'id');
		$this->addForeignKey('et_ophciexamination_catmanagement_last_modified_user_id_fk','et_ophciexamination_cataractmanagement', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_catmanagement_suitable_for_surgeon_id_fk','et_ophciexamination_cataractmanagement', 'suitable_for_surgeon_id', 'ophciexamination_cataractmanagement_suitable_for_surgeon', 'id');
		
		$this->update('element_type', array('class_name'=>'Element_OphCiExamination_CataractManagement', 'name'=> 'Cataract Management'), 'class_name = :orig_class', array(':orig_class' => 'Element_OphCiExamination_Management'));
	}

	public function down()
	{
		$this->update('element_type', array('class_name'=>'Element_OphCiExamination_Management', 'name'=> 'Management'), 'class_name = :orig_class', array(':orig_class' => 'Element_OphCiExamination_CataractManagement'));
	
		$this->renameTable('ophciexamination_cataractmanagement_suitable_for_surgeon','ophciexamination_management_suitable_for_surgeon');
		
		$this->dropForeignKey('et_ophciexamination_catmanagement_created_user_id_fk','et_ophciexamination_cataractmanagement');
		$this->dropForeignKey('et_ophciexamination_catmanagement_event_id_fk','et_ophciexamination_cataractmanagement');
		$this->dropForeignKey('et_ophciexamination_catmanagement_last_modified_user_id_fk','et_ophciexamination_cataractmanagement');
		$this->dropForeignKey('et_ophciexamination_catmanagement_suitable_for_surgeon_id_fk','et_ophciexamination_cataractmanagement');
		$this->renameTable('et_ophciexamination_cataractmanagement','et_ophciexamination_management');
		$this->addForeignKey('et_ophciexamination_management_created_user_id_fk','et_ophciexamination_management', 'created_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_management_event_id_fk','et_ophciexamination_management', 'event_id', 'event', 'id');
		$this->addForeignKey('et_ophciexamination_management_last_modified_user_id_fk','et_ophciexamination_management', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_management_suitable_for_surgeon_id_fk','et_ophciexamination_management', 'suitable_for_surgeon_id', 'ophciexamination_management_suitable_for_surgeon', 'id');
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