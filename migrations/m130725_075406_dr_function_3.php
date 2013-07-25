<?php

class m130725_075406_dr_function_3 extends CDbMigration
{
	public function up()
	{
		$this->update('ophciexamination_drgrading_nscmaculopathy', array('name' => 'M1A', 'display_order' => 3), 'name = :cname', array(':cname' => 'M1'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'M1S', 'display_order' => '2', 'class' =>'moderate', 'description' => 'Stable maculopathy needs no further treatment'));
		$this->insert('ophciexamination_drgrading_nscmaculopathy', array('name'=>'U', 'display_order' => '4', 'class' =>'ungradable', 'description' => 'Ungradable/unobtainable'));
		
		$this->createTable('ophciexamination_lasermanagement_lasertype', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'other' => 'boolean NOT NULL DEFAULT false',
				'enabled' => 'boolean NOT NULL DEFAULT true',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_lasermanagement_lasertype_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_lasermanagement_lasertype_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_lasermanagement_lasertype_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_lasermanagement_lasertype_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'Focal', 'display_order' => 1));
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'Grid', 'display_order' => 2));
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'Macular (focal/grid)', 'display_order' => 3));
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'PRP', 'display_order' => 4));
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'PRP & macular', 'display_order' => 5));
		$this->insert('ophciexamination_lasermanagement_lasertype', array('name' => 'Other', 'display_order' => 6, 'other' => true));
		
		$this->addColumn('et_ophciexamination_lasermanagement', 'eye_id', 'int(10) unsigned DEFAULT ' . Eye::BOTH);
		$this->addColumn('et_ophciexamination_lasermanagement', 'left_lasertype_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_lasermanagement_llt_fk', 'et_ophciexamination_lasermanagement', 'left_lasertype_id', 'ophciexamination_lasermanagement_lasertype', 'id');
		$this->addColumn('et_ophciexamination_lasermanagement', 'left_lasertype_other', 'varchar(128)');
		$this->addColumn('et_ophciexamination_lasermanagement', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_lasermanagement', 'right_lasertype_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_lasermanagement_rlt_fk', 'et_ophciexamination_lasermanagement', 'right_lasertype_id', 'ophciexamination_lasermanagement_lasertype', 'id');
		$this->addColumn('et_ophciexamination_lasermanagement', 'right_lasertype_other', 'varchar(128)');
		$this->addColumn('et_ophciexamination_lasermanagement', 'right_comments', 'text');
		
	}

	public function down()
	{
		$this->delete('ophciexamination_drgrading_nscmaculopathy', "name = 'M1S'");
		$this->delete('ophciexamination_drgrading_nscmaculopathy', "name = 'U'");
		$this->update('ophciexamination_drgrading_nscmaculopathy', array('name' => 'M1', 'display_order' => 2), 'name = :cname', array(':cname' => 'M1A'));
		
		$this->dropColumn('et_ophciexamination_lasermanagement', 'left_lasertype_id');
		$this->dropColumn('et_ophciexamination_lasermanagement', 'left_lasertype_other');
		$this->dropColumn('et_ophciexamination_lasermanagement', 'left_comments');
		$this->dropColumn('et_ophciexamination_lasermanagement', 'right_lasertype_id');
		$this->dropColumn('et_ophciexamination_lasermanagement', 'right_lasertype_other');
		$this->dropColumn('et_ophciexamination_lasermanagement', 'right_comments');
		
		$this->dropTable('ophciexamination_lasermanagement_lasertype');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}