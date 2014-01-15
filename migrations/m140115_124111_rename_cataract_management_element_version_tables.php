<?php

class m140115_124111_rename_cataract_management_element_version_tables extends CDbMigration
{
	public function up()
	{
		$this->renameTable('et_ophciexamination_cataractmanagement_version','et_ophciexamination_cataractsurgicalmanagement_version');
		$this->renameTable('ophciexamination_cataractmanagement_eye_version','ophciexamination_cataractsurgicalmanagement_eye_version');
		$this->renameTable('ophciexamination_cataractsurgicalmanagement_suitable_for_surgeon','ophciexamination_cataractsurgicalmanagement_sfsurgeon');
		$this->renameTable('ophciexamination_cataractmanagement_suitable_for_surgeon_version','ophciexamination_cataractsurgicalmanagement_sfsurgeon_version');
	}

	public function down()
	{
		$this->renameTable('ophciexamination_cataractsurgicalmanagement_sfsurgeon_version','ophciexamination_cataractmanagement_suitable_for_surgeon_version');
		$this->renameTable('ophciexamination_cataractsurgicalmanagement_sfsurgeon','ophciexamination_cataractsurgicalmanagement_suitable_for_surgeon');
		$this->renameTable('ophciexamination_cataractsurgicalmanagement_eye_version','ophciexamination_cataractmanagement_eye_version');
		$this->renameTable('et_ophciexamination_cataractsurgicalmanagement_version','et_ophciexamination_cataractmanagement_version');
	}
}
