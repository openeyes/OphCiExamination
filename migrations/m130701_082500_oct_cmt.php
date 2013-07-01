<?php

class m130701_082500_oct_cmt extends CDbMigration
{
	public function up()
	{
		$event_type_id = Yii::app()->db->createCommand("select id from event_type where class_name = 'OphCiExamination'")->queryScalar();
		$investigation_id = Yii::app()->db->createCommand("select id from element_type where class_name = 'Element_OphCiExamination_Investigation'")->queryScalar();
		$posterior_id = Yii::app()->db->createCommand("select id from element_type where class_name = 'Element_OphCiExamination_PosteriorPole'")->queryScalar();
		
		$both_eyes_id = Eye::BOTH;
		
		$this->createTable('et_ophciexamination_oct', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT '.$both_eyes_id,
				'left_crt' => 'int(10) unsigned',
				'right_crt' => 'int(10) unsigned',
				'left_sft' => 'int(10) unsigned',
				'right_sft' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_oct_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_oct_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_oct_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_oct_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_oct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$this->insert('element_type',array(
				'name' => 'OCT',
				'class_name' => 'Element_OphCiExamination_OCT',
				'event_type_id' => $event_type_id,
				'display_order' => 1,
				'parent_element_type_id' => $investigation_id
		));
		
		$this->createTable('ophciexamination_cmt_method', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255)NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'PRIMARY KEY (`id`)',
		),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$this->insert('ophciexamination_cmt_method', array('name' => 'Topcon', 'display_order' => 1));
		$this->insert('ophciexamination_cmt_method', array('name' => 'Spectralis', 'display_order' => 2));
		
		$this->createTable('et_ophciexamination_cmt', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT '.$both_eyes_id,
				'left_method_id' => 'int(10) unsigned',
				'right_method_id' => 'int(10) unsigned',
				'left_value' => 'int(10) unsigned',
				'right_value' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_cmt_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_cmt_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_cmt_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_cmt_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_cmt_lmi_fk` (`left_method_id`)',
				'KEY `et_ophciexamination_cmt_rmi_fk` (`right_method_id`)',
				'CONSTRAINT `et_ophciexamination_cmt_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_cmt_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_cmt_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_cmt_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_cmt_lmi_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)',
				'CONSTRAINT `et_ophciexamination_cmt_rmi_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)'
		),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$this->insert('element_type',array(
				'name' => 'CMT',
				'class_name' => 'Element_OphCiExamination_CMT',
				'event_type_id' => $event_type_id,
				'display_order' => 1,
				'parent_element_type_id' => $posterior_id
		));
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_cmt');
		$this->delete('element_type',"class_name = 'Element_OphCiExamination_CMT'");
		$this->dropTable('et_ophciexamination_oct');
		$this->delete('element_type',"class_name = 'Element_OphCiExamination_OCT'");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}