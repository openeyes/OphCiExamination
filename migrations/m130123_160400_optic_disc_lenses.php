<?php

class m130123_160400_optic_disc_lenses extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_opticdisc_lens', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255)NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'PRIMARY KEY (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->initialiseData(dirname(__FILE__));
		$this->addColumn('et_ophciexamination_opticdisc', 'left_lens_id', 'int(10) unsigned');
		$this->addColumn('et_ophciexamination_opticdisc', 'right_lens_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_opticdisc_lli', 'et_ophciexamination_opticdisc', 'left_lens_id', 'ophciexamination_opticdisc_lens', 'id');
		$this->addForeignKey('et_ophciexamination_opticdisc_rli', 'et_ophciexamination_opticdisc', 'right_lens_id', 'ophciexamination_opticdisc_lens', 'id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_opticdisc_lli', 'et_ophciexamination_opticdisc');
		$this->dropForeignKey('et_ophciexamination_opticdisc_rli', 'et_ophciexamination_opticdisc');
		$this->dropColumn('et_ophciexamination_opticdisc', 'left_lens_id');
		$this->dropColumn('et_ophciexamination_opticdisc', 'right_lens_id');
		$this->dropTable('ophciexamination_opticdisc_lens');
	}

}
