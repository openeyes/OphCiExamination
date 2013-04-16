<?php

class m130405_120200_attribute_elements extends OEMigration {

	public function up() {
		$this->createTable('ophciexamination_attribute_element',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'attribute_id' => 'int(10) unsigned NOT NULL',
				'element_type_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_attribute_element_a_fk` FOREIGN KEY (`attribute_id`) REFERENCES `ophciexamination_attribute` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_element_et_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_element_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_attribute_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$attributes = $this->getDbConnection()->createCommand()
		 ->select('id, element_type_id')
		 ->from('ophciexamination_attribute')
		 ->queryAll();
		foreach($attributes as $attribute) {
			$this->insert('ophciexamination_attribute_element', array('attribute_id' => $attribute['id'], 'element_type_id' => $attribute['element_type_id']));
		}
		$this->dropColumn('ophciexamination_attribute', 'element_type_id');
		
		$this->addColumn('ophciexamination_attribute_option', 'attribute_element_id', 'int(10) unsigned');
		$options = $this->getDbConnection()->createCommand()
		 ->select('id, attribute_id')
		 ->from('ophciexamination_attribute_option')
		 ->queryAll();
		foreach($options as $option) {
			$attribute_element_id = $this->getDbConnection()->createCommand()
			 ->select('id')
			 ->from('ophciexamination_attribute_element')
			 ->where('attribute_id = :attribute_id')
			 ->queryScalar(array(':attribute_id' => $option['attribute_id']));
			$this->update('ophciexamination_attribute_option',
					array('attribute_element_id' => $attribute_element_id),
					'id = :id',
					array(':id' => $option['id']));
		}
		$this->dropForeignKey('ophciexamination_attribute_option_attribute_id_fk', 'ophciexamination_attribute_option');
		$this->dropColumn('ophciexamination_attribute_option', 'attribute_id');
		$this->alterColumn('ophciexamination_attribute_option', 'attribute_element_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('ophciexamination_attribute_option_aei_fk', 'ophciexamination_attribute_option', 'attribute_element_id', 'ophciexamination_attribute_element', 'id');
	}

}
