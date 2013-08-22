<?php

class m130808_130328_missing_fields extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_glaucomarisk_risk','created_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_glaucomarisk_risk_cui_fk','ophciexamination_glaucomarisk_risk','created_user_id','user','id');
		$this->addColumn('ophciexamination_glaucomarisk_risk','last_modified_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_glaucomarisk_risk_lmui_fk','ophciexamination_glaucomarisk_risk','last_modified_user_id','user','id');
		$this->addColumn('ophciexamination_glaucomarisk_risk','created_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
		$this->addColumn('ophciexamination_glaucomarisk_risk','last_modified_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_oct_method','created_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_oct_method_cui_fk','ophciexamination_oct_method','created_user_id','user','id');
		$this->addColumn('ophciexamination_oct_method','last_modified_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_oct_method_lmui_fk','ophciexamination_oct_method','last_modified_user_id','user','id');
		$this->addColumn('ophciexamination_oct_method','created_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
		$this->addColumn('ophciexamination_oct_method','last_modified_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");

		$this->addColumn('ophciexamination_opticdisc_lens','created_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_opticdisc_lens_cui_fk','ophciexamination_opticdisc_lens','created_user_id','user','id');
		$this->addColumn('ophciexamination_opticdisc_lens','last_modified_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_opticdisc_lens_lmui_fk','ophciexamination_opticdisc_lens','last_modified_user_id','user','id');
		$this->addColumn('ophciexamination_opticdisc_lens','created_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
		$this->addColumn('ophciexamination_opticdisc_lens','last_modified_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_glaucomarisk_risk_cui_fk','ophciexamination_glaucomarisk_risk');
		$this->dropColumn('ophciexamination_glaucomarisk_risk','created_user_id');
		$this->dropForeignKey('ophciexamination_glaucomarisk_risk_lmui_fk','ophciexamination_glaucomarisk_risk');
		$this->dropColumn('ophciexamination_glaucomarisk_risk','last_modified_user_id');
		$this->dropColumn('ophciexamination_glaucomarisk_risk','created_date');
		$this->dropColumn('ophciexamination_glaucomarisk_risk','last_modified_date');

		$this->dropForeignKey('ophciexamination_oct_method_cui_fk','ophciexamination_oct_method');
		$this->dropColumn('ophciexamination_oct_method','created_user_id');
		$this->dropForeignKey('ophciexamination_oct_method_lmui_fk','ophciexamination_oct_method');
		$this->dropColumn('ophciexamination_oct_method','last_modified_user_id');
		$this->dropColumn('ophciexamination_oct_method','created_date');
		$this->dropColumn('ophciexamination_oct_method','last_modified_date');

		$this->dropForeignKey('ophciexamination_opticdisc_lens_cui_fk','ophciexamination_opticdisc_lens');
		$this->dropColumn('ophciexamination_opticdisc_lens','created_user_id');
		$this->dropForeignKey('ophciexamination_opticdisc_lens_lmui_fk','ophciexamination_opticdisc_lens');
		$this->dropColumn('ophciexamination_opticdisc_lens','last_modified_user_id');
		$this->dropColumn('ophciexamination_opticdisc_lens','created_date');
		$this->dropColumn('ophciexamination_opticdisc_lens','last_modified_date');
	}
}
