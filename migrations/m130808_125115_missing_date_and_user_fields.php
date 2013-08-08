<?php

class m130808_125115_missing_date_and_user_fields extends CDbMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_anteriorsegment_cct_method','created_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_anteriorsegment_cct_method_cui_fk','ophciexamination_anteriorsegment_cct_method','created_user_id','user','id');
		$this->addColumn('ophciexamination_anteriorsegment_cct_method','last_modified_user_id','int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('ophciexamination_anteriorsegment_cct_method_lmui_fk','ophciexamination_anteriorsegment_cct_method','last_modified_user_id','user','id');
		$this->addColumn('ophciexamination_anteriorsegment_cct_method','created_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
		$this->addColumn('ophciexamination_anteriorsegment_cct_method','last_modified_date',"datetime NOT NULL DEFAULT '1900-01-01 00:00:00'");
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_anteriorsegment_cct_method_cui_fk','ophciexamination_anteriorsegment_cct_method');
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method','created_user_id');
		$this->dropForeignKey('ophciexamination_anteriorsegment_cct_method_lmui_fk','ophciexamination_anteriorsegment_cct_method');
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method','last_modified_user_id');
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method','created_date');
		$this->dropColumn('ophciexamination_anteriorsegment_cct_method','last_modified_date');
	}
}
