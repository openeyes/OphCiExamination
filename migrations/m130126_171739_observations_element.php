<?php

class m130126_171739_observations_element extends CDbMigration
{
	public function up()
	{
		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$this->insert('element_type',array(
				'name' => 'Observations',
				'class_name' => 'Element_OphCiExamination_Observations',
				'event_type_id' => $event_type['id'],
				'display_order' => 12,
				'default' => 1,
		));

		$this->createTable('ophciexamination_observations_pulse', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_observations_pulse_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_observations_pulse_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_observations_pulse_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_observations_pulse_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_observations_pulse',array('name'=>'Regular','display_order'=>1));
		$this->insert('ophciexamination_observations_pulse',array('name'=>'Irregular','display_order'=>2));
		$this->insert('ophciexamination_observations_pulse',array('name'=>'None','display_order'=>3));

		$this->createTable('et_ophciexamination_observations', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'pulse_bpm' => 'tinyint(1) unsigned NOT NULL',
				'pulse_radial_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'pulse_pedial_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'pressure_systolic' => 'int(10) unsigned NOT NULL',
				'pressure_diastolic' => 'int(10) unsigned NOT NULL',
				'respiratory_rate' => 'int(10) unsigned NOT NULL',
				'saturation' => 'int(10) unsigned NOT NULL',
				'temperature' => 'float NOT NULL',
				'jvp_raised' => 'tinyint(1) unsigned NOT NULL',
				'jvp_cm' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_obs_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_obs_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_obs_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_obs_pulse_radial_id_fk` (`pulse_radial_id`)',
				'KEY `et_ophciexamination_obs_pulse_pedial_id_fk` (`pulse_pedial_id`)',
				'CONSTRAINT `et_ophciexamination_obs_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_obs_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_obs_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_obs_pulse_radial_id_fk` FOREIGN KEY (`pulse_radial_id`) REFERENCES `ophciexamination_observations_pulse` (`id`)',
				'CONSTRAINT `et_ophciexamination_obs_pulse_pedial_id` FOREIGN KEY (`pulse_pedial_id`) REFERENCES `ophciexamination_observations_pulse` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_observations');
		$this->dropTable('ophciexamination_observations_pulse');

		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$this->delete('element_type',"event_type_id = {$event_type['id']} and class_name = 'Element_OphCiExamination_Observations'");
	}
}
