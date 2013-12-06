<?php

class m131206_150635_soft_deletion extends CDbMigration
{
	public function up()
	{
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
	}

	public function down()
	{
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
	}
}
