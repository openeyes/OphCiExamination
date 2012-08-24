<?php

class m120823_144728_put_visualacuity_wearing_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_visualacuity_wearing',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(32) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_visualacuity_wearing_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_visualacuity_wearing_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_visualacuity_wearing_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visualacuity_wearing_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>1),"left_wearing='Unaided'");
		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>2),"left_wearing='Glasses'");
		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>3),"left_wearing='Contact lens'");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>1),"right_wearing='Unaided'");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>2),"right_wearing='Glasses'");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>3),"right_wearing='Contact lens'");

		$this->renameColumn('et_ophciexamination_visualacuity','left_wearing','left_wearing_id');
		$this->alterColumn('et_ophciexamination_visualacuity','left_wearing_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_visualacuity_lcri_fk','et_ophciexamination_visualacuity','left_wearing_id');
		$this->addForeignKey('et_ophciexamination_visualacuity_lcri_fk','et_ophciexamination_visualacuity','left_wearing_id','ophciexamination_visualacuity_wearing','id');
		$this->renameColumn('et_ophciexamination_visualacuity','right_wearing','right_wearing_id');
		$this->alterColumn('et_ophciexamination_visualacuity','right_wearing_id','int(10) unsigned NOT NULL');
		$this->createIndex('et_ophciexamination_visualacuity_rcri_fk','et_ophciexamination_visualacuity','right_wearing_id');
		$this->addForeignKey('et_ophciexamination_visualacuity_rcri_fk','et_ophciexamination_visualacuity','right_wearing_id','ophciexamination_visualacuity_wearing','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_visualacuity_rcri_fk','et_ophciexamination_visualacuity');
		$this->dropIndex('et_ophciexamination_visualacuity_rcri_fk','et_ophciexamination_visualacuity');
		$this->alterColumn('et_ophciexamination_visualacuity','right_wearing_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_visualacuity','right_wearing_id','right_wearing');
		$this->dropForeignKey('et_ophciexamination_visualacuity_lcri_fk','et_ophciexamination_visualacuity');
		$this->dropIndex('et_ophciexamination_visualacuity_lcri_fk','et_ophciexamination_visualacuity');
		$this->alterColumn('et_ophciexamination_visualacuity','left_wearing_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_visualacuity','left_wearing_id','left_wearing');

		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>'Unaided'),"left_wearing=1");
		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>'Glasses'),"left_wearing=2");
		$this->update('et_ophciexamination_visualacuity',array('left_wearing'=>'Contact lens'),"left_wearing=3");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>'Unaided'),"right_wearing=1");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>'Glasses'),"right_wearing=2");
		$this->update('et_ophciexamination_visualacuity',array('right_wearing'=>'Contact lens'),"right_wearing=3");

		$this->dropTable('ophciexamination_visualacuity_wearing');
	}
}
