<?php

class m121210_084931_dilation_element extends OEMigration
{
	public function up()
	{
		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$this->insert('element_type',array(
				'name' => 'Dilation',
				'class_name' => 'Element_OphCiExamination_Dilation',
				'event_type_id' => $event_type['id'],
				'display_order' => 65,
				'default' => 1,
		));

		$this->createTable('et_ophciexamination_dilation', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_dilation_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_dilation_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_dilation_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_dilation_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_dilation_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_dilation_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_dilation_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_dilation_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->createTable('ophciexamination_dilation_side', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'time' => 'time NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_dilation_side_element_id_fk` (`element_id`)',
				'KEY `ophciexamination_dilation_side_eye_id_fk` (`eye_id`)',
				'KEY `ophciexamination_dilation_side_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_dilation_side_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_dilation_side_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_dilation` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_side_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_side_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_side_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->createTable('ophciexamination_dilation_drugs', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin',
				'display_order' => 'tinyint(3) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_dilation_drugs_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_dilation_drugs_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_dilation_drugs_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_drugs_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->createTable('ophciexamination_dilation_drug', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'side_id' => 'int(10) unsigned NOT NULL',
				'drug_id' => 'int(10) unsigned NOT NULL',
				'drops' => 'tinyint(1) unsigned NOT NULL DEFAULT 1',
				'display_order' => 'tinyint(3) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_dilation_drug_side_id_fk` (`side_id`)',
				'KEY `ophciexamination_dilation_drug_drug_id_fk` (`drug_id`)',
				'KEY `ophciexamination_dilation_drug_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_dilation_drug_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_dilation_drug_side_id_fk` FOREIGN KEY (`side_id`) REFERENCES `ophciexamination_dilation_side` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_drug_drug_id_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophciexamination_dilation_drugs` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_drug_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_dilation_drug_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->initialiseData(dirname(__FILE__));
	}

	public function down()
	{
		$this->dropTable('ophciexamination_dilation_drug');
		$this->dropTable('ophciexamination_dilation_drugs');
		$this->dropTable('ophciexamination_dilation_side');
		$this->dropTable('et_ophciexamination_dilation');

		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$this->delete('element_type',"event_type_id = {$event_type['id']} and class_name = 'Element_OphCiExamination_Dilation'");
	}
}
