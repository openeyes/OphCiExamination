<?php

class m140619_091711_overall_management_changes extends OEMigration
{
	public function up()
	{
		$this->dropForeignKey('et_ophciexam_overallmanagementplan_clinic_internal_id_fk', 'et_ophciexamination_overallmanagementplan');
		$this->renameColumn('et_ophciexamination_overallmanagementplan','clinic_internal_id','clinic_interval_id');
		$this->renameColumn('et_ophciexamination_overallmanagementplan_version','clinic_internal_id','clinic_interval_id');
		$this->addForeignKey('et_ophciexam_overallmanagementplan_clinic_interval_id_fk', 'et_ophciexamination_overallmanagementplan',
			'clinic_interval_id', 'ophciexamination_overallperiod', 'id'
		);
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexam_overallmanagementplan_clinic_interval_id_fk', 'et_ophciexamination_overallmanagementplan');
		$this->renameColumn('et_ophciexamination_overallmanagementplan','clinic_interval_id','clinic_internal_id');
		$this->renameColumn('et_ophciexamination_overallmanagementplan_version','clinic_interval_id','clinic_internal_id');
		$this->addForeignKey('et_ophciexam_overallmanagementplan_clinic_internal_id_fk', 'et_ophciexamination_overallmanagementplan',
			'clinic_internal_id', 'ophciexamination_overallperiod', 'id'
		);
	}
}