<?php

class m120828_074417_put_refraction_integers_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_refraction_integer',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'value' => 'varchar(4) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_refraction_integer_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_refraction_integer_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_refraction_integer_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_refraction_integer_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
	}

	public function down()
	{
		$this->dropTable('ophciexamination_refraction_integer');
	}
}
