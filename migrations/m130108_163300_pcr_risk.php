<?php

class m130108_163300_pcr_risk extends OEMigration {
	
	public function up() {
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_pcr_risk', 'decimal(5,2)');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_pcr_risk', 'decimal(5,2)');
		$this->createTable('ophciexamination_anteriorsegment_surgeon',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(128) COLLATE utf8_bin DEFAULT NULL',
				'display_order' => 'tinyint(3) unsigned DEFAULT \'0\'',
				'risk' => 'decimal(3,2)',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'KEY `ophciexamination_anteriorsegment_surgeon_lmui_fk` (`last_modified_user_id`)',
				'KEY `ophciexamination_anteriorsegment_surgeon_cui_fk` (`created_user_id`)',
				'CONSTRAINT `ophciexamination_anteriorsegment_surgeon_lmui_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_anteriorsegment_surgeon_cui_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)'
			), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin'
		);
		$this->initialiseData(dirname(__FILE__));
		$this->addColumn('et_ophciexamination_anteriorsegment', 'left_surgeon_id', 'int(10) unsigned NOT NULL DEFAULT 1');
		$this->addColumn('et_ophciexamination_anteriorsegment', 'right_surgeon_id', 'int(10) unsigned NOT NULL DEFAULT 1');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_lsid_fk', 'et_ophciexamination_anteriorsegment', 'left_surgeon_id', 'ophciexamination_anteriorsegment_surgeon', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rsid_fk', 'et_ophciexamination_anteriorsegment', 'right_surgeon_id', 'ophciexamination_anteriorsegment_surgeon', 'id');
	}

	public function down() {
		$this->dropForeignKey('et_ophciexamination_anteriorsegment_rsid_fk', 'et_ophciexamination_anteriorsegment');
		$this->dropForeignKey('et_ophciexamination_anteriorsegment_lsid_fk', 'et_ophciexamination_anteriorsegment');
		$this->dropTable('ophciexamination_anteriorsegment_surgeon');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_pcr_risk');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_pcr_risk');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'left_surgeon_id');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'right_surgeon_id');
	}
}
