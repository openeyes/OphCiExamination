<?php

class m120626_164000_iop_instrument extends CDbMigration {

	public function up() {

		$this->createTable('ophciexamination_instrument',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(255) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_instrument_last_modified_user_id_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_instrument_created_user_id_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');

		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_instrument_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_li_fk', 'et_ophciexamination_intraocularpressure', 'left_instrument_id', 'ophciexamination_instrument', 'id');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'left_reading', 'varchar(45)');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_instrument_id', 'int(10) unsigned');
		$this->addForeignKey('et_ophciexamination_intraocularpressure_ri_fk', 'et_ophciexamination_intraocularpressure', 'right_instrument_id', 'ophciexamination_instrument', 'id');
		$this->addColumn('et_ophciexamination_intraocularpressure', 'right_reading', 'varchar(45)');
		
	}

	public function down() {
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_li_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropForeignKey('et_ophciexamination_intraocularpressure_ri_fk', 'et_ophciexamination_intraocularpressure');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_instrument_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_instrument_id');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'left_reading');
		$this->dropColumn('et_ophciexamination_intraocularpressure', 'right_reading');
		$this->dropTable('ophciexamination_instrument');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}