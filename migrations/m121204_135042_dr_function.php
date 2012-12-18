<?php

class m121204_135042_dr_function extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$parent_el  = ElementType::model()->find('class_name=? and event_type_id=?', array('Element_OphCiExamination_PosteriorSegment', $event_type->id));

		$this->insert('element_type',array('name'=>'DR Grading','class_name'=>'Element_OphCiExamination_DRGrading','event_type_id'=>$event_type->id, 'parent_element_type_id'=>$parent_el->id, 'display_order'=>$parent_el->display_order+1));
		$dr_grading_id = $this->dbConnection->lastInsertID;
		
		$subspecialty = $this->dbConnection->createCommand()->select('id')->from('subspecialty')->where('ref_spec=:spec',array(':spec'=>"MR"))->queryRow();
		
		$mr_id = $subspecialty['id'];
		
		$this->insert('ophciexamination_element_set', array('name'=>'MR Default'));
		$set_id = $this->dbConnection->lastInsertID;
		
		$subspecialty_rule = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set_rule')->where('clause=:clause', array(':clause'=>"subspecialty_id"))->queryRow();
		$parent_rule_id = $subspecialty_rule["id"];
		
		// MR set rules (not worried about status, so don't need another clause)
		$this->insert('ophciexamination_element_set_rule', array('set_id'=>$set_id, 'parent_id'=> $parent_rule_id, 'value'=>$mr_id));
		// MR set items
		$posterior = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_PosteriorSegment"))->queryRow();
		$history = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_History"))->queryRow();
		$va = $this->dbConnection->createCommand()->select('id')->from('element_type')->where('class_name=:class_name', array(':class_name'=>"Element_OphCiExamination_VisualAcuity"))->queryRow();
		
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$set_id, 'element_type_id' => $posterior['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$set_id, 'element_type_id' => $history['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$set_id, 'element_type_id' => $va['id']));
		$this->insert('ophciexamination_element_set_item', array('set_id'=>$set_id, 'element_type_id' => $dr_grading_id));
		
		// additional fields for posterior segment
		$this->createTable('ophciexamination_drgrading_nscretinopathy', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'booking_weeks' => 'int(2) unsigned',
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

		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R0', 'display_order' => '1', 'description' => 'No retinopathy'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R1', 'display_order' => '2', 'description' => 'Background retinopathy<ul><li>Microaneurysms</li><li>Retinal haemorrhages</li><li>Venous loop</li><li>Any exudate in the presence of other non-referable features of DR</li><li>Any number of cotton wool spots (CWS) in the presence of other non-referable features of DR</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R2', 'display_order' => '3', 'description' => 'Pre-proliferative retinopathy<ul><li>Venous beading</li><li>Venous reduplication</li><li>Multiple blot haemorrhages</li><li>Intraretinal microvascular abnormality (IRMA)</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R3S', 'display_order' => '4', 'description' => 'Evidence of Peripheral Retinal Laser Treatment AND stable retina from photograph taken at or shortly after discharge from the Hospital Eye service (HES)'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'R3A', 'display_order' => '5', 'booking_weeks' => 2, 'description' => 'Active Proliferative Retinopathy<ul><li>New vessels on disc (NVD)</li><li>New vessels elsewhere (NVE)</li><li>Pre-retinal or vitreous haemorrhage</li><li>Pre-retinal fibrosis +/- tractional retinal detachment</li></ul>'));
		$this->insert('ophciexamination_drgrading_nscretinopathy', array('name'=>'U', 'display_order' => '6', 'description' => 'Ungradable'));
		
		$this->createTable('ophciexamination_drgrading_nscmaculopathy', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'booking_weeks' => 'int(2) unsigned',
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
		
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M0', 'display_order' => '1', 'description' => 'No maculopathy'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M1', 'display_order' => '2', 'booking_weeks' => 13, 'description' => 'Any of the following:<ul><li>Exudate within 1 disc diameter (DD) of the centre of the fovea</li><li>Group of exudates within the macula</li><li>Retinal thickening within 1DD of the centre of the fovea (if stereo available)</li><li>Any microaneurysm or haemorrhage within 1DD of the centre of the fovea only if associated with a best VA of <= 6/12 (if no stereo)</li></ul>'));
		
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
				'KEY `et_ophciexamination_drgrading_eye_id_fk` (`eye_id`)', 
				'CONSTRAINT `et_ophciexamination_drgrading_e_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_nret_fk` FOREIGN KEY (`left_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_r_nret_fk` FOREIGN KEY (`right_nscretinopathy_id`) REFERENCES `ophciexamination_drgrading_nscretinopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_l_nmac_fk` FOREIGN KEY (`left_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_r_nmac_fk` FOREIGN KEY (`right_nscmaculopathy_id`) REFERENCES `ophciexamination_drgrading_nscmaculopathy` (`id`)',
				'CONSTRAINT `et_ophciexamination_drgrading_eye_id_fk` FOREIGN KEY (`eye_id`) REFERENCES `eye` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_drgrading');
		$this->dropTable('ophciexamination_drgrading_nscmaculopathy');
		$this->dropTable('ophciexamination_drgrading_nscretinopathy');
		
		$mr_set = $this->dbConnection->createCommand()->select('id')->from('ophciexamination_element_set')->where('name=:name',array(':name'=>"MR Default"))->queryRow();
		
		$this->delete('ophciexamination_element_set_item', "set_id=:set_id", array(':set_id'=>$mr_set['id']));
		$this->delete('ophciexamination_element_set_rule', "set_id=:set_id", array(':set_id'=>$mr_set['id']));
		$this->delete('ophciexamination_element_set', "id=:id", array(':id'=>$mr_set['id']));
		
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