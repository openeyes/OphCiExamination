<?php

class m120823_141902_put_visualacuity_method_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_visualacuity_method',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(32) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_visualacuity_method_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_visualacuity_method_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_visualacuity_method_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_method_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->update('et_ophciexamination_visualacuity',array('left_method'=>1),"left_method='Pinhole'");
		$this->update('et_ophciexamination_visualacuity',array('left_method'=>2),"left_method='Refraction'");
		$this->update('et_ophciexamination_visualacuity',array('right_method'=>1),"right_method='Pinhole'");
		$this->update('et_ophciexamination_visualacuity',array('right_method'=>2),"right_method='Refraction'");

		$this->renameColumn('et_ophciexamination_visualacuity','left_method','left_method_id');
		$this->alterColumn('et_ophciexamination_visualacuity','left_method_id','int(10) unsigned NOT NULL DEFAULT 5');
		$this->createIndex('et_ophciexamination_visualacuity_lmi_fk','et_ophciexamination_visualacuity','left_method_id');
		$this->addForeignKey('et_ophciexamination_visualacuity_lmi_fk','et_ophciexamination_visualacuity','left_method_id','ophciexamination_visualacuity_method','id');
		$this->renameColumn('et_ophciexamination_visualacuity','right_method','right_method_id');
		$this->alterColumn('et_ophciexamination_visualacuity','right_method_id','int(10) unsigned NOT NULL DEFAULT 5');
		$this->createIndex('et_ophciexamination_visualacuity_rmi_fk','et_ophciexamination_visualacuity','right_method_id');
		$this->addForeignKey('et_ophciexamination_visualacuity_rmi_fk','et_ophciexamination_visualacuity','right_method_id','ophciexamination_visualacuity_method','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_visualacuity_rmi_fk','et_ophciexamination_visualacuity');
		$this->dropIndex('et_ophciexamination_visualacuity_rmi_fk','et_ophciexamination_visualacuity');
		$this->alterColumn('et_ophciexamination_visualacuity','right_method_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_visualacuity','right_method_id','right_method');
		$this->dropForeignKey('et_ophciexamination_visualacuity_lmi_fk','et_ophciexamination_visualacuity');
		$this->dropIndex('et_ophciexamination_visualacuity_lmi_fk','et_ophciexamination_visualacuity');
		$this->alterColumn('et_ophciexamination_visualacuity','left_method_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_visualacuity','left_method_id','left_method');

		$this->update('et_ophciexamination_visualacuity',array('left_method'=>'Pinhole'),"left_method=1");
		$this->update('et_ophciexamination_visualacuity',array('left_method'=>'Refraction'),"left_method=2");
		$this->update('et_ophciexamination_visualacuity',array('right_method'=>'Pinhole'),"right_method=1");
		$this->update('et_ophciexamination_visualacuity',array('right_method'=>'Refraction'),"right_method=2");

		$this->dropTable('ophciexamination_visualacuity_method');
	}
}
