<?php

class m130408_135042_dr_function extends CDbMigration
{
	public function up()
	{
		
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		// Posterior Segment Element type
		$posterior_et  = ElementType::model()->find('class_name=? and event_type_id=?', array('Element_OphCiExamination_PosteriorPole', $event_type->id));
		// Management element type
		$mgmt_et = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_Management'));
		
		// MR subspecialty
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('ref_spec=:spec',array(':spec'=>"MR"))->queryRow();
		
		$mr_id = $subspecialty['id'];
		
		// create the MR default examination workflow
		$this->insert('ophciexamination_workflow', array('name' => 'MR Default'));
		$wf_id = $this->dbConnection->lastInsertID;
		
		$this->insert('ophciexamination_element_set', array('name'=>'Nurse', 'workflow_id' => $wf_id, 'position' => 1));
		$nurse_set_id = $this->dbConnection->lastInsertID;
		$this->insert('ophciexamination_element_set', array('name'=>'Consultant', 'workflow_id' => $wf_id, 'position' => 2));
		$consultant_set_id = $this->dbConnection->lastInsertID;
		
		$subspecialty_rule = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set_rule')->where('clause=:clause', array(':clause'=>"subspecialty_id"))->queryRow();
		$parent_rule_id = $subspecialty_rule["id"];
		
		// MR set rules (not worried about status, so don't need another clause)
		$this->insert('ophciexamination_element_set_rule', array('workflow_id'=>$wf_id, 'parent_id'=> $parent_rule_id, 'value'=>$mr_id));
		// MR set items
		$history = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_History"))->queryRow();
		$va = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_VisualAcuity"))->queryRow();
		$outcome = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_ClinicOutcome"))->queryRow();
		$refraction = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_Refraction"))->queryRow();
		$iop = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_IntraocularPressure"))->queryRow();
		$dilation = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_Dilation"))->queryRow();
		
		// base nurse and consultant set items
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$nurse_set_id, 'element_type_id' => $history['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$nurse_set_id, 'element_type_id' => $refraction['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$nurse_set_id, 'element_type_id' => $va['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$nurse_set_id, 'element_type_id' => $iop['id']));
		
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $posterior_et->id));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $outcome['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $mgmt_et->id));
		
		
		// NSC Retinopathy lookup
		$this->createTable('ophciexamination_drgrading_nscretinopathy', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'booking_weeks' => 'int(2) unsigned',
				'class' => 'varchar(16) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_drgrading_nscretinopathy_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_drgrading_nscretinopathy_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_drgrading_nscretinopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_drgrading_nscretinopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R0', 'display_order' => '1', 'class' => 'none', 'description' => 'No retinopathy'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R1', 'display_order' => '2', 'class' => 'background', 'description' => 'Background retinopathy<ul><li>Microaneurysms</li><li>Retinal haemorrhages</li><li>Venous loop</li><li>Any exudate in the presence of other non-referable features of DR</li><li>Any number of cotton wool spots (CWS) in the presence of other non-referable features of DR</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R2', 'display_order' => '3', 'class' => 'pre-prolif', 'description' => 'Pre-proliferative retinopathy<ul><li>Venous beading</li><li>Venous reduplication</li><li>Multiple blot haemorrhages</li><li>Intraretinal microvascular abnormality (IRMA)</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R3S', 'display_order' => '4', 'class' => 'peripheral', 'description' => 'Evidence of Peripheral Retinal Laser Treatment AND stable retina from photograph taken at or shortly after discharge from the Hospital Eye service (HES)'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R3A', 'display_order' => '5', 'class' => 'proliferative', 'booking_weeks' => 2, 'description' => 'Active Proliferative Retinopathy<ul><li>New vessels on disc (NVD)</li><li>New vessels elsewhere (NVE)</li><li>Pre-retinal or vitreous haemorrhage</li><li>Pre-retinal fibrosis +/- tractional retinal detachment</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'U', 'display_order' => '6', 'class' => 'ungradable', 'description' => 'Ungradable'));
		
		
		// NSC Maculopathy lookup
		$this->createTable('ophciexamination_drgrading_nscmaculopathy', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'booking_weeks' => 'int(2) unsigned',
				'class' => 'varchar(16) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_drgrading_nscmaculopathy_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_drgrading_nscmaculopathy_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_drgrading_nscmaculopathy_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_drgrading_nscmaculopathy_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M0', 'display_order' => '1', 'class' =>'none', 'description' => 'No maculopathy'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M1', 'display_order' => '2', 'class' =>'maculopathy', 'booking_weeks' => 13, 'description' => 'Any of the following:<ul><li>Exudate within 1 disc diameter (DD) of the centre of the fovea</li><li>Group of exudates within the macula</li><li>Retinal thickening within 1DD of the centre of the fovea (if stereo available)</li><li>Any microaneurysm or haemorrhage within 1DD of the centre of the fovea only if associated with a best VA of <= 6/12 (if no stereo)</li></ul>'));
		
		// clinical grading lookup
		$this->createTable('ophciexamination_drgrading_clinical', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'class' => 'varchar(16) NOT NULL',
				'booking_weeks' => 'int(2) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_drgrading_clinical_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_drgrading_clinical_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_drgrading_clinical_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_drgrading_clinical_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'None', 'display_order' => '1', 'class' => 'none', 'description' => 'No retinopathy'));
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'Mild nonproliferative retinopathy', 'display_order' => '2', 'class' => 'mild', 'description' => 'At least one microaneurysm'));
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'Moderate nonproliferative retinopathy', 'display_order' => '3', 'class' => 'moderate', 'description' => 'Hemorrhages and/or microaneurysms &ge; standard photograph 2A*; and/or:<ul><li>soft exudates</li><li>venous beading</li><li>intraretinal microvascular abnormalities definitely present ( IRMA )</li></ul>'));
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'Severe nonproliferative retinopathy', 'display_order' => '4', 'class' => 'severe', 'description' => '<ul><li>Soft exudates, venous beading, and intraretinal microvascular abnormalities all definitely present in at least two of fields four through seven</li><li>or two of the preceding three lesions present in at least two of fields four through seven and hemorrhages and microaneurysms present in these four fields, equaling or exceeding standard photo 2A in at least one of them</li><li>or intraretinal microvascular abnormalities present in each of fields four through seven and equaling or exceeding standard photograph 8A in at least two of them</li></ul>'));
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'Early proliferative retinopathy', 'display_order' => '5', 'class' => 'early', 'description' => 'Proliferative retinopathy without Diabetic Retinopathy Study high-risk characteristic:<ul><li>New vessels</li></ul>'));
		$this->insert('ophciexamination_drgrading_clinical', array('name'=>'High-risk proliferative retinopathy', 'display_order' => '6', 'class' => 'high-risk', 'description' => 'Proliferative retinopathy with Diabetic Retinopathy Study high-risk characteristics:<ul><li>New vessels on or within one disc diameter of the optic disc (NVD) &ge; standard photograph 10A* (about one-quarter to one-third disc area), with or without vitreous or preretinal hemorrhage</li><li>vitreous and/or preretinal hemorrhage accompanied by new vessels, either NVD &lt; standard photograph 10A or new vessels elsewhere (NVE) &ge; one-quarter disc area</li></ul>'));
		
		// create the DR Grading table
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		
		$this->createTable('et_ophciexamination_drgrading', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'left_nscretinopathy_id' => 'int(10) unsigned',
				'right_nscretinopathy_id' => 'int(10) unsigned',
				'left_nscmaculopathy_id' => 'int(10) unsigned',
				'right_nscmaculopathy_id' => 'int(10) unsigned',
				'left_nscretinopathy_photocoagulation' => 'boolean',
				'right_nscretinopathy_photocoagulation' => 'boolean',
				'left_nscmaculopathy_photocoagulation' => 'boolean',
				'right_nscmaculopathy_photocoagulation' => 'boolean',
				'left_clinical_id' => 'int(10) unsigned',
				'right_clinical_id' => 'int(10) unsigned',
				'eye_id' => 'int(10) unsigned DEFAULT ' . $both_eyes_id,
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_drgrading_e_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_drgrading_c_u_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_drgrading_l_m_u_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_drgrading_l_nret_fk` (`left_nscretinopathy_id`)',
				'KEY `et_ophciexamination_drgrading_r_nret_fk` (`right_nscretinopathy_id`)',
				'KEY `et_ophciexamination_drgrading_l_nmac_fk` (`left_nscmaculopathy_id`)',
				'KEY `et_ophciexamination_drgrading_r_nmac_fk` (`right_nscmaculopathy_id`)',
				'KEY `et_ophciexamination_drgrading_l_clinical_fk` (`left_clinical_id`)',
				'KEY `et_ophciexamination_drgrading_r_clinical_fk` (`right_clinical_id`)',
				'KEY `et_ophciexamination_drgrading_eye_id_fk` (`eye_id`)', 
				'CONSTRAINT `et_ophciexamination_drgrading_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_nret_fk` FOREIGN KEY (`left_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_r_nret_fk` FOREIGN KEY (`right_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_nmac_fk` FOREIGN KEY (`left_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_r_nmac_fk` FOREIGN KEY (`right_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_clinical_fk` FOREIGN KEY (`left_clinical_id`) REFERENCES `ophciexamination_drgrading_clinical` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_r_clinical_fk` FOREIGN KEY (`right_clinical_id`) REFERENCES `ophciexamination_drgrading_clinical` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type',array('name'=>'DR Grading','class_name'=>'Element_OphCiExamination_DRGrading','event_type_id'=>$event_type->id, 'parent_element_type_id'=>$posterior_et->id, 'display_order'=>$posterior_et->display_order+1));
		$dr_grading_id = $this->dbConnection->lastInsertID;
		
		// add DR Grading element to default set for Consultant workflow step
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $dr_grading_id));
		
		// end of DR Grading setup
		
		// management lookup for laser and injection management
		$this->createTable('ophciexamination_management_status', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'deferred' => 'boolean NOT NULL DEFAULT false',
				'book' => 'boolean NOT NULL DEFAULT false',
				'event' => 'boolean NOT NULL DEFAULT false',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_management_laser_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_management_laser_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_management_laser_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_management_laser_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_management_status', array('name'=>'Not Required', 'display_order' => '1'));
		$this->insert('ophciexamination_management_status', array('name'=>'Deferred', 'display_order' => '2', 'deferred' => true));
		$this->insert('ophciexamination_management_status', array('name'=>'Booked for a future date', 'display_order' => '3', 'book' => true));
		$this->insert('ophciexamination_management_status', array('name'=>'Performed today', 'display_order' => '4', 'event' => true));
		
		// deferral reason lookup for laser and injection management
		$this->createTable('ophciexamination_management_deferralreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'other' => 'boolean NOT NULL DEFAULT false',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_management_ldeferral_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_management_ldeferral_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_management_ldeferral_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_management_ldeferral_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Cataract', 'display_order' => '1'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Retinal detachment', 'display_order' => '2'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Vitreous haemorrhage', 'display_order' => '3'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Patient choice', 'display_order' => '4'));
		$this->insert('ophciexamination_management_deferralreason', array('name'=>'Other', 'display_order' => '5', 'other' => true));
		
		// laser management element (child of management)
		$this->createTable('et_ophciexamination_lasermanagement', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'laser_status_id' => 'int(10) unsigned NOT NULL',
				'laser_deferralreason_id' => 'int(10) unsigned',
				'laser_deferralreason_other' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_lasermanagement_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_lasermanagement_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_lasermanagement_laser_fk` (`laser_status_id`)',
				'KEY `et_ophciexamination_lasermanagement_ldeferral_fk` (`laser_deferralreason_id`)',
				'KEY `et_ophciexamination_lasermanagement_event_id_fk` (`event_id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_laser_fk` FOREIGN KEY (`laser_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_ldeferral_fk` FOREIGN KEY (`laser_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
				'CONSTRAINT `et_ophciexamination_lasermanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type', array(
				'name' => 'Laser Management',
				'class_name' => 'Element_OphCiExamination_LaserManagement',
				'event_type_id' => $event_type->id,
				'display_order' => 91,
				'default' => 1,
				'parent_element_type_id' => $mgmt_et->id
		));
		
		$lmgmt_id = $this->dbConnection->lastInsertID;
		
		// add to the MR Consultant workflow step
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $lmgmt_id));
		
		// end laser management
		
		// injection management element (child of management)
		$this->createTable('et_ophciexamination_injectionmanagement', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'injection_status_id' => 'int(10) unsigned NOT NULL',
				'injection_deferralreason_id' => 'int(10) unsigned',
				'injection_deferralreason_other' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_injectionmanagement_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_injectionmanagement_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_injectionmanagement_injection_fk` (`injection_status_id`)',
				'KEY `et_ophciexamination_injectionmanagement_ideferral_fk` (`injection_deferralreason_id`)',
				'KEY `et_ophciexamination_injectionmanagement_event_id_fk` (`event_id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_injection_fk` FOREIGN KEY (`injection_status_id`) REFERENCES `ophciexamination_management_status` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_ideferral_fk` FOREIGN KEY (`injection_deferralreason_id`) REFERENCES `ophciexamination_management_deferralreason` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagement_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('element_type', array(
				'name' => 'Injection Management',
				'class_name' => 'Element_OphCiExamination_InjectionManagement',
				'event_type_id' => $event_type->id,
				'display_order' => 92,
				'default' => 1,
				'parent_element_type_id' => $mgmt_et->id
		));
		
		$imgmt_id = $this->dbConnection->lastInsertID;
		
		// add to the MR Consultant workflow set
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $imgmt_id));
		
		//end injection management
	}

	public function down()
	{
		$workflow = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_workflow')->where('name=:name', array(':name'=>"MR Default"))->queryRow();
		
		$consultant_set = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name AND workflow_id=:wf_id',array(':name'=>"Consultant", ':wf_id'=> $workflow['id']))->queryRow();
		$nurse_set = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name AND workflow_id=:wf_id',array(':name'=>"Nurse", ':wf_id'=> $workflow['id']))->queryRow();
		
		// laser
		$this->dropTable('et_ophciexamination_lasermanagement');
		
		$lmgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_LaserManagement'))
		->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$consultant_set['id'], ':element_type_id' => $lmgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$lmgmt_id));
		
		// injection
		$this->dropTable('et_ophciexamination_injectionmanagement');
		
		$imgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_InjectionManagement'))
		->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'set_id=:set_id AND element_type_id = :element_type_id', array(':set_id'=>$consultant_set['id'], ':element_type_id' => $imgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$imgmt_id));
		
		// mgmt lookups
		$this->dropTable('ophciexamination_management_status');
		$this->dropTable('ophciexamination_management_deferralreason');
		
		// DR Grading tables
		$this->dropTable('et_ophciexamination_drgrading');
		$this->dropTable('ophciexamination_drgrading_nscmaculopathy');
		$this->dropTable('ophciexamination_drgrading_nscretinopathy');
		$this->dropTable('ophciexamination_drgrading_clinical');
		
		$this->delete('ophciexamination_element_set_item', "set_id=:set_id", array(':set_id'=>$consultant_set['id']));
		$this->delete('ophciexamination_element_set_item', "set_id=:set_id", array(':set_id'=>$nurse_set['id']));
		
		$this->delete('ophciexamination_element_set_rule', "workflow_id=:wf_id", array(':wf_id'=>$workflow['id']));
		
		// remove any workflow step assignments
		$this->delete('ophciexamination_event_elementset_assignment', "step_id=:step_id", array(':step_id'=>$nurse_set['id']));
		$this->delete('ophciexamination_event_elementset_assignment', "step_id=:step_id", array(':step_id'=>$consultant_set['id']));
		
		$this->delete('ophciexamination_element_set', "workflow_id=:id", array(':id'=>$workflow['id']));
		$this->delete('ophciexamination_workflow', "id=:id", array(':id'=>$workflow['id']));
		
		// remove DR Grading class
		$this->delete('element_type', "class_name=:name", array(":name"=>"Element_OphCiExamination_DRGrading"));
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
