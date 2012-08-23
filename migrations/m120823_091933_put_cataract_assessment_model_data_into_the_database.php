<?php

class m120823_091933_put_cataract_assessment_model_data_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_cataractassessment_pupil',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_cataractassessment_pupil_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_cataractassessment_pupil_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_pupil_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_pupil_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>1),"left_pupil='Large'");
		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>2),"left_pupil='Medium'");
		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>3),"left_pupil='Small'");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>1),"right_pupil='Large'");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>2),"right_pupil='Medium'");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>3),"right_pupil='Small'");

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->renameColumn('et_ophciexamination_cataractassessment','left_pupil','left_pupil_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_pupil_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_lpi_fk','et_ophciexamination_cataractassessment','left_pupil_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_lpi_fk','et_ophciexamination_cataractassessment','left_pupil_id','ophciexamination_cataractassessment_pupil','id');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_pupil','right_pupil_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_pupil_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_rpi_fk','et_ophciexamination_cataractassessment','right_pupil_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_rpi_fk','et_ophciexamination_cataractassessment','right_pupil_id','ophciexamination_cataractassessment_pupil','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rpi_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rpi_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_pupil_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_pupil_id','right_pupil');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lpi_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lpi_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_pupil_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','left_pupil_id','left_pupil');

		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>'Large'),"left_pupil=1");
		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>'Medium'),"left_pupil=2");
		$this->update('et_ophciexamination_cataractassessment',array('left_pupil'=>'Small'),"left_pupil=3");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>'Large'),"right_pupil=1");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>'Medium'),"right_pupil=2");
		$this->update('et_ophciexamination_cataractassessment',array('right_pupil'=>'Small'),"right_pupil=3");

		$this->dropTable('ophciexamination_cataractassessment_pupil');
	}
}
