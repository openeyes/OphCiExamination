<?php

class m120823_113230_put_iop_reading_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_intraocularpressure_reading',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(3) COLLATE utf8_bin DEFAULT NULL',
				'value' => 'int(10) unsigned NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_intraocularpressure_reading_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_intraocularpressure_reading_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_intraocularpressure_reading_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_intraocularpressure_reading_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		Yii::app()->db->createCommand('update et_ophciexamination_intraocularpressure set left_reading = left_reading + 1')->query();
		Yii::app()->db->createCommand('update et_ophciexamination_intraocularpressure set right_reading = right_reading + 1')->query();

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->update('ophciexamination_intraocularpressure_reading',array('value'=>null),'id=1');

		$this->renameColumn('et_ophciexamination_intraocularpressure','left_reading','left_reading_id');
		$this->alterColumn('et_ophciexamination_intraocularpressure','left_reading_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure','left_reading_id');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure','left_reading_id','ophciexamination_intraocularpressure_reading','id');
		$this->renameColumn('et_ophciexamination_intraocularpressure','right_reading','right_reading_id');
		$this->alterColumn('et_ophciexamination_intraocularpressure','right_reading_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure','right_reading_id');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure','right_reading_id','ophciexamination_intraocularpressure_reading','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure');
		$this->dropIndex('et_ophciexamination_intraocularpressure_rri_fk','et_ophciexamination_intraocularpressure');
		$this->alterColumn('et_ophciexamination_intraocularpressure','right_reading_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_intraocularpressure','right_reading_id','right_reading');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure');
		$this->dropIndex('et_ophciexamination_intraocularpressure_lri_fk','et_ophciexamination_intraocularpressure');
		$this->alterColumn('et_ophciexamination_intraocularpressure','left_reading_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_intraocularpressure','left_reading_id','left_reading');

		Yii::app()->db->createCommand('update et_ophciexamination_intraocularpressure set left_reading = left_reading - 1')->query();
		Yii::app()->db->createCommand('update et_ophciexamination_intraocularpressure set right_reading = right_reading - 1')->query();
		Yii::app()->db->createCommand("update et_ophciexamination_intraocularpressure set left_reading = '' where left_reading = 0")->query();
		Yii::app()->db->createCommand("update et_ophciexamination_intraocularpressure set right_reading = '' where right_reading = 0")->query();

		$this->dropTable('ophciexamination_intraocularpressure_reading');
	}
}
