<?php

class m130226_141700_clinic_outcome_element extends CDbMigration
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
				'name' => 'Clinic Outcome',
				'class_name' => 'Element_OphCiExamination_ClinicOutcome',
				'event_type_id' => $event_type_id,
				'display_order' => 97,
				'default' => 1
		));

		$this->createTable('ophciexamination_clinicoutcome_status', array(
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
				'KEY `ophciexamination_clinicoutcome_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_clinicoutcome_laser_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_clinicoutcome_episode_status_fk` (`episode_status_id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_episode_status_fk` FOREIGN KEY (`episode_status_id`) REFERENCES `episode_status` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophciexamination_clinicoutcome_status', array('id' => 1, 'name'=>'Follow-up', 'display_order' => '1', 'episode_status_id' => $fup->id, 'followup' => true));
		$this->insert('ophciexamination_clinicoutcome_status', array('id' => 2, 'name'=>'Discharge', 'display_order' => '2', 'episode_status_id' => $dcharg->id));

		$this->createTable('et_ophciexamination_clinicoutcome', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'status_id' => 'int(10) unsigned NOT NULL',
				'followup_quantity' => 'int(10) unsigned',
				'followup_period_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_clinicoutcome_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_clinicoutcome_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_clinicoutcome_status_fk` (`status_id`)',
				'KEY `et_ophciexamination_clinicoutcome_fup_p_fk` (`followup_period_id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_status_fk` FOREIGN KEY (`status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_fup_p_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

	}

	public function down()
	{
		$this->delete('element_type', 'class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_ClinicOutcome'));
		$this->dropTable('et_ophciexamination_clinicoutcome');
		$this->dropTable('ophciexamination_clinicoutcome_status');
	}
}
