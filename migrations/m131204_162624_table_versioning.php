<?php

class m131204_162624_table_versioning extends CDbMigration
{
	public function up()
	{
		$this->execute("
CREATE TABLE `et_ophciexamination_adnexalcomorbidity_version` (
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
	KEY `acv_et_ophciexamination_adnexalcomorbidity_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_adnexalcomorbidity_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_adnexalcomorbidity_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_adnexalcomorbidity_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_adnexalcomorbidity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_adnexalcomorbidity_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_adnexalcomorbidity_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_adnexalcomorbidity_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_adnexalcomorbidity_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_adnexalcomorbidity_version');

		$this->createIndex('et_ophciexamination_adnexalcomorbidity_aid_fk','et_ophciexamination_adnexalcomorbidity_version','id');
		$this->addForeignKey('et_ophciexamination_adnexalcomorbidity_aid_fk','et_ophciexamination_adnexalcomorbidity_version','id','et_ophciexamination_adnexalcomorbidity','id');

		$this->addColumn('et_ophciexamination_adnexalcomorbidity_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_adnexalcomorbidity_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_adnexalcomorbidity_version','version_id');
		$this->alterColumn('et_ophciexamination_adnexalcomorbidity_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_anteriorsegment_version` (
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
	KEY `acv_et_ophciexamination_anteriorsegment_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_ei_fk` (`event_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_rni_fk` (`right_nuclear_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_lni_fk` (`left_nuclear_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_rpi_fk` (`right_pupil_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_lpi_fk` (`left_pupil_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_rci_fk` (`right_cortical_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_lci_fk` (`left_cortical_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_ei_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_lci_fk` FOREIGN KEY (`left_cortical_id`) REFERENCES `ophciexamination_anteriorsegment_cortical` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_lni_fk` FOREIGN KEY (`left_nuclear_id`) REFERENCES `ophciexamination_anteriorsegment_nuclear` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_lpi_fk` FOREIGN KEY (`left_pupil_id`) REFERENCES `ophciexamination_anteriorsegment_pupil` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_rci_fk` FOREIGN KEY (`right_cortical_id`) REFERENCES `ophciexamination_anteriorsegment_cortical` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_rni_fk` FOREIGN KEY (`right_nuclear_id`) REFERENCES `ophciexamination_anteriorsegment_nuclear` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_rpi_fk` FOREIGN KEY (`right_pupil_id`) REFERENCES `ophciexamination_anteriorsegment_pupil` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_anteriorsegment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_anteriorsegment_version');

		$this->createIndex('et_ophciexamination_anteriorsegment_aid_fk','et_ophciexamination_anteriorsegment_version','id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_aid_fk','et_ophciexamination_anteriorsegment_version','id','et_ophciexamination_anteriorsegment','id');

		$this->addColumn('et_ophciexamination_anteriorsegment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_anteriorsegment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_anteriorsegment_version','version_id');
		$this->alterColumn('et_ophciexamination_anteriorsegment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_anteriorsegment_cct_version` (
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
	KEY `acv_et_ophciexamination_anteriorsegment_cct_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_cct_eye_id_fk` (`eye_id`),
	KEY `acv_phciexamination_anteriorsegment_cct_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_cct_created_user_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_cct_lmi_fk` (`left_method_id`),
	KEY `acv_et_ophciexamination_anteriorsegment_cct_rmi_fk` (`right_method_id`),
	CONSTRAINT `acv_phciexamination_anteriorsegment_cct_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cct_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cct_lmi_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`),
	CONSTRAINT `acv_et_ophciexamination_anteriorsegment_cct_rmi_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_anteriorsegment_cct_method` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_anteriorsegment_cct_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_anteriorsegment_cct_version');

		$this->createIndex('et_ophciexamination_anteriorsegment_cct_aid_fk','et_ophciexamination_anteriorsegment_cct_version','id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_cct_aid_fk','et_ophciexamination_anteriorsegment_cct_version','id','et_ophciexamination_anteriorsegment_cct','id');

		$this->addColumn('et_ophciexamination_anteriorsegment_cct_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_anteriorsegment_cct_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_anteriorsegment_cct_version','version_id');
		$this->alterColumn('et_ophciexamination_anteriorsegment_cct_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_cataractmanagement_version` (
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
	KEY `acv_et_ophciexamination_management_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_management_suitable_for_surgeon_id_fk` (`suitable_for_surgeon_id`),
	KEY `acv_et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_management_created_user_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_cataractmanagement_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_cataractmanagement_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `ophciexamination_cataractmanagement_eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_catmanagement_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_catmanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_catmanagement_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_catmanagement_suitable_for_surgeon_id_fk` FOREIGN KEY (`suitable_for_surgeon_id`) REFERENCES `ophciexamination_cataractmanagement_suitable_for_surgeon` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_cataractmanagement_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_cataractmanagement_version');

		$this->createIndex('et_ophciexamination_cataractmanagement_aid_fk','et_ophciexamination_cataractmanagement_version','id');
		$this->addForeignKey('et_ophciexamination_cataractmanagement_aid_fk','et_ophciexamination_cataractmanagement_version','id','et_ophciexamination_cataractmanagement','id');

		$this->addColumn('et_ophciexamination_cataractmanagement_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_cataractmanagement_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_cataractmanagement_version','version_id');
		$this->alterColumn('et_ophciexamination_cataractmanagement_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_clinicoutcome_version` (
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
	KEY `acv_et_ophciexamination_clinicoutcome_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_clinicoutcome_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_clinicoutcome_status_fk` (`status_id`),
	KEY `acv_et_ophciexamination_clinicoutcome_fup_p_fk` (`followup_period_id`),
	KEY `acv_et_ophciexamination_clinicoutcome_ri_fk` (`role_id`),
	KEY `acv_et_ophciexamination_clinicoutcome_event_id_fk` (`event_id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_fup_p_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_ri_fk` FOREIGN KEY (`role_id`) REFERENCES `ophciexamination_clinicoutcome_role` (`id`),
	CONSTRAINT `acv_et_ophciexamination_clinicoutcome_status_fk` FOREIGN KEY (`status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_clinicoutcome_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_clinicoutcome_version');

		$this->createIndex('et_ophciexamination_clinicoutcome_aid_fk','et_ophciexamination_clinicoutcome_version','id');
		$this->addForeignKey('et_ophciexamination_clinicoutcome_aid_fk','et_ophciexamination_clinicoutcome_version','id','et_ophciexamination_clinicoutcome','id');

		$this->addColumn('et_ophciexamination_clinicoutcome_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_clinicoutcome_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_clinicoutcome_version','version_id');
		$this->alterColumn('et_ophciexamination_clinicoutcome_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_comorbidities_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`comments` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_risks_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_risks_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_risks_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_et_ophciexamination_risks_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_risks_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_risks_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_comorbidities_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_comorbidities_version');

		$this->createIndex('et_ophciexamination_comorbidities_aid_fk','et_ophciexamination_comorbidities_version','id');
		$this->addForeignKey('et_ophciexamination_comorbidities_aid_fk','et_ophciexamination_comorbidities_version','id','et_ophciexamination_comorbidities','id');

		$this->addColumn('et_ophciexamination_comorbidities_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_comorbidities_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_comorbidities_version','version_id');
		$this->alterColumn('et_ophciexamination_comorbidities_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_conclusion_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`description` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_conclusion_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_conclusion_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_conclusion_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_et_ophciexamination_conclusion_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_conclusion_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_conclusion_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_conclusion_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_conclusion_version');

		$this->createIndex('et_ophciexamination_conclusion_aid_fk','et_ophciexamination_conclusion_version','id');
		$this->addForeignKey('et_ophciexamination_conclusion_aid_fk','et_ophciexamination_conclusion_version','id','et_ophciexamination_conclusion','id');

		$this->addColumn('et_ophciexamination_conclusion_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_conclusion_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_conclusion_version','version_id');
		$this->alterColumn('et_ophciexamination_conclusion_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_diagnoses_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_diagnosis_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_diagnosis_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_diagnosis_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_et_ophciexamination_diagnosis_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_diagnosis_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_diagnosis_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_diagnoses_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_diagnoses_version');

		$this->createIndex('et_ophciexamination_diagnoses_aid_fk','et_ophciexamination_diagnoses_version','id');
		$this->addForeignKey('et_ophciexamination_diagnoses_aid_fk','et_ophciexamination_diagnoses_version','id','et_ophciexamination_diagnoses','id');

		$this->addColumn('et_ophciexamination_diagnoses_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_diagnoses_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_diagnoses_version','version_id');
		$this->alterColumn('et_ophciexamination_diagnoses_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_dilation_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL DEFAULT '3',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_dilation_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_dilation_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_dilation_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_dilation_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophciexamination_dilation_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_dilation_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_dilation_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_dilation_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_dilation_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_dilation_version');

		$this->createIndex('et_ophciexamination_dilation_aid_fk','et_ophciexamination_dilation_version','id');
		$this->addForeignKey('et_ophciexamination_dilation_aid_fk','et_ophciexamination_dilation_version','id','et_ophciexamination_dilation','id');

		$this->addColumn('et_ophciexamination_dilation_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_dilation_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_dilation_version','version_id');
		$this->alterColumn('et_ophciexamination_dilation_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_drgrading_version` (
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
	`left_clinicalret_id` int(10) unsigned DEFAULT NULL,
	`right_clinicalret_id` int(10) unsigned DEFAULT NULL,
	`eye_id` int(10) unsigned DEFAULT '3',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`secondarydiagnosis_id` int(10) unsigned DEFAULT NULL,
	`secondarydiagnosis_disorder_id` int(10) unsigned DEFAULT NULL,
	`left_clinicalmac_id` int(10) unsigned DEFAULT NULL,
	`right_clinicalmac_id` int(10) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_drgrading_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_drgrading_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_drgrading_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_drgrading_l_nret_fk` (`left_nscretinopathy_id`),
	KEY `acv_et_ophciexamination_drgrading_r_nret_fk` (`right_nscretinopathy_id`),
	KEY `acv_et_ophciexamination_drgrading_l_nmac_fk` (`left_nscmaculopathy_id`),
	KEY `acv_et_ophciexamination_drgrading_r_nmac_fk` (`right_nscmaculopathy_id`),
	KEY `acv_et_ophciexamination_drgrading_l_clinical_fk` (`left_clinicalret_id`),
	KEY `acv_et_ophciexamination_drgrading_r_clinical_fk` (`right_clinicalret_id`),
	KEY `acv_et_ophciexamination_drgrading_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_drgrading_l_clinmac_fk` (`left_clinicalmac_id`),
	KEY `acv_et_ophciexamination_drgrading_r_clinmac_fk` (`right_clinicalmac_id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_r_clinmac_fk` FOREIGN KEY (`right_clinicalmac_id`) REFERENCES `ophciexamination_drgrading_clinicalmaculopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_l_clinmac_fk` FOREIGN KEY (`left_clinicalmac_id`) REFERENCES `ophciexamination_drgrading_clinicalmaculopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_l_clinret_fk` FOREIGN KEY (`left_clinicalret_id`) REFERENCES `ophciexamination_drgrading_clinicalretinopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_l_nmac_fk` FOREIGN KEY (`left_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_l_nret_fk` FOREIGN KEY (`left_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_r_clinret_fk` FOREIGN KEY (`right_clinicalret_id`) REFERENCES `ophciexamination_drgrading_clinicalretinopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_r_nmac_fk` FOREIGN KEY (`right_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`),
	CONSTRAINT `acv_et_ophciexamination_drgrading_r_nret_fk` FOREIGN KEY (`right_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_drgrading_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_drgrading_version');

		$this->createIndex('et_ophciexamination_drgrading_aid_fk','et_ophciexamination_drgrading_version','id');
		$this->addForeignKey('et_ophciexamination_drgrading_aid_fk','et_ophciexamination_drgrading_version','id','et_ophciexamination_drgrading','id');

		$this->addColumn('et_ophciexamination_drgrading_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_drgrading_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_drgrading_version','version_id');
		$this->alterColumn('et_ophciexamination_drgrading_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_glaucomarisk_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`risk_id` int(10) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_glaucomarisk_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_glaucomarisk_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_glaucomarisk_created_user_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_glaucomarisk_risk_id_fk` (`risk_id`),
	CONSTRAINT `acv_et_ophciexamination_glaucomarisk_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_glaucomarisk_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_glaucomarisk_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_glaucomarisk_risk_id_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_glaucomarisk_risk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_glaucomarisk_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_glaucomarisk_version');

		$this->createIndex('et_ophciexamination_glaucomarisk_aid_fk','et_ophciexamination_glaucomarisk_version','id');
		$this->addForeignKey('et_ophciexamination_glaucomarisk_aid_fk','et_ophciexamination_glaucomarisk_version','id','et_ophciexamination_glaucomarisk','id');

		$this->addColumn('et_ophciexamination_glaucomarisk_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_glaucomarisk_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_glaucomarisk_version','version_id');
		$this->alterColumn('et_ophciexamination_glaucomarisk_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_gonioscopy_version` (
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
	KEY `acv_et_ophciexamination_gonioscopy_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_gonioscopy_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_gonioscopy_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_gonioscopy_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_gonioscopy_left_gonio_sup_id_fk` (`left_gonio_sup_id`),
	KEY `acv_et_ophciexamination_gonioscopy_right_gonio_sup_id_fk` (`right_gonio_sup_id`),
	KEY `acv_et_ophciexamination_gonioscopy_left_gonio_tem_id_fk` (`left_gonio_tem_id`),
	KEY `acv_et_ophciexamination_gonioscopy_right_gonio_tem_id_fk` (`right_gonio_tem_id`),
	KEY `acv_et_ophciexamination_gonioscopy_left_gonio_nas_id_fk` (`left_gonio_nas_id`),
	KEY `acv_et_ophciexamination_gonioscopy_right_gonio_nas_id_fk` (`right_gonio_nas_id`),
	KEY `acv_et_ophciexamination_gonioscopy_left_gonio_inf_id_fk` (`left_gonio_inf_id`),
	KEY `acv_et_ophciexamination_gonioscopy_right_gonio_inf_id_fk` (`right_gonio_inf_id`),
	KEY `acv_et_ophciexamination_gonioscopy_left_van_herick_id_fk` (`left_van_herick_id`),
	KEY `acv_et_ophciexamination_gonioscopy_right_van_herick_id_fk` (`right_van_herick_id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_right_van_herick_id_fk` FOREIGN KEY (`right_van_herick_id`) REFERENCES `ophciexamination_gonioscopy_van_herick` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_left_gonio_inf_id_fk` FOREIGN KEY (`left_gonio_inf_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_left_gonio_nas_id_fk` FOREIGN KEY (`left_gonio_nas_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_left_gonio_sup_id_fk` FOREIGN KEY (`left_gonio_sup_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_left_gonio_tem_id_fk` FOREIGN KEY (`left_gonio_tem_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_left_van_herick_id_fk` FOREIGN KEY (`left_van_herick_id`) REFERENCES `ophciexamination_gonioscopy_van_herick` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_right_gonio_inf_id_fk` FOREIGN KEY (`right_gonio_inf_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_right_gonio_nas_id_fk` FOREIGN KEY (`right_gonio_nas_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_right_gonio_sup_id_fk` FOREIGN KEY (`right_gonio_sup_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`),
	CONSTRAINT `acv_et_ophciexamination_gonioscopy_right_gonio_tem_id_fk` FOREIGN KEY (`right_gonio_tem_id`) REFERENCES `ophciexamination_gonioscopy_description` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_gonioscopy_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_gonioscopy_version');

		$this->createIndex('et_ophciexamination_gonioscopy_aid_fk','et_ophciexamination_gonioscopy_version','id');
		$this->addForeignKey('et_ophciexamination_gonioscopy_aid_fk','et_ophciexamination_gonioscopy_version','id','et_ophciexamination_gonioscopy','id');

		$this->addColumn('et_ophciexamination_gonioscopy_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_gonioscopy_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_gonioscopy_version','version_id');
		$this->alterColumn('et_ophciexamination_gonioscopy_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_history_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`description` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_history_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_history_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_history_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_et_ophciexamination_history_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_history_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_history_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_history_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_history_version');

		$this->createIndex('et_ophciexamination_history_aid_fk','et_ophciexamination_history_version','id');
		$this->addForeignKey('et_ophciexamination_history_aid_fk','et_ophciexamination_history_version','id','et_ophciexamination_history','id');

		$this->addColumn('et_ophciexamination_history_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_history_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_history_version','version_id');
		$this->alterColumn('et_ophciexamination_history_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_injectionmanagement_version` (
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
	KEY `acv_et_ophciexamination_injectionmanagement_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_injectionmanagement_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_injectionmanagement_injection_fk` (`injection_status_id`),
	KEY `acv_et_ophciexamination_injectionmanagement_ideferral_fk` (`injection_deferralreason_id`),
	KEY `acv_et_ophciexamination_injectionmanagement_event_id_fk` (`event_id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagement_injection_fk` FOREIGN KEY (`injection_status_id`) REFERENCES `ophciexamination_management_status` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagement_ideferral_fk` FOREIGN KEY (`injection_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_injectionmanagement_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_injectionmanagement_version');

		$this->createIndex('et_ophciexamination_injectionmanagement_aid_fk','et_ophciexamination_injectionmanagement_version','id');
		$this->addForeignKey('et_ophciexamination_injectionmanagement_aid_fk','et_ophciexamination_injectionmanagement_version','id','et_ophciexamination_injectionmanagement','id');

		$this->addColumn('et_ophciexamination_injectionmanagement_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_injectionmanagement_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_injectionmanagement_version','version_id');
		$this->alterColumn('et_ophciexamination_injectionmanagement_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_injectionmanagementcomplex_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned DEFAULT '3',
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
	`left_no_treatment` tinyint(1) DEFAULT NULL,
	`right_no_treatment` tinyint(1) DEFAULT NULL,
	`left_no_treatment_reason_id` int(10) unsigned DEFAULT NULL,
	`right_no_treatment_reason_id` int(10) unsigned DEFAULT NULL,
	`left_no_treatment_reason_other` text COLLATE utf8_bin,
	`right_no_treatment_reason_other` text COLLATE utf8_bin,
	`left_treatment_id` int(10) unsigned DEFAULT NULL,
	`right_treatment_id` int(10) unsigned DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_eye_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` (`left_diagnosis1_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` (`right_diagnosis1_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` (`left_diagnosis2_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` (`right_diagnosis2_id`),
	KEY `acv_et_ophciexamination_injectionmanagementcomplex_event_id_fk` (`event_id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_eye_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` FOREIGN KEY (`left_diagnosis1_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` FOREIGN KEY (`left_diagnosis2_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` FOREIGN KEY (`right_diagnosis1_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` FOREIGN KEY (`right_diagnosis2_id`) REFERENCES `disorder` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_injectionmanagementcomplex_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_injectionmanagementcomplex_version');

		$this->createIndex('et_ophciexamination_injectionmanagementcomplex_aid_fk','et_ophciexamination_injectionmanagementcomplex_version','id');
		$this->addForeignKey('et_ophciexamination_injectionmanagementcomplex_aid_fk','et_ophciexamination_injectionmanagementcomplex_version','id','et_ophciexamination_injectionmanagementcomplex','id');

		$this->addColumn('et_ophciexamination_injectionmanagementcomplex_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_injectionmanagementcomplex_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_injectionmanagementcomplex_version','version_id');
		$this->alterColumn('et_ophciexamination_injectionmanagementcomplex_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_intraocularpressure_version` (
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
	KEY `acv_et_ophciexamination_intraocularpressure_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_li_fk` (`left_instrument_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_ri_fk` (`right_instrument_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_lri_fk` (`left_reading_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_rri_fk` (`right_reading_id`),
	KEY `acv_et_ophciexamination_intraocularpressure_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_li_fk` FOREIGN KEY (`left_instrument_id`) REFERENCES `ophciexamination_instrument` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_lri_fk` FOREIGN KEY (`left_reading_id`) REFERENCES `ophciexamination_intraocularpressure_reading` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_ri_fk` FOREIGN KEY (`right_instrument_id`) REFERENCES `ophciexamination_instrument` (`id`),
	CONSTRAINT `acv_et_ophciexamination_intraocularpressure_rri_fk` FOREIGN KEY (`right_reading_id`) REFERENCES `ophciexamination_intraocularpressure_reading` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_intraocularpressure_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_intraocularpressure_version');

		$this->createIndex('et_ophciexamination_intraocularpressure_aid_fk','et_ophciexamination_intraocularpressure_version','id');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_aid_fk','et_ophciexamination_intraocularpressure_version','id','et_ophciexamination_intraocularpressure','id');

		$this->addColumn('et_ophciexamination_intraocularpressure_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_intraocularpressure_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_intraocularpressure_version','version_id');
		$this->alterColumn('et_ophciexamination_intraocularpressure_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_investigation_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`description` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_investigation_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_investigation_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_investigation_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_et_ophciexamination_investigation_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_investigation_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_investigation_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_investigation_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_investigation_version');

		$this->createIndex('et_ophciexamination_investigation_aid_fk','et_ophciexamination_investigation_version','id');
		$this->addForeignKey('et_ophciexamination_investigation_aid_fk','et_ophciexamination_investigation_version','id','et_ophciexamination_investigation','id');

		$this->addColumn('et_ophciexamination_investigation_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_investigation_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_investigation_version','version_id');
		$this->alterColumn('et_ophciexamination_investigation_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_lasermanagement_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
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
	`left_laser_status_id` int(10) unsigned DEFAULT NULL,
	`right_laser_status_id` int(10) unsigned DEFAULT NULL,
	`left_laser_deferralreason_id` int(10) unsigned DEFAULT NULL,
	`right_laser_deferralreason_id` int(10) unsigned DEFAULT NULL,
	`left_laser_deferralreason_other` text COLLATE utf8_bin,
	`right_laser_deferralreason_other` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_lasermanagement_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_lasermanagement_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_lasermanagement_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_lasermanagement_llt_fk` (`left_lasertype_id`),
	KEY `acv_et_ophciexamination_lasermanagement_rlt_fk` (`right_lasertype_id`),
	KEY `acv_et_ophciexamination_lasermanagement_l_laser_fk` (`left_laser_status_id`),
	KEY `acv_et_ophciexamination_lasermanagement_r_laser_fk` (`right_laser_status_id`),
	KEY `acv_et_ophciexamination_lasermanagement_l_ldeferral_fk` (`left_laser_deferralreason_id`),
	KEY `acv_et_ophciexamination_lasermanagement_r_ldeferral_fk` (`right_laser_deferralreason_id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_llt_fk` FOREIGN KEY (`left_lasertype_id`) REFERENCES `ophciexamination_lasermanagement_lasertype` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_l_laser_fk` FOREIGN KEY (`left_laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_l_ldeferral_fk` FOREIGN KEY (`left_laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_rlt_fk` FOREIGN KEY (`right_lasertype_id`) REFERENCES `ophciexamination_lasermanagement_lasertype` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_r_laser_fk` FOREIGN KEY (`right_laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`),
	CONSTRAINT `acv_et_ophciexamination_lasermanagement_r_ldeferral_fk` FOREIGN KEY (`right_laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_lasermanagement_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_lasermanagement_version');

		$this->createIndex('et_ophciexamination_lasermanagement_aid_fk','et_ophciexamination_lasermanagement_version','id');
		$this->addForeignKey('et_ophciexamination_lasermanagement_aid_fk','et_ophciexamination_lasermanagement_version','id','et_ophciexamination_lasermanagement','id');

		$this->addColumn('et_ophciexamination_lasermanagement_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_lasermanagement_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_lasermanagement_version','version_id');
		$this->alterColumn('et_ophciexamination_lasermanagement_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_management_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`comments` text COLLATE utf8_bin,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_management_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_management_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_management_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophciexamination_management_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_management_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_management_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_management_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_management_version');

		$this->createIndex('et_ophciexamination_management_aid_fk','et_ophciexamination_management_version','id');
		$this->addForeignKey('et_ophciexamination_management_aid_fk','et_ophciexamination_management_version','id','et_ophciexamination_management','id');

		$this->addColumn('et_ophciexamination_management_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_management_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_management_version','version_id');
		$this->alterColumn('et_ophciexamination_management_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_oct_version` (
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
	`left_thickness_increase` tinyint(1) DEFAULT NULL,
	`right_thickness_increase` tinyint(1) DEFAULT NULL,
	`left_dry` tinyint(1) DEFAULT NULL,
	`right_dry` tinyint(1) DEFAULT NULL,
	`left_fluidstatus_id` int(10) unsigned DEFAULT NULL,
	`right_fluidstatus_id` int(10) unsigned DEFAULT NULL,
	`left_comments` text COLLATE utf8_bin,
	`right_comments` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_oct_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_oct_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_oct_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_oct_created_user_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_oct_lmid_fk` (`left_method_id`),
	KEY `acv_et_ophciexamination_oct_rmid_fk` (`right_method_id`),
	KEY `acv_et_ophciexamination_oct_lfs_fk` (`left_fluidstatus_id`),
	KEY `acv_et_ophciexamination_oct_rfs_fk` (`right_fluidstatus_id`),
	CONSTRAINT `acv_et_ophciexamination_oct_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_lfs_fk` FOREIGN KEY (`left_fluidstatus_id`) REFERENCES `ophciexamination_oct_fluidstatus` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_lmid_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_oct_method` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_rfs_fk` FOREIGN KEY (`right_fluidstatus_id`) REFERENCES `ophciexamination_oct_fluidstatus` (`id`),
	CONSTRAINT `acv_et_ophciexamination_oct_rmid_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_oct_method` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_oct_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_oct_version');

		$this->createIndex('et_ophciexamination_oct_aid_fk','et_ophciexamination_oct_version','id');
		$this->addForeignKey('et_ophciexamination_oct_aid_fk','et_ophciexamination_oct_version','id','et_ophciexamination_oct','id');

		$this->addColumn('et_ophciexamination_oct_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_oct_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_oct_version','version_id');
		$this->alterColumn('et_ophciexamination_oct_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_opticdisc_version` (
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
	KEY `acv_et_ophciexamination_opticdisc_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_opticdisc_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_opticdisc_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_opticdisc_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_opticdisc_left_cd_ratio_id_fk` (`left_cd_ratio_id`),
	KEY `acv_et_ophciexamination_opticdisc_right_cd_ratio_id_fk` (`right_cd_ratio_id`),
	KEY `acv_et_ophciexamination_opticdisc_lli` (`left_lens_id`),
	KEY `acv_et_ophciexamination_opticdisc_rli` (`right_lens_id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_left_cd_ratio_id_fk` FOREIGN KEY (`left_cd_ratio_id`) REFERENCES `ophciexamination_opticdisc_cd_ratio` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_lli` FOREIGN KEY (`left_lens_id`) REFERENCES `ophciexamination_opticdisc_lens` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_right_cd_ratio_id_fk` FOREIGN KEY (`right_cd_ratio_id`) REFERENCES `ophciexamination_opticdisc_cd_ratio` (`id`),
	CONSTRAINT `acv_et_ophciexamination_opticdisc_rli` FOREIGN KEY (`right_lens_id`) REFERENCES `ophciexamination_opticdisc_lens` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_opticdisc_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_opticdisc_version');

		$this->createIndex('et_ophciexamination_opticdisc_aid_fk','et_ophciexamination_opticdisc_version','id');
		$this->addForeignKey('et_ophciexamination_opticdisc_aid_fk','et_ophciexamination_opticdisc_version','id','et_ophciexamination_opticdisc','id');

		$this->addColumn('et_ophciexamination_opticdisc_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_opticdisc_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_opticdisc_version','version_id');
		$this->alterColumn('et_ophciexamination_opticdisc_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_posteriorpole_version` (
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
	KEY `acv_et_ophciexamination_posteriorpole_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_posteriorpole_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_posteriorpole_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_posteriorpole_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_posteriorpole_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_posteriorpole_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_posteriorpole_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_posteriorpole_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_posteriorpole_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_posteriorpole_version');

		$this->createIndex('et_ophciexamination_posteriorpole_aid_fk','et_ophciexamination_posteriorpole_version','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_aid_fk','et_ophciexamination_posteriorpole_version','id','et_ophciexamination_posteriorpole','id');

		$this->addColumn('et_ophciexamination_posteriorpole_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_posteriorpole_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_posteriorpole_version','version_id');
		$this->alterColumn('et_ophciexamination_posteriorpole_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_pupillaryabnormalities_version` (
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
	KEY `acv_et_ophciexamination_pupillaryabnormal_ei_fk` (`event_id`),
	KEY `acv_et_ophciexamination_pupillaryabnormal_lmi_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_pupillaryabnormal_cui_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_pupillaryabnormal_lai_fk` (`left_abnormality_id`),
	KEY `acv_et_ophciexamination_pupillaryabnormal_rai_fk` (`right_abnormality_id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormal_ei_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormal_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormal_lmi_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormal_lai_fk` FOREIGN KEY (`left_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormal_rai_fk` FOREIGN KEY (`right_abnormality_id`) REFERENCES `ophciexamination_pupillaryabnormalities_abnormality` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_pupillaryabnormalities_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_pupillaryabnormalities_version');

		$this->createIndex('et_ophciexamination_pupillaryabnormalities_aid_fk','et_ophciexamination_pupillaryabnormalities_version','id');
		$this->addForeignKey('et_ophciexamination_pupillaryabnormalities_aid_fk','et_ophciexamination_pupillaryabnormalities_version','id','et_ophciexamination_pupillaryabnormalities','id');

		$this->addColumn('et_ophciexamination_pupillaryabnormalities_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_pupillaryabnormalities_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_pupillaryabnormalities_version','version_id');
		$this->alterColumn('et_ophciexamination_pupillaryabnormalities_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_refraction_version` (
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
	KEY `acv_et_ophciexamination_refraction_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_refraction_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_refraction_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_refraction_lti_fk` (`left_type_id`),
	KEY `acv_et_ophciexamination_refraction_rti_fk` (`right_type_id`),
	KEY `acv_et_ophciexamination_refraction_eye_id_fk` (`eye_id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_lti_fk` FOREIGN KEY (`left_type_id`) REFERENCES `ophciexamination_refraction_type` (`id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_refraction_rti_fk` FOREIGN KEY (`right_type_id`) REFERENCES `ophciexamination_refraction_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_refraction_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_refraction_version');

		$this->createIndex('et_ophciexamination_refraction_aid_fk','et_ophciexamination_refraction_version','id');
		$this->addForeignKey('et_ophciexamination_refraction_aid_fk','et_ophciexamination_refraction_version','id','et_ophciexamination_refraction','id');

		$this->addColumn('et_ophciexamination_refraction_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_refraction_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_refraction_version','version_id');
		$this->alterColumn('et_ophciexamination_refraction_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_risks_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`comments` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_risks_event_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_risks_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_risks_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophciexamination_risks_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_risks_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_risks_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_risks_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_risks_version');

		$this->createIndex('et_ophciexamination_risks_aid_fk','et_ophciexamination_risks_version','id');
		$this->addForeignKey('et_ophciexamination_risks_aid_fk','et_ophciexamination_risks_version','id','et_ophciexamination_risks','id');

		$this->addColumn('et_ophciexamination_risks_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_risks_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_risks_version','version_id');
		$this->alterColumn('et_ophciexamination_risks_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `et_ophciexamination_visualacuity_version` (
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
	KEY `acv_et_ophciexamination_visualacuity_e_id_fk` (`event_id`),
	KEY `acv_et_ophciexamination_visualacuity_c_u_id_fk` (`created_user_id`),
	KEY `acv_et_ophciexamination_visualacuity_l_m_u_id_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_visualacuity_eye_id_fk` (`eye_id`),
	KEY `acv_et_ophciexamination_visualacuity_unit_fk` (`unit_id`),
	CONSTRAINT `acv_et_ophciexamination_visualacuity_unit_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`),
	CONSTRAINT `acv_et_ophciexamination_visualacuity_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_visualacuity_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_et_ophciexamination_visualacuity_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_et_ophciexamination_visualacuity_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('et_ophciexamination_visualacuity_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','et_ophciexamination_visualacuity_version');

		$this->createIndex('et_ophciexamination_visualacuity_aid_fk','et_ophciexamination_visualacuity_version','id');
		$this->addForeignKey('et_ophciexamination_visualacuity_aid_fk','et_ophciexamination_visualacuity_version','id','et_ophciexamination_visualacuity','id');

		$this->addColumn('et_ophciexamination_visualacuity_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('et_ophciexamination_visualacuity_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','et_ophciexamination_visualacuity_version','version_id');
		$this->alterColumn('et_ophciexamination_visualacuity_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_anteriorsegment_cct_method_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL,
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_anteriorsegment_cct_method_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_anteriorsegment_cct_method_lmui_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_cct_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_cct_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_anteriorsegment_cct_method_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_anteriorsegment_cct_method_version');

		$this->createIndex('ophciexamination_anteriorsegment_cct_method_aid_fk','ophciexamination_anteriorsegment_cct_method_version','id');
		$this->addForeignKey('ophciexamination_anteriorsegment_cct_method_aid_fk','ophciexamination_anteriorsegment_cct_method_version','id','ophciexamination_anteriorsegment_cct_method','id');

		$this->addColumn('ophciexamination_anteriorsegment_cct_method_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_anteriorsegment_cct_method_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_anteriorsegment_cct_method_version','version_id');
		$this->alterColumn('ophciexamination_anteriorsegment_cct_method_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_anteriorsegment_cortical_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_anteriorsegment_cortical_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_anteriorsegment_cortical_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_cortical_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_cortical_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_anteriorsegment_cortical_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_anteriorsegment_cortical_version');

		$this->createIndex('ophciexamination_anteriorsegment_cortical_aid_fk','ophciexamination_anteriorsegment_cortical_version','id');
		$this->addForeignKey('ophciexamination_anteriorsegment_cortical_aid_fk','ophciexamination_anteriorsegment_cortical_version','id','ophciexamination_anteriorsegment_cortical','id');

		$this->addColumn('ophciexamination_anteriorsegment_cortical_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_anteriorsegment_cortical_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_anteriorsegment_cortical_version','version_id');
		$this->alterColumn('ophciexamination_anteriorsegment_cortical_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_anteriorsegment_nuclear_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_anteriorsegment_nuclear_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_anteriorsegment_nuclear_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_nuclear_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_nuclear_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_anteriorsegment_nuclear_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_anteriorsegment_nuclear_version');

		$this->createIndex('ophciexamination_anteriorsegment_nuclear_aid_fk','ophciexamination_anteriorsegment_nuclear_version','id');
		$this->addForeignKey('ophciexamination_anteriorsegment_nuclear_aid_fk','ophciexamination_anteriorsegment_nuclear_version','id','ophciexamination_anteriorsegment_nuclear','id');

		$this->addColumn('ophciexamination_anteriorsegment_nuclear_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_anteriorsegment_nuclear_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_anteriorsegment_nuclear_version','version_id');
		$this->alterColumn('ophciexamination_anteriorsegment_nuclear_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_anteriorsegment_pupil_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`value` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_anteriorsegment_pupil_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_anteriorsegment_pupil_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_pupil_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_anteriorsegment_pupil_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_anteriorsegment_pupil_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_anteriorsegment_pupil_version');

		$this->createIndex('ophciexamination_anteriorsegment_pupil_aid_fk','ophciexamination_anteriorsegment_pupil_version','id');
		$this->addForeignKey('ophciexamination_anteriorsegment_pupil_aid_fk','ophciexamination_anteriorsegment_pupil_version','id','ophciexamination_anteriorsegment_pupil','id');

		$this->addColumn('ophciexamination_anteriorsegment_pupil_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_anteriorsegment_pupil_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_anteriorsegment_pupil_version','version_id');
		$this->alterColumn('ophciexamination_anteriorsegment_pupil_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_attribute_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(40) COLLATE utf8_bin NOT NULL,
	`label` varchar(255) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_attribute_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_attribute_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_attribute_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_attribute_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_attribute_version');

		$this->createIndex('ophciexamination_attribute_aid_fk','ophciexamination_attribute_version','id');
		$this->addForeignKey('ophciexamination_attribute_aid_fk','ophciexamination_attribute_version','id','ophciexamination_attribute','id');

		$this->addColumn('ophciexamination_attribute_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_attribute_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_attribute_version','version_id');
		$this->alterColumn('ophciexamination_attribute_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_attribute_element_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`attribute_id` int(10) unsigned NOT NULL,
	`element_type_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_attribute_element_a_fk` (`attribute_id`),
	KEY `acv_ophciexamination_attribute_element_et_fk` (`element_type_id`),
	KEY `acv_ophciexamination_attribute_element_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_attribute_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_attribute_element_a_fk` FOREIGN KEY (`attribute_id`) REFERENCES `ophciexamination_attribute` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_element_et_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_element_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_attribute_element_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_attribute_element_version');

		$this->createIndex('ophciexamination_attribute_element_aid_fk','ophciexamination_attribute_element_version','id');
		$this->addForeignKey('ophciexamination_attribute_element_aid_fk','ophciexamination_attribute_element_version','id','ophciexamination_attribute_element','id');

		$this->addColumn('ophciexamination_attribute_element_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_attribute_element_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_attribute_element_version','version_id');
		$this->alterColumn('ophciexamination_attribute_element_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_attribute_option_version` (
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
	KEY `acv_ophciexamination_attribute_option_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_attribute_option_created_user_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_attribute_option_ssi_fk` (`subspecialty_id`),
	KEY `acv_ophciexamination_attribute_option_aei_fk` (`attribute_element_id`),
	CONSTRAINT `acv_ophciexamination_attribute_option_aei_fk` FOREIGN KEY (`attribute_element_id`) REFERENCES `ophciexamination_attribute_element` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_option_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_option_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_attribute_option_ssi_fk` FOREIGN KEY (`subspecialty_id`) REFERENCES `subspecialty` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_attribute_option_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_attribute_option_version');

		$this->createIndex('ophciexamination_attribute_option_aid_fk','ophciexamination_attribute_option_version','id');
		$this->addForeignKey('ophciexamination_attribute_option_aid_fk','ophciexamination_attribute_option_version','id','ophciexamination_attribute_option','id');

		$this->addColumn('ophciexamination_attribute_option_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_attribute_option_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_attribute_option_version','version_id');
		$this->alterColumn('ophciexamination_attribute_option_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_cataractmanagement_eye_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`display_order` tinyint(1) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_cataractmanagement_eye_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_cataractmanagement_eye_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_cataractmanagement_eye_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_cataractmanagement_eye_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_cataractmanagement_eye_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_cataractmanagement_eye_version');

		$this->createIndex('ophciexamination_cataractmanagement_eye_aid_fk','ophciexamination_cataractmanagement_eye_version','id');
		$this->addForeignKey('ophciexamination_cataractmanagement_eye_aid_fk','ophciexamination_cataractmanagement_eye_version','id','ophciexamination_cataractmanagement_eye','id');

		$this->addColumn('ophciexamination_cataractmanagement_eye_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_cataractmanagement_eye_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_cataractmanagement_eye_version','version_id');
		$this->alterColumn('ophciexamination_cataractmanagement_eye_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_cataractmanagement_suitable_for_surgeon_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_sfs_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_sfs_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_sfs_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_sfs_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_cataractmanagement_suitable_for_surgeon_version');

		$this->createIndex('ophciexamination_cataractmanagement_suitable_for_surgeon_aid_fk','ophciexamination_cataractmanagement_suitable_for_surgeon_version','id');
		$this->addForeignKey('ophciexamination_cataractmanagement_suitable_for_surgeon_aid_fk','ophciexamination_cataractmanagement_suitable_for_surgeon_version','id','ophciexamination_cataractmanagement_suitable_for_surgeon','id');

		$this->addColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_cataractmanagement_suitable_for_surgeon_version','version_id');
		$this->alterColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_clinicoutcome_role_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '10',
	`requires_comment` int(1) unsigned NOT NULL DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_clinicoutcome_role_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_clinicoutcome_role_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_role_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_role_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_clinicoutcome_role_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_clinicoutcome_role_version');

		$this->createIndex('ophciexamination_clinicoutcome_role_aid_fk','ophciexamination_clinicoutcome_role_version','id');
		$this->addForeignKey('ophciexamination_clinicoutcome_role_aid_fk','ophciexamination_clinicoutcome_role_version','id','ophciexamination_clinicoutcome_role','id');

		$this->addColumn('ophciexamination_clinicoutcome_role_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_clinicoutcome_role_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_clinicoutcome_role_version','version_id');
		$this->alterColumn('ophciexamination_clinicoutcome_role_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_clinicoutcome_status_version` (
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
	KEY `acv_ophciexamination_clinicoutcome_laser_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_clinicoutcome_laser_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_clinicoutcome_episode_status_fk` (`episode_status_id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_episode_status_fk` FOREIGN KEY (`episode_status_id`) REFERENCES `episode_status` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_clinicoutcome_status_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_clinicoutcome_status_version');

		$this->createIndex('ophciexamination_clinicoutcome_status_aid_fk','ophciexamination_clinicoutcome_status_version','id');
		$this->addForeignKey('ophciexamination_clinicoutcome_status_aid_fk','ophciexamination_clinicoutcome_status_version','id','ophciexamination_clinicoutcome_status','id');

		$this->addColumn('ophciexamination_clinicoutcome_status_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_clinicoutcome_status_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_clinicoutcome_status_version','version_id');
		$this->alterColumn('ophciexamination_clinicoutcome_status_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_clinicoutcome_template_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`followup_quantity` int(10) unsigned DEFAULT NULL,
	`clinic_outcome_status_id` int(10) unsigned NOT NULL,
	`followup_period_id` int(10) unsigned DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_clinicoutcome_template_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_clinicoutcome_template_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_clinicoutcome_template_cosi_fk` (`clinic_outcome_status_id`),
	KEY `acv_ophciexamination_clinicoutcome_template_fpi_fk` (`followup_period_id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_template_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_template_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_template_cosi_fk` FOREIGN KEY (`clinic_outcome_status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`),
	CONSTRAINT `acv_ophciexamination_clinicoutcome_template_fpi_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_clinicoutcome_template_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_clinicoutcome_template_version');

		$this->createIndex('ophciexamination_clinicoutcome_template_aid_fk','ophciexamination_clinicoutcome_template_version','id');
		$this->addForeignKey('ophciexamination_clinicoutcome_template_aid_fk','ophciexamination_clinicoutcome_template_version','id','ophciexamination_clinicoutcome_template','id');

		$this->addColumn('ophciexamination_clinicoutcome_template_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_clinicoutcome_template_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_clinicoutcome_template_version','version_id');
		$this->alterColumn('ophciexamination_clinicoutcome_template_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_comorbidities_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`element_id` int(10) unsigned NOT NULL,
	`item_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_risks_assign_e_id_fk` (`element_id`),
	KEY `acv_ophciexamination_risks_assign_r_id_fk` (`item_id`),
	KEY `acv_ophciexamination_risks_assign_c_u_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_risks_assign_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_comorbidities_assign_i_id_fk` FOREIGN KEY (`item_id`) REFERENCES `ophciexamination_comorbidities_item` (`id`),
	CONSTRAINT `acv_ophciexamination_comorbidities_assign_e_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_comorbidities` (`id`),
	CONSTRAINT `acv_ophciexamination_risks_assign_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_risks_assign_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_comorbidities_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_comorbidities_assignment_version');

		$this->createIndex('ophciexamination_comorbidities_assignment_aid_fk','ophciexamination_comorbidities_assignment_version','id');
		$this->addForeignKey('ophciexamination_comorbidities_assignment_aid_fk','ophciexamination_comorbidities_assignment_version','id','ophciexamination_comorbidities_assignment','id');

		$this->addColumn('ophciexamination_comorbidities_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_comorbidities_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_comorbidities_assignment_version','version_id');
		$this->alterColumn('ophciexamination_comorbidities_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_comorbidities_item_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_risks_risk_c_u_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_risks_risk_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_risks_risk_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_risks_risk_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_comorbidities_item_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_comorbidities_item_version');

		$this->createIndex('ophciexamination_comorbidities_item_aid_fk','ophciexamination_comorbidities_item_version','id');
		$this->addForeignKey('ophciexamination_comorbidities_item_aid_fk','ophciexamination_comorbidities_item_version','id','ophciexamination_comorbidities_item','id');

		$this->addColumn('ophciexamination_comorbidities_item_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_comorbidities_item_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_comorbidities_item_version','version_id');
		$this->alterColumn('ophciexamination_comorbidities_item_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_diagnosis_version` (
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
	KEY `acv_ophciexamination_diagnosis_element_diagnoses_id_fk` (`element_diagnoses_id`),
	KEY `acv_ophciexamination_diagnosis_disorder_id_fk` (`disorder_id`),
	KEY `acv_ophciexamination_diagnosis_eye_id_fk` (`eye_id`),
	KEY `acv_ophciexamination_diagnosis_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_diagnosis_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_diagnosis_element_diagnoses_id_fk` FOREIGN KEY (`element_diagnoses_id`) REFERENCES `et_ophciexamination_diagnoses` (`id`),
	CONSTRAINT `acv_ophciexamination_diagnosis_disorder_id_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`),
	CONSTRAINT `acv_ophciexamination_diagnosis_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_ophciexamination_diagnosis_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_diagnosis_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_diagnosis_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_diagnosis_version');

		$this->createIndex('ophciexamination_diagnosis_aid_fk','ophciexamination_diagnosis_version','id');
		$this->addForeignKey('ophciexamination_diagnosis_aid_fk','ophciexamination_diagnosis_version','id','ophciexamination_diagnosis','id');

		$this->addColumn('ophciexamination_diagnosis_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_diagnosis_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_diagnosis_version','version_id');
		$this->alterColumn('ophciexamination_diagnosis_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_dilation_drugs_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_dilation_drugs_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_dilation_drugs_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_dilation_drugs_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_dilation_drugs_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_dilation_drugs_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_dilation_drugs_version');

		$this->createIndex('ophciexamination_dilation_drugs_aid_fk','ophciexamination_dilation_drugs_version','id');
		$this->addForeignKey('ophciexamination_dilation_drugs_aid_fk','ophciexamination_dilation_drugs_version','id','ophciexamination_dilation_drugs','id');

		$this->addColumn('ophciexamination_dilation_drugs_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_dilation_drugs_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_dilation_drugs_version','version_id');
		$this->alterColumn('ophciexamination_dilation_drugs_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_dilation_treatment_version` (
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
	KEY `acv_ophciexamination_dilation_treatment_element_id_fk` (`element_id`),
	KEY `acv_ophciexamination_dilation_treatment_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_dilation_treatment_created_user_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_dilation_treatment_drug_id_fk` (`drug_id`),
	CONSTRAINT `acv_ophciexamination_dilation_treatment_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_dilation_treatment_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_dilation_treatment_drug_id_fk` FOREIGN KEY (`drug_id`) REFERENCES `ophciexamination_dilation_drugs` (`id`),
	CONSTRAINT `acv_ophciexamination_dilation_treatment_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_dilation` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_dilation_treatment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_dilation_treatment_version');

		$this->createIndex('ophciexamination_dilation_treatment_aid_fk','ophciexamination_dilation_treatment_version','id');
		$this->addForeignKey('ophciexamination_dilation_treatment_aid_fk','ophciexamination_dilation_treatment_version','id','ophciexamination_dilation_treatment','id');

		$this->addColumn('ophciexamination_dilation_treatment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_dilation_treatment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_dilation_treatment_version','version_id');
		$this->alterColumn('ophciexamination_dilation_treatment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_drgrading_clinicalmaculopathy_version` (
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
	KEY `acv_ophciexamination_drgrading_clinicalm_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_drgrading_clinicalm_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_drgrading_clinicalm_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_drgrading_clinicalm_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_drgrading_clinicalmaculopathy_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_drgrading_clinicalmaculopathy_version');

		$this->createIndex('ophciexamination_drgrading_clinicalmaculopathy_aid_fk','ophciexamination_drgrading_clinicalmaculopathy_version','id');
		$this->addForeignKey('ophciexamination_drgrading_clinicalmaculopathy_aid_fk','ophciexamination_drgrading_clinicalmaculopathy_version','id','ophciexamination_drgrading_clinicalmaculopathy','id');

		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_drgrading_clinicalmaculopathy_version','version_id');
		$this->alterColumn('ophciexamination_drgrading_clinicalmaculopathy_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_drgrading_clinicalretinopathy_version` (
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
	KEY `acv_ophciexamination_drgrading_clinical_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_drgrading_clinical_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_drgrading_clinical_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_drgrading_clinical_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_drgrading_clinicalretinopathy_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_drgrading_clinicalretinopathy_version');

		$this->createIndex('ophciexamination_drgrading_clinicalretinopathy_aid_fk','ophciexamination_drgrading_clinicalretinopathy_version','id');
		$this->addForeignKey('ophciexamination_drgrading_clinicalretinopathy_aid_fk','ophciexamination_drgrading_clinicalretinopathy_version','id','ophciexamination_drgrading_clinicalretinopathy','id');

		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_drgrading_clinicalretinopathy_version','version_id');
		$this->alterColumn('ophciexamination_drgrading_clinicalretinopathy_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_drgrading_nscmaculopathy_version` (
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
	KEY `acv_ophciexamination_drgrading_nscmaculopathy_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_drgrading_nscmaculopathy_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_drgrading_nscmaculopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_drgrading_nscmaculopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_drgrading_nscmaculopathy_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_drgrading_nscmaculopathy_version');

		$this->createIndex('ophciexamination_drgrading_nscmaculopathy_aid_fk','ophciexamination_drgrading_nscmaculopathy_version','id');
		$this->addForeignKey('ophciexamination_drgrading_nscmaculopathy_aid_fk','ophciexamination_drgrading_nscmaculopathy_version','id','ophciexamination_drgrading_nscmaculopathy','id');

		$this->addColumn('ophciexamination_drgrading_nscmaculopathy_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_drgrading_nscmaculopathy_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_drgrading_nscmaculopathy_version','version_id');
		$this->alterColumn('ophciexamination_drgrading_nscmaculopathy_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_drgrading_nscretinopathy_version` (
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
	KEY `acv_ophciexamination_drgrading_nscretinopathy_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_drgrading_nscretinopathy_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_drgrading_nscretinopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_drgrading_nscretinopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_drgrading_nscretinopathy_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_drgrading_nscretinopathy_version');

		$this->createIndex('ophciexamination_drgrading_nscretinopathy_aid_fk','ophciexamination_drgrading_nscretinopathy_version','id');
		$this->addForeignKey('ophciexamination_drgrading_nscretinopathy_aid_fk','ophciexamination_drgrading_nscretinopathy_version','id','ophciexamination_drgrading_nscretinopathy','id');

		$this->addColumn('ophciexamination_drgrading_nscretinopathy_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_drgrading_nscretinopathy_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_drgrading_nscretinopathy_version','version_id');
		$this->alterColumn('ophciexamination_drgrading_nscretinopathy_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_element_set_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`position` int(10) unsigned NOT NULL DEFAULT '1',
	`workflow_id` int(10) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_element_set_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_element_set_created_user_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_element_set_workflow_id_fk` (`workflow_id`),
	CONSTRAINT `acv_ophciexamination_element_set_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_workflow_id_fk` FOREIGN KEY (`workflow_id`) REFERENCES `ophciexamination_workflow` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_element_set_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_element_set_version');

		$this->createIndex('ophciexamination_element_set_aid_fk','ophciexamination_element_set_version','id');
		$this->addForeignKey('ophciexamination_element_set_aid_fk','ophciexamination_element_set_version','id','ophciexamination_element_set','id');

		$this->addColumn('ophciexamination_element_set_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_element_set_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_element_set_version','version_id');
		$this->alterColumn('ophciexamination_element_set_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_element_set_item_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`set_id` int(10) unsigned NOT NULL,
	`element_type_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_element_set_item_set_id_fk` (`set_id`),
	KEY `acv_ophciexamination_element_set_item_element_type_id_fk` (`element_type_id`),
	KEY `acv_ophciexamination_element_set_item_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_element_set_item_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_element_set_item_set_id_fk` FOREIGN KEY (`set_id`) REFERENCES `ophciexamination_element_set` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_item_element_type_id_fk` FOREIGN KEY (`element_type_id`) REFERENCES `element_type` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_item_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_item_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_element_set_item_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_element_set_item_version');

		$this->createIndex('ophciexamination_element_set_item_aid_fk','ophciexamination_element_set_item_version','id');
		$this->addForeignKey('ophciexamination_element_set_item_aid_fk','ophciexamination_element_set_item_version','id','ophciexamination_element_set_item','id');

		$this->addColumn('ophciexamination_element_set_item_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_element_set_item_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_element_set_item_version','version_id');
		$this->alterColumn('ophciexamination_element_set_item_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_element_set_rule_version` (
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
	KEY `acv_ophciexamination_element_set_rule_parent_id_fk` (`parent_id`),
	KEY `acv_ophciexamination_element_set_rule_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_element_set_rule_created_user_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_element_set_rule_workflow_id_fk` (`workflow_id`),
	CONSTRAINT `acv_ophciexamination_element_set_rule_workflow_id_fk` FOREIGN KEY (`workflow_id`) REFERENCES `ophciexamination_workflow` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_rule_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_rule_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_element_set_rule_parent_id_fk` FOREIGN KEY (`parent_id`) REFERENCES `ophciexamination_element_set_rule` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_element_set_rule_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_element_set_rule_version');

		$this->createIndex('ophciexamination_element_set_rule_aid_fk','ophciexamination_element_set_rule_version','id');
		$this->addForeignKey('ophciexamination_element_set_rule_aid_fk','ophciexamination_element_set_rule_version','id','ophciexamination_element_set_rule','id');

		$this->addColumn('ophciexamination_element_set_rule_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_element_set_rule_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_element_set_rule_version','version_id');
		$this->alterColumn('ophciexamination_element_set_rule_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_event_elementset_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`step_id` int(10) unsigned NOT NULL,
	`event_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	UNIQUE KEY `ophciexamination_event_ea_event_id_unique` (`event_id`),
	KEY `acv_ophciexamination_event_ea_step_id_fk` (`step_id`),
	KEY `acv_ophciexamination_event_ea_event_id_fk` (`event_id`),
	KEY `acv_ophciexamination_event_ea_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_event_ea_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_event_ea_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_event_ea_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_event_ea_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
	CONSTRAINT `acv_ophciexamination_event_ea_step_id_fk` FOREIGN KEY (`step_id`) REFERENCES `ophciexamination_element_set` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_event_elementset_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_event_elementset_assignment_version');

		$this->createIndex('ophciexamination_event_elementset_assignment_aid_fk','ophciexamination_event_elementset_assignment_version','id');
		$this->addForeignKey('ophciexamination_event_elementset_assignment_aid_fk','ophciexamination_event_elementset_assignment_version','id','ophciexamination_event_elementset_assignment','id');

		$this->addColumn('ophciexamination_event_elementset_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_event_elementset_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_event_elementset_assignment_version','version_id');
		$this->alterColumn('ophciexamination_event_elementset_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_glaucomarisk_risk_version` (
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
	KEY `acv_ophciexamination_glaucomarisk_risk_coti_fk` (`clinicoutcome_template_id`),
	KEY `acv_ophciexamination_glaucomarisk_risk_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_glaucomarisk_risk_lmui_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_glaucomarisk_risk_coti_fk` FOREIGN KEY (`clinicoutcome_template_id`) REFERENCES `ophciexamination_clinicoutcome_template` (`id`),
	CONSTRAINT `acv_ophciexamination_glaucomarisk_risk_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_glaucomarisk_risk_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_glaucomarisk_risk_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_glaucomarisk_risk_version');

		$this->createIndex('ophciexamination_glaucomarisk_risk_aid_fk','ophciexamination_glaucomarisk_risk_version','id');
		$this->addForeignKey('ophciexamination_glaucomarisk_risk_aid_fk','ophciexamination_glaucomarisk_risk_version','id','ophciexamination_glaucomarisk_risk','id');

		$this->addColumn('ophciexamination_glaucomarisk_risk_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_glaucomarisk_risk_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_glaucomarisk_risk_version','version_id');
		$this->alterColumn('ophciexamination_glaucomarisk_risk_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_gonioscopy_description_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(40) COLLATE utf8_bin NOT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`seen` tinyint(1) unsigned NOT NULL DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_gonioscopy_description_lmuid_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_gonioscopy_description_cuid_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_gonioscopy_description_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_gonioscopy_description_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_gonioscopy_description_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_gonioscopy_description_version');

		$this->createIndex('ophciexamination_gonioscopy_description_aid_fk','ophciexamination_gonioscopy_description_version','id');
		$this->addForeignKey('ophciexamination_gonioscopy_description_aid_fk','ophciexamination_gonioscopy_description_version','id','ophciexamination_gonioscopy_description','id');

		$this->addColumn('ophciexamination_gonioscopy_description_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_gonioscopy_description_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_gonioscopy_description_version','version_id');
		$this->alterColumn('ophciexamination_gonioscopy_description_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_gonioscopy_van_herick_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(40) COLLATE utf8_bin NOT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_gonioscopy_van_herick_lmuid_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_gonioscopy_van_herick_cuid_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_gonioscopy_van_herick_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_gonioscopy_van_herick_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_gonioscopy_van_herick_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_gonioscopy_van_herick_version');

		$this->createIndex('ophciexamination_gonioscopy_van_herick_aid_fk','ophciexamination_gonioscopy_van_herick_version','id');
		$this->addForeignKey('ophciexamination_gonioscopy_van_herick_aid_fk','ophciexamination_gonioscopy_van_herick_version','id','ophciexamination_gonioscopy_van_herick','id');

		$this->addColumn('ophciexamination_gonioscopy_van_herick_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_gonioscopy_van_herick_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_gonioscopy_van_herick_version','version_id');
		$this->alterColumn('ophciexamination_gonioscopy_van_herick_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_injectmanagecomplex_answer_version` (
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
	KEY `acv_ophciexamination_injectmanagecomplex_answer_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_answer_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_answer_eli_fk` (`element_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_answer_eyei_fk` (`eye_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_answer_qi_fk` (`question_id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_answer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_answer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_answer_eli_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_answer_eyei_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_answer_qi_fk` FOREIGN KEY (`question_id`) REFERENCES `ophciexamination_injectmanagecomplex_question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_injectmanagecomplex_answer_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_injectmanagecomplex_answer_version');

		$this->createIndex('ophciexamination_injectmanagecomplex_answer_aid_fk','ophciexamination_injectmanagecomplex_answer_version','id');
		$this->addForeignKey('ophciexamination_injectmanagecomplex_answer_aid_fk','ophciexamination_injectmanagecomplex_answer_version','id','ophciexamination_injectmanagecomplex_answer','id');

		$this->addColumn('ophciexamination_injectmanagecomplex_answer_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_injectmanagecomplex_answer_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_injectmanagecomplex_answer_version','version_id');
		$this->alterColumn('ophciexamination_injectmanagecomplex_answer_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_injectmanagecomplex_notreatmentreason_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`other` tinyint(1) NOT NULL DEFAULT '0',
	`letter_str` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_iexamination_injectmanagecomplex_notreatmentreason_lmui_fk` (`last_modified_user_id`),
	KEY `acv_iexamination_injectmanagecomplex_notreatmentreason_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_iexamination_injectmanagecomplex_notreatmentreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_iexamination_injectmanagecomplex_notreatmentreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_injectmanagecomplex_notreatmentreason_version');

		$this->createIndex('ophciexamination_injectmanagecomplex_notreatmentreason_aid_fk','ophciexamination_injectmanagecomplex_notreatmentreason_version','id');
		$this->addForeignKey('ophciexamination_injectmanagecomplex_notreatmentreason_aid_fk','ophciexamination_injectmanagecomplex_notreatmentreason_version','id','ophciexamination_injectmanagecomplex_notreatmentreason','id');

		$this->addColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_injectmanagecomplex_notreatmentreason_version','version_id');
		$this->alterColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_injectmanagecomplex_question_version` (
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
	KEY `acv_ophciexamination_injectmanagecomplex_question_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_question_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_question_disorder_fk` (`disorder_id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_question_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_question_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_question_disorder_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_injectmanagecomplex_question_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_injectmanagecomplex_question_version');

		$this->createIndex('ophciexamination_injectmanagecomplex_question_aid_fk','ophciexamination_injectmanagecomplex_question_version','id');
		$this->addForeignKey('ophciexamination_injectmanagecomplex_question_aid_fk','ophciexamination_injectmanagecomplex_question_version','id','ophciexamination_injectmanagecomplex_question','id');

		$this->addColumn('ophciexamination_injectmanagecomplex_question_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_injectmanagecomplex_question_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_injectmanagecomplex_question_version','version_id');
		$this->alterColumn('ophciexamination_injectmanagecomplex_question_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_injectmanagecomplex_risk_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(256) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_injectmanagecomplex_risk_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_injectmanagecomplex_risk_version');

		$this->createIndex('ophciexamination_injectmanagecomplex_risk_aid_fk','ophciexamination_injectmanagecomplex_risk_version','id');
		$this->addForeignKey('ophciexamination_injectmanagecomplex_risk_aid_fk','ophciexamination_injectmanagecomplex_risk_version','id','ophciexamination_injectmanagecomplex_risk','id');

		$this->addColumn('ophciexamination_injectmanagecomplex_risk_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_injectmanagecomplex_risk_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_injectmanagecomplex_risk_version','version_id');
		$this->alterColumn('ophciexamination_injectmanagecomplex_risk_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_injectmanagecomplex_risk_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`element_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL DEFAULT '3',
	`risk_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` (`element_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` (`eye_id`),
	KEY `acv_ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` (`risk_id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_injectmanagecomplex_risk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_injectmanagecomplex_risk_assignment_version');

		$this->createIndex('ophciexamination_injectmanagecomplex_risk_assignment_aid_fk','ophciexamination_injectmanagecomplex_risk_assignment_version','id');
		$this->addForeignKey('ophciexamination_injectmanagecomplex_risk_assignment_aid_fk','ophciexamination_injectmanagecomplex_risk_assignment_version','id','ophciexamination_injectmanagecomplex_risk_assignment','id');

		$this->addColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_injectmanagecomplex_risk_assignment_version','version_id');
		$this->alterColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_instrument_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`display_order` int(10) unsigned DEFAULT '1',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_instrument_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_instrument_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_instrument_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_instrument_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_instrument_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_instrument_version');

		$this->createIndex('ophciexamination_instrument_aid_fk','ophciexamination_instrument_version','id');
		$this->addForeignKey('ophciexamination_instrument_aid_fk','ophciexamination_instrument_version','id','ophciexamination_instrument','id');

		$this->addColumn('ophciexamination_instrument_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_instrument_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_instrument_version','version_id');
		$this->alterColumn('ophciexamination_instrument_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_intraocularpressure_reading_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(3) COLLATE utf8_bin DEFAULT NULL,
	`value` int(10) unsigned DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_intraocularpressure_reading_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_intraocularpressure_reading_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_intraocularpressure_reading_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_intraocularpressure_reading_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_intraocularpressure_reading_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_intraocularpressure_reading_version');

		$this->createIndex('ophciexamination_intraocularpressure_reading_aid_fk','ophciexamination_intraocularpressure_reading_version','id');
		$this->addForeignKey('ophciexamination_intraocularpressure_reading_aid_fk','ophciexamination_intraocularpressure_reading_version','id','ophciexamination_intraocularpressure_reading','id');

		$this->addColumn('ophciexamination_intraocularpressure_reading_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_intraocularpressure_reading_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_intraocularpressure_reading_version','version_id');
		$this->alterColumn('ophciexamination_intraocularpressure_reading_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_lasermanagement_lasertype_version` (
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
	KEY `acv_ophciexamination_lasermanagement_lasertype_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_lasermanagement_lasertype_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_lasermanagement_lasertype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_lasermanagement_lasertype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_lasermanagement_lasertype_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_lasermanagement_lasertype_version');

		$this->createIndex('ophciexamination_lasermanagement_lasertype_aid_fk','ophciexamination_lasermanagement_lasertype_version','id');
		$this->addForeignKey('ophciexamination_lasermanagement_lasertype_aid_fk','ophciexamination_lasermanagement_lasertype_version','id','ophciexamination_lasermanagement_lasertype','id');

		$this->addColumn('ophciexamination_lasermanagement_lasertype_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_lasermanagement_lasertype_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_lasermanagement_lasertype_version','version_id');
		$this->alterColumn('ophciexamination_lasermanagement_lasertype_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_management_deferralreason_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`other` tinyint(1) NOT NULL DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_management_ldeferral_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_management_ldeferral_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_management_ldeferral_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_management_ldeferral_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_management_deferralreason_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_management_deferralreason_version');

		$this->createIndex('ophciexamination_management_deferralreason_aid_fk','ophciexamination_management_deferralreason_version','id');
		$this->addForeignKey('ophciexamination_management_deferralreason_aid_fk','ophciexamination_management_deferralreason_version','id','ophciexamination_management_deferralreason','id');

		$this->addColumn('ophciexamination_management_deferralreason_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_management_deferralreason_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_management_deferralreason_version','version_id');
		$this->alterColumn('ophciexamination_management_deferralreason_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_management_status_version` (
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
	KEY `acv_ophciexamination_management_laser_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_management_laser_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_management_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_management_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_management_status_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_management_status_version');

		$this->createIndex('ophciexamination_management_status_aid_fk','ophciexamination_management_status_version','id');
		$this->addForeignKey('ophciexamination_management_status_aid_fk','ophciexamination_management_status_version','id','ophciexamination_management_status','id');

		$this->addColumn('ophciexamination_management_status_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_management_status_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_management_status_version','version_id');
		$this->alterColumn('ophciexamination_management_status_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_oct_fluidstatus_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_oct_fluidstatus_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_oct_fluidstatus_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidstatus_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidstatus_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_oct_fluidstatus_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_oct_fluidstatus_version');

		$this->createIndex('ophciexamination_oct_fluidstatus_aid_fk','ophciexamination_oct_fluidstatus_version','id');
		$this->addForeignKey('ophciexamination_oct_fluidstatus_aid_fk','ophciexamination_oct_fluidstatus_version','id','ophciexamination_oct_fluidstatus','id');

		$this->addColumn('ophciexamination_oct_fluidstatus_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_oct_fluidstatus_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_oct_fluidstatus_version','version_id');
		$this->alterColumn('ophciexamination_oct_fluidstatus_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_oct_fluidtype_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(128) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`enabled` tinyint(1) NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_oct_fluidtype_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_oct_fluidtype_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_oct_fluidtype_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_oct_fluidtype_version');

		$this->createIndex('ophciexamination_oct_fluidtype_aid_fk','ophciexamination_oct_fluidtype_version','id');
		$this->addForeignKey('ophciexamination_oct_fluidtype_aid_fk','ophciexamination_oct_fluidtype_version','id','ophciexamination_oct_fluidtype','id');

		$this->addColumn('ophciexamination_oct_fluidtype_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_oct_fluidtype_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_oct_fluidtype_version','version_id');
		$this->alterColumn('ophciexamination_oct_fluidtype_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_oct_fluidtype_assignment_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`fluidtype_id` int(10) unsigned NOT NULL,
	`element_id` int(10) unsigned NOT NULL,
	`eye_id` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_oct_fluidtype_assignment_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_oct_fluidtype_assignment_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_oct_fluidtype_assignment_eye_id_fk` (`eye_id`),
	KEY `acv_ophciexamination_oct_fluidtype_assignment_fti_fk` (`fluidtype_id`),
	KEY `acv_ophciexamination_oct_fluidtype_assignment_ei_fk` (`element_id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_assignment_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_assignment_fti_fk` FOREIGN KEY (`fluidtype_id`) REFERENCES `ophciexamination_oct_fluidtype` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_fluidtype_assignment_ei_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_oct` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_oct_fluidtype_assignment_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_oct_fluidtype_assignment_version');

		$this->createIndex('ophciexamination_oct_fluidtype_assignment_aid_fk','ophciexamination_oct_fluidtype_assignment_version','id');
		$this->addForeignKey('ophciexamination_oct_fluidtype_assignment_aid_fk','ophciexamination_oct_fluidtype_assignment_version','id','ophciexamination_oct_fluidtype_assignment','id');

		$this->addColumn('ophciexamination_oct_fluidtype_assignment_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_oct_fluidtype_assignment_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_oct_fluidtype_assignment_version','version_id');
		$this->alterColumn('ophciexamination_oct_fluidtype_assignment_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_oct_method_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL,
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_oct_method_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_oct_method_lmui_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_oct_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_oct_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_oct_method_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_oct_method_version');

		$this->createIndex('ophciexamination_oct_method_aid_fk','ophciexamination_oct_method_version','id');
		$this->addForeignKey('ophciexamination_oct_method_aid_fk','ophciexamination_oct_method_version','id','ophciexamination_oct_method','id');

		$this->addColumn('ophciexamination_oct_method_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_oct_method_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_oct_method_version','version_id');
		$this->alterColumn('ophciexamination_oct_method_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_opticdisc_cd_ratio_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1901-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_opticdisc_cd_ratio_c_u_id_fk` (`created_user_id`),
	KEY `acv_ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_opticdisc_cd_ratio_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_opticdisc_cd_ratio_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_opticdisc_cd_ratio_version');

		$this->createIndex('ophciexamination_opticdisc_cd_ratio_aid_fk','ophciexamination_opticdisc_cd_ratio_version','id');
		$this->addForeignKey('ophciexamination_opticdisc_cd_ratio_aid_fk','ophciexamination_opticdisc_cd_ratio_version','id','ophciexamination_opticdisc_cd_ratio','id');

		$this->addColumn('ophciexamination_opticdisc_cd_ratio_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_opticdisc_cd_ratio_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_opticdisc_cd_ratio_version','version_id');
		$this->alterColumn('ophciexamination_opticdisc_cd_ratio_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_opticdisc_lens_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL,
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_opticdisc_lens_cui_fk` (`created_user_id`),
	KEY `acv_ophciexamination_opticdisc_lens_lmui_fk` (`last_modified_user_id`),
	CONSTRAINT `acv_ophciexamination_opticdisc_lens_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_opticdisc_lens_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_opticdisc_lens_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_opticdisc_lens_version');

		$this->createIndex('ophciexamination_opticdisc_lens_aid_fk','ophciexamination_opticdisc_lens_version','id');
		$this->addForeignKey('ophciexamination_opticdisc_lens_aid_fk','ophciexamination_opticdisc_lens_version','id','ophciexamination_opticdisc_lens','id');

		$this->addColumn('ophciexamination_opticdisc_lens_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_opticdisc_lens_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_opticdisc_lens_version','version_id');
		$this->alterColumn('ophciexamination_opticdisc_lens_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_pupillaryabnormalities_abnormality_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(255) COLLATE utf8_bin NOT NULL,
	`display_order` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_et_ophciexamination_pupillaryabnormalities_lmui_fk` (`last_modified_user_id`),
	KEY `acv_et_ophciexamination_pupillaryabnormalities_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormalities_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_et_ophciexamination_pupillaryabnormalities_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_pupillaryabnormalities_abnormality_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_pupillaryabnormalities_abnormality_version');

		$this->createIndex('ophciexamination_pupillaryabnormalities_abnormality_aid_fk','ophciexamination_pupillaryabnormalities_abnormality_version','id');
		$this->addForeignKey('ophciexamination_pupillaryabnormalities_abnormality_aid_fk','ophciexamination_pupillaryabnormalities_abnormality_version','id','ophciexamination_pupillaryabnormalities_abnormality','id');

		$this->addColumn('ophciexamination_pupillaryabnormalities_abnormality_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_pupillaryabnormalities_abnormality_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_pupillaryabnormalities_abnormality_version','version_id');
		$this->alterColumn('ophciexamination_pupillaryabnormalities_abnormality_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_refraction_fraction_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(4) COLLATE utf8_bin DEFAULT NULL,
	`value` varchar(3) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_refraction_fraction_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_refraction_fraction_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_refraction_fraction_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_refraction_fraction_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_refraction_fraction_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_refraction_fraction_version');

		$this->createIndex('ophciexamination_refraction_fraction_aid_fk','ophciexamination_refraction_fraction_version','id');
		$this->addForeignKey('ophciexamination_refraction_fraction_aid_fk','ophciexamination_refraction_fraction_version','id','ophciexamination_refraction_fraction','id');

		$this->addColumn('ophciexamination_refraction_fraction_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_refraction_fraction_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_refraction_fraction_version','version_id');
		$this->alterColumn('ophciexamination_refraction_fraction_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_refraction_integer_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`value` varchar(4) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_refraction_integer_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_refraction_integer_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_refraction_integer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_refraction_integer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_refraction_integer_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_refraction_integer_version');

		$this->createIndex('ophciexamination_refraction_integer_aid_fk','ophciexamination_refraction_integer_version','id');
		$this->addForeignKey('ophciexamination_refraction_integer_aid_fk','ophciexamination_refraction_integer_version','id','ophciexamination_refraction_integer','id');

		$this->addColumn('ophciexamination_refraction_integer_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_refraction_integer_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_refraction_integer_version','version_id');
		$this->alterColumn('ophciexamination_refraction_integer_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_refraction_sign_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(4) COLLATE utf8_bin DEFAULT NULL,
	`value` varchar(4) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_refraction_sign_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_refraction_sign_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_refraction_sign_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_refraction_sign_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_refraction_sign_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_refraction_sign_version');

		$this->createIndex('ophciexamination_refraction_sign_aid_fk','ophciexamination_refraction_sign_version','id');
		$this->addForeignKey('ophciexamination_refraction_sign_aid_fk','ophciexamination_refraction_sign_version','id','ophciexamination_refraction_sign','id');

		$this->addColumn('ophciexamination_refraction_sign_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_refraction_sign_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_refraction_sign_version','version_id');
		$this->alterColumn('ophciexamination_refraction_sign_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_refraction_type_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(32) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_refraction_type_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_refraction_type_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_refraction_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_refraction_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_refraction_type_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_refraction_type_version');

		$this->createIndex('ophciexamination_refraction_type_aid_fk','ophciexamination_refraction_type_version','id');
		$this->addForeignKey('ophciexamination_refraction_type_aid_fk','ophciexamination_refraction_type_version','id','ophciexamination_refraction_type','id');

		$this->addColumn('ophciexamination_refraction_type_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_refraction_type_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_refraction_type_version','version_id');
		$this->alterColumn('ophciexamination_refraction_type_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_visual_acuity_unit_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(40) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`tooltip` tinyint(1) NOT NULL DEFAULT '0',
	`information` text COLLATE utf8_bin,
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_visual_acuity_unit_lmuid_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_visual_acuity_unit_cuid_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_visual_acuity_unit_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_visual_acuity_unit_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_visual_acuity_unit_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_visual_acuity_unit_version');

		$this->createIndex('ophciexamination_visual_acuity_unit_aid_fk','ophciexamination_visual_acuity_unit_version','id');
		$this->addForeignKey('ophciexamination_visual_acuity_unit_aid_fk','ophciexamination_visual_acuity_unit_version','id','ophciexamination_visual_acuity_unit','id');

		$this->addColumn('ophciexamination_visual_acuity_unit_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_visual_acuity_unit_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_visual_acuity_unit_version','version_id');
		$this->alterColumn('ophciexamination_visual_acuity_unit_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_visual_acuity_unit_value_version` (
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
	KEY `acv_ophciexamination_visual_acuity_unit_value_unit_id_fk` (`unit_id`),
	KEY `acv_ophciexamination_visual_acuity_unit_value_lmuid_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_visual_acuity_unit_value_cuid_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_visual_acuity_unit_value_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_visual_acuity_unit_value_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_visual_acuity_unit_value_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_visual_acuity_unit_value_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_visual_acuity_unit_value_version');

		$this->createIndex('ophciexamination_visual_acuity_unit_value_aid_fk','ophciexamination_visual_acuity_unit_value_version','id');
		$this->addForeignKey('ophciexamination_visual_acuity_unit_value_aid_fk','ophciexamination_visual_acuity_unit_value_version','id','ophciexamination_visual_acuity_unit_value','id');

		$this->addColumn('ophciexamination_visual_acuity_unit_value_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_visual_acuity_unit_value_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_visual_acuity_unit_value_version','version_id');
		$this->alterColumn('ophciexamination_visual_acuity_unit_value_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_visualacuity_method_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(32) COLLATE utf8_bin DEFAULT NULL,
	`display_order` tinyint(3) unsigned DEFAULT '0',
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_visualacuity_method_lmui_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_visualacuity_method_cui_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_visualacuity_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_visualacuity_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_visualacuity_method_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_visualacuity_method_version');

		$this->createIndex('ophciexamination_visualacuity_method_aid_fk','ophciexamination_visualacuity_method_version','id');
		$this->addForeignKey('ophciexamination_visualacuity_method_aid_fk','ophciexamination_visualacuity_method_version','id','ophciexamination_visualacuity_method','id');

		$this->addColumn('ophciexamination_visualacuity_method_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_visualacuity_method_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_visualacuity_method_version','version_id');
		$this->alterColumn('ophciexamination_visualacuity_method_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_visualacuity_reading_version` (
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
	KEY `acv_ophciexamination_visualacuity_reading_element_id_fk` (`element_id`),
	KEY `acv_ophciexamination_visualacuity_reading_method_id_fk` (`method_id`),
	KEY `acv_iexamination_visualacuity_reading_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_visualacuity_reading_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_visualacuity_reading_element_id_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_visualacuity` (`id`),
	CONSTRAINT `acv_ophciexamination_visualacuity_reading_method_id_fk` FOREIGN KEY (`method_id`) REFERENCES `ophciexamination_visualacuity_method` (`id`),
	CONSTRAINT `acv_iexamination_visualacuity_reading_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_visualacuity_reading_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_visualacuity_reading_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_visualacuity_reading_version');

		$this->createIndex('ophciexamination_visualacuity_reading_aid_fk','ophciexamination_visualacuity_reading_version','id');
		$this->addForeignKey('ophciexamination_visualacuity_reading_aid_fk','ophciexamination_visualacuity_reading_version','id','ophciexamination_visualacuity_reading','id');

		$this->addColumn('ophciexamination_visualacuity_reading_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_visualacuity_reading_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_visualacuity_reading_version','version_id');
		$this->alterColumn('ophciexamination_visualacuity_reading_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->execute("
CREATE TABLE `ophciexamination_workflow_version` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) COLLATE utf8_bin NOT NULL,
	`last_modified_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`last_modified_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	`created_user_id` int(10) unsigned NOT NULL DEFAULT '1',
	`created_date` datetime NOT NULL DEFAULT '1900-01-01 00:00:00',
	PRIMARY KEY (`id`),
	KEY `acv_ophciexamination_workflow_last_modified_user_id_fk` (`last_modified_user_id`),
	KEY `acv_ophciexamination_workflow_created_user_id_fk` (`created_user_id`),
	CONSTRAINT `acv_ophciexamination_workflow_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`),
	CONSTRAINT `acv_ophciexamination_workflow_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
		");

		$this->alterColumn('ophciexamination_workflow_version','id','int(10) unsigned NOT NULL');
		$this->dropPrimaryKey('id','ophciexamination_workflow_version');

		$this->createIndex('ophciexamination_workflow_aid_fk','ophciexamination_workflow_version','id');
		$this->addForeignKey('ophciexamination_workflow_aid_fk','ophciexamination_workflow_version','id','ophciexamination_workflow','id');

		$this->addColumn('ophciexamination_workflow_version','version_date',"datetime not null default '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_workflow_version','version_id','int(10) unsigned NOT NULL');
		$this->addPrimaryKey('version_id','ophciexamination_workflow_version','version_id');
		$this->alterColumn('ophciexamination_workflow_version','version_id','int(10) unsigned NOT NULL AUTO_INCREMENT');

		$this->addColumn('et_ophciexamination_adnexalcomorbidity','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_adnexalcomorbidity_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_anteriorsegment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_anteriorsegment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_anteriorsegment_cct','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_anteriorsegment_cct_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_cataractmanagement','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_cataractmanagement_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_clinicoutcome','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_clinicoutcome_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_comorbidities','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_comorbidities_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_conclusion','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_conclusion_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_diagnoses','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_diagnoses_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_dilation','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_dilation_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_drgrading','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_drgrading_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_glaucomarisk','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_glaucomarisk_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_gonioscopy_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_history','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_history_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_injectionmanagement','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_injectionmanagement_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_injectionmanagementcomplex','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_injectionmanagementcomplex_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_intraocularpressure','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_intraocularpressure_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_investigation','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_investigation_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_lasermanagement','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_lasermanagement_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_management','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_management_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_oct','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_oct_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_opticdisc','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_opticdisc_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_posteriorpole','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_posteriorpole_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_pupillaryabnormalities','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_pupillaryabnormalities_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_refraction','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_refraction_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_risks','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_risks_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_visualacuity','deleted','tinyint(1) unsigned not null');
		$this->addColumn('et_ophciexamination_visualacuity_version','deleted','tinyint(1) unsigned not null');

		$this->addColumn('ophciexamination_anteriorsegment_cct_method','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_cct_method_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_cortical','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_cortical_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_nuclear','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_nuclear_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_pupil','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_anteriorsegment_pupil_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute_element','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute_element_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute_option','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_attribute_option_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_cataractmanagement_eye','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_cataractmanagement_eye_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_cataractmanagement_suitable_for_surgeon','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_role','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_role_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_status','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_status_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_template','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_clinicoutcome_template_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_comorbidities_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_comorbidities_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_comorbidities_item','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_comorbidities_item_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_diagnosis','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_diagnosis_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_dilation_drugs','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_dilation_drugs_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_dilation_treatment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_dilation_treatment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_nscmaculopathy','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_nscmaculopathy_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_nscretinopathy','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_drgrading_nscretinopathy_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set_item','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set_item_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set_rule','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_element_set_rule_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_event_elementset_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_event_elementset_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_glaucomarisk_risk','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_glaucomarisk_risk_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_gonioscopy_description','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_gonioscopy_description_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_gonioscopy_van_herick','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_gonioscopy_van_herick_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_answer','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_answer_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_notreatmentreason','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_question','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_question_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_risk','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_risk_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_risk_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_instrument','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_instrument_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_intraocularpressure_reading','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_intraocularpressure_reading_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_lasermanagement_lasertype','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_lasermanagement_lasertype_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_management_deferralreason','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_management_deferralreason_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_management_status','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_management_status_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidstatus','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidstatus_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidtype','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidtype_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidtype_assignment','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_fluidtype_assignment_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_method','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_oct_method_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_opticdisc_cd_ratio','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_opticdisc_cd_ratio_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_opticdisc_lens','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_opticdisc_lens_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_pupillaryabnormalities_abnormality','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_pupillaryabnormalities_abnormality_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_fraction','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_fraction_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_integer','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_integer_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_sign','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_sign_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_type','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_refraction_type_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visual_acuity_unit','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visual_acuity_unit_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visual_acuity_unit_value','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visual_acuity_unit_value_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visualacuity_method','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visualacuity_method_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visualacuity_reading','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_visualacuity_reading_version','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_workflow','deleted','tinyint(1) unsigned not null');
		$this->addColumn('ophciexamination_workflow_version','deleted','tinyint(1) unsigned not null');
	}

	public function down()
	{
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method_version','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_cortical','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_cortical_version','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_nuclear','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_nuclear_version','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_pupil','deleted');
		$this->dropColumn('ophciexamination_anteriorsegment_pupil_version','deleted');
		$this->dropColumn('ophciexamination_attribute','deleted');
		$this->dropColumn('ophciexamination_attribute_version','deleted');
		$this->dropColumn('ophciexamination_attribute_element','deleted');
		$this->dropColumn('ophciexamination_attribute_element_version','deleted');
		$this->dropColumn('ophciexamination_attribute_option','deleted');
		$this->dropColumn('ophciexamination_attribute_option_version','deleted');
		$this->dropColumn('ophciexamination_cataractmanagement_eye','deleted');
		$this->dropColumn('ophciexamination_cataractmanagement_eye_version','deleted');
		$this->dropColumn('ophciexamination_cataractmanagement_suitable_for_surgeon','deleted');
		$this->dropColumn('ophciexamination_cataractmanagement_suitable_for_surgeon_version','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_role','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_role_version','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_status','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_status_version','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_template','deleted');
		$this->dropColumn('ophciexamination_clinicoutcome_template_version','deleted');
		$this->dropColumn('ophciexamination_comorbidities_assignment','deleted');
		$this->dropColumn('ophciexamination_comorbidities_assignment_version','deleted');
		$this->dropColumn('ophciexamination_comorbidities_item','deleted');
		$this->dropColumn('ophciexamination_comorbidities_item_version','deleted');
		$this->dropColumn('ophciexamination_diagnosis','deleted');
		$this->dropColumn('ophciexamination_diagnosis_version','deleted');
		$this->dropColumn('ophciexamination_dilation_drugs','deleted');
		$this->dropColumn('ophciexamination_dilation_drugs_version','deleted');
		$this->dropColumn('ophciexamination_dilation_treatment','deleted');
		$this->dropColumn('ophciexamination_dilation_treatment_version','deleted');
		$this->dropColumn('ophciexamination_drgrading_clinicalmaculopathy','deleted');
		$this->dropColumn('ophciexamination_drgrading_clinicalmaculopathy_version','deleted');
		$this->dropColumn('ophciexamination_drgrading_clinicalretinopathy','deleted');
		$this->dropColumn('ophciexamination_drgrading_clinicalretinopathy_version','deleted');
		$this->dropColumn('ophciexamination_drgrading_nscmaculopathy','deleted');
		$this->dropColumn('ophciexamination_drgrading_nscmaculopathy_version','deleted');
		$this->dropColumn('ophciexamination_drgrading_nscretinopathy','deleted');
		$this->dropColumn('ophciexamination_drgrading_nscretinopathy_version','deleted');
		$this->dropColumn('ophciexamination_element_set','deleted');
		$this->dropColumn('ophciexamination_element_set_version','deleted');
		$this->dropColumn('ophciexamination_element_set_item','deleted');
		$this->dropColumn('ophciexamination_element_set_item_version','deleted');
		$this->dropColumn('ophciexamination_element_set_rule','deleted');
		$this->dropColumn('ophciexamination_element_set_rule_version','deleted');
		$this->dropColumn('ophciexamination_event_elementset_assignment','deleted');
		$this->dropColumn('ophciexamination_event_elementset_assignment_version','deleted');
		$this->dropColumn('ophciexamination_glaucomarisk_risk','deleted');
		$this->dropColumn('ophciexamination_glaucomarisk_risk_version','deleted');
		$this->dropColumn('ophciexamination_gonioscopy_description','deleted');
		$this->dropColumn('ophciexamination_gonioscopy_description_version','deleted');
		$this->dropColumn('ophciexamination_gonioscopy_van_herick','deleted');
		$this->dropColumn('ophciexamination_gonioscopy_van_herick_version','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_answer','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_answer_version','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_notreatmentreason','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_notreatmentreason_version','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_question','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_question_version','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_risk','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_risk_version','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_risk_assignment','deleted');
		$this->dropColumn('ophciexamination_injectmanagecomplex_risk_assignment_version','deleted');
		$this->dropColumn('ophciexamination_instrument','deleted');
		$this->dropColumn('ophciexamination_instrument_version','deleted');
		$this->dropColumn('ophciexamination_intraocularpressure_reading','deleted');
		$this->dropColumn('ophciexamination_intraocularpressure_reading_version','deleted');
		$this->dropColumn('ophciexamination_lasermanagement_lasertype','deleted');
		$this->dropColumn('ophciexamination_lasermanagement_lasertype_version','deleted');
		$this->dropColumn('ophciexamination_management_deferralreason','deleted');
		$this->dropColumn('ophciexamination_management_deferralreason_version','deleted');
		$this->dropColumn('ophciexamination_management_status','deleted');
		$this->dropColumn('ophciexamination_management_status_version','deleted');
		$this->dropColumn('ophciexamination_oct_fluidstatus','deleted');
		$this->dropColumn('ophciexamination_oct_fluidstatus_version','deleted');
		$this->dropColumn('ophciexamination_oct_fluidtype','deleted');
		$this->dropColumn('ophciexamination_oct_fluidtype_version','deleted');
		$this->dropColumn('ophciexamination_oct_fluidtype_assignment','deleted');
		$this->dropColumn('ophciexamination_oct_fluidtype_assignment_version','deleted');
		$this->dropColumn('ophciexamination_oct_method','deleted');
		$this->dropColumn('ophciexamination_oct_method_version','deleted');
		$this->dropColumn('ophciexamination_opticdisc_cd_ratio','deleted');
		$this->dropColumn('ophciexamination_opticdisc_cd_ratio_version','deleted');
		$this->dropColumn('ophciexamination_opticdisc_lens','deleted');
		$this->dropColumn('ophciexamination_opticdisc_lens_version','deleted');
		$this->dropColumn('ophciexamination_pupillaryabnormalities_abnormality','deleted');
		$this->dropColumn('ophciexamination_pupillaryabnormalities_abnormality_version','deleted');
		$this->dropColumn('ophciexamination_refraction_fraction','deleted');
		$this->dropColumn('ophciexamination_refraction_fraction_version','deleted');
		$this->dropColumn('ophciexamination_refraction_integer','deleted');
		$this->dropColumn('ophciexamination_refraction_integer_version','deleted');
		$this->dropColumn('ophciexamination_refraction_sign','deleted');
		$this->dropColumn('ophciexamination_refraction_sign_version','deleted');
		$this->dropColumn('ophciexamination_refraction_type','deleted');
		$this->dropColumn('ophciexamination_refraction_type_version','deleted');
		$this->dropColumn('ophciexamination_visual_acuity_unit','deleted');
		$this->dropColumn('ophciexamination_visual_acuity_unit_version','deleted');
		$this->dropColumn('ophciexamination_visual_acuity_unit_value','deleted');
		$this->dropColumn('ophciexamination_visual_acuity_unit_value_version','deleted');
		$this->dropColumn('ophciexamination_visualacuity_method','deleted');
		$this->dropColumn('ophciexamination_visualacuity_method_version','deleted');
		$this->dropColumn('ophciexamination_visualacuity_reading','deleted');
		$this->dropColumn('ophciexamination_visualacuity_reading_version','deleted');
		$this->dropColumn('ophciexamination_workflow','deleted');
		$this->dropColumn('ophciexamination_workflow_version','deleted');

		$this->dropColumn('et_ophciexamination_adnexalcomorbidity','deleted');
		$this->dropColumn('et_ophciexamination_adnexalcomorbidity_version','deleted');
		$this->dropColumn('et_ophciexamination_anteriorsegment','deleted');
		$this->dropColumn('et_ophciexamination_anteriorsegment_version','deleted');
		$this->dropColumn('et_ophciexamination_anteriorsegment_cct','deleted');
		$this->dropColumn('et_ophciexamination_anteriorsegment_cct_version','deleted');
		$this->dropColumn('et_ophciexamination_cataractmanagement','deleted');
		$this->dropColumn('et_ophciexamination_cataractmanagement_version','deleted');
		$this->dropColumn('et_ophciexamination_clinicoutcome','deleted');
		$this->dropColumn('et_ophciexamination_clinicoutcome_version','deleted');
		$this->dropColumn('et_ophciexamination_comorbidities','deleted');
		$this->dropColumn('et_ophciexamination_comorbidities_version','deleted');
		$this->dropColumn('et_ophciexamination_conclusion','deleted');
		$this->dropColumn('et_ophciexamination_conclusion_version','deleted');
		$this->dropColumn('et_ophciexamination_diagnoses','deleted');
		$this->dropColumn('et_ophciexamination_diagnoses_version','deleted');
		$this->dropColumn('et_ophciexamination_dilation','deleted');
		$this->dropColumn('et_ophciexamination_dilation_version','deleted');
		$this->dropColumn('et_ophciexamination_drgrading','deleted');
		$this->dropColumn('et_ophciexamination_drgrading_version','deleted');
		$this->dropColumn('et_ophciexamination_glaucomarisk','deleted');
		$this->dropColumn('et_ophciexamination_glaucomarisk_version','deleted');
		$this->dropColumn('et_ophciexamination_gonioscopy','deleted');
		$this->dropColumn('et_ophciexamination_gonioscopy_version','deleted');
		$this->dropColumn('et_ophciexamination_history','deleted');
		$this->dropColumn('et_ophciexamination_history_version','deleted');
		$this->dropColumn('et_ophciexamination_injectionmanagement','deleted');
		$this->dropColumn('et_ophciexamination_injectionmanagement_version','deleted');
		$this->dropColumn('et_ophciexamination_injectionmanagementcomplex','deleted');
		$this->dropColumn('et_ophciexamination_injectionmanagementcomplex_version','deleted');
		$this->dropColumn('et_ophciexamination_intraocularpressure','deleted');
		$this->dropColumn('et_ophciexamination_intraocularpressure_version','deleted');
		$this->dropColumn('et_ophciexamination_investigation','deleted');
		$this->dropColumn('et_ophciexamination_investigation_version','deleted');
		$this->dropColumn('et_ophciexamination_lasermanagement','deleted');
		$this->dropColumn('et_ophciexamination_lasermanagement_version','deleted');
		$this->dropColumn('et_ophciexamination_management','deleted');
		$this->dropColumn('et_ophciexamination_management_version','deleted');
		$this->dropColumn('et_ophciexamination_oct','deleted');
		$this->dropColumn('et_ophciexamination_oct_version','deleted');
		$this->dropColumn('et_ophciexamination_opticdisc','deleted');
		$this->dropColumn('et_ophciexamination_opticdisc_version','deleted');
		$this->dropColumn('et_ophciexamination_posteriorpole','deleted');
		$this->dropColumn('et_ophciexamination_posteriorpole_version','deleted');
		$this->dropColumn('et_ophciexamination_pupillaryabnormalities','deleted');
		$this->dropColumn('et_ophciexamination_pupillaryabnormalities_version','deleted');
		$this->dropColumn('et_ophciexamination_refraction','deleted');
		$this->dropColumn('et_ophciexamination_refraction_version','deleted');
		$this->dropColumn('et_ophciexamination_risks','deleted');
		$this->dropColumn('et_ophciexamination_risks_version','deleted');
		$this->dropColumn('et_ophciexamination_visualacuity','deleted');
		$this->dropColumn('et_ophciexamination_visualacuity_version','deleted');
		$this->dropTable('et_ophciexamination_adnexalcomorbidity_version');
		$this->dropTable('et_ophciexamination_anteriorsegment_version');
		$this->dropTable('et_ophciexamination_anteriorsegment_cct_version');
		$this->dropTable('et_ophciexamination_cataractmanagement_version');
		$this->dropTable('et_ophciexamination_clinicoutcome_version');
		$this->dropTable('et_ophciexamination_comorbidities_version');
		$this->dropTable('et_ophciexamination_conclusion_version');
		$this->dropTable('et_ophciexamination_diagnoses_version');
		$this->dropTable('et_ophciexamination_dilation_version');
		$this->dropTable('et_ophciexamination_drgrading_version');
		$this->dropTable('et_ophciexamination_glaucomarisk_version');
		$this->dropTable('et_ophciexamination_gonioscopy_version');
		$this->dropTable('et_ophciexamination_history_version');
		$this->dropTable('et_ophciexamination_injectionmanagement_version');
		$this->dropTable('et_ophciexamination_injectionmanagementcomplex_version');
		$this->dropTable('et_ophciexamination_intraocularpressure_version');
		$this->dropTable('et_ophciexamination_investigation_version');
		$this->dropTable('et_ophciexamination_lasermanagement_version');
		$this->dropTable('et_ophciexamination_management_version');
		$this->dropTable('et_ophciexamination_oct_version');
		$this->dropTable('et_ophciexamination_opticdisc_version');
		$this->dropTable('et_ophciexamination_posteriorpole_version');
		$this->dropTable('et_ophciexamination_pupillaryabnormalities_version');
		$this->dropTable('et_ophciexamination_refraction_version');
		$this->dropTable('et_ophciexamination_risks_version');
		$this->dropTable('et_ophciexamination_visualacuity_version');
		$this->dropTable('ophciexamination_anteriorsegment_cct_method_version');
		$this->dropTable('ophciexamination_anteriorsegment_cortical_version');
		$this->dropTable('ophciexamination_anteriorsegment_nuclear_version');
		$this->dropTable('ophciexamination_anteriorsegment_pupil_version');
		$this->dropTable('ophciexamination_attribute_version');
		$this->dropTable('ophciexamination_attribute_element_version');
		$this->dropTable('ophciexamination_attribute_option_version');
		$this->dropTable('ophciexamination_cataractmanagement_eye_version');
		$this->dropTable('ophciexamination_cataractmanagement_suitable_for_surgeon_version');
		$this->dropTable('ophciexamination_clinicoutcome_role_version');
		$this->dropTable('ophciexamination_clinicoutcome_status_version');
		$this->dropTable('ophciexamination_clinicoutcome_template_version');
		$this->dropTable('ophciexamination_comorbidities_assignment_version');
		$this->dropTable('ophciexamination_comorbidities_item_version');
		$this->dropTable('ophciexamination_diagnosis_version');
		$this->dropTable('ophciexamination_dilation_drugs_version');
		$this->dropTable('ophciexamination_dilation_treatment_version');
		$this->dropTable('ophciexamination_drgrading_clinicalmaculopathy_version');
		$this->dropTable('ophciexamination_drgrading_clinicalretinopathy_version');
		$this->dropTable('ophciexamination_drgrading_nscmaculopathy_version');
		$this->dropTable('ophciexamination_drgrading_nscretinopathy_version');
		$this->dropTable('ophciexamination_element_set_version');
		$this->dropTable('ophciexamination_element_set_item_version');
		$this->dropTable('ophciexamination_element_set_rule_version');
		$this->dropTable('ophciexamination_event_elementset_assignment_version');
		$this->dropTable('ophciexamination_glaucomarisk_risk_version');
		$this->dropTable('ophciexamination_gonioscopy_description_version');
		$this->dropTable('ophciexamination_gonioscopy_van_herick_version');
		$this->dropTable('ophciexamination_injectmanagecomplex_answer_version');
		$this->dropTable('ophciexamination_injectmanagecomplex_notreatmentreason_version');
		$this->dropTable('ophciexamination_injectmanagecomplex_question_version');
		$this->dropTable('ophciexamination_injectmanagecomplex_risk_version');
		$this->dropTable('ophciexamination_injectmanagecomplex_risk_assignment_version');
		$this->dropTable('ophciexamination_instrument_version');
		$this->dropTable('ophciexamination_intraocularpressure_reading_version');
		$this->dropTable('ophciexamination_lasermanagement_lasertype_version');
		$this->dropTable('ophciexamination_management_deferralreason_version');
		$this->dropTable('ophciexamination_management_status_version');
		$this->dropTable('ophciexamination_oct_fluidstatus_version');
		$this->dropTable('ophciexamination_oct_fluidtype_version');
		$this->dropTable('ophciexamination_oct_fluidtype_assignment_version');
		$this->dropTable('ophciexamination_oct_method_version');
		$this->dropTable('ophciexamination_opticdisc_cd_ratio_version');
		$this->dropTable('ophciexamination_opticdisc_lens_version');
		$this->dropTable('ophciexamination_pupillaryabnormalities_abnormality_version');
		$this->dropTable('ophciexamination_refraction_fraction_version');
		$this->dropTable('ophciexamination_refraction_integer_version');
		$this->dropTable('ophciexamination_refraction_sign_version');
		$this->dropTable('ophciexamination_refraction_type_version');
		$this->dropTable('ophciexamination_visual_acuity_unit_version');
		$this->dropTable('ophciexamination_visual_acuity_unit_value_version');
		$this->dropTable('ophciexamination_visualacuity_method_version');
		$this->dropTable('ophciexamination_visualacuity_reading_version');
		$this->dropTable('ophciexamination_workflow_version');
	}
}
