<?php

class m120925_122900_uat_changes extends OEMigration {

	public function up() {
		// Add other field to refraction types
		$this->addColumn('et_ophciexamination_refraction', 'left_type_other', 'varchar(100)');
		$this->addColumn('et_ophciexamination_refraction', 'right_type_other', 'varchar(100)');

		// Remove "Other" from refraction types and add "Own Glasses"
		$this->alterColumn('et_ophciexamination_refraction','left_type_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_refraction','right_type_id','int(10) unsigned');
		$other_id = OphCiExamination_Refraction_Type::model()->find("name = 'Other'")->id;
		$this->update('et_ophciexamination_refraction',array('left_type_id' => null), "left_type_id = $other_id");
		$this->update('et_ophciexamination_refraction',array('right_type_id' => null), "right_type_id = $other_id");
		$this->delete('ophciexamination_refraction_type', "id = $other_id");
		$this->insert('ophciexamination_refraction_type', array('name' => 'Own Glasses', 'display_order' => 4));

		// Multiple visual acuity readings
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_initial');
		$this->dropForeignKey('et_ophciexamination_visualacuity_lcri_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_wearing_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_corrected');
		$this->dropForeignKey('et_ophciexamination_visualacuity_lmi_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_method_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_initial');
		$this->dropForeignKey('et_ophciexamination_visualacuity_rcri_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_wearing_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_corrected');
		$this->dropForeignKey('et_ophciexamination_visualacuity_rmi_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_method_id');
		$this->dropTable('ophciexamination_visualacuity_wearing');
		$this->createTable('ophciexamination_visualacuity_reading',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'value' => 'int(10) unsigned NOT NULL',
				'method_id' => 'int(10) unsigned NOT NULL',
				'side' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_reading_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_visualacuity` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_reading_method_id_fk` FOREIGN KEY (`method_id`) REFERENCES `ophciexamination_visualacuity_method` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_reading_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_reading_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->delete('ophciexamination_visualacuity_method');

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {
		$this->delete('ophciexamination_refraction_type', "name = 'Own Glasses'");
		$this->insert('ophciexamination_refraction_type', array('name' => 'Other', 'display_order' => 4));
		$this->dropColumn('et_ophciexamination_refraction', 'left_type_other');
		$this->dropColumn('et_ophciexamination_refraction', 'right_type_other');

		$this->dropTable('ophciexamination_visualacuity_reading');
		$this->createTable('ophciexamination_visualacuity_wearing',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(32) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_visualacuity_wearing_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_visualacuity_wearing_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_visualacuity_wearing_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_wearing_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->addColumn('et_ophciexamination_visualacuity', 'left_initial', 'int(10) unsigned NOT NULL');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_wearing_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_lcri_fk','et_ophciexamination_visualacuity','left_wearing_id','ophciexamination_visualacuity_wearing','id');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_corrected', 'int(10) unsigned NOT NULL');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_method_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_lmi_fk','et_ophciexamination_visualacuity','left_method_id','ophciexamination_visualacuity_method','id');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_initial', 'int(10) unsigned NOT NULL');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_wearing_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_rcri_fk','et_ophciexamination_visualacuity','right_wearing_id','ophciexamination_visualacuity_wearing','id');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_corrected', 'int(10) unsigned NOT NULL');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_method_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_rmi_fk','et_ophciexamination_visualacuity','right_method_id','ophciexamination_visualacuity_method','id');

	}
}
