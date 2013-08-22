<?php

class m121009_141300_more_uat_changes extends OEMigration
{
	public function up()
	{
		// Allow null foreign keys
		$this->alterColumn('et_ophciexamination_posteriorsegment','left_cd_ratio_id','int(10) unsigned');
		$this->alterColumn('et_ophciexamination_posteriorsegment','right_cd_ratio_id','int(10) unsigned');

		// Rename cataract assessment
		$this->dropTable('et_ophciexamination_anteriorsegment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rci_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lci_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lni_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_lpi_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rni_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_rpi_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_c_u_id_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_e_id_fk', 'et_ophciexamination_cataractassessment');
		$this->dropForeignKey('et_ophciexamination_cataractassessment_l_m_u_id_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rci_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lci_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lni_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_lpi_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rni_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_rpi_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_c_u_id_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_e_id_fk', 'et_ophciexamination_cataractassessment');
		$this->dropIndex('et_ophciexamination_cataractassessment_l_m_u_id_fk', 'et_ophciexamination_cataractassessment');
		$this->renameTable('et_ophciexamination_cataractassessment', 'et_ophciexamination_anteriorsegment');

		$this->dropForeignKey('ophciexamination_cataractassessment_cortical_lmui_fk', 'ophciexamination_cataractassessment_cortical');
		$this->dropForeignKey('ophciexamination_cataractassessment_cortical_cui_fk', 'ophciexamination_cataractassessment_cortical');
		$this->dropIndex('ophciexamination_cataractassessment_cortical_lmui_fk', 'ophciexamination_cataractassessment_cortical');
		$this->dropIndex('ophciexamination_cataractassessment_cortical_cui_fk', 'ophciexamination_cataractassessment_cortical');
		$this->renameTable('ophciexamination_cataractassessment_cortical', 'ophciexamination_anteriorsegment_cortical');
		$this->addForeignKey('ophciexamination_anteriorsegment_cortical_lmui_fk', 'ophciexamination_anteriorsegment_cortical', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('ophciexamination_anteriorsegment_cortical_cui_fk', 'ophciexamination_anteriorsegment_cortical', 'created_user_id', 'user', 'id');

		$this->dropForeignKey('ophciexamination_cataractassessment_nuclear_lmui_fk', 'ophciexamination_cataractassessment_nuclear');
		$this->dropForeignKey('ophciexamination_cataractassessment_nuclear_cui_fk', 'ophciexamination_cataractassessment_nuclear');
		$this->dropIndex('ophciexamination_cataractassessment_nuclear_lmui_fk', 'ophciexamination_cataractassessment_nuclear');
		$this->dropIndex('ophciexamination_cataractassessment_nuclear_cui_fk', 'ophciexamination_cataractassessment_nuclear');
		$this->renameTable('ophciexamination_cataractassessment_nuclear', 'ophciexamination_anteriorsegment_nuclear');
		$this->addForeignKey('ophciexamination_anteriorsegment_nuclear_lmui_fk', 'ophciexamination_anteriorsegment_nuclear', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('ophciexamination_anteriorsegment_nuclear_cui_fk', 'ophciexamination_anteriorsegment_nuclear', 'created_user_id', 'user', 'id');

		$this->dropForeignKey('ophciexamination_cataractassessment_pupil_lmui_fk', 'ophciexamination_cataractassessment_pupil');
		$this->dropForeignKey('ophciexamination_cataractassessment_pupil_cui_fk', 'ophciexamination_cataractassessment_pupil');
		$this->dropIndex('ophciexamination_cataractassessment_pupil_lmui_fk', 'ophciexamination_cataractassessment_pupil');
		$this->dropIndex('ophciexamination_cataractassessment_pupil_cui_fk', 'ophciexamination_cataractassessment_pupil');
		$this->renameTable('ophciexamination_cataractassessment_pupil', 'ophciexamination_anteriorsegment_pupil');
		$this->addForeignKey('ophciexamination_anteriorsegment_pupil_lmui_fk', 'ophciexamination_anteriorsegment_pupil', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('ophciexamination_anteriorsegment_pupil_cui_fk', 'ophciexamination_anteriorsegment_pupil', 'created_user_id', 'user', 'id');

		$this->addForeignKey('et_ophciexamination_anteriorsegment_cui_fk', 'et_ophciexamination_anteriorsegment', 'created_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_lmui_fk', 'et_ophciexamination_anteriorsegment', 'last_modified_user_id', 'user', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_ei_fk', 'et_ophciexamination_anteriorsegment', 'event_id', 'event', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rni_fk', 'et_ophciexamination_anteriorsegment', 'right_nuclear_id', 'ophciexamination_anteriorsegment_nuclear', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_lni_fk', 'et_ophciexamination_anteriorsegment', 'left_nuclear_id', 'ophciexamination_anteriorsegment_nuclear', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rpi_fk', 'et_ophciexamination_anteriorsegment', 'right_pupil_id', 'ophciexamination_anteriorsegment_pupil', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_lpi_fk', 'et_ophciexamination_anteriorsegment', 'left_pupil_id', 'ophciexamination_anteriorsegment_pupil', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_rci_fk', 'et_ophciexamination_anteriorsegment', 'right_cortical_id', 'ophciexamination_anteriorsegment_cortical', 'id');
		$this->addForeignKey('et_ophciexamination_anteriorsegment_lci_fk', 'et_ophciexamination_anteriorsegment', 'left_cortical_id', 'ophciexamination_anteriorsegment_cortical', 'id');

		$this->update('element_type', array(
				'class_name' => 'Element_OphCiExamination_AnteriorSegment',
				'name' => 'Anterior Segment'
		), 'class_name = \'Element_OphCiExamination_CataractAssessment\'');

	}

	public function down()
	{
		$this->alterColumn('et_ophciexamination_posteriorsegment','left_cd_ratio_id','int(10) unsigned NOT NULL DEFAULT 5');
		$this->alterColumn('et_ophciexamination_posteriorsegment','right_cd_ratio_id','int(10) unsigned NOT NULL DEFAULT 5');
		// TODO: Down migration for reinstating old anteriorsegment table?
	}
}
