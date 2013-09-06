<?php

class m130906_110037_eyedraw_config extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_eyedraw_config', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'event_id' => 'INT(10) UNSIGNED NOT NULL',
				'config' => 'TEXT NOT NULL',
				'subspeciality_id' => 'INT(11) UNSIGNED NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_eyedraw_config_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_eyedraw_config_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_eyedraw_config_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_eyedraw_config_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'INDEX `ophciexamination_event_id_fk` (`event_id`)',
				'INDEX `ophciexamination_subspeciality_id_fk` (`subspeciality_id`)',
				'CONSTRAINT `ophciexamination_subspeciality_id_fk` FOREIGN KEY (`subspeciality_id`) REFERENCES `service_subspecialty_assignment` (`subspecialty_id`)',
				'CONSTRAINT `ophciexamination_event_id_fk` FOREIGN KEY (`event_id`) REFERENCES `event_type` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
	}

	public function down()
	{
		$this->dropTable('ophciexamination_eyedraw_config');
	}

}