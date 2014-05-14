<?php 
class m140513_153538_glaucoma_management extends OEMigration
{
	public function up()
	{
		$event_type = $this->dbConnection->createCommand()->select('id')->from('event_type')->where('class_name=:class_name', array(':class_name'=>'OphCiExamination'))->queryRow();

		$element_types = array(
			'Element_OphCiExamination_OverallManagementPlan' => array('name' => 'Overall Management Plan'),
			'Element_OphCiExamination_CurrentManagementPlan' => array('name' => 'Current Management Plan'),
			'Element_OphCiExamination_ClinicOutcome' => array('name' => 'Clinic Outcome'),
		);

		$this->insertOEElementType($element_types,$event_type['id'] );

		$this->createOETable('et_ophciexamination_overallmanagementplan', array(
				'id' => 'pk',
				'event_id' => 'int(10) unsigned NOT NULL',
				'target_iop' => 'int(10) NOT NULL',

				'clinic_internal_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'photo_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'oct_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'hfa_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'gonio_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'comments' => 'text COLLATE utf8_bin DEFAULT \'\'',

				'KEY `et_ophciexamination_overallmanagementplan_ev_fk` (`event_id`)',
				'KEY `et_ophciexamination_overallmanagementplan_clinic_internal_id_fk` (`clinic_internal_id`)',
				'KEY `et_ophciexamination_overallmanagementplan_photo_id_fk` (`photo_id`)',
				'KEY `et_ophciexamination_overallmanagementplan_oct_id_fk` (`oct_id`)',
				'KEY `et_ophciexamination_overallmanagementplan_hfa_id_fk` (`hfa_id`)',
				'KEY `et_ophciexamination_overallmanagementplan_gonio_id_fk` (`gonio_id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_clinic_internal_id_fk` FOREIGN KEY (`clinic_internal_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_photo_id_fk` FOREIGN KEY (`photo_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_oct_id_fk` FOREIGN KEY (`oct_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_hfa_id_fk` FOREIGN KEY (`hfa_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_overallmanagementplan_gonio_id_fk` FOREIGN KEY (`gonio_id`) REFERENCES `gender` (`id`)',
			), true);



		$this->createOETable('et_ophciexamination_currentmanagementplan', array(
				'id' => 'pk',
				'event_id' => 'int(10) unsigned NOT NULL',
				'iop' => 'int(10) unsigned NOT NULL',

				'glaucoma_status_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'drop-related_prob_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'drops_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'surgery_id' => 'int(10) unsigned NOT NULL DEFAULT 1',

				'other-service' => 'tinyint(1) unsigned NOT NULL',

				'refraction' => 'tinyint(1) unsigned NOT NULL',

				'lva' => 'tinyint(1) unsigned NOT NULL',

				'orthoptics' => 'tinyint(1) unsigned NOT NULL',

				'cl_clinic' => 'tinyint(1) unsigned NOT NULL',

				'vf' => 'tinyint(1) unsigned NOT NULL',

				'us' => 'tinyint(1) unsigned NOT NULL',

				'biometry' => 'tinyint(1) unsigned NOT NULL',

				'oct' => 'tinyint(1) unsigned NOT NULL',

				'hrt' => 'tinyint(1) unsigned NOT NULL',

				'disc_photos' => 'tinyint(1) unsigned NOT NULL',

				'edt' => 'tinyint(1) unsigned NOT NULL',

				'KEY `et_ophciexamination_currentmanagementplan_ev_fk` (`event_id`)',
				'KEY `et_ophciexamination_currentmanagementplan_glaucoma_status_id_fk` (`glaucoma_status_id`)',
				'KEY `et_ophciexamination_currentmanagementplan-related_prob_id_fk` (`drop-related_prob_id`)',
				'KEY `et_ophciexamination_currentmanagementplan_drops_id_fk` (`drops_id`)',
				'KEY `et_ophciexamination_currentmanagementplan_surgery_id_fk` (`surgery_id`)',
				'CONSTRAINT `et_ophciexamination_currentmanagementplan_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_currentmanagementplan_glaucoma_status_id_fk` FOREIGN KEY (`glaucoma_status_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_currentmanagementplan-related_prob_id_fk` FOREIGN KEY (`drop-related_prob_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_currentmanagementplan_drops_id_fk` FOREIGN KEY (`drops_id`) REFERENCES `gender` (`id`)',
				'CONSTRAINT `et_ophciexamination_currentmanagementplan_surgery_id_fk` FOREIGN KEY (`surgery_id`) REFERENCES `gender` (`id`)',
			), true);



		$this->createOETable('et_ophciexamination_clinicoutcome', array(
				'id' => 'pk',
				'event_id' => 'int(10) unsigned NOT NULL',
				'status_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'KEY `et_ophciexamination_et_exam_clinicoutcome_ev_fk` (`event_id`)',
				'KEY `et_ophciexamination_et_exam_clinicoutcome_status_id_fk` (`status_id`)',
				'CONSTRAINT `et_ophciexamination_et_exam_clinicoutcome_ev_fk` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`)',
				'CONSTRAINT `et_ophciexamination_et_exam_clinicoutcome_status_id_fk` FOREIGN KEY (`status_id`) REFERENCES `gender` (`id`)',
			), true);

	}

	public function down()
	{
		$this->dropTable('et_ophciexamination_overallmanagementplan');
		$this->dropTable('et_ophciexamination_overallmanagementplan_version');
		$this->dropTable('et_ophciexamination_currentmanagementplan');
		$this->dropTable('et_ophciexamination_currentmanagementplan_version');
		$this->dropTable('et_ophciexamination_clinicoutcome');
		$this->dropTable('et_ophciexamination_clinicoutcome_version');

		$this->delete('element_type', 'class_name="Element_OphCiExamination_OverallManagementPlan"');
		$this->delete('element_type', 'class_name="Element_OphCiExamination_CurrentManagementPlan"');
		$this->delete('element_type', 'class_name="Element_OphCiExamination_ClinicOutcome"');
	}
}

