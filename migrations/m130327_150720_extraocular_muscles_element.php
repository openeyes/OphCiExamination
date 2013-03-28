<?php

class m130327_150720_extraocular_muscles_element extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->insert('element_type',array(
			'name' => 'Extraocular Muscles',
			'class_name' => 'Element_OphCiExamination_ExtraocularMuscles',
			'event_type_id' => $event_type->id,
			'display_order' => 32,
			'default' => 0,
		));

		$this->createTable('ophciexamination_extraocular_muscles_eom', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_extraocular_muscles_eom_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_extraocular_muscles_eom_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_eom_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_eom_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_extraocular_muscles_eom',array('name'=>'Full','display_order'=>1));
		$this->insert('ophciexamination_extraocular_muscles_eom',array('name'=>'LR palsy','display_order'=>2));
		$this->insert('ophciexamination_extraocular_muscles_eom',array('name'=>'MR palsy','display_order'=>3));
		$this->insert('ophciexamination_extraocular_muscles_eom',array('name'=>'SO palsy','display_order'=>4));

		$this->createTable('ophciexamination_extraocular_muscles_ct_distance', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_extraocular_muscles_ct_distance_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_extraocular_muscles_ct_distance_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_ct_distance_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_ct_distance_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'O','display_order'=>1));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'E','display_order'=>2));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'ET','display_order'=>3));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'E(T)','display_order'=>4));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'(E)T','display_order'=>5));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'X','display_order'=>6));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'XT','display_order'=>7));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'X(T)','display_order'=>8));
		$this->insert('ophciexamination_extraocular_muscles_ct_distance',array('name'=>'(X)T','display_order'=>9));

		$this->createTable('ophciexamination_extraocular_muscles_ct_near', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_extraocular_muscles_ct_near_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_extraocular_muscles_ct_near_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_ct_near_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_extraocular_muscles_ct_near_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'O','display_order'=>1));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'E','display_order'=>2));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'ET','display_order'=>3));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'E(T)','display_order'=>4));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'(E)T','display_order'=>5));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'X','display_order'=>6));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'XT','display_order'=>7));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'X(T)','display_order'=>8));
		$this->insert('ophciexamination_extraocular_muscles_ct_near',array('name'=>'(X)T','display_order'=>9));

		$this->createTable('et_ophciexamination_extraocular_muscles', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'left_eom_id' => 'int(10) unsigned NOT NULL',
				'right_eom_id' => 'int(10) unsigned NOT NULL',
				'left_ct_distance_id' => 'int(10) unsigned NOT NULL',
				'right_ct_distance_id' => 'int(10) unsigned NOT NULL',
				'left_ct_near_id' => 'int(10) unsigned NOT NULL',
				'right_ct_near_id' => 'int(10) unsigned NOT NULL',
				'left_details' => 'text COLLATE utf8_bin',
				'right_details' => 'text COLLATE utf8_bin',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_extraocular_muscles_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_left_eom_id_fk` (`left_eom_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_right_eom_id_fk` (`right_eom_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_left_ct_distance_id_fk` (`left_ct_distance_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_right_ct_distance_id_fk` (`right_ct_distance_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_left_ct_near_id_fk` (`left_ct_near_id`)',
				'KEY `et_ophciexamination_extraocular_muscles_right_ct_near_id_fk` (`right_ct_near_id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_lmui_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_left_eom_id_fk` FOREIGN KEY (`left_eom_id`) REFERENCES `ophciexamination_extraocular_muscles_eom` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_right_eom_id_fk` FOREIGN KEY (`right_eom_id`) REFERENCES `ophciexamination_extraocular_muscles_eom` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_left_ct_distance_id_fk` FOREIGN KEY (`left_ct_distance_id`) REFERENCES `ophciexamination_extraocular_muscles_ct_distance` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_right_ct_distance_id_fk` FOREIGN KEY (`right_ct_distance_id`) REFERENCES `ophciexamination_extraocular_muscles_ct_distance` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_left_ct_near_id_fk` FOREIGN KEY (`left_ct_near_id`) REFERENCES `ophciexamination_extraocular_muscles_ct_near` (`id`)',
				'CONSTRAINT `et_ophciexamination_extraocular_muscles_right_ct_near_id_fk` FOREIGN KEY (`right_ct_near_id`) REFERENCES `ophciexamination_extraocular_muscles_ct_near` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_extraocular_muscles');
		$this->dropTable('ophciexamination_extraocular_muscles_ct_near');
		$this->dropTable('ophciexamination_extraocular_muscles_ct_distance');
		$this->dropTable('ophciexamination_extraocular_muscles_eom');

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->delete('element_type',"event_type_id=$event_type->id and class_name='Element_OphCiExamination_ExtraocularMuscles'");
	}
}
