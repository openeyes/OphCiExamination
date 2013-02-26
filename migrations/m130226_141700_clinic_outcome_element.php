<?php

class m130226_141700_clinic_outcome_element extends CDbMigration {
	
	public function up() {
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->insert('element_type',array(
				'name' => 'Clinic Outcome',
				'class_name' => 'Element_OphCiExamination_ClinicOutcome',
				'event_type_id' => $event_type->id,
				'display_order' => 97,
				'default' => 1
		));
		$this->createTable('et_ophciexamination_clinicoutcome', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_clinicoutcome_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_clinicoutcome_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_clinicoutcome_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_clinicoutcome_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down() {
		$this->dropTable('et_ophciexamination_clinicoutcome');
		$this->delete('element_type',"class_name='Element_OphCiExamination_ClinicOutcome'");
	}
}
