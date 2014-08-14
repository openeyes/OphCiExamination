<?php

class m140813_152442_surgery_management extends OEMigration
{
	public function up()
	{
		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = 'OphCiExamination'")->queryRow();
		$el = $this->dbConnection->createCommand()->select("*")->from("element_type")->where("event_type_id = {$et['id']} and name = 'Clinical Management'")->queryRow();

		$this->insert('element_type',array(
			'name' => 'Surgery management',
			'class_name' => 'OEModule\OphCiExamination\models\Element_OphCiExamination_SurgeryManagement',
			'event_type_id' => $et['id'],
			'display_order' => 93,
			'default' => 0,
			'parent_element_type_id' => $el['id'],
			'required' => 0,
			'active' => 0,
		));

		$this->createTable('et_ophciexamination_surgeryman', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'biome_needed' => 'tinyint(1) unsigned not null',
				'lenses_needed' => 'tinyint(1) unsigned not null',
				'interop_laser_needed' => 'tinyint(1) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_surgeryman_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_surgeryman_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_surgeryman_ev_fk` (`event_id`)',
				'CONSTRAINT `et_ophciexamination_surgeryman_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_surgeryman_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_surgeryman_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('et_ophciexamination_surgeryman');

		$this->createTable('ophciexamination_surgeryman_procedure', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned not null',
				'procedure_id' => 'int(10) unsigned not null',
				'eye_id' => 'int(10) unsigned not null',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_surgeryman_procedure_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_surgeryman_procedure_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_surgeryman_procedure_ele_fk` (`element_id`)',
				'KEY `ophciexamination_surgeryman_procedure_pid_fk` (`procedure_id`)',
				'KEY `ophciexamination_surgeryman_procedure_eye_fk` (`eye_id`)',
				'CONSTRAINT `ophciexamination_surgeryman_procedure_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_surgeryman_procedure_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_surgeryman_procedure_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_surgeryman` (`id`)',
				'CONSTRAINT `ophciexamination_surgeryman_procedure_pid_fk` FOREIGN KEY (`procedure_id`) REFERENCES `proc` (`id`)',
				'CONSTRAINT `ophciexamination_surgeryman_procedure_eye_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci');

		$this->versionExistingTable('ophciexamination_surgeryman_procedure');
	}

	public function down()
	{
		$this->dropTable('ophciexamination_surgeryman_procedure_version');
		$this->dropTable('ophciexamination_surgeryman_procedure');

		$this->dropTable('et_ophciexamination_surgeryman_version');
		$this->dropTable('et_ophciexamination_surgeryman');

		$et = $this->dbConnection->createCommand()->select("*")->from("event_type")->where("class_name = 'OphCiExamination'")->queryRow();

		$this->delete('element_type',"event_type_id = {$et['id']} and name = 'Surgery Management'");
	}
}
