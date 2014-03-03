<?php

class m140228_130301_transactions extends CDbMigration
{
	public $tables = array('et_ophciexamination_adnexalcomorbidity','et_ophciexamination_anteriorsegment_cct','et_ophciexamination_anteriorsegment','et_ophciexamination_cataractsurgicalmanagement','et_ophciexamination_clinicoutcome','et_ophciexamination_comorbidities','et_ophciexamination_conclusion','et_ophciexamination_diagnoses','et_ophciexamination_dilation','et_ophciexamination_drgrading','et_ophciexamination_glaucomarisk','et_ophciexamination_gonioscopy','et_ophciexamination_history','et_ophciexamination_injectionmanagement','et_ophciexamination_injectionmanagementcomplex','et_ophciexamination_intraocularpressure','et_ophciexamination_investigation','et_ophciexamination_lasermanagement','et_ophciexamination_management','et_ophciexamination_oct','et_ophciexamination_opticdisc','et_ophciexamination_posteriorpole','et_ophciexamination_pupillaryabnormalities','et_ophciexamination_refraction','et_ophciexamination_risks','et_ophciexamination_visualacuity','ophciexamination_anteriorsegment_cct_method','ophciexamination_anteriorsegment_cortical','ophciexamination_anteriorsegment_nuclear','ophciexamination_anteriorsegment_pupil','ophciexamination_attribute_element','ophciexamination_attribute_option','ophciexamination_attribute','ophciexamination_cataractsurgicalmanagement_eye','ophciexamination_cataractsurgicalmanagement_sfsurgeon','ophciexamination_clinicoutcome_role','ophciexamination_clinicoutcome_status','ophciexamination_clinicoutcome_template','ophciexamination_comorbidities_assignment','ophciexamination_comorbidities_item','ophciexamination_diagnosis','ophciexamination_dilation_drugs','ophciexamination_dilation_treatment','ophciexamination_drgrading_clinicalmaculopathy','ophciexamination_drgrading_clinicalretinopathy','ophciexamination_drgrading_nscmaculopathy','ophciexamination_drgrading_nscretinopathy','ophciexamination_element_set_item','ophciexamination_element_set','ophciexamination_event_elementset_assignment','ophciexamination_glaucomarisk_risk','ophciexamination_gonioscopy_description','ophciexamination_gonioscopy_van_herick','ophciexamination_injectmanagecomplex_answer','ophciexamination_injectmanagecomplex_notreatmentreason','ophciexamination_injectmanagecomplex_question','ophciexamination_injectmanagecomplex_risk_assignment','ophciexamination_injectmanagecomplex_risk','ophciexamination_instrument','ophciexamination_intraocularpressure_reading','ophciexamination_lasermanagement_lasertype','ophciexamination_management_deferralreason','ophciexamination_management_status','ophciexamination_oct_fluidstatus','ophciexamination_oct_fluidtype_assignment','ophciexamination_oct_fluidtype','ophciexamination_oct_method','ophciexamination_opticdisc_cd_ratio','ophciexamination_opticdisc_lens','ophciexamination_pupillaryabnormalities_abnormality','ophciexamination_refraction_fraction','ophciexamination_refraction_integer','ophciexamination_refraction_sign','ophciexamination_refraction_type','ophciexamination_visual_acuity_unit_value','ophciexamination_visual_acuity_unit','ophciexamination_visualacuity_method','ophciexamination_visualacuity_reading','ophciexamination_workflow_rule','ophciexamination_workflow');

	public function up()
	{
		foreach ($this->tables as $table) {
			$this->addColumn($table,'hash','varchar(40) not null');
			$this->addColumn($table,'transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_tid',$table,'transaction_id');
			$this->addForeignKey($table.'_tid',$table,'transaction_id','transaction','id');

			$this->addColumn($table.'_version','hash','varchar(40) not null');
			$this->addColumn($table.'_version','transaction_id','int(10) unsigned null');
			$this->addColumn($table.'_version','deleted_transaction_id','int(10) unsigned null');
			$this->createIndex($table.'_vtid',$table.'_version','transaction_id');
			$this->addForeignKey($table.'_vtid',$table.'_version','transaction_id','transaction','id');
			$this->createIndex($table.'_dtid',$table.'_version','deleted_transaction_id');
			$this->addForeignKey($table.'_dtid',$table.'_version','deleted_transaction_id','transaction','id');
		}
	}

	public function down()
	{
		foreach ($this->tables as $table) {
			$this->dropColumn($table,'hash');
			$this->dropForeignKey($table.'_tid',$table);
			$this->dropIndex($table.'_tid',$table);
			$this->dropColumn($table,'transaction_id');

			$this->dropColumn($table.'_version','hash');
			$this->dropForeignKey($table.'_vtid',$table.'_version');
			$this->dropIndex($table.'_vtid',$table.'_version');
			$this->dropColumn($table.'_version','transaction_id');
			$this->dropForeignKey($table.'_dtid',$table.'_version');
			$this->dropIndex($table.'_dtid',$table.'_version');
			$this->dropColumn($table.'_version','deleted_transaction_id');
		}
	}
}
