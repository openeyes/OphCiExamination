<?php

class m130327_081818_visual_fields_element extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		/*
		$this->insert('element_type',array(
			'name' => 'Visual Fields',
			'class_name' => 'Element_OphCiExamination_VisualFields',
			'event_type_id' => $event_type->id,
			'display_order' => 31,
			'default' => 0,
		));
		*/

		$this->createTable('et_ophciexamination_visual_fields', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'left_eyedraw' => 'text COLLATE utf8_bin',
				'right_eyedraw' => 'text COLLATE utf8_bin',
				'left_description' => 'text COLLATE utf8_bin',
				'right_description' => 'text COLLATE utf8_bin',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT 3',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_visual_acuity_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_visual_acuity_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_visual_acuity_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_visual_acuity_eye_id_fk` (`eye_id`)',
				'CONSTRAINT `et_ophciexamination_visual_acuity_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_visual_acuity_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_visual_acuity_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_visual_acuity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_visual_fields');

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->delete('element_type',"event_type_id = $event_type->id and class_name = 'Element_OphCiExamination_VisualFields'");
	}
}
