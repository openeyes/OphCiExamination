<?php

class m130228_152100_risks_element extends OEMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->insert('element_type',array(
				'name' => 'Risks',
				'class_name' => 'Element_OphCiExamination_Risks',
				'event_type_id' => $event_type->id,
				'display_order' => 96,
				'default' => 0
		));
		$this->createTable('et_ophciexamination_risks', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_risks_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_risks_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_risks_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_risks_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_risks_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_risks_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->addColumn('et_ophciexamination_risks', 'comments', 'text');
		$risks_et_id = ElementType::model()->find('class_name=?', array('Element_OphCiExamination_Risks'))->id;
		$this->update('element_type', array('parent_element_type_id' => $risks_et_id), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_GlaucomaRisk'));
	}

	public function down()
	{
		$outcome_et_id = ElementType::model()->find('class_name=?', array('Element_OphCiExamination_ClinicOutcome'))->id;
		$this->update('element_type', array('parent_element_type_id' => $outcome_et_id), 'class_name = :class_name', array(':class_name' => 'Element_OphCiExamination_GlaucomaRisk'));
		$this->dropTable('et_ophciexamination_risks');
		$this->delete('element_type','class_name=?',array('Element_OphCiExamination_Risks'));
	}
}
