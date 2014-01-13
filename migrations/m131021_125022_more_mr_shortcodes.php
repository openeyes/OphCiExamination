<?php

class m131021_125022_more_mr_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$event_type->registerShortcode('imb','getLetterInjectionManagementComplexDiagnosisBoth','Visual acuity findings from latest examination');
	}

	public function down()
	{
		$this->delete('patient_shortcode','method = :mt',array(':mt'=>'getLetterInjectionManagementComplexDiagnosisBoth'));
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
