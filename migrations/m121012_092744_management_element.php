<?php

class m121012_092744_management_element extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$this->insert('element_type',array('name'=>'Management','class_name'=>'Element_OphCiExamination_Management','event_type_id'=>$event_type->id,'display_order'=>95,'default'=>1));

		$this->createTable('ophciexamination_management_suitable_for_surgeon', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned NOT NULL DEFAULT 1',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_sfs_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_sfs_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_sfs_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_sfs_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_management_suitable_for_surgeon',array('name'=>'Senior Surgeon','display_order'=>1));
		$this->insert('ophciexamination_management_suitable_for_surgeon',array('name'=>'Fellow','display_order'=>2));
		$this->insert('ophciexamination_management_suitable_for_surgeon',array('name'=>'SpR','display_order'=>3));
		$this->insert('ophciexamination_management_suitable_for_surgeon',array('name'=>'SHO','display_order'=>4));

		$this->createTable('et_ophciexamination_management', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'city_road' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'satellite' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'fast_track' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'target_postop_refraction' => 'decimal(5,1) NOT NULL DEFAULT 0',
				'correction_discussed' => 'tinyint(1) unsigned NOT NULL',
				'suitable_for_surgeon_id' => 'int(10) unsigned NOT NULL',
				'supervised' => 'tinyint(1) unsigned NOT NULL DEFAULT 0',
				'comments' => 'varchar(2048) COLLATE utf8_bin',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_management_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_management_suitable_for_surgeon_id_fk` (`suitable_for_surgeon_id`)',
				'KEY `et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_management_created_user_id_fk` (`created_user_id`)',
				'CONSTRAINT `et_ophciexamination_management_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_suitable_for_surgeon_id_fk` FOREIGN KEY (`suitable_for_surgeon_id`) REFERENCES `ophciexamination_management_suitable_for_surgeon` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_management_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Management'));

		$this->insert('ophciexamination_attribute',array('name'=>'management','label'=>'Management','element_type_id'=>$element_type->id));

		$attribute = OphCiExamination_Attribute::model()->find('element_type_id=?',array($element_type->id));

		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Listed for left cataract surgery under LA'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Listed for right cataract surgery under LA'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Patient managing well and not keen for surgery'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Wean off the medication'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'New glasses prescribed'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Good outcome from the first eye surgery and is booked for second eye'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Discharged with glasses'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Discharged with prescription for glasses'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Discharged and glasses not required'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Patient declined surgery'));
		$this->insert('ophciexamination_attribute_option',array('attribute_id'=>$attribute->id,'value'=>'Removal of suture at next visit'));
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$element_type = ElementType::model()->find('event_type_id=? and class_name=?',array($event_type->id,'Element_OphCiExamination_Management'));

		$attribute = OphCiExamination_Attribute::model()->find('element_type_id=?',array($element_type->id));

		$this->delete('ophciexamination_attribute_option','attribute_id='.$attribute->id);
		$this->delete('ophciexamination_attribute','id='.$attribute->id);

		$this->dropTable('et_ophciexamination_management');
		$this->dropTable('ophciexamination_management_suitable_for_surgeon');

		$this->delete('element_type','event_type_id='.$event_type->id." and class_name='Element_OphCiExamination_Management'");
	}
}
