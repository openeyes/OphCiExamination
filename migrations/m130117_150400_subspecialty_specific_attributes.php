<?php

class m130117_150400_subspecialty_specific_attributes extends OEMigration
{
	public function up()
	{
		$this->addColumn('ophciexamination_attribute_option', 'subspecialty_id', 'int(10) unsigned default null');
		$this->addForeignKey('ophciexamination_attribute_option_ssi_fk', 'ophciexamination_attribute_option', 'subspecialty_id', 'subspecialty', 'id');
		$this->delete('ophciexamination_attribute_option');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_attribute_option_ssi_fk', 'ophciexamination_attribute_option');
		$this->dropColumn('ophciexamination_attribute_option', 'subspecialty_id');
	}

}
