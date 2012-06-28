<?php

class m120628_153500_cataract_assessment extends CDbMigration {

	public function up() {
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_pupil', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_nuclear', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_cortical', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_pxe', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_phako', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_surgeon', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'left_description', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_eyedraw', 'text');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_pupil', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_nuclear', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_cortical', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_pxe', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_phako', 'tinyint(1)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_surgeon', 'varchar(40)');
		$this->addColumn('et_ophciexamination_cataractassessment', 'right_description', 'text');
	}

	public function down() {
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_eyedraw');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_pupil');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_nuclear');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_cortical');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_pxe');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_phako');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_surgeon');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'left_description');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_eyedraw');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_pupil');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_nuclear');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_cortical');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_pxe');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_phako');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_surgeon');
		$this->dropColumn('et_ophciexamination_cataractassessment', 'right_description');
	}

	public function safeUp() {
		$this->up();
	}

	public function safeDown() {
		$this->down();
	}

}