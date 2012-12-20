<?php

class m121212_173423_new_management extends CDbMigration
{
	public function up()
	{
		
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();
		
		$this->insert('element_type', array(
				'name' => 'Management',
				'class_name' => 'Element_OphCiExamination_Management',
				'event_type_id' => $event_type_id,
				'display_order' => 91,
				'default' => 1,
		));
		
		$mgmt_id = $this->dbConnection->lastInsertID;
		
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$mr_set_id, 'element_type_id' => $mgmt_id));
		
		$this->createTable('ophciexamination_management_status', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'deferred' => 'boolean NOT NULL DEFAULT false',
				'book' => 'boolean NOT NULL DEFAULT false',
				'event' => 'boolean NOT NULL DEFAULT false',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_management_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_management_laser_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_management_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_management_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_management_status', array('name'=>'Not Required', 'display_order' => '1'));
		$this->insert('ophciexamination_management_status', array('name'=>'Deferred', 'display_order' => '2', 'deferred' => true));
		$this->insert('ophciexamination_management_status', array('name'=>'Booked for a future date', 'display_order' => '3', 'book' => true));
		$this->insert('ophciexamination_management_status', array('name'=>'Performed today', 'display_order' => '4', 'event' => true));
		
		$this->createTable('ophciexamination_management_deferralreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'other' => 'boolean NOT NULL DEFAULT false',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_management_ldeferral_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_management_ldeferral_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_management_ldeferral_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_management_ldeferral_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Cataract', 'display_order' => '1'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Retinal detachment', 'display_order' => '2'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Vitreous haemorrhage', 'display_order' => '3'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Patient choice', 'display_order' => '4'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Other', 'display_order' => '5', 'other' => true));
		
		$this->createTable('et_ophciexamination_management', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'laser_status_id' => 'int(10) unsigned NOT NULL',
				'laser_deferralreason_id' => 'int(10) unsigned',
				'laser_deferralreason_other' => 'text',
				'injection_status_id' => 'int(10) unsigned NOT NULL',
				'injection_deferralreason_id' => 'int(10) unsigned',
				'injection_deferralreason_other' => 'text',
				'comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_management_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_management_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_management_laser_fk` (`laser_status_id`)',
				'KEY `et_ophciexamination_management_ldeferral_fk` (`laser_deferralreason_id`)',
				'KEY `et_ophciexamination_management_injection_fk` (`injection_status_id`)',
				'KEY `et_ophciexamination_management_ideferral_fk` (`injection_deferralreason_id`)',
				'CONSTRAINT `et_ophciexamination_management_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_laser_fk` FOREIGN KEY (`laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_ldeferral_fk` FOREIGN KEY (`laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_injection_fk` FOREIGN KEY (`injection_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_ideferral_fk` FOREIGN KEY (`injection_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
	}

	public function down()
	{
		$mgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_Management'))
		->queryScalar();
		
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$mr_set_id, ':element_type_id' => $mgmt_id));
		$this->delete('element_type', 'class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_Management'));
		
		$this->dropTable('et_ophciexamination_management');
		$this->dropTable('ophciexamination_management_status');
		$this->dropTable('ophciexamination_management_deferralreason');
		
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