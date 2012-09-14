<?php

class m120914_111700_glaucoma extends OEMigration {

	public function up() {

		// Get examination event type
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();

		// Insert element types (in order of display)
		$element_types = array(
				'Element_OphCiExamination_Risks' => array('name' => 'Risks', 'display_order' => 25),
				'Element_OphCiExamination_Gonioscopy' => array('name' => 'Gonioscopy', 'display_order' => 35),
		);
		foreach($element_types as $element_type_class => $element_type_data) {
			$this->insert('element_type', array(
					'name' => $element_type_data['name'],
					'class_name' => $element_type_class,
					'event_type_id' => $event_type_id,
					'display_order' => $element_type_data['display_order'],
					'default' => 1,
			));

			// Insert element type id into element type array
			$element_type_id = $this->dbConnection->createCommand()
			->select('id')
			->from('element_type')
			->where('class_name=:class_name', array(':class_name'=>$element_type_class))
			->queryScalar();
			$element_types[$element_type_class]['id'] = $element_type_id;

		}

		// Create element type tables
		$element_type_tables = array(
				'risks',
				'gonioscopy',
		);
		foreach($element_type_tables as $element_type_table) {
			$this->createTable('et_ophciexamination_'.$element_type_table, array(
					'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
					'event_id' => 'int(10) unsigned NOT NULL',
					'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
					'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
					'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
					'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
					'PRIMARY KEY (`id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_e_id_fk` (`event_id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_c_u_id_fk` (`created_user_id`)',
					'KEY `et_ophciexamination_'.$element_type_table.'_l_m_u_id_fk` (`last_modified_user_id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
					'CONSTRAINT `et_ophciexamination_'.$element_type_table.'_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		}

		// Risks
		$this->addColumn('et_ophciexamination_risks', 'myopia', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'migraine', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'cva', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'blood_loss', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'raynauds', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'foh', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'hyperopia', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'cardiac_surgery', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'angina', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'asthma', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'sob', 'tinyint(1) unsigned NOT NULL DEFAULT 0');
		$this->addColumn('et_ophciexamination_risks', 'hypotension', 'tinyint(1) unsigned NOT NULL DEFAULT 0');

		// Gonioscopy
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_gonio_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_gonio_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_van_herick_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_van_herick_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_description', 'text COLLATE utf8_bin');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_description', 'text COLLATE utf8_bin');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_eyedraw', 'text COLLATE utf8_bin');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_eyedraw', 'text COLLATE utf8_bin');
		$this->createTable('ophciexamination_gonioscopy_description',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) NOT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_gonioscopy_description_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_gonioscopy_description_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_gonioscopy_van_herick',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) NOT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_gonioscopy_van_herick_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_gonioscopy_van_herick_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down() {

		// Remove tables
		$tables = array(
				'et_ophciexamination_risks',
				'ophciexamination_gonioscopy_description',
				'ophciexamination_gonioscopy_van_herick',
				'et_ophciexamination_gonioscopy',
		);
		foreach($tables as $table) {
			$this->dropTable($table);
		}

		// Remove types
		$element_types = array(
				'Element_OphCiExamination_Risks',
				'Element_OphCiExamination_Gonioscopy',
		);
		foreach($element_types as $element_type) {
			$this->delete('element_type',"class_name = ?", array($element_type));
		}

	}

}