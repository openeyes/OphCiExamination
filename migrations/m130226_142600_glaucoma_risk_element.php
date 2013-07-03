<?php

class m130226_142600_glaucoma_risk_element extends OEMigration {
	
	public function up() {
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$clinic_outcome_element_type_id = ElementType::model()->find('class_name = ?', array('Element_OphCiExamination_ClinicOutcome'))->id;
		
		$this->insert('element_type',array(
				'name' => 'Glaucoma Risk Stratification',
				'class_name' => 'Element_OphCiExamination_GlaucomaRisk',
				'event_type_id' => $event_type->id,
				'display_order' => 10,
				'parent_element_type_id' => $clinic_outcome_element_type_id,
				'default' => 0
		));
		$this->createTable('ophciexamination_glaucomarisk_risk', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(48) NOT NULL',
				'description' => 'text',
				'follow_up' => 'varchar(48)',
				'review' => 'varchar(48)',
				'display_order' => 'int(10) unsigned NOT NULL',
				'class' => 'varchar(16)',
				'PRIMARY KEY (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		
		$this->createTable('et_ophciexamination_glaucomarisk', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_glaucomarisk_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_glaucomarisk_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_glaucomarisk_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_glaucomarisk_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_glaucomarisk_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_glaucomarisk_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->addColumn('et_ophciexamination_glaucomarisk', 'risk_id', 'int(10) unsigned NOT NULL');

		$this->addForeignKey('et_ophciexamination_glaucomarisk_risk_id_fk', 'et_ophciexamination_glaucomarisk', 'risk_id', 'ophciexamination_glaucomarisk_risk', 'id');
	}

	public function down() {
		$this->dropTable('et_ophciexamination_glaucomarisk');
		$this->dropTable('ophciexamination_glaucomarisk_risk');
		$this->delete('element_type',"class_name='Element_OphCiExamination_GlaucomaRisk'");
	}
}
