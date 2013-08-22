<?php

class m121211_115300_new_opticdisc_fields extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_opticdisc_cd_ratio', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_opticdisc_cd_ratio_c_u_id_fk` (`created_user_id`)',
				'KEY `ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` (`last_modified_user_id`)',
				'CONSTRAINT `ophciexamination_opticdisc_cd_ratio_c_u_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_opticdisc_cd_ratio_l_m_u_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		$default_ratio_id = 1;
		$this->addColumn('et_ophciexamination_opticdisc', 'left_cd_ratio_id', 'int(10) unsigned NOT NULL DEFAULT '.$default_ratio_id);
		$this->addColumn('et_ophciexamination_opticdisc', 'right_cd_ratio_id', 'int(10) unsigned NOT NULL DEFAULT '.$default_ratio_id);
		$this->addForeignKey('et_ophciexamination_opticdisc_left_cd_ratio_id_fk', 'et_ophciexamination_opticdisc', 'left_cd_ratio_id', 'ophciexamination_opticdisc_cd_ratio', 'id');
		$this->addForeignKey('et_ophciexamination_opticdisc_right_cd_ratio_id_fk', 'et_ophciexamination_opticdisc', 'right_cd_ratio_id', 'ophciexamination_opticdisc_cd_ratio', 'id');

		$this->renameColumn('et_ophciexamination_opticdisc', 'left_size', 'left_diameter');
		$this->renameColumn('et_ophciexamination_opticdisc', 'right_size', 'right_diameter');
	}

	public function down()
	{
		$this->renameColumn('et_ophciexamination_opticdisc', 'left_diameter', 'left_size');
		$this->renameColumn('et_ophciexamination_opticdisc', 'right_diameter', 'right_size');

		$this->dropForeignKey('et_ophciexamination_opticdisc_left_cd_ratio_id_fk', 'et_ophciexamination_opticdisc');
		$this->dropForeignKey('et_ophciexamination_opticdisc_right_cd_ratio_id_fk', 'et_ophciexamination_opticdisc');
		$this->dropColumn('et_ophciexamination_opticdisc', 'left_cd_ratio_id');
		$this->dropColumn('et_ophciexamination_opticdisc', 'right_cd_ratio_id');
		$this->dropTable('ophciexamination_opticdisc_cd_ratio');
	}

}
