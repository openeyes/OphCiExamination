<?php

class m131022_135806_missing_mgmt_findings_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$event_type->registerShortcode('lmf','getLetterLaserManagementFindings','Laser management findings from latest examination');
		$event_type->registerShortcode('imf','getLetterInjectionManagementComplexFindings','Injection management findings from latest examination');
	}

	public function down()
	{
		$this->delete('patient_shortcode','method = :meth',array(':meth'=>'getLetterInjectionManagementComplexFindings'));
		$this->delete('patient_shortcode','method = :meth',array(':meth'=>'getLetterLaserManagementFindings'));
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}