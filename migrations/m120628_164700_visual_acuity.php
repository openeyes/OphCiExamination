<?php

class m120628_164700_visual_acuity extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_visualacuity', 'left_initial', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_wearing', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_corrected', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_initial', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_wearing', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_corrected', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_comments', 'text');
		$this->createTable('ophciexamination_visual_acuity_unit',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'name' => 'varchar(40) NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->createTable('ophciexamination_visual_acuity_unit_value',array(
				'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT',
				'unit_id' => 'int(10) unsigned NOT NULL',
				'value' => 'varchar(255) NOT NULL',
				'base_value' => 'int(10) unsigned NOT NULL',
				'last_modified_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'last_modified_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'created_user_id' => 'int(10) unsigned NOT NULL DEFAULT \'1\'',
				'created_date' => 'datetime NOT NULL DEFAULT \'1900-01-01 00:00:00\'',
				'PRIMARY KEY (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `ophciexamination_visual_acuity_unit` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_lmuid_fk` FOREIGN KEY (`last_modified_user_id`) REFERENCES `user` (`id`)',
				'CONSTRAINT `ophciexamination_visual_acuity_unit_value_cuid_fk` FOREIGN KEY (`created_user_id`) REFERENCES `user` (`id`)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin');
		$this->initialiseData();
	}

	/**
	 * Initialise tables with default data
	 * Filenames must to be in the format "nn_tablename.csv", where nn is the processing order
	 */
	protected function initialiseData() {
		$data_path = dirname(__FILE__).'/data/';
		foreach(glob($data_path."*.csv") as $file_path) {
			$table = substr(substr(basename($file_path), 0, -4), 3);
			echo "Importing $table data...";
			$fh = fopen($file_path, 'r');
			$columns = fgetcsv($fh);
			$row_count = 0;
			$values = array();
			while(($record = fgetcsv($fh)) !== false) {
				$row_count++;
				$data = array_combine($columns, $record);
				$this->insert($table, $data);
			}
			fclose($fh);
			echo "$row_count records, done.\n";
		}
	}

	public function down() {
		$this->dropTable('ophciexamination_visual_acuity_unit_value');
		$this->dropTable('ophciexamination_visual_acuity_unit');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_initial');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_wearing');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_corrected');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_method');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_comments');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_initial');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_wearing');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_corrected');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_method');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_comments');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}