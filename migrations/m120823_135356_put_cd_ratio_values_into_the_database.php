<?php

class m120823_135356_put_cd_ratio_values_into_the_database extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_posteriorsegment_cd_ratio',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(3) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_posteriorsegment_cd_ratio_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_posteriorsegment_cd_ratio_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_posteriorsegment_cd_ratio_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_posteriorsegment_cd_ratio_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);

		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);

		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>2),"left_cd_ratio = '0.9'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>3),"left_cd_ratio = '0.8'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>4),"left_cd_ratio = '0.7'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>5),"left_cd_ratio = '0.6'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>6),"left_cd_ratio = '0.5'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>7),"left_cd_ratio = '0.4'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>8),"left_cd_ratio = '0.3'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>9),"left_cd_ratio = '0.2'");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>10),"left_cd_ratio = '0.1'");

		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>2),"right_cd_ratio = '0.9'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>3),"right_cd_ratio = '0.8'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>4),"right_cd_ratio = '0.7'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>5),"right_cd_ratio = '0.6'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>6),"right_cd_ratio = '0.5'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>7),"right_cd_ratio = '0.4'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>8),"right_cd_ratio = '0.3'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>9),"right_cd_ratio = '0.2'");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>10),"right_cd_ratio = '0.1'");

		$this->renameColumn('et_ophciexamination_posteriorsegment','left_cd_ratio','left_cd_ratio_id');
		$this->alterColumn('et_ophciexamination_posteriorsegment','left_cd_ratio_id','int(10) unsigned NOT NULL DEFAULT 5');
		$this->createIndex('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment','left_cd_ratio_id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment','left_cd_ratio_id','ophciexamination_posteriorsegment_cd_ratio','id');
		$this->renameColumn('et_ophciexamination_posteriorsegment','right_cd_ratio','right_cd_ratio_id');
		$this->alterColumn('et_ophciexamination_posteriorsegment','right_cd_ratio_id','int(10) unsigned NOT NULL DEFAULT 5');
		$this->createIndex('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment','right_cd_ratio_id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment','right_cd_ratio_id','ophciexamination_posteriorsegment_cd_ratio','id');
	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment');
		$this->alterColumn('et_ophciexamination_posteriorsegment','right_cd_ratio_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_posteriorsegment','right_cd_ratio_id','right_cd_ratio');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment');
		$this->alterColumn('et_ophciexamination_posteriorsegment','left_cd_ratio_id','varchar(40) COLLATE utf8_bin DEFAULT NULL');
		$this->renameColumn('et_ophciexamination_posteriorsegment','left_cd_ratio_id','left_cd_ratio');

		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.9'),"left_cd_ratio = 2");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.8'),"left_cd_ratio = 3");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.7'),"left_cd_ratio = 4");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.6'),"left_cd_ratio = 5");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.5'),"left_cd_ratio = 6");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.4'),"left_cd_ratio = 7");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.3'),"left_cd_ratio = 8");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.2'),"left_cd_ratio = 9");
		$this->update('et_ophciexamination_posteriorsegment',array('left_cd_ratio'=>'0.1'),"left_cd_ratio = 10");

		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.9'),"right_cd_ratio = 2");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.8'),"right_cd_ratio = 3");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.7'),"right_cd_ratio = 4");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.6'),"right_cd_ratio = 5");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.5'),"right_cd_ratio = 6");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.4'),"right_cd_ratio = 7");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.3'),"right_cd_ratio = 8");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.2'),"right_cd_ratio = 9");
		$this->update('et_ophciexamination_posteriorsegment',array('right_cd_ratio'=>'0.1'),"right_cd_ratio = 10");

		$this->dropTable('ophciexamination_posteriorsegment_cd_ratio');
	}
}
