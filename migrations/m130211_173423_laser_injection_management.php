<?php

class m130211_173423_laser_injection_management extends CDbMigration
{
	public function up()
	{
		// additional management lookup tables
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
		
		// end of lookup tables
		
		// examination event id
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();
		
		// medical retinal default elements set
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		
		// laser management element type
		$this->createTable('et_ophciexamination_lasermanagement', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'laser_status_id' => 'int(10) unsigned NOT NULL',
				'laser_deferralreason_id' => 'int(10) unsigned',
				'laser_deferralreason_other' => 'text',
				'comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_lasermanagement_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_lasermanagement_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_lasermanagement_laser_fk` (`laser_status_id`)',
				'KEY `et_ophciexamination_lasermanagement_ldeferral_fk` (`laser_deferralreason_id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_laser_fk` FOREIGN KEY (`laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_ldeferral_fk` FOREIGN KEY (`laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type', array(
				'name' => 'Management',
				'class_name' => 'Element_OphCiExamination_LaserManagement',
				'event_type_id' => $event_type_id,
				'display_order' => 91,
				'default' => 1,
		));
		
		$lmgmt_id = $this->dbConnection->lastInsertID;
		
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$mr_set_id, 'element_type_id' => $lmgmt_id));
		// end laser management element type
		
		// injection management element type
		$this->createTable('et_ophciexamination_injectionmanagement', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'injection_status_id' => 'int(10) unsigned NOT NULL',
				'injection_deferralreason_id' => 'int(10) unsigned',
				'injection_deferralreason_other' => 'text',
				'comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_injectionmanagement_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_injectionmanagement_cui_fk` (`created_user_id`)',
		
				'KEY `et_ophciexamination_injectionmanagement_injection_fk` (`injection_status_id`)',
				'KEY `et_ophciexamination_injectionmanagement_ideferral_fk` (`injection_deferralreason_id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_injection_fk` FOREIGN KEY (`injection_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_ideferral_fk` FOREIGN KEY (`injection_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type', array(
				'name' => 'Management',
				'class_name' => 'Element_OphCiExamination_InjectionManagement',
				'event_type_id' => $event_type_id,
				'display_order' => 92,
				'default' => 1,
		));
		
		$imgmt_id = $this->dbConnection->lastInsertID;
		
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$mr_set_id, 'element_type_id' => $imgmt_id));
		
		// end injection setup
		
	}

	public function down()
	{
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		
		// laser
		$this->dropTable('et_ophciexamination_lasermanagement');
		
		$lmgmt_id = $this->dbConnection->createCommand()
			->select('id')
			->from('element_type')
			->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_LaserManagement'))
			->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$mr_set_id, ':element_type_id' => $lmgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$lmgmt_id));
		
		// injection
		$this->dropTable('et_ophciexamination_injectionmanagement');
		
		$imgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_InjectionManagement'))
		->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$mr_set_id, ':element_type_id' => $imgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$imgmt_id));
		
		// lookups
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