<?php

class m130126_164452_smoking_element extends CDbMigration
{
	public function up()
	{
		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$this->insert('element_type',array(
				'name' => 'Smoking',
				'class_name' => 'Element_OphCiExamination_Smoking',
				'event_type_id' => $event_type['id'],
				'display_order' => 65,
				'default' => 1,
		));

		$this->createTable('et_ophciexamination_smoking', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'smoker' => 'tinyint(1) unsigned NOT NULL',
				'past_smoker' => 'tinyint(1) unsigned NOT NULL',
				'cigs_day' => 'int(10) unsigned NOT NULL DEFAULT 0',
				'duration_days' => 'int(10) unsigned NOT NULL DEFAULT 0',
				'duration_months' => 'int(10) unsigned NOT NULL DEFAULT 0',
				'duration_years' => 'int(10) unsigned NOT NULL DEFAULT 0',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_smoking_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_smoking_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_smoking_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_smoking_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_smoking_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_smoking_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_smoking');
		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();
		$this->delete('element_type',"event_type_id = {$event_type['id']} and class_name = 'Element_OphCiExamination_Smoking'");
	}
}
