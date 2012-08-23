<?php

class m120823_103423_put_cataract_assessment_nuclear_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_cataractassessment_nuclear',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_cataractassessment_nuclear_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_cataractassessment_nuclear_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_nuclear_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_nuclear_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>1),"left_nuclear='None'");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>2),"left_nuclear='Mild'");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>3),"left_nuclear='Moderate'");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>4),"left_nuclear='Brunescent'");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>1),"right_nuclear='None'");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>2),"right_nuclear='Mild'");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>3),"right_nuclear='Moderate'");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>4),"right_nuclear='Brunescent'");

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->renameColumn('et_ophciexamination_cataractassessment','left_nuclear','left_nuclear_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_nuclear_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_lni_fk','et_ophciexamination_cataractassessment','left_nuclear_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_lni_fk','et_ophciexamination_cataractassessment','left_nuclear_id','ophciexamination_cataractassessment_nuclear','id');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_nuclear','right_nuclear_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_nuclear_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_rni_fk','et_ophciexamination_cataractassessment','right_nuclear_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_rni_fk','et_ophciexamination_cataractassessment','right_nuclear_id','ophciexamination_cataractassessment_nuclear','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rni_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rni_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_nuclear_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_nuclear_id','right_nuclear');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lni_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lni_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_nuclear_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','left_nuclear_id','left_nuclear');

		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>'None'),"left_nuclear=1");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>'Mild'),"left_nuclear=2");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>'Moderate'),"left_nuclear=3");
		$this->update('et_ophciexamination_cataractassessment',array('left_nuclear'=>'Brunescent'),"left_nuclear=4");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>'None'),"right_nuclear=1");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>'Mild'),"right_nuclear=2");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>'Moderate'),"right_nuclear=3");
		$this->update('et_ophciexamination_cataractassessment',array('right_nuclear'=>'Brunescent'),"right_nuclear=4");

		$this->dropTable('ophciexamination_cataractassessment_nuclear');
	}
}
