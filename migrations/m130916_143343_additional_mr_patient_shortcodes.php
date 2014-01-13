<?php

class m130916_143343_additional_mr_patient_shortcodes extends CDbMigration
{
	public function up()
	{
		$event_type = EventType::model()->find('class_name=?',array('OphCiExamination'));

		$event_type->registerShortcode('tcl','getLetterCentralSFTLeft','Central SFT for left eye from Examination');
		$event_type->registerShortcode('tcr','getLetterCentralSFTRight','Central SFT for right eye from Examination');
		$event_type->registerShortcode('tml','getLetterMaxCRTLeft','Maximim CRT for left eye from Examination');
		$event_type->registerShortcode('tmr','getLetterMaxCRTRight','Maximim CRT for right eye from Examination');
		$event_type->registerShortcode('iml','getLetterInjectionManagementComplexDiagnosisLeft','Injection Management Complex diagnosis for left eye from Examination');
		$event_type->registerShortcode('imr','getLetterInjectionManagementComplexDiagnosisRight','Injection Management Complex diagnosis for right eye from Examination');

	}

	public function down()
	{
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tmr'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tml'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tcr'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'tcl'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'iml'));
		$this->delete('patient_shortcode','code = :sc',array(':sc'=>'imr'));

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
