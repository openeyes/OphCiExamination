<?php

class m131015_140752_add_findings_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$event_type->registerShortcode('vaf','getLetterVisualAcuityFindings','Visual acuity findings from latest examination');
	}

	public function down()
	{
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'vaf'));
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