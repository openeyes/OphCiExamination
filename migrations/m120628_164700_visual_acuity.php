<?php

class m120628_164700_visual_acuity extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_visualacuity', 'left_initial_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_wearing_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_corrected_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'left_comments', 'text');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_initial_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_wearing_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_corrected_id', 'int(10)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_method', 'varchar(40)');
		$this->addColumn('et_ophciexamination_visualacuity', 'right_comments', 'text');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_initial_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_wearing_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_corrected_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_method');
		$this->dropColumn('et_ophciexamination_visualacuity', 'left_comments');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_initial_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_wearing_id');
		$this->dropColumn('et_ophciexamination_visualacuity', 'right_corrected_id');
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