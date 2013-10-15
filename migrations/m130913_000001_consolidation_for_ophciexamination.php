<?php

class m130913_000001_consolidation_for_ophciexamination extends OEMigration
{
	public function up()
	{
		//disable foreign keys check
		$this->execute("SET foreign_key_checks = 0");

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
		$this->execute("CREATE TABLE `et_ophciexamination_adnexalcomorbidity` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_anteriorsegment` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_anteriorsegment_cct` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_cataractmanagement` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_clinicoutcome` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_comorbidities` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_conclusion` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_diagnoses` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_dilation` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_drgrading` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_glaucomarisk` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_gonioscopy` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_history` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_injectionmanagement` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_injectionmanagementcomplex` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_intraocularpressure` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_investigation` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_lasermanagement` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_management` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_oct` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_opticdisc` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_posteriorpole` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_pupillaryabnormalities` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_refraction` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_risks` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_visual_fields` (
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

		$this->execute("CREATE TABLE `et_ophciexamination_visualacuity` (
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

		$this->execute("CREATE TABLE `ophciexamination_anteriorsegment_cct_method` (
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

		$this->execute("CREATE TABLE `ophciexamination_anteriorsegment_cortical` (
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

		$this->execute("CREATE TABLE `ophciexamination_anteriorsegment_nuclear` (
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

		$this->execute("CREATE TABLE `ophciexamination_anteriorsegment_pupil` (
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

		$this->execute("CREATE TABLE `ophciexamination_attribute` (
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

		$this->execute("CREATE TABLE `ophciexamination_attribute_element` (
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

		$this->execute("CREATE TABLE `ophciexamination_attribute_option` (
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

		$this->execute("CREATE TABLE `ophciexamination_cataractmanagement_eye` (
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

		$this->execute("CREATE TABLE `ophciexamination_cataractmanagement_suitable_for_surgeon` (
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

		$this->execute("CREATE TABLE `ophciexamination_clinicoutcome_role` (
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

		$this->execute("CREATE TABLE `ophciexamination_clinicoutcome_status` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `followup` tinyint(1) NOT NULL DEFAULT '0',
			  `episode_status_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_clinicoutcome_laser_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_clinicoutcome_laser_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_clinicoutcome_episode_status_fk` (`episode_status_id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_episode_status_fk` FOREIGN KEY (`episode_status_id`) REFERENCES `episode_status` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_clinicoutcome_template` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `followup_quantity` int(10) unsigned DEFAULT NULL,
			  `clinic_outcome_status_id` int(10) unsigned NOT NULL,
			  `followup_period_id` int(10) unsigned DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_clinicoutcome_template_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_clinicoutcome_template_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_clinicoutcome_template_cosi_fk` (`clinic_outcome_status_id`),
			  KEY `ophciexamination_clinicoutcome_template_fpi_fk` (`followup_period_id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_template_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_template_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_template_cosi_fk` FOREIGN KEY (`clinic_outcome_status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`),
			  CONSTRAINT `ophciexamination_clinicoutcome_template_fpi_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_comorbidities_assignment` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_id` int(10) unsigned NOT NULL,
			  `item_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_risks_assign_e_id_fk` (`element_id`),
			  KEY `ophciexamination_risks_assign_r_id_fk` (`item_id`),
			  KEY `ophciexamination_risks_assign_c_u_id_fk` (`created_user_id`),
			  KEY `ophciexamination_risks_assign_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_comorbidities_assign_i_id_fk` FOREIGN KEY (`item_id`) REFERENCES `ophciexamination_comorbidities_item` (`id`),
			  CONSTRAINT `ophciexamination_comorbidities_assign_e_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_comorbidities` (`id`),
			  CONSTRAINT `ophciexamination_risks_assign_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_risks_assign_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_comorbidities_item` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_risks_risk_c_u_id_fk` (`created_user_id`),
			  KEY `ophciexamination_risks_risk_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_risks_risk_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_risks_risk_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_diagnosis` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_diagnoses_id` int(10) unsigned NOT NULL,
			  `disorder_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL,
			  `principal` tinyint(1) unsigned NOT NULL DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_diagnosis_element_diagnoses_id_fk` (`element_diagnoses_id`),
			  KEY `ophciexamination_diagnosis_disorder_id_fk` (`disorder_id`),
			  KEY `ophciexamination_diagnosis_eye_id_fk` (`eye_id`),
			  KEY `ophciexamination_diagnosis_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_diagnosis_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_diagnosis_element_diagnoses_id_fk` FOREIGN KEY (`element_diagnoses_id`) REFERENCES `et_ophciexamination_diagnoses` (`id`),
			  CONSTRAINT `ophciexamination_diagnosis_disorder_id_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`),
			  CONSTRAINT `ophciexamination_diagnosis_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `ophciexamination_diagnosis_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_diagnosis_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_dilation_drugs` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_dilation_drugs_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_dilation_drugs_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_dilation_drugs_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_dilation_drugs_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_dilation_treatment` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_id` int(10) unsigned NOT NULL,
			  `side` tinyint(1) unsigned NOT NULL,
			  `drug_id` int(10) unsigned NOT NULL,
			  `drops` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `treatment_time` time NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_dilation_treatment_element_id_fk` (`element_id`),
			  KEY `ophciexamination_dilation_treatment_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_dilation_treatment_created_user_id_fk` (`created_user_id`),
			  KEY `ophciexamination_dilation_treatment_drug_id_fk` (`drug_id`),
			  CONSTRAINT `ophciexamination_dilation_treatment_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_dilation_treatment_drug_id_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophciexamination_dilation_drugs` (`id`),
			  CONSTRAINT `ophciexamination_dilation_treatment_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_dilation` (`id`),
			  CONSTRAINT `ophciexamination_dilation_treatment_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_drgrading_clinical` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `description` text COLLATE utf8_bin,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `class` varchar(16) COLLATE utf8_bin NOT NULL,
			  `booking_weeks` int(2) unsigned DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_drgrading_clinical_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_drgrading_clinical_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_drgrading_clinical_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_drgrading_clinical_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_drgrading_nscmaculopathy` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `description` text COLLATE utf8_bin,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `booking_weeks` int(2) unsigned DEFAULT NULL,
			  `class` varchar(16) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_drgrading_nscmaculopathy_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_drgrading_nscmaculopathy_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_drgrading_nscmaculopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_drgrading_nscmaculopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_drgrading_nscretinopathy` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `description` text COLLATE utf8_bin,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `booking_weeks` int(2) unsigned DEFAULT NULL,
			  `class` varchar(16) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_drgrading_nscretinopathy_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_drgrading_nscretinopathy_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_drgrading_nscretinopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_drgrading_nscretinopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_element_set` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `position` int(10) unsigned NOT NULL DEFAULT '1',
			  `workflow_id` int(10) unsigned NOT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_element_set_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_element_set_created_user_id_fk` (`created_user_id`),
			  KEY `ophciexamination_element_set_workflow_id_fk` (`workflow_id`),
			  CONSTRAINT `ophciexamination_element_set_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_element_set_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_element_set_workflow_id_fk` FOREIGN KEY (`workflow_id`) REFERENCES `ophciexamination_workflow` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_element_set_item` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `set_id` int(10) unsigned NOT NULL,
			  `element_type_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_element_set_item_set_id_fk` (`set_id`),
			  KEY `ophciexamination_element_set_item_element_type_id_fk` (`element_type_id`),
			  KEY `ophciexamination_element_set_item_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_element_set_item_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_element_set_item_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`),
			  CONSTRAINT `ophciexamination_element_set_item_element_type_id_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`),
			  CONSTRAINT `ophciexamination_element_set_item_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_element_set_item_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_element_set_rule` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `parent_id` int(10) unsigned DEFAULT NULL,
			  `clause` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `value` varchar(255) COLLATE utf8_bin DEFAULT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `workflow_id` int(10) unsigned DEFAULT NULL,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_element_set_rule_parent_id_fk` (`parent_id`),
			  KEY `ophciexamination_element_set_rule_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_element_set_rule_created_user_id_fk` (`created_user_id`),
			  KEY `ophciexamination_element_set_rule_workflow_id_fk` (`workflow_id`),
			  CONSTRAINT `ophciexamination_element_set_rule_workflow_id_fk` FOREIGN KEY (`workflow_id`) REFERENCES `ophciexamination_workflow` (`id`),
			  CONSTRAINT `ophciexamination_element_set_rule_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_element_set_rule_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_element_set_rule_parent_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophciexamination_element_set_rule` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_event_elementset_assignment` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `step_id` int(10) unsigned NOT NULL,
			  `event_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `ophciexamination_event_ea_event_id_unique` (`event_id`),
			  KEY `ophciexamination_event_ea_step_id_fk` (`step_id`),
			  KEY `ophciexamination_event_ea_event_id_fk` (`event_id`),
			  KEY `ophciexamination_event_ea_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_event_ea_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_event_ea_step_id_fk` FOREIGN KEY (`step_id`) REFERENCES `ophciexamination_element_set` (`id`),
			  CONSTRAINT `ophciexamination_event_ea_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
			  CONSTRAINT `ophciexamination_event_ea_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_event_ea_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_glaucomarisk_risk` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(48) COLLATE utf8_bin NOT NULL,
			  `description` text COLLATE utf8_bin,
			  `follow_up` varchar(48) COLLATE utf8_bin DEFAULT NULL,
			  `review` varchar(48) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `class` varchar(16) COLLATE utf8_bin DEFAULT NULL,
			  `clinicoutcome_template_id` int(10) unsigned NOT NULL,
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_glaucomarisk_risk_coti_fk` (`clinicoutcome_template_id`),
			  KEY `ophciexamination_glaucomarisk_risk_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_glaucomarisk_risk_lmui_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_glaucomarisk_risk_coti_fk` FOREIGN KEY (`clinicoutcome_template_id`) REFERENCES `ophciexamination_clinicoutcome_template` (`id`),
			  CONSTRAINT `ophciexamination_glaucomarisk_risk_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_glaucomarisk_risk_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_gonioscopy_description` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(40) COLLATE utf8_bin NOT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `seen` tinyint(1) unsigned NOT NULL DEFAULT '1',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_gonioscopy_description_lmuid_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_gonioscopy_description_cuid_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_gonioscopy_description_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_gonioscopy_description_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_gonioscopy_van_herick` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(40) COLLATE utf8_bin NOT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_gonioscopy_van_herick_lmuid_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_gonioscopy_van_herick_cuid_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_gonioscopy_van_herick_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_gonioscopy_van_herick_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_injectmanagecomplex_answer` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL,
			  `question_id` int(10) unsigned NOT NULL,
			  `answer` tinyint(1) NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_injectmanagecomplex_answer_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_answer_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_answer_eli_fk` (`element_id`),
			  KEY `ophciexamination_injectmanagecomplex_answer_eyei_fk` (`eye_id`),
			  KEY `ophciexamination_injectmanagecomplex_answer_qi_fk` (`question_id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_answer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_answer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_answer_eli_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_answer_eyei_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_answer_qi_fk` FOREIGN KEY (`question_id`) REFERENCES `ophciexamination_injectmanagecomplex_question` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_injectmanagecomplex_notreatmentreason` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `enabled` tinyint(1) NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `other` tinyint(1) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_injectmanagecomplex_notreatmentreason_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_notreatmentreason_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_notreatmentreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_notreatmentreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_injectmanagecomplex_question` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `disorder_id` int(10) unsigned NOT NULL,
			  `question` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `enabled` tinyint(1) NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_injectmanagecomplex_question_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_question_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_question_disorder_fk` (`disorder_id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_question_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_question_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_question_disorder_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_injectmanagecomplex_risk` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(256) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `enabled` tinyint(1) NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_injectmanagecomplex_risk_assignment` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_id` int(10) unsigned NOT NULL,
			  `eye_id` int(10) unsigned NOT NULL DEFAULT '3',
			  `risk_id` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` (`element_id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` (`eye_id`),
			  KEY `ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` (`risk_id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
			  CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_injectmanagecomplex_risk` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_instrument` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `display_order` int(10) unsigned DEFAULT '1',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_instrument_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_instrument_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_instrument_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_instrument_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_intraocularpressure_reading` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(3) COLLATE utf8_bin DEFAULT NULL,
			  `value` int(10) unsigned DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_intraocularpressure_reading_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_intraocularpressure_reading_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_intraocularpressure_reading_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_intraocularpressure_reading_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_lasermanagement_lasertype` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `other` tinyint(1) NOT NULL DEFAULT '0',
			  `enabled` tinyint(1) NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_lasermanagement_lasertype_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_lasermanagement_lasertype_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_lasermanagement_lasertype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_lasermanagement_lasertype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_management_deferralreason` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `other` tinyint(1) NOT NULL DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_management_ldeferral_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_management_ldeferral_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_management_ldeferral_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_management_ldeferral_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_management_status` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(128) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `deferred` tinyint(1) NOT NULL DEFAULT '0',
			  `book` tinyint(1) NOT NULL DEFAULT '0',
			  `event` tinyint(1) NOT NULL DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_management_laser_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_management_laser_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_management_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_management_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_oct_method` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_oct_method_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_oct_method_lmui_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_oct_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_oct_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_opticdisc_cd_ratio` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_opticdisc_cd_ratio_c_u_id_fk` (`created_user_id`),
			  KEY `ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_opticdisc_cd_ratio_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_opticdisc_lens` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL,
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_opticdisc_lens_cui_fk` (`created_user_id`),
			  KEY `ophciexamination_opticdisc_lens_lmui_fk` (`last_modified_user_id`),
			  CONSTRAINT `ophciexamination_opticdisc_lens_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_opticdisc_lens_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_pupillaryabnormalities_abnormality` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(255) COLLATE utf8_bin NOT NULL,
			  `display_order` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `et_ophciexamination_pupillaryabnormalities_lmui_fk` (`last_modified_user_id`),
			  KEY `et_ophciexamination_pupillaryabnormalities_cui_fk` (`created_user_id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormalities_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `et_ophciexamination_pupillaryabnormalities_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_refraction_fraction` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(4) COLLATE utf8_bin DEFAULT NULL,
			  `value` varchar(3) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_refraction_fraction_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_refraction_fraction_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_refraction_fraction_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_refraction_fraction_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_refraction_integer` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `value` varchar(4) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_refraction_integer_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_refraction_integer_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_refraction_integer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_refraction_integer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_refraction_sign` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(4) COLLATE utf8_bin DEFAULT NULL,
			  `value` varchar(4) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_refraction_sign_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_refraction_sign_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_refraction_sign_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_refraction_sign_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_refraction_type` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(32) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_refraction_type_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_refraction_type_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_refraction_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_refraction_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_visual_acuity_unit` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(40) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `tooltip` tinyint(1) NOT NULL DEFAULT '0',
			  `information` text COLLATE utf8_bin,
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_visual_acuity_unit_lmuid_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_visual_acuity_unit_cuid_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_visual_acuity_unit_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_visual_acuity_unit_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_visual_acuity_unit_value` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `unit_id` int(10) unsigned NOT NULL,
			  `value` varchar(255) COLLATE utf8_bin NOT NULL,
			  `base_value` int(10) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `selectable` tinyint(1) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_visual_acuity_unit_value_unit_id_fk` (`unit_id`),
			  KEY `ophciexamination_visual_acuity_unit_value_lmuid_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_visual_acuity_unit_value_cuid_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_visual_acuity_unit_value_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_visual_acuity_unit_value_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_visual_acuity_unit_value_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_visualacuity_method` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(32) COLLATE utf8_bin DEFAULT NULL,
			  `display_order` tinyint(3) unsigned DEFAULT '0',
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_visualacuity_method_lmui_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_visualacuity_method_cui_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_visualacuity_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_visualacuity_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_visualacuity_reading` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `element_id` int(10) unsigned NOT NULL,
			  `value` int(10) unsigned NOT NULL,
			  `method_id` int(10) unsigned NOT NULL,
			  `side` tinyint(1) unsigned NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_visualacuity_reading_element_id_fk` (`element_id`),
			  KEY `ophciexamination_visualacuity_reading_method_id_fk` (`method_id`),
			  KEY `ophciexamination_visualacuity_reading_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_visualacuity_reading_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_visualacuity_reading_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_visualacuity` (`id`),
			  CONSTRAINT `ophciexamination_visualacuity_reading_method_id_fk` FOREIGN KEY (`method_id`) REFERENCES `ophciexamination_visualacuity_method` (`id`),
			  CONSTRAINT `ophciexamination_visualacuity_reading_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_visualacuity_reading_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->execute("CREATE TABLE `ophciexamination_workflow` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
			  `name` varchar(64) COLLATE utf8_bin NOT NULL,
			  `last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  `created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
			  `created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
			  PRIMARY KEY (`id`),
			  KEY `ophciexamination_workflow_last_modified_user_id_fk` (`last_modified_user_id`),
			  KEY `ophciexamination_workflow_created_user_id_fk` (`created_user_id`),
			  CONSTRAINT `ophciexamination_workflow_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
			  CONSTRAINT `ophciexamination_workflow_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");


		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->execute("SET foreign_key_checks = 1");
	}

	public function down()
	{
		// Remove tables
		$tables = array(
			'et_ophciexamination_adnexalcomorbidity',
			'et_ophciexamination_anteriorsegment',
			'et_ophciexamination_anteriorsegment_cct',
			'et_ophciexamination_cataractmanagement',
			'et_ophciexamination_clinicoutcome',
			'et_ophciexamination_comorbidities',
			'et_ophciexamination_conclusion',
			'et_ophciexamination_diagnoses',
			'et_ophciexamination_dilation',
			'et_ophciexamination_drgrading',
			'et_ophciexamination_glaucomarisk',
			'et_ophciexamination_gonioscopy',
			'et_ophciexamination_history',
			'et_ophciexamination_injectionmanagement',
			'et_ophciexamination_injectionmanagementcomplex',
			'et_ophciexamination_intraocularpressure',
			'et_ophciexamination_investigation',
			'et_ophciexamination_lasermanagement',
			'et_ophciexamination_management',
			'et_ophciexamination_oct',
			'et_ophciexamination_opticdisc',
			'et_ophciexamination_posteriorpole',
			'et_ophciexamination_pupillaryabnormalities',
			'et_ophciexamination_refraction',
			'et_ophciexamination_risks',
			'et_ophciexamination_visual_fields',
			'et_ophciexamination_visualacuity',
			'ophciexamination_anteriorsegment_cct_method',
			'ophciexamination_anteriorsegment_cortical',
			'ophciexamination_anteriorsegment_nuclear',
			'ophciexamination_anteriorsegment_pupil',
			'ophciexamination_attribute',
			'ophciexamination_attribute_element',
			'ophciexamination_attribute_option',
			'ophciexamination_cataractmanagement_eye',
			'ophciexamination_cataractmanagement_suitable_for_surgeon',
			'ophciexamination_clinicoutcome_role',
			'ophciexamination_clinicoutcome_status',
			'ophciexamination_clinicoutcome_template',
			'ophciexamination_comorbidities_assignment',
			'ophciexamination_comorbidities_item',
			'ophciexamination_diagnosis',
			'ophciexamination_dilation_drugs',
			'ophciexamination_dilation_treatment',
			'ophciexamination_drgrading_clinical',
			'ophciexamination_drgrading_nscmaculopathy',
			'ophciexamination_drgrading_nscretinopathy',
			'ophciexamination_element_set',
			'ophciexamination_element_set_item',
			'ophciexamination_element_set_rule',
			'ophciexamination_event_elementset_assignment',
			'ophciexamination_glaucomarisk_risk',
			'ophciexamination_gonioscopy_description',
			'ophciexamination_gonioscopy_van_herick',
			'ophciexamination_injectmanagecomplex_answer',
			'ophciexamination_injectmanagecomplex_notreatmentreason',
			'ophciexamination_injectmanagecomplex_question',
			'ophciexamination_injectmanagecomplex_risk',
			'ophciexamination_injectmanagecomplex_risk_assignment',
			'ophciexamination_instrument',
			'ophciexamination_intraocularpressure_reading',
			'ophciexamination_lasermanagement_lasertype',
			'ophciexamination_management_deferralreason',
			'ophciexamination_management_status',
			'ophciexamination_oct_method',
			'ophciexamination_opticdisc_cd_ratio',
			'ophciexamination_opticdisc_lens',
			'ophciexamination_pupillaryabnormalities_abnormality',
			'ophciexamination_refraction_fraction',
			'ophciexamination_refraction_integer',
			'ophciexamination_refraction_sign',
			'ophciexamination_refraction_type',
			'ophciexamination_visual_acuity_unit',
			'ophciexamination_visual_acuity_unit_value',
			'ophciexamination_visualacuity_method',
			'ophciexamination_visualacuity_reading',
			'ophciexamination_workflow'
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
