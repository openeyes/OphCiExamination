<?php

class m140818_143656_patient_program_selection_criteria_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphCiExamination"))->queryRow();

		$this->insert('element_type',array(
			'event_type_id' => $et['id'],
			'name' => 'Program selection criteria',
			'class_name' => 'OEModule\\OphCiExamination\\models\\Element_OphCiExamination_SelectionCriteria',
			'display_order' => 96,
			'default' => 0,
			'required' => 0,
			'active' => 0,
		));

		$this->createTable('ophciexamination_selectioncriteria_blindness', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_selectioncriteria_blindness_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_selectioncriteria_blindness_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_blindness_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_blindness_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophciexamination_selectioncriteria_blindness');

		$this->createTable('ophciexamination_selectioncriteria_age', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_selectioncriteria_age_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_selectioncriteria_age_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_age_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_age_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophciexamination_selectioncriteria_age');

		$this->createTable('ophciexamination_selectioncriteria_prognosis', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_selectioncriteria_prognosis_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_selectioncriteria_prognosis_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_prognosis_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_selectioncriteria_prognosis_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophciexamination_selectioncriteria_prognosis');

		$this->createTable('et_ophciexamination_selectioncriteria', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'blindness_id' => 'int(10) unsigned not null',
				'age_id' => 'int(10) unsigned not null',
				'vip' => 'tinyint(1) unsigned not null',
				'prognosis_id' => 'int(10) unsigned not null',
				'suitable_teaching_case' => 'tinyint(1) unsigned not null',
				'request_special_consideration' => 'tinyint(1) unsigned not null',
				'comments' => 'varchar(4096) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_selectioncriteria_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_selectioncriteria_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_selectioncriteria_ev_fk` (`event_id`)',
				'KEY `et_ophciexamination_selectioncriteria_bi_fk` (`blindness_id`)',
				'KEY `et_ophciexamination_selectioncriteria_ai_fk` (`age_id`)',
				'KEY `et_ophciexamination_selectioncriteria_pi_fk` (`prognosis_id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_bi_fk` FOREIGN KEY (`blindness_id`) REFERENCES `ophciexamination_selectioncriteria_blindness` (`id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_ai_fk` FOREIGN KEY (`age_id`) REFERENCES `ophciexamination_selectioncriteria_age` (`id`)',
				'CONSTRAINT `et_ophciexamination_selectioncriteria_pi_fk` FOREIGN KEY (`prognosis_id`) REFERENCES `ophciexamination_selectioncriteria_prognosis` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophciexamination_selectioncriteria');

		$this->initialiseData(dirname(__FILE__));
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_selectioncriteria_version');
		$this->dropTable('et_ophciexamination_selectioncriteria');

		$this->dropTable('ophciexamination_selectioncriteria_prognosis_version');
		$this->dropTable('ophciexamination_selectioncriteria_prognosis');

		$this->dropTable('ophciexamination_selectioncriteria_age_version');
		$this->dropTable('ophciexamination_selectioncriteria_age');

		$this->dropTable('ophciexamination_selectioncriteria_blindness_version');
		$this->dropTable('ophciexamination_selectioncriteria_blindness');

		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphCiExamination"))->queryRow();

		$this->delete('element_type',"event_type_id = {$et['id']} and class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_SelectionCriteria'");
	}
}
