<?php

class m121217_152021_create_outcome_element extends CDbMigration
{
	public function up()
	{
		$fup = EpisodeStatus::model()->find('name = :name', array(':name'=>'Follow-up'));
		$dcharg = EpisodeStatus::model()->find('name = :name', array('name'=>'Discharged'));
		
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();
		
		$this->insert('element_type', array(
				'name' => 'Outcome',
				'class_name' => 'Element_OphCiExamination_Outcome',
				'event_type_id' => $event_type_id,
				'display_order' => 92,
		));
		
		$out_id = $this->dbConnection->lastInsertID;
		
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$mr_set_id, 'element_type_id' => $out_id));
		
		$this->createTable('ophciexamination_outcome_laser', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'followup' => 'boolean NOT NULL DEFAULT false',
				'episode_status_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_outcome_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_outcome_laser_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_outcome_episode_status_fk` (`episode_status_id`)',
				'CONSTRAINT `ophciexamination_outcome_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_outcome_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_outcome_episode_status_fk` FOREIGN KEY (`episode_status_id`) REFERENCES `episode_status` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_outcome_laser', array('name'=>'Follow-up', 'display_order' => '1', 'episode_status_id' => $fup->id, 'followup' => true));
		$this->insert('ophciexamination_outcome_laser', array('name'=>'Discharge', 'display_order' => '2', 'episode_status_id' => $dcharg->id));
		
		$this->createTable('et_ophciexamination_outcome', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'laser_id' => 'int(10) unsigned NOT NULL',
				'followup_quantity' => 'int(10) unsigned',
				'followup_period_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_outcome_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_outcome_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_outcome_laser_fk` (`laser_id`)',
				'KEY `et_ophciexamination_outcome_fup_p_fk` (`followup_period_id`)',
				'CONSTRAINT `et_ophciexamination_outcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_outcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_outcome_laser_fk` FOREIGN KEY (`laser_id`) REFERENCES `ophciexamination_outcome_laser` (`id`)',
				'CONSTRAINT `et_ophciexamination_outcome_fup_p_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
	}

	public function down()
	{
		$out_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_Management'))
		->queryScalar();
		
		$mr_set_id = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryScalar();
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$mr_set_id, ':element_type_id' => $out_id));
		
		$this->delete('element_type', 'class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_Outcome'));
		
		$this->dropTable('et_ophciexamination_outcome');
		$this->dropTable('ophciexamination_outcome_laser');
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