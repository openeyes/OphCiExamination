<?php

class m120613_185300_initial_migration_for_ophciexamination extends CDbMigration {

	public function up() {

		// Get the event group id for "Clinical Events"
		$group_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_group')
		->where('code=:code', array(':code'=>'Ci'))
		->queryScalar();

		// Create the new Examination event_type
		$this->insert('event_type', array(
				'name' => 'Examination',
				'event_group_id' => $group_id,
				'class_name' => 'OphCiExamination'
		));

		// Get the newly created event type
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();

		// Insert element types
		$element_types = array(
				'ElementAdnexalComorbidity' => 'Adnexal Comorbidity',
				'ElementAnteriorSegment' => 'Anterior Segment',
				'ElementCateractAssessment' => 'Cateract Assessment',
				'ElementConclusion' => 'Conclusion',
				'ElementHistory' => 'History',
				'ElementIntraocularPressure' => 'Intraocular Pressure',
				'ElementInvestigation' => 'Investigation',
				'ElementPosteriorSegment' => 'Posterior Segment',
				'ElementVisualAcuity' => 'Visual Acuity',
		);
		foreach($element_types as $element_type_class => $element_type_name) {
			$this->insert('element_type', array(
					'name' => $element_type_name,
					'class_name' => $element_type_class,
					'event_type_id' => $event_type_id,
					'display_order' => 1,
					'default' => 1,
			));
		}

		// Create element type tables
		$element_type_tables = array(
				'adnexal_comorbidity',
				'anterior_segment',
				'cateract_assessment',
				'conclusion',
				'history',
				'intraocular_pressure',
				'investigation',
				'posterior_segment',
				'visual_acuity',
		);
		foreach($element_type_tables as $element_type_table) {
			$this->createTable('et_ophciexamination_'.$element_type_table, array(
					'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
					'event_id' => 'int(10) unsigned NOT NULL',
					'comments' => 'varchar(255)',
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

	}

	public function down() {

		// Remove element type tables
		$element_type_tables = array(
				'adnexal_comorbidity',
				'anterior_segment',
				'cateract_assessment',
				'conclusion',
				'history',
				'intraocular_pressure',
				'investigation',
				'posterior_segment',
				'visual_acuity',
		);
		foreach($element_type_tables as $element_type_table) {
			$this->dropTable('et_ophciexamination_'.$element_type_table);
		}

		// Delete the element types
		$event_type_id = $this->dbConnection->createCommand()
		->select('id')
		->from('event_type')
		->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))
		->queryScalar();
		$this->delete('element_type','event_type_id = ' . $event_type_id);

		 // Delete the event type
		$this->delete('event_type','id = ' . $event_type_id);

	}

}