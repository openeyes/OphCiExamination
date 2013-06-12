<?php

class m130301_141001_rename_posterior_segment_to_posterior_pole extends CDbMigration
{
	public function up()
	{
		$this->dropForeignKey('ophciexamination_posteriorsegment_cd_ratio_lmui_fk','ophciexamination_posteriorsegment_cd_ratio');
		$this->dropForeignKey('ophciexamination_posteriorsegment_cd_ratio_cui_fk','ophciexamination_posteriorsegment_cd_ratio');
		$this->dropIndex('ophciexamination_posteriorsegment_cd_ratio_lmui_fk','ophciexamination_posteriorsegment_cd_ratio');
		$this->dropIndex('ophciexamination_posteriorsegment_cd_ratio_cui_fk','ophciexamination_posteriorsegment_cd_ratio');

		$this->renameTable('ophciexamination_posteriorsegment_cd_ratio','ophciexamination_posteriorpole_cd_ratio');

		$this->createIndex('ophciexamination_posteriorpole_cd_ratio_lmui_fk','ophciexamination_posteriorpole_cd_ratio','last_modified_user_id');
		$this->createIndex('ophciexamination_posteriorpole_cd_ratio_cui_fk','ophciexamination_posteriorpole_cd_ratio','created_user_id');
		$this->addForeignKey('ophciexamination_posteriorpole_cd_ratio_lmui_fk','ophciexamination_posteriorpole_cd_ratio','last_modified_user_id','user','id');
		$this->addForeignKey('ophciexamination_posteriorpole_cd_ratio_cui_fk','ophciexamination_posteriorpole_cd_ratio','created_user_id','user','id');

		$this->dropForeignKey('et_ophciexamination_posteriorsegment_e_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_c_u_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_l_m_u_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropForeignKey('et_ophciexamination_posteriorsegment_eye_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_e_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_c_u_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_l_m_u_id_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment');
		$this->dropIndex('et_ophciexamination_posteriorsegment_eye_id_fk','et_ophciexamination_posteriorsegment');

		$this->renameTable('et_ophciexamination_posteriorsegment','et_ophciexamination_posteriorpole');

		$this->createIndex('et_ophciexamination_posteriorpole_e_id_fk','et_ophciexamination_posteriorpole','event_id');
		$this->createIndex('et_ophciexamination_posteriorpole_c_u_id_fk','et_ophciexamination_posteriorpole','created_user_id');
		$this->createIndex('et_ophciexamination_posteriorpole_l_m_u_id_fk','et_ophciexamination_posteriorpole','last_modified_user_id');
		$this->createIndex('et_ophciexamination_posteriorpole_lcri_fk','et_ophciexamination_posteriorpole','left_cd_ratio_id');
		$this->createIndex('et_ophciexamination_posteriorpole_rcri_fk','et_ophciexamination_posteriorpole','right_cd_ratio_id');
		$this->createIndex('et_ophciexamination_posteriorpole_eye_id_fk','et_ophciexamination_posteriorpole','eye_id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_e_id_fk','et_ophciexamination_posteriorpole','event_id','event','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_c_u_id_fk','et_ophciexamination_posteriorpole','created_user_id','user','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_l_m_u_id_fk','et_ophciexamination_posteriorpole','last_modified_user_id','user','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_lcri_fk','et_ophciexamination_posteriorpole','left_cd_ratio_id','ophciexamination_posteriorpole_cd_ratio','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_rcri_fk','et_ophciexamination_posteriorpole','right_cd_ratio_id','ophciexamination_posteriorpole_cd_ratio','id');
		$this->addForeignKey('et_ophciexamination_posteriorpole_eye_id_fk','et_ophciexamination_posteriorpole','eye_id','eye','id');

		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->update('element_type',array('name'=>'Posterior Pole','class_name'=>'Element_OphCiExamination_PosteriorPole'),"event_type_id = $event_type->id and class_name='Element_OphCiExamination_PosteriorSegment'");
	}

	public function down()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));
		$this->update('element_type',array('name'=>'Posterior Segment','class_name'=>'Element_OphCiExamination_PosteriorSegment'),"event_type_id = $event_type->id and class_name='Element_OphCiExamination_PosteriorPole'");

		$this->dropForeignKey('ophciexamination_posteriorpole_cd_ratio_lmui_fk','ophciexamination_posteriorpole_cd_ratio');
		$this->dropForeignKey('ophciexamination_posteriorpole_cd_ratio_cui_fk','ophciexamination_posteriorpole_cd_ratio');
		$this->dropIndex('ophciexamination_posteriorpole_cd_ratio_lmui_fk','ophciexamination_posteriorpole_cd_ratio');
		$this->dropIndex('ophciexamination_posteriorpole_cd_ratio_cui_fk','ophciexamination_posteriorpole_cd_ratio');

		$this->renameTable('ophciexamination_posteriorpole_cd_ratio','ophciexamination_posteriorsegment_cd_ratio');

		$this->createIndex('ophciexamination_posteriorsegment_cd_ratio_lmui_fk','ophciexamination_posteriorsegment_cd_ratio','last_modified_user_id');
		$this->createIndex('ophciexamination_posteriorsegment_cd_ratio_cui_fk','ophciexamination_posteriorsegment_cd_ratio','created_user_id');
		$this->addForeignKey('ophciexamination_posteriorsegment_cd_ratio_lmui_fk','ophciexamination_posteriorsegment_cd_ratio','last_modified_user_id','user','id');
		$this->addForeignKey('ophciexamination_posteriorsegment_cd_ratio_cui_fk','ophciexamination_posteriorsegment_cd_ratio','created_user_id','user','id');

		$this->dropForeignKey('et_ophciexamination_posteriorpole_e_id_fk','et_ophciexamination_posteriorpole');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_c_u_id_fk','et_ophciexamination_posteriorpole');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_l_m_u_id_fk','et_ophciexamination_posteriorpole');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_lcri_fk','et_ophciexamination_posteriorpole');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_rcri_fk','et_ophciexamination_posteriorpole');
		$this->dropForeignKey('et_ophciexamination_posteriorpole_eye_id_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_e_id_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_c_u_id_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_l_m_u_id_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_lcri_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_rcri_fk','et_ophciexamination_posteriorpole');
		$this->dropIndex('et_ophciexamination_posteriorpole_eye_id_fk','et_ophciexamination_posteriorpole');

		$this->renameTable('et_ophciexamination_posteriorpole','et_ophciexamination_posteriorsegment');

		$this->createIndex('et_ophciexamination_posteriorsegment_e_id_fk','et_ophciexamination_posteriorsegment','event_id');
		$this->createIndex('et_ophciexamination_posteriorsegment_c_u_id_fk','et_ophciexamination_posteriorsegment','created_user_id');
		$this->createIndex('et_ophciexamination_posteriorsegment_l_m_u_id_fk','et_ophciexamination_posteriorsegment','last_modified_user_id');
		$this->createIndex('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment','left_cd_ratio_id');
		$this->createIndex('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment','right_cd_ratio_id');
		$this->createIndex('et_ophciexamination_posteriorsegment_eye_id_fk','et_ophciexamination_posteriorsegment','eye_id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_e_id_fk','et_ophciexamination_posteriorsegment','event_id','event','id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_c_u_id_fk','et_ophciexamination_posteriorsegment','created_user_id','user','id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_l_m_u_id_fk','et_ophciexamination_posteriorsegment','last_modified_user_id','user','id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_lcri_fk','et_ophciexamination_posteriorsegment','left_cd_ratio_id','ophciexamination_posteriorsegment_cd_ratio','id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_rcri_fk','et_ophciexamination_posteriorsegment','right_cd_ratio_id','ophciexamination_posteriorsegment_cd_ratio','id');
		$this->addForeignKey('et_ophciexamination_posteriorsegment_eye_id_fk','et_ophciexamination_posteriorsegment','eye_id','eye','id');
	}
}
