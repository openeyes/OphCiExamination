<?php

class m130129_153400_new_management_element extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->insert('element_type', array(
				'name' => 'Management',
				'class_name' => 'Element_OphCiExamination_Management',
				'event_type_id' => $event_type->id,
				'display_order' => 95,
				'default'=>1
		));
		$element_type = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_Management'));
		$this->createTable('et_ophciexamination_management', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_management_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_management_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_management_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		// Make the cataract management element a child
		$this->update('element_type', array('parent_element_type_id' => $element_type->id, 'display_order' => 10), "class_name = 'Element_OphCiExamination_CataractManagement'");

		// Create a management element for each cataract_management
		$elements =  Element_OphCiExamination_CataractManagement::model()->findAll();
		foreach ($elements as $element) {
			$this->insert('et_ophciexamination_management', array(
					'event_id' => $element->event_id,
					'comments' => $element->comments,
					'last_modified_user_id' => $element->last_modified_user_id,
					'created_user_id' => $element->created_user_id,
					'last_modified_date' => $element->last_modified_date,
					'created_date' => $element->created_date,
			));
		}

		$this->dropColumn('et_ophciexamination_cataractmanagement', 'comments');
	}

	public function down()
	{
		$this->addColumn('et_ophciexamination_cataractmanagement', 'comments', 'varchar(2048) COLLATE utf8_bin');
		$elements =  Element_OphCiExamination_Management::model()->findAll();
		foreach ($elements as $element) {
			$this->update('et_ophciexamination_cataractmanagement', array('comments' => $element->comments), 'event_id = :event_id', array(':event_id' => $element->event_id));
		}
		$this->update('element_type', array('parent_element_type_id' => null, 'display_order' => 95), "class_name = 'Element_OphCiExamination_CataractManagement'");
		$this->dropTable('et_ophciexamination_management');
		$this->delete('element_type', "class_name = 'Element_OphCiExamination_Management'");
	}

}
