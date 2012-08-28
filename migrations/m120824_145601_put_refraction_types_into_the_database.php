<?php

class m120824_145601_put_refraction_types_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_refraction_type',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(32) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_refraction_type_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_refraction_type_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_refraction_type_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_refraction_type_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->update('et_ophciexamination_refraction',array('left_type'=>1),"left_type='Auto-refraction'");
		$this->update('et_ophciexamination_refraction',array('left_type'=>2),"left_type='Ophthalmologist'");
		$this->update('et_ophciexamination_refraction',array('left_type'=>3),"left_type='Optometrist'");
		$this->update('et_ophciexamination_refraction',array('left_type'=>4),"left_type='Other'");
		$this->update('et_ophciexamination_refraction',array('right_type'=>1),"right_type='Auto-refraction'");
		$this->update('et_ophciexamination_refraction',array('right_type'=>2),"right_type='Ophthalmologist'");
		$this->update('et_ophciexamination_refraction',array('right_type'=>3),"right_type='Optometrist'");
		$this->update('et_ophciexamination_refraction',array('right_type'=>4),"right_type='Other'");

		$this->renameColumn('et_ophciexamination_refraction','left_type','left_type_id');
		$this->alterColumn('et_ophciexamination_refraction','left_type_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_refraction_lti_fk','et_ophciexamination_refraction','left_type_id');
		$this->addForeignKey('et_ophciexamination_refraction_lti_fk','et_ophciexamination_refraction','left_type_id','ophciexamination_refraction_type','id');
		$this->renameColumn('et_ophciexamination_refraction','right_type','right_type_id');
		$this->alterColumn('et_ophciexamination_refraction','right_type_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_refraction_rti_fk','et_ophciexamination_refraction','right_type_id');
		$this->addForeignKey('et_ophciexamination_refraction_rti_fk','et_ophciexamination_refraction','right_type_id','ophciexamination_refraction_type','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_refraction_rti_fk','et_ophciexamination_refraction');
		$this->dropIndex('et_ophciexamination_refraction_rti_fk','et_ophciexamination_refraction');
		$this->alterColumn('et_ophciexamination_refraction','right_type_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_refraction','right_type_id','right_type');
		$this->dropForeignKey('et_ophciexamination_refraction_lti_fk','et_ophciexamination_refraction');
		$this->dropIndex('et_ophciexamination_refraction_lti_fk','et_ophciexamination_refraction');
		$this->alterColumn('et_ophciexamination_refraction','left_type_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_refraction','left_type_id','left_type');

		$this->update('et_ophciexamination_refraction',array('left_type'=>'Auto-refraction'),"left_type=1");
		$this->update('et_ophciexamination_refraction',array('left_type'=>'Ophthalmologist'),"left_type=2");
		$this->update('et_ophciexamination_refraction',array('left_type'=>'Optometrist'),"left_type=3");
		$this->update('et_ophciexamination_refraction',array('left_type'=>'Other'),"left_type=4");
		$this->update('et_ophciexamination_refraction',array('right_type'=>'Auto-refraction'),"right_type=1");
		$this->update('et_ophciexamination_refraction',array('right_type'=>'Ophthalmologist'),"right_type=2");
		$this->update('et_ophciexamination_refraction',array('right_type'=>'Optometristlens'),"right_type=3");
		$this->update('et_ophciexamination_refraction',array('right_type'=>'Other'),"right_type=4");

		$this->dropTable('ophciexamination_refraction_type');
	}
}
