<?php

class m131003_134310_add_clinical_maculopathy_drgrading extends CDbMigration
{
	public function up()
	{
		$this->renameTable('ophciexamination_drgrading_clinical', 'ophciexamination_drgrading_clinicalretinopathy');
		$this->dropForeignKey('et_ophciexamination_drgrading_l_clinical_fk', 'et_ophciexamination_drgrading');
		$this->renameColumn('et_ophciexamination_drgrading', 'left_clinical_id', 'left_clinicalret_id');
		$this->addForeignKey('et_ophciexamination_drgrading_l_clinret_fk', 'et_ophciexamination_drgrading', 'left_clinicalret_id', 'ophciexamination_drgrading_clinicalretinopathy', 'id');
		$this->dropForeignKey('et_ophciexamination_drgrading_r_clinical_fk', 'et_ophciexamination_drgrading');
		$this->renameColumn('et_ophciexamination_drgrading', 'right_clinical_id', 'right_clinicalret_id');
		$this->addForeignKey('et_ophciexamination_drgrading_r_clinret_fk', 'et_ophciexamination_drgrading', 'right_clinicalret_id', 'ophciexamination_drgrading_clinicalretinopathy', 'id');

		$this->createTable('ophciexamination_drgrading_clinicalmaculopathy', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin NOT NULL',
				'description' => 'text',
				'display_order' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'class' => 'varchar(16) NOT NULL',
				'booking_weeks' => 'int(2) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_drgrading_clinicalm_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_drgrading_clinicalm_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_drgrading_clinicalm_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_drgrading_clinicalm_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
			), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->insert('ophciexamination_drgrading_clinicalmaculopathy', array('name'=>'No macular oedema', 'display_order' => '1', 'class' => 'none'));
		$this->insert('ophciexamination_drgrading_clinicalmaculopathy', array('name'=>'Diabetic macular oedema not clinically significant', 'display_order' => '2', 'class' => 'mild'));
		$this->insert('ophciexamination_drgrading_clinicalmaculopathy', array('name'=>'Clinically significant macular oedema', 'display_order' => '3', 'class' => 'moderate'));
		$this->insert('ophciexamination_drgrading_clinicalmaculopathy', array('name'=>'Centre involving diabetic macular oedema', 'display_order' => '4', 'class' => 'severe'));

		$this->addColumn('et_ophciexamination_drgrading', 'left_clinicalmac_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_drgrading_l_clinmac_fk', 'et_ophciexamination_drgrading', 'left_clinicalmac_id', 'ophciexamination_drgrading_clinicalmaculopathy', 'id');
		$this->addColumn('et_ophciexamination_drgrading', 'right_clinicalmac_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_drgrading_r_clinmac_fk', 'et_ophciexamination_drgrading', 'right_clinicalmac_id', 'ophciexamination_drgrading_clinicalmaculopathy', 'id');
	}

	public function down()
	{

		$this->dropForeignKey('et_ophciexamination_drgrading_r_clinmac_fk', 'et_ophciexamination_drgrading');
		$this->dropColumn('et_ophciexamination_drgrading', 'right_clinicalmac_id');
		$this->dropForeignKey('et_ophciexamination_drgrading_l_clinmac_fk', 'et_ophciexamination_drgrading');
		$this->dropColumn('et_ophciexamination_drgrading', 'left_clinicalmac_id');

		$this->dropTable('ophciexamination_drgrading_clinicalmaculopathy');
		$this->dropForeignKey('et_ophciexamination_drgrading_r_clinret_fk', 'et_ophciexamination_drgrading');
		$this->renameColumn('et_ophciexamination_drgrading', 'right_clinicalret_id', 'right_clinical_id');
		$this->dropForeignKey('et_ophciexamination_drgrading_l_clinret_fk', 'et_ophciexamination_drgrading');
		$this->renameColumn('et_ophciexamination_drgrading', 'left_clinicalret_id', 'left_clinical_id');
		$this->renameTable('ophciexamination_drgrading_clinicalretinopathy', 'ophciexamination_drgrading_clinical');
		$this->addForeignKey('et_ophciexamination_drgrading_r_clinical_fk', 'et_ophciexamination_drgrading', 'right_clinical_id', 'ophciexamination_drgrading_clinical', 'id');
		$this->addForeignKey('et_ophciexamination_drgrading_l_clinical_fk', 'et_ophciexamination_drgrading', 'left_clinical_id', 'ophciexamination_drgrading_clinical', 'id');
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