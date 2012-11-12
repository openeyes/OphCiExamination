<?php

class m121009_162400_anterior_segment extends OEMigration {

	public function up() {
		$both_eyes_id = Eye::model()->find("name = 'Both'")->id;
		$this->addColumn('et_ophciexamination_anteriorsegment', 'eye_id', "int(10) unsigned NOT NULL DEFAULT $both_eyes_id");
		$this->addForeignKey('et_ophciexamination_anteriorsegment_eye_id_fk', 'et_ophciexamination_anteriorsegment', 'eye_id', 'eye', 'id');
		$this->alterColumn('et_ophciexamination_anteriorsegment','left_pupil_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_anteriorsegment','right_pupil_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_anteriorsegment','left_nuclear_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_anteriorsegment','right_nuclear_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_anteriorsegment','left_cortical_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_anteriorsegment','right_cortical_id','int(10) unsigned');
	}

	public function down() {
		$this->dropForeignKey('et_ophciexamination_anteriorsegment_eye_id_fk', 'et_ophciexamination_anteriorsegment');
		$this->dropColumn('et_ophciexamination_anteriorsegment', 'eye_id');
	}

}
