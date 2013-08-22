<?php

class m130405_132505_first_second_eye_in_cataract_management_element extends CDbMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_cataractmanagement_eye',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(64) COLLATE utf8_bin NOT NULL',
				'display_order' => 'tinyint(1) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_cataractmanagement_eye_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_cataractmanagement_eye_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_cataractmanagement_eye_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_cataractmanagement_eye_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
			),
			'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->insert('ophciexamination_cataractmanagement_eye',array('name'=>'First eye','display_order'=>1));
		$this->insert('ophciexamination_cataractmanagement_eye',array('name'=>'Second eye','display_order'=>2));

		$this->addColumn('et_ophciexamination_cataractmanagement','eye_id','int(10) unsigned NULL');
		$this->createIndex('et_ophciexamination_cataractmanagement_eye_id_fk','et_ophciexamination_cataractmanagement','eye_id');
		$this->addForeignKey('et_ophciexamination_cataractmanagement_eye_id_fk','et_ophciexamination_cataractmanagement','eye_id','ophciexamination_cataractmanagement_eye','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_cataractmanagement_eye_id_fk','et_ophciexamination_cataractmanagement');
		$this->dropIndex('et_ophciexamination_cataractmanagement_eye_id_fk','et_ophciexamination_cataractmanagement');
		$this->dropColumn('et_ophciexamination_cataractmanagement','eye_id');

		$this->dropTable('ophciexamination_cataractmanagement_eye');
	}
}
