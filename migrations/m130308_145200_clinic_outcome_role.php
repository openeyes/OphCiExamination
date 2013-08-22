<?php

class m130308_145200_clinic_outcome_role extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_clinicoutcome_role', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 10',
				'requires_comment' => 'int(1) unsigned NOT NULL DEFAULT 0',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_clinicoutcome_role_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_clinicoutcome_role_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_role_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_role_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->addColumn('et_ophciexamination_clinicoutcome', 'role_id', 'int(10) unsigned');
		$this->addColumn('et_ophciexamination_clinicoutcome', 'role_comments', 'varchar(255)');
		$this->addForeignKey('et_ophciexamination_clinicoutcome_ri_fk', 'et_ophciexamination_clinicoutcome', 'role_id', 'ophciexamination_clinicoutcome_role', 'id');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_clinicoutcome_ri_fk', 'et_ophciexamination_clinicoutcome');
		$this->dropColumn('et_ophciexamination_clinicoutcome', 'role_id');
		$this->dropColumn('et_ophciexamination_clinicoutcome', 'role_comments');
		$this->dropTable('ophciexamination_clinicoutcome_role');
	}
}
