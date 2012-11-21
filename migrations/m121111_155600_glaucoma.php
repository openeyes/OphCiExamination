<?php

class m121111_155600_glaucoma extends OEMigration {

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
				'Element_OphCiExamination_OpticDisc' => array('name' => 'Optic Disc', 'display_order' => 65),
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
				'opticdisc',
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
		$this->createTable('ophciexamination_risks_risk', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_risks_risk_c_u_id_fk` (`created_user_id`)',
				'KEY `ophciexamination_risks_risk_l_m_u_id_fk` (`last_modified_user_id`)',
				'CONSTRAINT `ophciexamination_risks_risk_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_risks_risk_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_risks_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'risk_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_risks_assign_e_id_fk` (`element_id`)',
				'KEY `ophciexamination_risks_assign_r_id_fk` (`risk_id`)',
				'KEY `ophciexamination_risks_assign_c_u_id_fk` (`created_user_id`)',
				'KEY `ophciexamination_risks_assign_l_m_u_id_fk` (`last_modified_user_id`)',
				'CONSTRAINT `ophciexamination_risks_assign_e_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_risks` (`id`)',
				'CONSTRAINT `ophciexamination_risks_assign_r_id_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_risks_risk` (`id`)',
				'CONSTRAINT `ophciexamination_risks_assign_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_risks_assign_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		
		// Gonioscopy
		$this->addColumn('et_ophciexamination_gonioscopy', 'eye_id', "int(10) unsigned NOT NULL DEFAULT $both_eyes_id");
		$this->addForeignKey('et_ophciexamination_gonioscopy_eye_id_fk', 'et_ophciexamination_gonioscopy', 'eye_id', 'eye', 'id');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_gonio_sup_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_gonio_tem_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_gonio_nas_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_gonio_inf_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_gonio_sup_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_gonio_tem_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_gonio_nas_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_gonio_inf_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_van_herick_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_van_herick_id', 'int(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_gonioscopy', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_gonioscopy', 'right_eyedraw', 'text');
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
		$this->insert('setting_metadata', array(
				'element_type_id' => $element_types['Element_OphCiExamination_Gonioscopy']['id'],
				'field_type_id' => 1, // Boolean
				'key' => 'expert',
				'name' => 'Expert Mode',
				'default_value' => 0,
		));
		$glaucoma_ss = Subspecialty::model()->find('ref_spec = \'GL\'');
		$this->insert('setting_subspecialty', array(
				'subspecialty_id' => $glaucoma_ss->id,
				'element_type_id' => $element_types['Element_OphCiExamination_Gonioscopy']['id'],
				'key' => 'expert',
				'value' => 1
		));

		// Optic Disc
		$this->addColumn('et_ophciexamination_opticdisc', 'eye_id', "int(10) unsigned NOT NULL DEFAULT $both_eyes_id");
		$this->addForeignKey('et_ophciexamination_opticdisc_eye_id_fk', 'et_ophciexamination_opticdisc', 'eye_id', 'eye', 'id');
		$this->addColumn('et_ophciexamination_opticdisc', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_opticdisc', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_opticdisc', 'left_size', 'float(2,1) not null');
		$this->addColumn('et_ophciexamination_opticdisc', 'right_size', 'float(2,1) not null');
		$this->addColumn('et_ophciexamination_opticdisc', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_opticdisc', 'right_eyedraw', 'text');

		// Add rule for glaucoma
		$this->insert('ophciexamination_element_set', array(
				'name' => 'Glaucoma Default'
		));
		$set_id = OphCiExamination_ElementSet::model()->find("name = 'Glaucoma Default'")->id;
		foreach(array(
				'History',
				'VisualAcuity',
				'AnteriorSegment',
				'Gonioscopy',
				'IntraocularPressure',
				'PosteriorSegment',
				'OpticDisc',
				'Conclusion',
				'Risks',
		) as $element_name) {
			$element_type_id = ElementType::model()->find("class_name = :class_name", array(':class_name' => 'Element_OphCiExamination_'.$element_name))->id;
			$this->insert('ophciexamination_element_set_item',array(
					'set_id' => $set_id,
					'element_type_id' => $element_type_id
			));
		}
		$glaucoma_id = Subspecialty::model()->find("ref_spec = 'GL'")->id;
		$parent_id = OphCiExamination_ElementSetRule::model()->find("clause = 'subspecialty_id'")->id;
		$this->insert('ophciexamination_element_set_rule',array(
				'set_id' => $set_id,
				'parent_id' => $parent_id,
				'value' => $glaucoma_id
		));
				
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

	}

	public function down() {

		$set_id = OphCiExamination_ElementSet::model()->find("name = 'Glaucoma Default'")->id;
		$this->delete('ophciexamination_element_set_rule', 'set_id = :set_id', array(
			':set_id' => $set_id,
		));
		$this->delete('ophciexamination_element_set_item', 'set_id = :set_id', array(
			'set_id' => $set_id,
		));
		$this->delete('ophciexamination_element_set', 'id = :set_id', array(
			'set_id' => $set_id,
		));
		
		// Remove tables
		$tables = array(
				'ophciexamination_risks_assignment',
				'ophciexamination_risks_risk',
				'et_ophciexamination_risks',
				'ophciexamination_gonioscopy_description',
				'ophciexamination_gonioscopy_van_herick',
				'et_ophciexamination_gonioscopy',
				'et_ophciexamination_opticdisc',
		);
		foreach($tables as $table) {
			$this->dropTable($table);
		}

		// Remove types (and settings)
		$element_types = array(
				'Element_OphCiExamination_Risks',
				'Element_OphCiExamination_Gonioscopy',
				'Element_OphCiExamination_OpticDisc',
		);
		foreach($element_types as $element_type) {
			$element_type_id = $this->dbConnection->createCommand()
				->select('id')
				->from('element_type')
				->where('class_name=:class_name', array(':class_name'=>$element_type))
				->queryScalar();
			$this->delete('setting_subspecialty', "element_type_id = ?", array($element_type_id));
			$this->delete('setting_metadata', "element_type_id = ?", array($element_type_id));
			$this->delete('element_type',"id = ?", array($element_type_id));
		}

	}

}