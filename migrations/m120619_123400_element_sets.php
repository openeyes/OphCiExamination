<?php

class m120619_123400_element_sets extends CDbMigration {

	public function up() {

		// Create element set tables
		$this->createTable('ophciexamination_element_set',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) DEFAULT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_element_set_item',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'set_id' => 'int(10) unsigned NOT NULL',
				'element_type_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_element_type_id_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_item_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_element_set_rule',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'set_id' => 'int(10) unsigned NOT NULL',
				'parent_id' => 'int(10) unsigned',
				'clause' => 'varchar(255)',
				'value' => 'varchar(255)',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_parent_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophciexamination_element_set_rule` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_element_set_rule_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
	}

	public function down() {
		$this->dropTable('ophciexamination_element_set_rule');
		$this->dropTable('ophciexamination_element_set_item');
		$this->dropTable('ophciexamination_element_set');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}