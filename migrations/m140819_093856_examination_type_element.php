<?php

class m140819_093856_examination_type_element extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphCiExamination"))->queryRow();

		$this->insert('element_type',array(
			'event_type_id' => $et['id'],
			'name' => 'Examination type',
			'class_name' => 'OEModule\\OphCiExamination\\models\\Element_OphCiExamination_Type',
			'display_order' => 9,
			'default' => 0,
			'active' => 0,
		));

		$this->createTable('ophciexamination_exam_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) not null',
				'display_order' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_exam_type_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_exam_type_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_exam_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_exam_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophciexamination_exam_type');

		$this->createTable('et_ophciexamination_type', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'type_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_type_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_type_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_type_ev_fk` (`event_id`)',
				'KEY `et_ophciexamination_type_ty_fk` (`type_id`)',
				'CONSTRAINT `et_ophciexamination_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_type_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_type_ty_fk` FOREIGN KEY (`type_id`) REFERENCES `ophciexamination_exam_type` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophciexamination_type');
	}

	public function down()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = :cn",array(":cn" => "OphCiExamination"))->queryRow();

		$this->dropTable('et_ophciexamination_type_version');
		$this->dropTable('et_ophciexamination_type');

		$this->dropTable('ophciexamination_exam_type_version');
		$this->dropTable('ophciexamination_exam_type');

		$this->delete('element_type',"event_type_id = {$et['id']} and class_name = 'OEModule\\\\OphCiExamination\\\\models\\\\Element_OphCiExamination_Type'");
	}
}
