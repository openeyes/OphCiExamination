<?php

class m140115_130847_abstraction_of_dr_grading_dropdowns_version extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_drgrading_clinicalmaculopathy_version','code','varchar(2) NOT NULL');
		$this->addColumn('ophciexamination_drgrading_clinicalretinopathy_version','code','varchar(2) NOT NULL');
		$this->addColumn('ophciexamination_drgrading_nscmaculopathy_version','code','varchar(2) NOT NULL');
		$this->addColumn('ophciexamination_drgrading_nscretinopathy_version','code','varchar(2) NOT NULL');

		$this->createIndex('ophciexamination_drgrading_clinicalmaculopathy_version_code','ophciexamination_drgrading_clinicalmaculopathy_version','code',true);
		$this->createIndex('ophciexamination_drgrading_clinicalretinopathy_version_code','ophciexamination_drgrading_clinicalretinopathy_version','code',true);
		$this->createIndex('ophciexamination_drgrading_nscmaculopathy_version_code','ophciexamination_drgrading_nscmaculopathy_version','code',true);
		$this->createIndex('ophciexamination_drgrading_nscretinopathy_version_code','ophciexamination_drgrading_nscretinopathy_version','code',true);
	}

	public function down()
	{
		$this->dropColumn('ophciexamination_drgrading_nscretinopathy_version','code');
		$this->dropColumn('ophciexamination_drgrading_nscmaculopathy_version','code');
		$this->dropColumn('ophciexamination_drgrading_clinicalretinopathy_version','code');
		$this->dropColumn('ophciexamination_drgrading_clinicalmaculopathy_version','code');
	}
}
