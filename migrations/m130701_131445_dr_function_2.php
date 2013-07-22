<?php

class m130701_131445_dr_function_2 extends CDbMigration
{
	public function up()
	{
		// letter short codes
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		
		$event_type->registerShortcode('nrr','getLetterDRRetinopathyRight','NSC right retinopathy');
		$event_type->registerShortcode('nlr','getLetterDRRetinopathyLeft','NSC left retinopathy');
		$event_type->registerShortcode('nrm','getLetterDRMaculopathyRight','NSC right maculopathy');
		$event_type->registerShortcode('nlm','getLetterDRMaculopathyLeft','NSC left maculopathy');
		$event_type->registerShortcode('crd','getLetterDRClinicalRight','Clinical right retinopathy');
		$event_type->registerShortcode('cld','getLetterDRClinicalLeft','Clinical left retinopathy');
		$event_type->registerShortcode('lmp','getLetterLaserManagementPlan','Laser management plan');
		$event_type->registerShortcode('lmc','getLetterLaserManagementComments','Laser management comments');
		$event_type->registerShortcode('fup','getLetterOutcomeFollowUpPeriod','Follow up period');
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')
			->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		// now keeping track of the units used to record the va
		// up until now, they've all been Snellen Metre
		$unit_type = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
			->where('name=:name', array(':name'=>'Snellen Metre'))->queryRow();
		$snellen_id = $unit_type['id'];
		
		$this->addColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned');
		
		$this->update('et_ophciexamination_visualacuity', array('unit_id' => $snellen_id));
		
		$this->alterColumn('et_ophciexamination_visualacuity', 'unit_id', 'int(10) unsigned NOT NULL');
		$this->addForeignKey('et_ophciexamination_visualacuity_unit_fk', 'et_ophciexamination_visualacuity', 'unit_id', 'ophciexamination_visual_acuity_unit', 'id');
		
		// add flag to unit_value table to indicate whether the conversion value is just there for display, or is a valid value to be recorded
		$this->addColumn('ophciexamination_visual_acuity_unit_value', 'selectable', 'boolean NOT NULL DEFAULT true');
		
		// ETDRS equivalent of 1/60
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $etdrs_id,
				'value' => 'N/A',
				'selectable' => false,
				'base_value' => 21));
		
		// extend the ETDRS range to 0:
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $etdrs_id,
				'value' => '0',
				'base_value' => 25));
		
		// add entries for every single letter for ETDRS
		for ($i = 26; $i < 130; $i++) {
			if ($i % 5 == 0) {
				continue;
			}
			$this->insert('ophciexamination_visual_acuity_unit_value', array(
					'unit_id' => $etdrs_id,
					'value' => $i-25,
					'base_value' => $i));
		}
		
		// extend ETDRS to 120
		for ($i = 126; $i <= 145; $i++) {
			$this->insert('ophciexamination_visual_acuity_unit_value', array(
					'unit_id' => $etdrs_id,
					'value' => $i-25,
					'base_value' => $i));
		}
		
		// extend the snellen metre values
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '6/4',
				'base_value' => 119));
		
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '6/3',
				'base_value' => 126));
		
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '6/2',
				'selectable' => false,
				'base_value' => 135));
		
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $snellen_id,
				'value' => '6/1',
				'selectable' => false,
				'base_value' => 150));
		
		// add column on VA units to flag whether it should be shown in conversion tool tip
		$this->addColumn('ophciexamination_visual_acuity_unit', 'tooltip', 'boolean NOT NULL DEFAULT false');
		
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $snellen_id));
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $etdrs_id));
		
		// add column on VA units to provide informational text to display in VA element
		$this->addColumn('ophciexamination_visual_acuity_unit', 'information', 'text');
		
		$this->update('ophciexamination_visual_acuity_unit', array('information' => 'ETDRS letters score is at 1m. For tests done at 4m, 30 letters should be added, at 2m, 15 letters should be added.'), 'id = :uid', array(':uid' => $etdrs_id));
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')
		->where('name=:name', array(':name'=>'logMAR'))->queryRow();
		$logmar_id = $units['id'];
		
		// set up logMar unit values
		$logMar = 1.6;
		for ($i = 30; $i <= 145; $i+=5) {
			// dirty hack to avoid -0.0 as a value
			if ($logMar < 0 && $logMar + 0.05 > 0) {
				$logMar = 0;
			}
			$this->insert('ophciexamination_visual_acuity_unit_value', array(
					'unit_id' => $logmar_id,
					'value' => sprintf('%.1f', $logMar),
					'selectable' => true,
					'base_value' => $i));
			$logMar -= 0.1;
		}
		// logMar equiv for bottom end of scale
		$this->insert('ophciexamination_visual_acuity_unit_value', array(
				'unit_id' => $logmar_id,
				'value' => '1.78',
				'selectable' => false,
				'base_value' => 21));
		
		$this->update('ophciexamination_visual_acuity_unit', array('information' => 'logMAR score is at 1m. For tests done at 4m, subtract 0.6 logMAR, at 2m, subtract 0.3 logMar.'), 'id = :uid', array(':uid' => $logmar_id));
		// turn logMAR on
		$this->update('ophciexamination_visual_acuity_unit', array('tooltip' => true), 'id = :uid', array(':uid' => $logmar_id));
		

		// Injection Management Complex
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		// Management element type
		$mgmt_et = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_Management'));
		
		$mr_workflow = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_workflow')->where('name=:name',array(':name'=>"MR Default"))->queryRow();
		$mrwf_id = $mr_workflow['id'];
		
		$consultant_set = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name AND workflow_id=:wf_id',array(':name'=>"Consultant", ':wf_id' => $mrwf_id))->queryRow();
		
		$consultant_set_id = $consultant_set['id'];
		
		// get the id for both eyes
		$both_eyes_id = Eye::BOTH;
		
		$this->createTable('ophciexamination_injectmanagecomplex_notreatmentreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_injectmanagecomplex_notreatmentreason_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_notreatmentreason_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_notreatmentreason_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_notreatmentreason_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'DNA', 'display_order' => 1));
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'Infection', 'display_order' => 2));
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'CVA', 'display_order' => 3));
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'MI', 'display_order' => 4));
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'Spontaneous improvement', 'display_order' => 5));
		$this->insert('ophciexamination_injectmanagecomplex_notreatmentreason', array('name' => 'Other', 'display_order' => 6));
		
		$this->createTable('et_ophciexamination_injectionmanagementcomplex', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned DEFAULT ' . $both_eyes_id,
				'no_treatment' => 'boolean NOT NULL DEFAULT false',
				'no_treatment_reason_id' => 'int(10) unsigned',
				'left_diagnosis1_id' => 'int(10) unsigned',
				'right_diagnosis1_id' => 'int(10) unsigned',
				'left_diagnosis2_id' => 'int(10) unsigned',
				'right_diagnosis2_id' => 'int(10) unsigned',
				'left_comments' => 'text',
				'right_comments' => 'text',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_lmui_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_cui_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_eye_fk` (`eye_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` (`left_diagnosis1_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` (`right_diagnosis1_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` (`left_diagnosis2_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` (`right_diagnosis2_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_event_id_fk` (`event_id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_eye_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_ldiag1_fk` FOREIGN KEY (`left_diagnosis1_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_rdiag1_fk` FOREIGN KEY (`right_diagnosis1_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_ldiag2_fk` FOREIGN KEY (`left_diagnosis2_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_rdiag2_fk` FOREIGN KEY (`right_diagnosis2_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->createTable('ophciexamination_injectmanagecomplex_risk', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(256) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_injectmanagecomplex_risk',array('name'=>'Pre-existing glaucoma','display_order'=>1));
		$this->insert('ophciexamination_injectmanagecomplex_risk',array('name'=>'Previous glaucoma surgery (trabeculectomy bleb, glaucoma draining device)','display_order'=>2));
		$this->insert('ophciexamination_injectmanagecomplex_risk',array('name'=>'Allergy to povidone iodine','display_order'=>3));
		
		$this->createTable('ophciexamination_injectmanagecomplex_risk_assignment', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT ' . $both_eyes_id,
				'risk_id' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` (`element_id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` (`eye_id`)',
				'KEY `ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` (`risk_id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_ele_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assign_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_risk_assignment_lku_fk` FOREIGN KEY (`risk_id`) REFERENCES `ophciexamination_injectmanagecomplex_risk` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		
		$this->createTable('ophciexamination_injectmanagecomplex_question', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'disorder_id' => 'int(10) unsigned NOT NULL',
				'question' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_injectmanagecomplex_question_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_question_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_question_disorder_fk` (`disorder_id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_question_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_question_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_question_disorder_fk` FOREIGN KEY (`disorder_id`) REFERENCES `disorder` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->createTable('ophciexamination_injectmanagecomplex_answer', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'element_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL',
				'question_id' => 'int(10) unsigned NOT NULL',
				'answer' => 'boolean NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_injectmanagecomplex_answer_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_answer_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_injectmanagecomplex_answer_eli_fk` (`element_id`)',
				'KEY `ophciexamination_injectmanagecomplex_answer_eyei_fk` (`eye_id`)',
				'KEY `ophciexamination_injectmanagecomplex_answer_qi_fk` (`question_id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_answer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_answer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_answer_eli_fk` FOREIGN KEY (`element_id`) REFERENCES `et_ophciexamination_injectionmanagementcomplex` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_answer_eyei_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `ophciexamination_injectmanagecomplex_answer_qi_fk` FOREIGN KEY (`question_id`) REFERENCES `ophciexamination_injectmanagecomplex_question` (`id`)',
		
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		
		$this->insert('element_type', array(
				'name' => 'Injection Management',
				'class_name' => 'Element_OphCiExamination_InjectionManagementComplex',
				'event_type_id' => $event_type->id,
				'display_order' => 92,
				'default' => 1,
				'parent_element_type_id' => $mgmt_et->id
		));
		
		$imgmt_id = $this->dbConnection->lastInsertID;
		
		// add to the MR Consultant workflow set
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$consultant_set_id, 'element_type_id' => $imgmt_id));
		
		// OCT Elements
		
		$event_type_id = Yii::app()->db->createCommand("select id from event_type where class_name = 'OphCiExamination'")->queryScalar();
		$investigation_id = Yii::app()->db->createCommand("select id from element_type where class_name = 'Element_OphCiExamination_Investigation'")->queryScalar();
		$posterior_id = Yii::app()->db->createCommand("select id from element_type where class_name = 'Element_OphCiExamination_PosteriorPole'")->queryScalar();
		
		$both_eyes_id = Eye::BOTH;
		
		$this->createTable('ophciexamination_oct_method', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255)NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'PRIMARY KEY (`id`)',
		),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$this->insert('ophciexamination_oct_method', array('name' => 'Topcon', 'display_order' => 1));
		$this->insert('ophciexamination_oct_method', array('name' => 'Spectralis', 'display_order' => 2));
		
		$this->createTable('et_ophciexamination_oct', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned NOT NULL DEFAULT '.$both_eyes_id,
				'left_method_id' => 'int(10) unsigned',
				'right_method_id' => 'int(10) unsigned',
				'left_crt' => 'int(10) unsigned',
				'right_crt' => 'int(10) unsigned',
				'left_sft' => 'int(10) unsigned',
				'right_sft' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `et_ophciexamination_oct_event_id_fk` (`event_id`)',
				'KEY `et_ophciexamination_oct_eye_id_fk` (`eye_id`)',
				'KEY `et_ophciexamination_oct_last_modified_user_id_fk` (`last_modified_user_id`)',
				'KEY `et_ophciexamination_oct_created_user_id_fk` (`created_user_id`)',
				'KEY `et_ophciexamination_oct_lmid_fk` (`left_method_id`)',
				'KEY `et_ophciexamination_oct_rmid_fk` (`right_method_id`)',
				'CONSTRAINT `et_ophciexamination_oct_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_last_modified_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_created_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_lmid_fk` FOREIGN KEY (`left_method_id`) REFERENCES `ophciexamination_oct_method` (`id`)',
				'CONSTRAINT `et_ophciexamination_oct_rmid_fk` FOREIGN KEY (`right_method_id`) REFERENCES `ophciexamination_oct_method` (`id`)',
		),
				'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		
		$this->insert('element_type',array(
				'name' => 'OCT',
				'class_name' => 'Element_OphCiExamination_OCT',
				'event_type_id' => $event_type_id,
				'display_order' => 1,
				'parent_element_type_id' => $investigation_id
		));
		
	}

	public function down()
	{
		
		echo "***WARNING: down migration will remove selectable values for VA. Edit migration and remove return statement to perform this down step";
		//return false;
		$this->dropForeignKey('et_ophciexamination_visualacuity_unit_fk', 'et_ophciexamination_visualacuity');
		$this->dropColumn('et_ophciexamination_visualacuity', 'unit_id');
		$this->dropColumn('ophciexamination_visual_acuity_unit_value', 'selectable');
		$this->dropColumn('ophciexamination_visual_acuity_unit', 'tooltip');
		$this->dropColumn('ophciexamination_visual_acuity_unit', 'information');
		
		$element_type = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:cname', array(':cname'=>'Element_OphCiExamination_VisualAcuity'))->queryRow();
		$va_id = $element_type['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'ETDRS Letters'))->queryRow();
		$etdrs_id = $units['id'];
		
		$units = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_visual_acuity_unit')->where('name=:name', array(':name'=>'logMar'))->queryRow();
		$logmar_id = $units['id'];
		
		// remove the logmar entries
		$this->delete('ophciexamination_visual_acuity_unit_value', 'unit_id = :uid', array(':uid' => $logmar_id));
		
		// remove the additional scale entries
		$this->delete('ophciexamination_visual_acuity_unit_value', 'base_value = :bv AND unit_id = :uid', array(':bv' => 21, ':uid' => $etdrs_id));
		
		// extend the ETDRS range to 0:
		$this->delete('ophciexamination_visual_acuity_unit_value', 'base_value = :bv AND unit_id = :uid', array(':bv' => 25, ':uid' => $etdrs_id));
		
		// remove the non stepped values for ETDRS
		for ($i = 26; $i < 130; $i++) {
			if ($i % 5 == 0) {
				continue;
			}
			$this->delete('ophciexamination_visual_acuity_unit_value','base_value = :bv AND unit_id = :uid', array(':bv' => $i, ':uid' => $etdrs_id));
		}
		
		// remove all ETDRS above 100
		for ($i = 126; $i <= 145; $i++) {
			$this->delete('ophciexamination_visual_acuity_unit_value','base_value = :bv AND unit_id = :uid', array(':bv' => $i, ':uid' => $etdrs_id));
		}
		
		$this->dropTable('ophciexamination_injectmanagecomplex_answer');
		$this->dropTable('ophciexamination_injectmanagecomplex_question');
		$this->dropTable('ophciexamination_injectmanagecomplex_risk_assignment');
		$this->dropTable('ophciexamination_injectmanagecomplex_risk');
		$this->dropTable('et_ophciexamination_injectionmanagementcomplex');
		$this->dropTable('ophciexamination_injectmanagecomplex_notreatmentreason');
		
		$imgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_InjectionManagementComplex'))
		->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'element_type_id = :element_type_id', array(':element_type_id' => $imgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$imgmt_id));
		
		$this->dropTable('et_ophciexamination_oct');
		$this->dropTable('ophciexamination_oct_method');
		$this->delete('element_type',"class_name = 'Element_OphCiExamination_OCT'");
		
		$this->delete('patient_shortcode', "default_code = 'nrr'");
		$this->delete('patient_shortcode', "default_code = 'nlr'");
		$this->delete('patient_shortcode', "default_code = 'nrm'");
		$this->delete('patient_shortcode', "default_code = 'nlm'");
		$this->delete('patient_shortcode', "default_code = 'crd'");
		$this->delete('patient_shortcode', "default_code = 'cld'");
		$this->delete('patient_shortcode', "default_code = 'lmp'");
		$this->delete('patient_shortcode', "default_code = 'lmc'");
		$this->delete('patient_shortcode', "default_code = 'fup'");		
	}

}