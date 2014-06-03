<?php

class m140110_084630_soft_deletion extends OEMigration
{
	public function up()
	{
		$this->renameColumn('ophciexamination_injectmanagecomplex_notreatmentreason', 'enabled', 'active');
		$this->renameColumn('ophciexamination_injectmanagecomplex_question', 'enabled', 'active');
		$this->renameColumn('ophciexamination_injectmanagecomplex_risk', 'enabled', 'active');
		$this->renameColumn('ophciexamination_lasermanagement_lasertype', 'enabled', 'active');
		$this->renameColumn('ophciexamination_oct_fluidtype', 'enabled', 'active');
		$this->renameColumn('ophciexamination_oct_fluidstatus', 'enabled', 'active');

		$this->renameColumn('ophciexamination_visual_acuity_unit', 'tooltip', 'active');

		$this->addColumn('ophciexamination_anteriorsegment_cct_method', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_cataractsurgicalmanagement_sfsurgeon', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_clinicoutcome_role', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_clinicoutcome_status', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_comorbidities_item', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_drgrading_nscmaculopathy', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_drgrading_nscretinopathy', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_instrument', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_management_deferralreason', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_management_status', 'active', 'boolean not null default true');
		$this->addColumn('ophciexamination_oct_method', 'active', 'boolean not null default true');
	}

	public function down()
	{
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method', 'active');
		$this->dropColumn('ophciexamination_cataractsurgicalmanagement_sfsurgeon', 'active');
		$this->dropColumn('ophciexamination_clinicoutcome_role', 'active');
		$this->dropColumn('ophciexamination_clinicoutcome_status', 'active');
		$this->dropColumn('ophciexamination_comorbidities_item', 'active');
		$this->dropColumn('ophciexamination_drgrading_clinicalmaculopathy', 'active');
		$this->dropColumn('ophciexamination_drgrading_clinicalretinopathy', 'active');
		$this->dropColumn('ophciexamination_drgrading_nscmaculopathy', 'active');
		$this->dropColumn('ophciexamination_drgrading_nscretinopathy', 'active');
		$this->dropColumn('ophciexamination_instrument', 'active');
		$this->dropColumn('ophciexamination_management_deferralreason', 'active');
		$this->dropColumn('ophciexamination_management_status', 'active');
		$this->dropColumn('ophciexamination_oct_method', 'active');

		$this->renameColumn('ophciexamination_visual_acuity_unit', 'active', 'tooltip');

		$this->renameColumn('ophciexamination_injectmanagecomplex_notreatmentreason', 'active', 'enabled');
		$this->renameColumn('ophciexamination_injectmanagecomplex_question', 'active', 'enabled');
		$this->renameColumn('ophciexamination_injectmanagecomplex_risk', 'active', 'enabled');
		$this->renameColumn('ophciexamination_lasermanagement_lasertype', 'active', 'enabled');
		$this->renameColumn('ophciexamination_oct_fluidtype', 'active', 'enabled');
		$this->renameColumn('ophciexamination_oct_fluidstatus', 'active', 'enabled');
	}
}
