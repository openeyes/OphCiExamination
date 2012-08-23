<?php

class m120823_105425_put_cataract_assessment_cortical_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_cataractassessment_cortical',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_cataractassessment_cortical_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_cataractassessment_cortical_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_cortical_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_cataractassessment_cortical_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>1),"left_cortical='None'");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>2),"left_cortical='Mild'");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>3),"left_cortical='Moderate'");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>4),"left_cortical='White'");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>1),"right_cortical='None'");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>2),"right_cortical='Mild'");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>3),"right_cortical='Moderate'");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>4),"right_cortical='White'");

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->renameColumn('et_ophciexamination_cataractassessment','left_cortical','left_cortical_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_cortical_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_lci_fk','et_ophciexamination_cataractassessment','left_cortical_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_lci_fk','et_ophciexamination_cataractassessment','left_cortical_id','ophciexamination_cataractassessment_cortical','id');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_cortical','right_cortical_id');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_cortical_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_cataractassessment_rci_fk','et_ophciexamination_cataractassessment','right_cortical_id');
		$this->addForeignKey('et_ophciexamination_cataractassessment_rci_fk','et_ophciexamination_cataractassessment','right_cortical_id','ophciexamination_cataractassessment_cortical','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rci_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rci_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','right_cortical_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','right_cortical_id','right_cortical');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lci_fk','et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lci_fk','et_ophciexamination_cataractassessment');
		$this->alterColumn('et_ophciexamination_cataractassessment','left_cortical_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_cataractassessment','left_cortical_id','left_cortical');

		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>'None'),"left_cortical=1");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>'Mild'),"left_cortical=2");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>'Moderate'),"left_cortical=3");
		$this->update('et_ophciexamination_cataractassessment',array('left_cortical'=>'White'),"left_cortical=4");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>'None'),"right_cortical=1");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>'Mild'),"right_cortical=2");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>'Moderate'),"right_cortical=3");
		$this->update('et_ophciexamination_cataractassessment',array('right_cortical'=>'White'),"right_cortical=4");

		$this->dropTable('ophciexamination_cataractassessment_cortical');
	}
}
