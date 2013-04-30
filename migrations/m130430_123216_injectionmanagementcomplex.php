<?php

class m130430_123216_injectionmanagementcomplex extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		// Management element type
		$mgmt_et = ElementType::model()->find('class_name=?',array('Element_OphCiExamination_Management'));
		
		$mr_workflow = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_workflow')->where('name=:name',array(':name'=>"MR Default"))->queryRow();
		$mrwf_id = $mr_workflow['id'];
		
		$consultant_set = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name AND workflow_id=:wf_id',array(':name'=>"Consultant", ':wf_id' => $mrwf_id))->queryRow();
		
		$consultant_set_id = $consultant_set['id'];
		
		// get the id for both eyes
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		
		$this->createTable('ophciexamination_injectmanagecomplex_notreatmentreason', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
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
		
		$this->createTable('et_ophciexamination_injectionmanagementcomplex', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'int(10) unsigned NOT NULL',
				'eye_id' => 'int(10) unsigned DEFAULT ' . $both_eyes_id,
				'no_treatment' => 'boolean NOT NULL DEFAULT false',
				'no_treatment_reason_id' => 'int(10) unsigned',
				'left_diagnosis_id' => 'int(10) unsigned',
				'right_diagnosis_id' => 'int(10) unsigned',
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
				'KEY `et_ophciexamination_injectionmanagementcomplex_ldiag_fk` (`left_diagnosis_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_rdiag_fk` (`right_diagnosis_id`)',
				'KEY `et_ophciexamination_injectionmanagementcomplex_event_id_fk` (`event_id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_eye_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_ldiag_fk` FOREIGN KEY (`left_diagnosis_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_rdiag_fk` FOREIGN KEY (`right_diagnosis_id`) REFERENCES `disorder` (`id`)',
				'CONSTRAINT `et_ophciexamination_injectionmanagementcomplex_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->createTable('ophciexamination_injectmanagecomplex_question', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'disorder_id' => 'int(10) unsigned NOT NULL',
				'question' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
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
	}

	public function down()
	{
		$this->dropTable('ophciexamination_injectmanagecomplex_answer');
		$this->dropTable('ophciexamination_injectmanagecomplex_question');
		$this->dropTable('et_ophciexamination_injectionmanagementcomplex');
		$this->dropTable('ophciexamination_injectmanagecomplex_notreatmentreason');
		
		$imgmt_id = $this->dbConnection->createCommand()
		->select('id')
		->from('element_type')
		->where('class_name=:class_name', array(':class_name'=>'Element_OphCiExamination_InjectionManagementComplex'))
		->queryScalar();
		
		$this->delete('ophciexamination_element_set_item', 'element_type_id = :element_type_id', array(':element_type_id' => $imgmt_id));
		$this->delete('element_type', 'id=:id', array(':id'=>$imgmt_id));
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