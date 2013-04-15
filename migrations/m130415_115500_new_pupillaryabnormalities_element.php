<?php

class m130415_115500_new_pupillaryabnormalities_element extends OEMigration {
	
	public function up() {
		$this->createTable('ophciexamination_pupillaryabnormalities_abnormality', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255) NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_pupillaryabnormalities_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_pupillaryabnormalities_cui_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormalities_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormalities_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->insert('element_type', array(
				'name' => 'Pupillary Abnormalities',
				'class_name' => 'Element_OphCiExamination_PupillaryAbnormalities',
				'event_type_id' => $event_type->id,
				'display_order' => 63,
				'default' => 0
		));
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		$this->createTable('et_ophciexamination_pupillaryabnormalities', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT '.$both_eyes_id,
				'left_abnormality_id' => 'int(10) unsigned',
				'right_abnormality_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_pupillaryabnormal_ei_fk` (`event_id`)',
				'KEY `et_ophciexamination_pupillaryabnormal_lmi_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_pupillaryabnormal_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_pupillaryabnormal_lai_fk` (`left_abnormality_id`)',
				'KEY `et_ophciexamination_pupillaryabnormal_rai_fk` (`right_abnormality_id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormal_ei_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormal_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormal_lmi_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormal_lai_fk` FOREIGN KEY (`left_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`)',
				'CONSTRAINT `et_ophciexamination_pupillaryabnormal_rai_fk` FOREIGN KEY (`right_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down() {
		$this->dropTable('et_ophciexamination_pupillaryabnormalities');
		$this->delete('element_type', "class_name = 'Element_OphCiExamination_PupillaryAbnormalities'");
		$this->dropTable('ophciexamination_pupillaryabnormalities_abnormality');
	}
	
}
