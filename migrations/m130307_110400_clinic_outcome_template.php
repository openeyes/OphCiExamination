<?php

class m130307_110400_clinic_outcome_template extends OEMigration
{
	public function up()
	{
		$this->createTable('ophciexamination_clinicoutcome_template', array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'followup_quantity' => 'int(10) unsigned',
				'clinic_outcome_status_id' => 'int(10) unsigned NOT NULL',
				'followup_period_id' => 'int(10) unsigned',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT 1',
				'created_date' => 'datetime NOT NULL DEFAULT \'1901-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_clinicoutcome_template_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_clinicoutcome_template_cui_fk` (`created_user_id`)',
				'KEY `ophciexamination_clinicoutcome_template_cosi_fk` (`clinic_outcome_status_id`)',
				'KEY `ophciexamination_clinicoutcome_template_fpi_fk` (`followup_period_id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_template_lmui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_template_cui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_template_cosi_fk` FOREIGN KEY (`clinic_outcome_status_id`) REFERENCES `ophciexamination_clinicoutcome_status` (`id`)',
				'CONSTRAINT `ophciexamination_clinicoutcome_template_fpi_fk` FOREIGN KEY (`followup_period_id`) REFERENCES `period` (`id`)',
		), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->addColumn('ophciexamination_glaucomarisk_risk', 'clinicoutcome_template_id', 'int(10) unsigned');
		$this->addForeignKey('ophciexamination_glaucomarisk_risk_coti_fk', 'ophciexamination_glaucomarisk_risk', 'clinicoutcome_template_id', 'ophciexamination_clinicoutcome_template', 'id');
		$migrations_path = dirname(__FILE__);
		$this->initialiseData($migrations_path);
		$this->update('ophciexamination_glaucomarisk_risk', array('clinicoutcome_template_id' => new CDbExpression('id')));
		$this->alterColumn('ophciexamination_glaucomarisk_risk', 'clinicoutcome_template_id', 'int(10) unsigned NOT NULL');
	}

	public function down()
	{
		$this->dropForeignKey('ophciexamination_glaucomarisk_risk_coti_fk', 'ophciexamination_glaucomarisk_risk');
		$this->dropColumn('ophciexamination_glaucomarisk_risk', 'clinicoutcome_template_id');
		$this->dropTable('ophciexamination_clinicoutcome_template');
	}
}
