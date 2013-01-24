<?php

class m130121_115900_anterior_segment_cct_element extends OEMigration {
	
	public function up() {
		$event_type_id = Yii::app()->db->createCommand("select id from event_type where class_name = 'OphCiExamination'")->queryScalar();
		$anterior_segment_id = Yii::app()->db->createCommand("select id from element_type where class_name = 'Element_OphCiExamination_AnteriorSegment'")->queryScalar();
		
		$this->insert('element_type',array(
				'name' => 'CCT',
				'class_name' => 'Element_OphCiExamination_AnteriorSegment_CCT',
				'event_type_id' => $event_type_id,
				'display_order' => 1,
				'parent_element_type_id' => $anterior_segment_id
		));

		$this->createTable('ophciexamination_anteriorsegment_cct_method', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255)NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'PRIMARY KEY (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		$this->createTable('et_ophciexamination_anteriorsegment_cct', array(
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
				'KEY `et_ophciexamination_anteriorsegment_cct_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_anteriorsegment_cct_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_anteriorsegment_cct_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_anteriorsegment_cct_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_anteriorsegment_cct_lmi_fk` (`left_method_id`)',
				'KEY `et_ophciexamination_anteriorsegment_cct_rmi_fk` (`right_method_id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_lmi_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)',
				'CONSTRAINT `et_ophciexamination_anteriorsegment_cct_rmi_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)'
		),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->initialiseData(dirname(__FILE__));
	}

	public function down() {
		$this->dropTable('et_ophciexamination_anteriorsegment_cct');
		$this->dropTable('ophciexamination_anteriorsegment_cct_method');
		$this->delete('element_type',"class_name = 'Element_OphCiExamination_AnteriorSegment_CCT'");
	}
	
}
