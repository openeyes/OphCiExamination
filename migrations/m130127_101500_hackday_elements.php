<?php

class m130127_101500_hackday_elements extends CDbMigration
{
	public function up() {
		$event_type = Yii::app()->db->createCommand("select * from event_type where class_name = 'OphCiExamination'")->queryRow();

		$position = 11;
		foreach(array(
				'Lungs' => 'Lungs',
				'HeartSounds' => 'Heart Sounds',
				'PeripheralOedema' => 'Peripheral Oedema',
				'Groin' => 'Groin',
				) as $class => $name)
		{
			$this->insert('element_type',array(
					'name' => $name,
					'class_name' => 'Element_OphCiExamination_'.$class,
					'event_type_id' => $event_type['id'],
					'display_order' => $position,
					'default' => 1,
			));
			$position = $position + 2;
			$table_name = 'et_ophciexamination_'.strtolower($class);
			$this->createTable($table_name, array(
					'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
					'event_id' => 'int(10) unsigned NOT NULL',
					'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
					'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
					'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
					'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
					'PRIMARY KEY (`id`)',
					'KEY `'.$table_name.'_event_id_fk` (`event_id`)',
					'KEY `'.$table_name.'_last_modified_user_id_fk` (`last_modified_user_id`)',
					'KEY `'.$table_name.'_created_user_id_fk` (`created_user_id`)',
					'CONSTRAINT `'.$table_name.'_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
					'CONSTRAINT `'.$table_name.'_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
					'CONSTRAINT `'.$table_name.'_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
			);
		}
		
		// Lungs
		$this->addColumn('et_ophciexamination_lungs', 'eyedraw', 'text');
		$this->addColumn('et_ophciexamination_lungs', 'description', 'text');
		
		// Heart Sounds
		$this->addColumn('et_ophciexamination_heartsounds', 'eyedraw', 'text');
		$this->addColumn('et_ophciexamination_heartsounds', 's1s2', 'varchar(255)');
		$this->addColumn('et_ophciexamination_heartsounds', 'systolic_murmur', 'varchar(255)');
		$this->addColumn('et_ophciexamination_heartsounds', 'diastolic_murmur', 'varchar(255)');
		
		// Peripheral Oedema
		$this->addColumn('et_ophciexamination_peripheraloedema', 'present', 'tinyint(1) unsigned');
		$this->addColumn('et_ophciexamination_peripheraloedema', 'body_part', 'varchar(255)');

		// Groin
		$this->addColumn('et_ophciexamination_groin', 'eyedraw', 'text');
		$this->addColumn('et_ophciexamination_groin', 'description', 'text');
		$this->addColumn('et_ophciexamination_groin', 'bruising', 'tinyint(1) unsigned');
		$this->addColumn('et_ophciexamination_groin', 'mass', 'tinyint(1) unsigned');
		$this->addColumn('et_ophciexamination_groin', 'mass_type', 'varchar(255)');
		$this->addColumn('et_ophciexamination_groin', 'expansile', 'tinyint(1) unsigned');
		$this->addColumn('et_ophciexamination_groin', 'bruit', 'tinyint(1) unsigned');
		
	}

	public function down()
	{
		foreach(array(
				'Lungs' => 'Lungs',
				'HeartSounds' => 'Heart Sounds',
				'PeripheralOedema' => 'Peripheral Oedema',
				'Groin' => 'Groin',
		) as $class => $name)
		{
			$this->dropTable('et_ophciexamination_'.strtolower($class));
			$this->delete('element_type',"class_name = 'Element_OphCiExamination_$class'");
		}
	}
}
