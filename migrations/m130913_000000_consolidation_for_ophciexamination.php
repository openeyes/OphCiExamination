<?php

class m130913_000000_consolidation_for_ophciexamination extends OEMigration
{
	public function up()
	{
		// Get the event group id for "Clinical Events"
		$group_id = $this->dbConnection->createCommand()
			->select('id')
			->from('event_group')
			->where('code=:code', array(':code' => 'Ci'))
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
			->where('class_name=:class_name', array(':class_name' => 'OphCiExamination'))
			->queryScalar();

		// Insert element types (in order of display)
		$element_types = array(
			'Element_OphCiExamination_History' => array('name' => 'History'),
			'Element_OphCiExamination_Refraction' => array('name' => 'Refraction'),
			'Element_OphCiExamination_VisualAcuity' => array('name' => 'Visual Acuity'),
			'Element_OphCiExamination_AdnexalComorbidity' => array('name' => 'Adnexal Comorbidity'),
			'Element_OphCiExamination_AnteriorSegment' => array('name' => 'Anterior Segment'),
			'Element_OphCiExamination_IntraocularPressure' => array('name' => 'Intraocular Pressure'),
			'Element_OphCiExamination_PosteriorPole' => array('name' => 'Posterior Pole'),
			'Element_OphCiExamination_Diagnosis' => array('name' => 'Diagnosis'),
			'Element_OphCiExamination_Investigation' => array('name' => 'Investigation'),
			'Element_OphCiExamination_Conclusion' => array('name' => 'Conclusion'),
			'Element_OphCiExamination_CataractManagement' => array('name' => 'Cataract Management'),
			'Element_OphCiExamination_Comorbidities' => array('name' => 'Comorbidities'),
			'Element_OphCiExamination_Gonioscopy' => array('name' => 'Gonioscopy'),
			'Element_OphCiExamination_OpticDisc' => array('name' => 'Optic Disc'),
			'Element_OphCiExamination_Dilation' => array('name' => 'Dilation'),
			'Element_OphCiExamination_AnteriorSegment_CCT' => array('name' => 'CCT'),
			'Element_OphCiExamination_Management' => array('name' => 'Clinical Management'),
			'Element_OphCiExamination_ClinicOutcome' => array('name' => 'Clinic Outcome'),
			'Element_OphCiExamination_GlaucomaRisk' => array('name' => 'Glaucoma Risk Stratification'),
			'Element_OphCiExamination_Risks' => array('name' => 'Risks'),
			'Element_OphCiExamination_PupillaryAbnormalities' => array('name' => 'Pupillary Abnormalities'),
			'Element_OphCiExamination_DRGrading' => array('name' => 'DR Grading'),
			'Element_OphCiExamination_LaserManagement' => array('name' => 'Laser Management'),
			'Element_OphCiExamination_InjectionManagement' => array('name' => 'Injection Management'),
			'Element_OphCiExamination_InjectionManagementComplex' => array('name' => 'Injection Management'),
			'Element_OphCiExamination_OCT' => array('name' => 'OCT'),
		);
		$display_order = 1;
		foreach ($element_types as $element_type_class => $element_type_data) {
			$this->insert('element_type', array(
				'name' => $element_type_data['name'],
				'class_name' => $element_type_class,
				'event_type_id' => $event_type_id,
				'display_order' => $display_order * 10,
				'default' => 1,
			));

			// Insert element type id into element type array
			$element_type_id = $this->dbConnection->createCommand()
				->select('id')
				->from('element_type')
				->where('class_name=:class_name', array(':class_name' => $element_type_class))
				->queryScalar();
			$element_types[$element_type_class]['id'] = $element_type_id;

			$display_order++;
		}

		// Raw create tables as per last dump
		$this->createTable("CREATE TABLE `et_ophciexamination_adnexalcomorbidity` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `event_id` int(10) unsigned NOT NULL,
                  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
                  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
                  `left_description` text COLLATE utf8_bin,
                  `right_description` text COLLATE utf8_bin,
                  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
                  PRIMARY KEY (`id`),
                  KEY `et_ophciexamination_adnexalcomorbidity_e_id_fk` (`event_id`),
                  KEY `et_ophciexamination_adnexalcomorbidity_c_u_id_fk` (`created_user_id`),
                  KEY `et_ophciexamination_adnexalcomorbidity_l_m_u_id_fk` (`last_modified_user_id`),
                  KEY `et_ophciexamination_adnexalcomorbidity_eye_id_fk` (`eye_id`),
                  CONSTRAINT `et_ophciexamination_adnexalcomorbidity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
                  CONSTRAINT `et_ophciexamination_adnexalcomorbidity_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
                  CONSTRAINT `et_ophciexamination_adnexalcomorbidity_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
                  CONSTRAINT `et_ophciexamination_adnexalcomorbidity_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_anteriorsegment` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `event_id` int(10) unsigned NOT NULL,
                  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
                  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
                  `left_eyedraw` text COLLATE utf8_bin,
                  `left_pupil_id` int(10) unsigned DEFAULT NULL,
                  `left_nuclear_id` int(10) unsigned DEFAULT NULL,
                  `left_cortical_id` int(10) unsigned DEFAULT NULL,
                  `left_pxe` tinyint(1) DEFAULT NULL,
                  `left_phako` tinyint(1) DEFAULT NULL,
                  `left_description` text COLLATE utf8_bin,
                  `right_eyedraw` text COLLATE utf8_bin,
                  `right_pupil_id` int(10) unsigned DEFAULT NULL,
                  `right_nuclear_id` int(10) unsigned DEFAULT NULL,
                  `right_cortical_id` int(10) unsigned DEFAULT NULL,
                  `right_pxe` tinyint(1) DEFAULT NULL,
                  `right_phako` tinyint(1) DEFAULT NULL,
                  `right_description` text COLLATE utf8_bin,
                  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
                  PRIMARY KEY (`id`),
                  KEY `et_ophciexamination_anteriorsegment_cui_fk` (`created_user_id`),
                  KEY `et_ophciexamination_anteriorsegment_lmui_fk` (`last_modified_user_id`),
                  KEY `et_ophciexamination_anteriorsegment_ei_fk` (`event_id`),
                  KEY `et_ophciexamination_anteriorsegment_rni_fk` (`right_nuclear_id`),
                  KEY `et_ophciexamination_anteriorsegment_lni_fk` (`left_nuclear_id`),
                  KEY `et_ophciexamination_anteriorsegment_rpi_fk` (`right_pupil_id`),
                  KEY `et_ophciexamination_anteriorsegment_lpi_fk` (`left_pupil_id`),
                  KEY `et_ophciexamination_anteriorsegment_rci_fk` (`right_cortical_id`),
                  KEY `et_ophciexamination_anteriorsegment_lci_fk` (`left_cortical_id`),
                  KEY `et_ophciexamination_anteriorsegment_eye_id_fk` (`eye_id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_ei_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_lci_fk` FOREIGN KEY (`left_cortical_id`) REFERENCES `ophciexamination_anteriorsegment_cortical` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_lni_fk` FOREIGN KEY (`left_nuclear_id`) REFERENCES `ophciexamination_anteriorsegment_nuclear` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_lpi_fk` FOREIGN KEY (`left_pupil_id`) REFERENCES `ophciexamination_anteriorsegment_pupil` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_rci_fk` FOREIGN KEY (`right_cortical_id`) REFERENCES `ophciexamination_anteriorsegment_cortical` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_rni_fk` FOREIGN KEY (`right_nuclear_id`) REFERENCES `ophciexamination_anteriorsegment_nuclear` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_rpi_fk` FOREIGN KEY (`right_pupil_id`) REFERENCES `ophciexamination_anteriorsegment_pupil` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_anteriorsegment_cct` (
                  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                  `event_id` int(10) unsigned NOT NULL,
                  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
                  `left_method_id` int(10) unsigned DEFAULT NULL,
                  `right_method_id` int(10) unsigned DEFAULT NULL,
                  `left_value` int(10) unsigned DEFAULT NULL,
                  `right_value` int(10) unsigned DEFAULT NULL,
                  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
                  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
                  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
                  PRIMARY KEY (`id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_event_id_fk` (`event_id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_eye_id_fk` (`eye_id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_last_modified_user_id_fk` (`last_modified_user_id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_created_user_id_fk` (`created_user_id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_lmi_fk` (`left_method_id`),
                  KEY `et_ophciexamination_anteriorsegment_cct_rmi_fk` (`right_method_id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_lmi_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`),
                  CONSTRAINT `et_ophciexamination_anteriorsegment_cct_rmi_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_cataractmanagement` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `event_id` int(10) unsigned NOT NULL,
              `city_road` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `satellite` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `fast_track` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `target_postop_refraction` decimal(5,1) NOT NULL DEFAULT '0.0',
              `correction_discussed` tinyint(1) unsigned NOT NULL,
              `suitable_for_surgeon_id` int(10) unsigned NOT NULL,
              `supervised` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
              `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
              `previous_refractive_surgery` tinyint(1) unsigned NOT NULL,
              `vitrectomised_eye` tinyint(1) unsigned NOT NULL DEFAULT '0',
              `eye_id` int(10) unsigned DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `et_ophciexamination_management_event_id_fk` (`event_id`),
              KEY `et_ophciexamination_management_suitable_for_surgeon_id_fk` (`suitable_for_surgeon_id`),
              KEY `et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`),
              KEY `et_ophciexamination_management_created_user_id_fk` (`created_user_id`),
              KEY `et_ophciexamination_cataractmanagement_eye_id_fk` (`eye_id`),
              CONSTRAINT `et_ophciexamination_cataractmanagement_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `ophciexamination_cataractmanagement_eye` (`id`),
              CONSTRAINT `et_ophciexamination_catmanagement_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
              CONSTRAINT `et_ophciexamination_catmanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
              CONSTRAINT `et_ophciexamination_catmanagement_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
              CONSTRAINT `et_ophciexamination_catmanagement_suitable_for_surgeon_id_fk` FOREIGN KEY (`suitable_for_surgeon_id`) REFERENCES `ophciexamination_cataractmanagement_suitable_for_surgeon` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_clinicoutcome` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `event_id` int(10) unsigned NOT NULL,
              `status_id` int(10) unsigned NOT NULL,
              `followup_quantity` int(10) unsigned DEFAULT NULL,
              `followup_period_id` int(10) unsigned DEFAULT NULL,
              `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
              `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
              `role_id` int(10) unsigned DEFAULT NULL,
              `role_comments` varchar(255) COLLATE utf8_bin DEFAULT NULL,
              `community_patient` tinyint(1) unsigned NOT NULL DEFAULT '0',
              PRIMARY KEY (`id`),
              KEY `et_ophciexamination_clinicoutcome_lmui_fk` (`last_modified_user_id`),
              KEY `et_ophciexamination_clinicoutcome_cui_fk` (`created_user_id`),
              KEY `et_ophciexamination_clinicoutcome_status_fk` (`status_id`),
              KEY `et_ophciexamination_clinicoutcome_fup_p_fk` (`followup_period_id`),
              KEY `et_ophciexamination_clinicoutcome_ri_fk` (`role_id`),
              KEY `et_ophciexamination_clinicoutcome_event_id_fk` (`event_id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_fup_p_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_ri_fk` FOREIGN KEY (`role_id`) REFERENCES `ophciexamination_clinicoutcome_role` (`id`),
              CONSTRAINT `et_ophciexamination_clinicoutcome_status_fk` FOREIGN KEY (`status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_comorbidities` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              `event_id` int(10) unsigned NOT NULL,
              `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
              `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
              `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
              `comments` text COLLATE utf8_bin,
              PRIMARY KEY (`id`),
              KEY `et_ophciexamination_risks_e_id_fk` (`event_id`),
              KEY `et_ophciexamination_risks_c_u_id_fk` (`created_user_id`),
              KEY `et_ophciexamination_risks_l_m_u_id_fk` (`last_modified_user_id`),
              CONSTRAINT `et_ophciexamination_risks_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
              CONSTRAINT `et_ophciexamination_risks_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
              CONSTRAINT `et_ophciexamination_risks_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
        ");

		$this->createTable("CREATE TABLE `et_ophciexamination_conclusion` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `description` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_conclusion_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_conclusion_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_conclusion_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `et_ophciexamination_conclusion_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_conclusion_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_conclusion_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_diagnoses` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_diagnosis_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_diagnosis_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_diagnosis_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `et_ophciexamination_diagnosis_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_diagnosis_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_diagnosis_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_dilation` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_dilation_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_dilation_eye_id_fk` (`eye_id`),
			  KEY `et_ophciexamination_dilation_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_dilation_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `et_ophciexamination_dilation_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_dilation_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_dilation_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_dilation_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_drgrading` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `left_nscretinopathy_id` int(10) unsigned DEFAULT NULL,
			  `right_nscretinopathy_id` int(10) unsigned DEFAULT NULL,
			  `left_nscmaculopathy_id` int(10) unsigned DEFAULT NULL,
			  `right_nscmaculopathy_id` int(10) unsigned DEFAULT NULL,
			  `left_nscretinopathy_photocoagulation` tinyint(1) DEFAULT NULL,
			  `right_nscretinopathy_photocoagulation` tinyint(1) DEFAULT NULL,
			  `left_nscmaculopathy_photocoagulation` tinyint(1) DEFAULT NULL,
			  `right_nscmaculopathy_photocoagulation` tinyint(1) DEFAULT NULL,
			  `left_clinical_id` int(10) unsigned DEFAULT NULL,
			  `right_clinical_id` int(10) unsigned DEFAULT NULL,
			  `eye_id` int(10) unsigned DEFAULT '3',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_drgrading_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_drgrading_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_drgrading_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_drgrading_l_nret_fk` (`left_nscretinopathy_id`),
			  KEY `et_ophciexamination_drgrading_r_nret_fk` (`right_nscretinopathy_id`),
			  KEY `et_ophciexamination_drgrading_l_nmac_fk` (`left_nscmaculopathy_id`),
			  KEY `et_ophciexamination_drgrading_r_nmac_fk` (`right_nscmaculopathy_id`),
			  KEY `et_ophciexamination_drgrading_l_clinical_fk` (`left_clinical_id`),
			  KEY `et_ophciexamination_drgrading_r_clinical_fk` (`right_clinical_id`),
			  KEY `et_ophciexamination_drgrading_eye_id_fk` (`eye_id`),
			  CONSTRAINT `et_ophciexamination_drgrading_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_l_nret_fk` FOREIGN KEY (`left_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_r_nret_fk` FOREIGN KEY (`right_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_l_nmac_fk` FOREIGN KEY (`left_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_r_nmac_fk` FOREIGN KEY (`right_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_l_clinical_fk` FOREIGN KEY (`left_clinical_id`) REFERENCES `ophciexamination_drgrading_clinical` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_r_clinical_fk` FOREIGN KEY (`right_clinical_id`) REFERENCES `ophciexamination_drgrading_clinical` (`id`),
			  CONSTRAINT `et_ophciexamination_drgrading_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_glaucomarisk` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `risk_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_glaucomarisk_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_glaucomarisk_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_glaucomarisk_created_user_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_glaucomarisk_risk_id_fk` (`risk_id`),
			  CONSTRAINT `et_ophciexamination_glaucomarisk_risk_id_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_glaucomarisk_risk` (`id`),
			  CONSTRAINT `et_ophciexamination_glaucomarisk_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_glaucomarisk_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_glaucomarisk_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_gonioscopy` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `left_gonio_sup_id` int(10) unsigned DEFAULT NULL,
			  `left_gonio_tem_id` int(10) unsigned DEFAULT NULL,
			  `left_gonio_nas_id` int(10) unsigned DEFAULT NULL,
			  `left_gonio_inf_id` int(10) unsigned DEFAULT NULL,
			  `right_gonio_sup_id` int(10) unsigned DEFAULT NULL,
			  `right_gonio_tem_id` int(10) unsigned DEFAULT NULL,
			  `right_gonio_nas_id` int(10) unsigned DEFAULT NULL,
			  `right_gonio_inf_id` int(10) unsigned DEFAULT NULL,
			  `left_van_herick_id` int(10) unsigned DEFAULT NULL,
			  `right_van_herick_id` int(10) unsigned DEFAULT NULL,
			  `left_description` text COLLATE utf8_bin,
			  `right_description` text COLLATE utf8_bin,
			  `left_eyedraw` text COLLATE utf8_bin,
			  `right_eyedraw` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_gonioscopy_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_gonioscopy_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_gonioscopy_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_gonioscopy_eye_id_fk` (`eye_id`),
			  KEY `et_ophciexamination_gonioscopy_left_gonio_sup_id_fk` (`left_gonio_sup_id`),
			  KEY `et_ophciexamination_gonioscopy_right_gonio_sup_id_fk` (`right_gonio_sup_id`),
			  KEY `et_ophciexamination_gonioscopy_left_gonio_tem_id_fk` (`left_gonio_tem_id`),
			  KEY `et_ophciexamination_gonioscopy_right_gonio_tem_id_fk` (`right_gonio_tem_id`),
			  KEY `et_ophciexamination_gonioscopy_left_gonio_nas_id_fk` (`left_gonio_nas_id`),
			  KEY `et_ophciexamination_gonioscopy_right_gonio_nas_id_fk` (`right_gonio_nas_id`),
			  KEY `et_ophciexamination_gonioscopy_left_gonio_inf_id_fk` (`left_gonio_inf_id`),
			  KEY `et_ophciexamination_gonioscopy_right_gonio_inf_id_fk` (`right_gonio_inf_id`),
			  KEY `et_ophciexamination_gonioscopy_left_van_herick_id_fk` (`left_van_herick_id`),
			  KEY `et_ophciexamination_gonioscopy_right_van_herick_id_fk` (`right_van_herick_id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_right_van_herick_id_fk` FOREIGN KEY (`right_van_herick_id`) REFERENCES `ophciexamination_gonioscopy_van_herick` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_left_gonio_inf_id_fk` FOREIGN KEY (`left_gonio_inf_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_left_gonio_nas_id_fk` FOREIGN KEY (`left_gonio_nas_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_left_gonio_sup_id_fk` FOREIGN KEY (`left_gonio_sup_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_left_gonio_tem_id_fk` FOREIGN KEY (`left_gonio_tem_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_left_van_herick_id_fk` FOREIGN KEY (`left_van_herick_id`) REFERENCES `ophciexamination_gonioscopy_van_herick` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_right_gonio_inf_id_fk` FOREIGN KEY (`right_gonio_inf_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_right_gonio_nas_id_fk` FOREIGN KEY (`right_gonio_nas_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_right_gonio_sup_id_fk` FOREIGN KEY (`right_gonio_sup_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
			  CONSTRAINT `et_ophciexamination_gonioscopy_right_gonio_tem_id_fk` FOREIGN KEY (`right_gonio_tem_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_history` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `description` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_history_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_history_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_history_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `et_ophciexamination_history_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_history_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_history_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_injectionmanagement` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `injection_status_id` int(10) unsigned NOT NULL,
			  `injection_deferralreason_id` int(10) unsigned DEFAULT NULL,
			  `injection_deferralreason_other` text COLLATE utf8_bin,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_injectionmanagement_lmui_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_injectionmanagement_cui_fk` (`created_user_id`),
			  KEY `et_ophciexamination_injectionmanagement_injection_fk` (`injection_status_id`),
			  KEY `et_ophciexamination_injectionmanagement_ideferral_fk` (`injection_deferralreason_id`),
			  KEY `et_ophciexamination_injectionmanagement_event_id_fk` (`event_id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagement_injection_fk` FOREIGN KEY (`injection_status_id`) REFERENCES `ophciexamination_management_status` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagement_ideferral_fk` FOREIGN KEY (`injection_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_injectionmanagementcomplex` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned DEFAULT '3',
			  `no_treatment` tinyint(1) NOT NULL DEFAULT '0',
			  `no_treatment_reason_id` int(10) unsigned DEFAULT NULL,
			  `left_diagnosis1_id` int(10) unsigned DEFAULT NULL,
			  `right_diagnosis1_id` int(10) unsigned DEFAULT NULL,
			  `left_diagnosis2_id` int(10) unsigned DEFAULT NULL,
			  `right_diagnosis2_id` int(10) unsigned DEFAULT NULL,
			  `left_comments` text COLLATE utf8_bin,
			  `right_comments` text COLLATE utf8_bin,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `no_treatment_reason_other` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_lmui_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_cui_fk` (`created_user_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_eye_fk` (`eye_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` (`left_diagnosis1_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` (`right_diagnosis1_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` (`left_diagnosis2_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` (`right_diagnosis2_id`),
			  KEY `et_ophciexamination_injectionmanagementcomplex_event_id_fk` (`event_id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_eye_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` FOREIGN KEY (`left_diagnosis1_id`) REFERENCES `disorder` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` FOREIGN KEY (`left_diagnosis2_id`) REFERENCES `disorder` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` FOREIGN KEY (`right_diagnosis1_id`) REFERENCES `disorder` (`id`),
			  CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` FOREIGN KEY (`right_diagnosis2_id`) REFERENCES `disorder` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_intraocularpressure` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `left_instrument_id` int(10) unsigned DEFAULT NULL,
			  `left_reading_id` int(10) unsigned NOT NULL,
			  `right_instrument_id` int(10) unsigned DEFAULT NULL,
			  `right_reading_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_intraocularpressure_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_intraocularpressure_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_intraocularpressure_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_intraocularpressure_li_fk` (`left_instrument_id`),
			  KEY `et_ophciexamination_intraocularpressure_ri_fk` (`right_instrument_id`),
			  KEY `et_ophciexamination_intraocularpressure_lri_fk` (`left_reading_id`),
			  KEY `et_ophciexamination_intraocularpressure_rri_fk` (`right_reading_id`),
			  KEY `et_ophciexamination_intraocularpressure_eye_id_fk` (`eye_id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_li_fk` FOREIGN KEY (`left_instrument_id`) REFERENCES `ophciexamination_instrument` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_lri_fk` FOREIGN KEY (`left_reading_id`) REFERENCES `ophciexamination_intraocularpressure_reading` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_ri_fk` FOREIGN KEY (`right_instrument_id`) REFERENCES `ophciexamination_instrument` (`id`),
			  CONSTRAINT `et_ophciexamination_intraocularpressure_rri_fk` FOREIGN KEY (`right_reading_id`) REFERENCES `ophciexamination_intraocularpressure_reading` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_investigation` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `description` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_investigation_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_investigation_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_investigation_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `et_ophciexamination_investigation_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_investigation_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_investigation_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_lasermanagement` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `laser_status_id` int(10) unsigned NOT NULL,
			  `laser_deferralreason_id` int(10) unsigned DEFAULT NULL,
			  `laser_deferralreason_other` text COLLATE utf8_bin,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `eye_id` int(10) unsigned DEFAULT '3',
			  `left_lasertype_id` int(10) unsigned DEFAULT NULL,
			  `left_lasertype_other` varchar(128) COLLATE utf8_bin DEFAULT NULL,
			  `left_comments` text COLLATE utf8_bin,
			  `right_lasertype_id` int(10) unsigned DEFAULT NULL,
			  `right_lasertype_other` varchar(128) COLLATE utf8_bin DEFAULT NULL,
			  `right_comments` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_lasermanagement_lmui_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_lasermanagement_cui_fk` (`created_user_id`),
			  KEY `et_ophciexamination_lasermanagement_laser_fk` (`laser_status_id`),
			  KEY `et_ophciexamination_lasermanagement_ldeferral_fk` (`laser_deferralreason_id`),
			  KEY `et_ophciexamination_lasermanagement_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_lasermanagement_llt_fk` (`left_lasertype_id`),
			  KEY `et_ophciexamination_lasermanagement_rlt_fk` (`right_lasertype_id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_laser_fk` FOREIGN KEY (`laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_ldeferral_fk` FOREIGN KEY (`laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_llt_fk` FOREIGN KEY (`left_lasertype_id`) REFERENCES `ophciexamination_lasermanagement_lasertype` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_lasermanagement_rlt_fk` FOREIGN KEY (`right_lasertype_id`) REFERENCES `ophciexamination_lasermanagement_lasertype` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_management` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `comments` text COLLATE utf8_bin,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_management_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_management_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `et_ophciexamination_management_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_management_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_management_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_oct` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `left_method_id` int(10) unsigned DEFAULT NULL,
			  `right_method_id` int(10) unsigned DEFAULT NULL,
			  `left_crt` int(10) unsigned DEFAULT NULL,
			  `right_crt` int(10) unsigned DEFAULT NULL,
			  `left_sft` int(10) unsigned DEFAULT NULL,
			  `right_sft` int(10) unsigned DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_oct_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_oct_eye_id_fk` (`eye_id`),
			  KEY `et_ophciexamination_oct_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_oct_created_user_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_oct_lmid_fk` (`left_method_id`),
			  KEY `et_ophciexamination_oct_rmid_fk` (`right_method_id`),
			  CONSTRAINT `et_ophciexamination_oct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_oct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_oct_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_oct_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_oct_lmid_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_oct_method` (`id`),
			  CONSTRAINT `et_ophciexamination_oct_rmid_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_oct_method` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_opticdisc` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `left_description` text COLLATE utf8_bin,
			  `right_description` text COLLATE utf8_bin,
			  `left_diameter` float(2,1) DEFAULT NULL,
			  `right_diameter` float(2,1) DEFAULT NULL,
			  `left_eyedraw` text COLLATE utf8_bin,
			  `right_eyedraw` text COLLATE utf8_bin,
			  `left_cd_ratio_id` int(10) unsigned DEFAULT NULL,
			  `right_cd_ratio_id` int(10) unsigned DEFAULT NULL,
			  `left_lens_id` int(10) unsigned DEFAULT NULL,
			  `right_lens_id` int(10) unsigned DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_opticdisc_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_opticdisc_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_opticdisc_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_opticdisc_eye_id_fk` (`eye_id`),
			  KEY `et_ophciexamination_opticdisc_left_cd_ratio_id_fk` (`left_cd_ratio_id`),
			  KEY `et_ophciexamination_opticdisc_right_cd_ratio_id_fk` (`right_cd_ratio_id`),
			  KEY `et_ophciexamination_opticdisc_lli` (`left_lens_id`),
			  KEY `et_ophciexamination_opticdisc_rli` (`right_lens_id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_left_cd_ratio_id_fk` FOREIGN KEY (`left_cd_ratio_id`) REFERENCES `ophciexamination_opticdisc_cd_ratio` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_lli` FOREIGN KEY (`left_lens_id`) REFERENCES `ophciexamination_opticdisc_lens` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_right_cd_ratio_id_fk` FOREIGN KEY (`right_cd_ratio_id`) REFERENCES `ophciexamination_opticdisc_cd_ratio` (`id`),
			  CONSTRAINT `et_ophciexamination_opticdisc_rli` FOREIGN KEY (`right_lens_id`) REFERENCES `ophciexamination_opticdisc_lens` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_posteriorpole` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `left_eyedraw` text COLLATE utf8_bin,
			  `left_description` text COLLATE utf8_bin,
			  `right_eyedraw` text COLLATE utf8_bin,
			  `right_description` text COLLATE utf8_bin,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_posteriorpole_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_posteriorpole_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_posteriorpole_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_posteriorpole_eye_id_fk` (`eye_id`),
			  CONSTRAINT `et_ophciexamination_posteriorpole_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_posteriorpole_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_posteriorpole_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_posteriorpole_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_pupillaryabnormalities` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `left_abnormality_id` int(10) unsigned DEFAULT NULL,
			  `right_abnormality_id` int(10) unsigned DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_pupillaryabnormal_ei_fk` (`event_id`),
			  KEY `et_ophciexamination_pupillaryabnormal_lmi_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_pupillaryabnormal_cui_fk` (`created_user_id`),
			  KEY `et_ophciexamination_pupillaryabnormal_lai_fk` (`left_abnormality_id`),
			  KEY `et_ophciexamination_pupillaryabnormal_rai_fk` (`right_abnormality_id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormal_ei_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormal_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormal_lmi_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormal_lai_fk` FOREIGN KEY (`left_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormal_rai_fk` FOREIGN KEY (`right_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_refraction` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `left_sphere` decimal(5,2) DEFAULT NULL,
			  `left_cylinder` decimal(5,2) DEFAULT NULL,
			  `left_axis` int(3) DEFAULT NULL,
			  `left_axis_eyedraw` text COLLATE utf8_bin,
			  `left_type_id` int(10) unsigned DEFAULT NULL,
			  `right_sphere` decimal(5,2) DEFAULT NULL,
			  `right_cylinder` decimal(5,2) DEFAULT NULL,
			  `right_axis` int(3) DEFAULT NULL,
			  `right_axis_eyedraw` text COLLATE utf8_bin,
			  `right_type_id` int(10) unsigned DEFAULT NULL,
			  `left_type_other` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `right_type_other` varchar(100) COLLATE utf8_bin DEFAULT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_refraction_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_refraction_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_refraction_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_refraction_lti_fk` (`left_type_id`),
			  KEY `et_ophciexamination_refraction_rti_fk` (`right_type_id`),
			  KEY `et_ophciexamination_refraction_eye_id_fk` (`eye_id`),
			  CONSTRAINT `et_ophciexamination_refraction_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_refraction_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_refraction_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_refraction_lti_fk` FOREIGN KEY (`left_type_id`) REFERENCES `ophciexamination_refraction_type` (`id`),
			  CONSTRAINT `et_ophciexamination_refraction_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_refraction_rti_fk` FOREIGN KEY (`right_type_id`) REFERENCES `ophciexamination_refraction_type` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_risks` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `comments` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_risks_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_risks_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_risks_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `et_ophciexamination_risks_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_risks_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_risks_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_visual_fields` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `left_eyedraw` text COLLATE utf8_bin,
			  `right_eyedraw` text COLLATE utf8_bin,
			  `left_description` text COLLATE utf8_bin,
			  `right_description` text COLLATE utf8_bin,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_visual_acuity_event_id_fk` (`event_id`),
			  KEY `et_ophciexamination_visual_acuity_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_visual_acuity_created_user_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_visual_acuity_eye_id_fk` (`eye_id`),
			  CONSTRAINT `et_ophciexamination_visual_acuity_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_visual_acuity_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_visual_acuity_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_visual_acuity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `et_ophciexamination_visualacuity` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `left_comments` text COLLATE utf8_bin,
			  `right_comments` text COLLATE utf8_bin,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `unit_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_visualacuity_e_id_fk` (`event_id`),
			  KEY `et_ophciexamination_visualacuity_c_u_id_fk` (`created_user_id`),
			  KEY `et_ophciexamination_visualacuity_l_m_u_id_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_visualacuity_eye_id_fk` (`eye_id`),
			  KEY `et_ophciexamination_visualacuity_unit_fk` (`unit_id`),
			  CONSTRAINT `et_ophciexamination_visualacuity_unit_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`),
			  CONSTRAINT `et_ophciexamination_visualacuity_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_visualacuity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `et_ophciexamination_visualacuity_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `et_ophciexamination_visualacuity_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_anteriorsegment_cct_method` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_anteriorsegment_cct_method_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_anteriorsegment_cct_method_lmui_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_cct_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_cct_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_anteriorsegment_cortical` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_anteriorsegment_cortical_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_anteriorsegment_cortical_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_cortical_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_cortical_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_anteriorsegment_nuclear` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_anteriorsegment_nuclear_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_anteriorsegment_nuclear_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_nuclear_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_nuclear_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_anteriorsegment_pupil` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_anteriorsegment_pupil_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_anteriorsegment_pupil_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_pupil_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_anteriorsegment_pupil_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_attribute` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(40) COLLATE utf8_bin NOT NULL,
			  `label` varchar(255) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_attribute_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_attribute_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_attribute_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_attribute_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_attribute_element` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `attribute_id` int(10) unsigned NOT NULL,
			  `element_type_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_attribute_element_a_fk` (`attribute_id`),
			  KEY `ophciexamination_attribute_element_et_fk` (`element_type_id`),
			  KEY `ophciexamination_attribute_element_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_attribute_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_attribute_element_a_fk` FOREIGN KEY (`attribute_id`) REFERENCES `ophciexamination_attribute` (`id`),
			  CONSTRAINT `ophciexamination_attribute_element_et_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`),
			  CONSTRAINT `ophciexamination_attribute_element_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_attribute_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_attribute_option` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `value` varchar(255) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `delimiter` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ',',
			  `subspecialty_id` int(10) unsigned DEFAULT NULL,
			  `attribute_element_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_attribute_option_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_attribute_option_created_user_id_fk` (`created_user_id`),
			  KEY `ophciexamination_attribute_option_ssi_fk` (`subspecialty_id`),
			  KEY `ophciexamination_attribute_option_aei_fk` (`attribute_element_id`),
			  CONSTRAINT `ophciexamination_attribute_option_aei_fk` FOREIGN KEY (`attribute_element_id`) REFERENCES `ophciexamination_attribute_element` (`id`),
			  CONSTRAINT `ophciexamination_attribute_option_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_attribute_option_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_attribute_option_ssi_fk` FOREIGN KEY (`subspecialty_id`) REFERENCES `subspecialty` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_cataractmanagement_eye` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin NOT NULL,
			  `display_order` tinyint(1) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_cataractmanagement_eye_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_cataractmanagement_eye_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_cataractmanagement_eye_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_cataractmanagement_eye_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_cataractmanagement_suitable_for_surgeon` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_sfs_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_sfs_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_sfs_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_sfs_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->createTable("CREATE TABLE `ophciexamination_clinicoutcome_role` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '10',
			  `requires_comment` int(1) unsigned NOT NULL DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_clinicoutcome_role_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_clinicoutcome_role_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_role_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_role_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");


		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		// Remove tables
		$tables = array(
			'et_ophciexamination_adnexalcomorbidity',
			'et_ophciexamination_anteriorsegment',
			'et_ophciexamination_cataractassessment',
			'et_ophciexamination_conclusion',
			'et_ophciexamination_diagnosis',
			'et_ophciexamination_history',
			'et_ophciexamination_intraocularpressure',
			'et_ophciexamination_investigation',
			'et_ophciexamination_posteriorsegment',
			'et_ophciexamination_refraction',
			'et_ophciexamination_visualacuity',
			'ophciexamination_visual_acuity_unit_value',
			'ophciexamination_visual_acuity_unit',
			'ophciexamination_instrument',
			'ophciexamination_attribute_option',
			'ophciexamination_attribute',
			'ophciexamination_element_set_rule',
			'ophciexamination_element_set_item',
			'ophciexamination_element_set',
		);
		foreach ($tables as $table) {
			$this->dropTable($table);
		}

		$event_type_id = $this->dbConnection->createCommand()
			->select('id')
			->from('event_type')
			->where('class_name=:class_name', array(':class_name' => 'OphCiExamination'))
			->queryScalar();

		// Remove settings
		$element_type_ids = $this->dbConnection->createCommand()
			->select('id')
			->from('element_type')
			->where('event_type_id = :event_type_id', array(':event_type_id' => $event_type_id))
			->queryColumn();
		$element_type_ids_string = implode(',', $element_type_ids);
		$this->delete('setting_metadata', "element_type_id IN ($element_type_ids_string)");

		// Delete the element types
		$this->delete('element_type', 'event_type_id = ' . $event_type_id);

		// Delete the event type
		$this->delete('event_type', 'id = ' . $event_type_id);

	}

}
