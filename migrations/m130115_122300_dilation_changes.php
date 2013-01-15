<?php

class m130115_122300_dilation_changes extends OEMigration {
	
	public function up() {

		$this->addColumn('et_ophciexamination_dilation', 'left_time', 'time NOT NULL');
		$this->addColumn('et_ophciexamination_dilation', 'right_time', 'time NOT NULL');
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		$this->alterColumn('et_ophciexamination_dilation','eye_id','int(10) unsigned NOT NULL DEFAULT '.$both_eyes_id);

		$this->createTable('ophciexamination_dilation_treatment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'side' => 'tinyint(1) unsigned NOT NULL',
				'drug_id' => 'int(10) unsigned NOT NULL',
				'drops' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_dilation_treatment_element_id_fk` (`element_id`)',
				'KEY `ophciexamination_dilation_treatment_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_dilation_treatment_created_user_id_fk` (`created_user_id`)',
				'KEY `ophciexamination_dilation_treatment_drug_id_fk` (`drug_id`)',
				'CONSTRAINT `ophciexamination_dilation_treatment_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_dilation` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_treatment_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_treatment_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_treatment_drug_id_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophciexamination_dilation_drugs` (`id`)'
		),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->dropTable('ophciexamination_dilation_drug');
		$this->dropTable('ophciexamination_dilation_side');
		
	}

	public function down() {
		// TODO: Recreate old tables
		$this->dropTable('ophciexamination_dilation_treatment');
		$this->dropColumn('et_ophciexamination_dilation', 'left_time');
		$this->dropColumn('et_ophciexamination_dilation', 'right_time');
		$this->alterColumn('et_ophciexamination_dilation','eye_id','int(10) unsigned NULL');
	}
	
}
