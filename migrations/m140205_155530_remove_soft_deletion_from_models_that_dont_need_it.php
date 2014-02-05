<?php

class m140205_155530_remove_soft_deletion_from_models_that_dont_need_it extends CDbMigration
{
	public $tables = array(
		'et_ophciexamination_adnexalcomorbidity',
		'et_ophciexamination_anteriorsegment',
		'et_ophciexamination_anteriorsegment_cct',
		'et_ophciexamination_cataractsurgicalmanagement',
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
		'et_ophciexamination_visualacuity',
		'ophciexamination_attribute',
		'ophciexamination_attribute_element',
		'ophciexamination_attribute_option',
		'ophciexamination_clinicoutcome_template',
		'ophciexamination_comorbidities_assignment',
		'ophciexamination_diagnosis',
		'ophciexamination_dilation_treatment',
		'ophciexamination_element_set',
		'ophciexamination_element_set_item',
		'ophciexamination_event_elementset_assignment',
		'ophciexamination_glaucomarisk_risk',
		'ophciexamination_gonioscopy_description',
		'ophciexamination_injectmanagecomplex_answer',
		'ophciexamination_injectmanagecomplex_risk_assignment',
		'ophciexamination_intraocularpressure_reading',
		'ophciexamination_oct_fluidtype_assignment',
		'ophciexamination_visualacuity_reading',
		'ophciexamination_workflow_rule',
	);

	public function up()
	{
		foreach ($this->tables as $table) {
			$this->dropColumn($table,'deleted');
			$this->dropColumn($table.'_version','deleted');

			$this->dropForeignKey("{$table}_aid_fk",$table."_version");
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->addColumn($table,'deleted','tinyint(1) unsigned not null');
			$this->addColumn($table."_version",'deleted','tinyint(1) unsigned not null');

			$this->addForeignKey("{$table}_aid_fk",$table."_version","id",$table,"id");
		}
	}
}
