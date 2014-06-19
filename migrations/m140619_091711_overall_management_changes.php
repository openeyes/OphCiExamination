<?php

class m140619_091711_overall_management_changes extends OEMigration
{
	private $defaults = array('right_gonio' ,'left_gonio' ,'clinic_interval' ,'photo' ,'oct' ,	'hfa' ,	'hrt');
	public function up()
	{
		$this->dropForeignKey('et_ophciexam_overallmanagementplan_clinic_internal_id_fk', 'et_ophciexamination_overallmanagementplan');
		$this->renameColumn('et_ophciexamination_overallmanagementplan','clinic_internal_id','clinic_interval_id');
		$this->renameColumn('et_ophciexamination_overallmanagementplan_version','clinic_internal_id','clinic_interval_id');
		$this->addForeignKey('et_ophciexam_overallmanagementplan_clinic_interval_id_fk', 'et_ophciexamination_overallmanagementplan',
			'clinic_interval_id', 'ophciexamination_overallperiod', 'id'
		);

		$this->addColumn('et_ophciexamination_overallmanagementplan', 'hrt_id', 'int(11) DEFAULT NULL AFTER hfa_id');
		$this->addColumn('et_ophciexamination_overallmanagementplan_version', 'hrt_id', 'int(11) DEFAULT NULL AFTER hfa_id');
		$this->addForeignKey('et_ophciexam_overallmanagementplan_hrt_id_fk', 'et_ophciexamination_overallmanagementplan',
			'hrt_id', 'ophciexamination_overallperiod', 'id'
		);

		$period = Yii::app()->db->createCommand("SELECT id FROM ophciexamination_overallperiod WHERE name = '6 months'")->queryRow();

		foreach($this->defaults as $default){
			$this->insert('setting_metadata', array(
				'element_type_id' => $this->getIdOfElementTypeByClassName('OEModule\OphCiExamination\models\Element_OphCiExamination_OverallManagementPlan'),
				'field_type_id' => 2, // Dropdown
				'key' => $default .'_id',
				'name' => 'Default Period',
				'default_value' => $period['id']
			));
		}

	}

	public function down()
	{
		$this->dropForeignKey('et_ophciexam_overallmanagementplan_clinic_interval_id_fk', 'et_ophciexamination_overallmanagementplan');
		$this->renameColumn('et_ophciexamination_overallmanagementplan','clinic_interval_id','clinic_internal_id');
		$this->renameColumn('et_ophciexamination_overallmanagementplan_version','clinic_interval_id','clinic_internal_id');
		$this->addForeignKey('et_ophciexam_overallmanagementplan_clinic_internal_id_fk', 'et_ophciexamination_overallmanagementplan',
			'clinic_internal_id', 'ophciexamination_overallperiod', 'id'
		);

		$this->dropForeignKey('et_ophciexam_overallmanagementplan_hrt_id_fk', 'et_ophciexamination_overallmanagementplan');
		$this->dropColumn('et_ophciexamination_overallmanagementplan', 'hrt_id');
		$this->dropColumn('et_ophciexamination_overallmanagementplan_version', 'hrt_id');

		$element_type_id = $this->getIdOfElementTypeByClassName('OEModule\OphCiExamination\models\Element_OphCiExamination_OverallManagementPlan');

		foreach($this->defaults as $default){
			$this->delete('setting_metadata', '`element_type_id` = '.$element_type_id.' AND `key` = "' . $default . '_id"');
		}
	}
}