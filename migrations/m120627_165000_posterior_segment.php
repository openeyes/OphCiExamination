<?php

class m120627_165000_posterior_segment extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'left_cd_ratio', 'varchar(40)');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_description', 'text');
		$this->addColumn('et_ophciexamination_posteriorsegment', 'right_cd_ratio', 'varchar(40)');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'right_cd_ratio');
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'right_description');
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'right_eyedraw');
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'left_cd_ratio');
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'left_description');
		$this->dropColumn('et_ophciexamination_posteriorsegment', 'left_eyedraw');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}